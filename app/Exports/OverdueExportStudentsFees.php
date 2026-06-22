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

class OverdueExportStudentsFees implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, ShouldAutoSize
{
    protected $currentMonth;
    protected $currentYear;

    public function __construct() {
        $this->currentMonth = Carbon::now()->format('F'); 
        $this->currentYear = Carbon::now()->format('Y'); 
    }

    public function collection() {
        $last58Days = Carbon::now()->subDays(56)->toDateString(); 
        $students = User::OrderBy('ID','ASC')->where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->whereHas('student_fees_detail', function ($query) use ($last58Days) {
                $query->where('submission_date', '<', $last58Days); 
            })
            ->with(['student_fees_detail' => function ($query) {
                $query->orderBy('submission_date', 'desc'); 
            }])
            ->get();

        $data = new Collection();
        $total_last_paid_fees = 0;
        $total_remaining_fees = 0;

        foreach ($students as $student) {
            $last_payment = $student->student_fees_detail->first();
            $last_submission_date = $last_payment->submission_date ?? 'Overdue';
            $last_month_fees = $last_payment->user_fees ?? 0; 
            $last_payment_type = $last_payment->payment_type ?? 'N/A'; 
            $total_fees = $student->total_fees;

            if (!$last_payment || Carbon::parse($last_payment->submission_date)->gt($last58Days)) {
                continue; 
            }

            $down_payment_fee = $student->student_fees_detail->where('is_down_payment', 'down_payment')->first()->user_fees ?? 0;  
            $total_paid_fees = $student->student_fees_detail->sum('user_fees');
            $remaining_fees = max(0, $total_fees - $total_paid_fees);

            $difference = $total_fees - $down_payment_fee;
            $fee_percentage = match ($student->course_duration) {
                '1 Year' => $difference / 12,
                '2 Year' => $difference / 24,
                '3 Month' => $difference / 3,
                '6 Month' => $difference / 6,
                '1 Month' => $difference / 1,
                default => 0,
            };

            $data->push([
                'Registration ID' => $student->id, 
                'Name' => $student->name,
                'Phone No' => $student->father_phone_no ?? '-',
                'Last Fee Amount' => number_format($last_month_fees),
                'Remaining Fee Amount' => number_format($remaining_fees),
                'Last Fee Payment Type' => $last_payment_type,
                'Last Fee Submission Date' => $last_submission_date,   
                'Monthly Fee' => number_format($fee_percentage), 
                'Status' => 'Overdue Fees',
            ]);

            $total_last_paid_fees += $last_month_fees; 
            $total_remaining_fees += $remaining_fees;
        }

        $data->push([
            'Registration ID' => '',
            'Name' => '',
            'Phone No' => 'Total',
            'Last Fee Amount' => number_format($total_last_paid_fees),
            'Remaining Fee Amount' => number_format($total_remaining_fees),
            'Last Fee Payment Type' => '',
            'Last Fee Submission Date' => '', 
            'Monthly Fee' => '',
            'Status' => '',
        ]);

        return $data;
    }

    //Function for show heading
    public function headings(): array {
        return ['Registration ID','Name','Phone No','Last Fee Amount','Remaining Fee Amount','Last Fee Payment Type','Last Fee Submission Date','Monthly Fee','Status'];
    }

    public function startCell(): string {
        return 'A2';
    }

    //Function for excel header
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:I1'); 
                $sheet->setCellValue('A1', "Overdue Students Fees List :- " . $this->currentMonth . " " . $this->currentYear);

                $headerStyle = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                ];
                $sheet->getStyle('A1')->applyFromArray($headerStyle);

                $sheet->getStyle('A2:I2')->applyFromArray(['font' => ['bold' => true]]);

                $lastRow = $event->sheet->getHighestRow(); 
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
