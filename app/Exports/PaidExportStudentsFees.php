<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaidExportStudentsFees implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, ShouldAutoSize
{
    protected $currentMonth;
    protected $currentYear;

    public function __construct()
    {
        $this->currentMonth = Carbon::now()->format('F'); 
        $this->currentYear = Carbon::now()->format('Y'); 
    }
    
    //Function for get paid students list
    public function collection() {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
    
        $students = User::OrderBy('ID','ASC')->where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->with('student_fees_detail')
            ->get();
    
        $data = new Collection();
        $total_paid_fees_current_month = 0;
        $total_remaining_fees = 0;
    
        foreach ($students as $student) {
            $total_fees = (float) $student->total_fees;
    
            //Get total paid fees for all months
            $total_paid_fees_all_months = (float) $student->student_fees_detail->sum('user_fees');
    
            //Get current month's payments
            $current_month_fees = $student->student_fees_detail
                ->whereBetween('submission_date', [$startOfMonth, $endOfMonth])
                ->pluck('user_fees')
                ->toArray();
    
            $payment_types = $student->student_fees_detail
                ->whereBetween('submission_date', [$startOfMonth, $endOfMonth])
                ->pluck('payment_type')
                ->unique()
                ->implode('/');

            //Format Fee Amount Column  
            if (count($current_month_fees) > 1) {
                $formatted_fees = implode('/', array_map('number_format', $current_month_fees)) . ' = ' . number_format(array_sum($current_month_fees));
            } else {
                $formatted_fees = !empty($current_month_fees) ? number_format($current_month_fees[0]) : '0';
            }

            //Calculate Remaining Fees
            $remaining_fees = max(0, $total_fees - $total_paid_fees_all_months);
    
            //Calculate Monthly Fee
            $course_duration_months = [
                '1 Year' => 12,
                '2 Year' => 24,
                '3 Month' => 3,
                '6 Month' => 6,
                '1 Month' => 1,
            ];
            $fee_percentage = isset($course_duration_months[$student->course_duration]) 
                ? round(($total_fees - $student->student_fees_detail->where('is_down_payment', 'down_payment')->sum('user_fees')) / $course_duration_months[$student->course_duration]) 
                : 0;
    
            if (!empty($current_month_fees)) {
                $data->push([
                    'Registration ID' => $student->id,
                    'Name' => $student->name,
                    'Phone No' => $student->father_phone_no ?? '-',
                    'Fee Amount' => $formatted_fees,
                    'Fee Payment Type' => $payment_types,
                    'Remaining Fee' => number_format($remaining_fees),
                    'Fee Submission Date' => optional($student->student_fees_detail->sortByDesc('submission_date')->first())->submission_date,
                    'Monthly Fee' => number_format($fee_percentage),
                    'Fee Status' => 'Paid',
                ]);
            }
    
            $total_paid_fees_current_month += array_sum($current_month_fees);
            $total_remaining_fees += $remaining_fees;
        }
    
        // Append Total Row
        $data->push([
            'Registration ID' => '',
            'Name' => '',
            'Phone No' => 'Total',
            'Fee Amount' => number_format($total_paid_fees_current_month), 
            'Fee Payment Type' => '',
            'Remaining Fee' => number_format($total_remaining_fees),
            'Fee Submission Date' => '',
            'Monthly Fee' => '',
            'Fee Status' => '',
        ]);
    
        return $data;
    }
    
    //Function for show heading
    public function headings(): array {
        return ['Registration ID', 'Name', 'Phone No', 'Fee Amount', 'Fee Payment Type', 'Remaining Fee', 'Fee Submission Date', 'Monthly Fee', 'Fee Status'];
    }
    
    public function startCell(): string {
        return 'A2';
    }

    //Function for show excel sheet
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', "Monthly Paid Fees Report for Students :- {$this->currentMonth} {$this->currentYear}");
                $headerStyle = [
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'font' => ['bold' => true, 'size' => 14],
                ];
                $sheet->getStyle('A1')->applyFromArray($headerStyle);
                $sheet->getStyle('A2:I2')->applyFromArray(['font' => ['bold' => true]]);

                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A{$lastRow}:I{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '000000'],
                    ],
                ]);
            },
        ];
    }
}
