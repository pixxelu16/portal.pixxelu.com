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

class PendingExportStudentsFees implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, ShouldAutoSize
{
    protected $currentMonth;
    protected $currentYear;
    protected $currentMonthStart;

    public function __construct() {
        //Get current month and year
        $this->currentMonth = Carbon::now()->format('F');
        $this->currentYear = Carbon::now()->format('Y');
        $this->currentMonthStart = Carbon::now()->startOfMonth()->toDateString(); 
    }

    //Get collection
    public function collection() {
        $last31Days = Carbon::now()->subDays(31)->toDateString();
        $last55Days = Carbon::now()->subDays(55)->toDateString();

        //Get students detail
        $students = User::OrderBy('ID', 'ASC')->where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->where(function ($query) use ($last31Days, $last55Days) {
                $query->whereHas('student_fees_detail', function ($subQuery) use ($last31Days, $last55Days) {
                    $subQuery->whereBetween('submission_date', [$last55Days, $last31Days]);
                })
                ->orWhereDoesntHave('student_fees_detail');
            })
            ->whereDoesntHave('student_fees_detail', function ($query) {
                $query->where('submission_date', '>=', $this->currentMonthStart);
            })
            ->with(['student_fees_detail' => function ($query) {
                $query->orderBy('submission_date', 'desc');
            }])
            ->get();

        $data = new Collection();

        //Get last fee and remaining fees
        $total_last_paid_fees = 0;
        $total_remaining_fees = 0;

        //Get students detail
        foreach ($students as $student) {
            $last_payment = $student->student_fees_detail->first();
            $last_submission_date = $last_payment->submission_date ?? 'No fees paid in any month';
            $last_month_fees = (float) ($last_payment->user_fees ?? 0);
            $last_payment_type = $last_payment->payment_type ?? 0; 
            
            $total_fees = (float) $student->total_fees;

            $down_payment_fee = (float) ($student->student_fees_detail->where('is_down_payment', 'down_payment')->first()->user_fees ?? 0);
            
            //Get total paid and remaining fees detail
            $total_paid_fees = (float) $student->student_fees_detail->sum('user_fees');
            $remaining_fees = max(0, $total_fees - $total_paid_fees);
           
            $difference = max(0, $total_fees - $down_payment_fee);

            switch ($student->course_duration) {
                case '1 Year':
                    $fee_percentage = $difference / 12;
                    break;
                case '2 Year':
                    $fee_percentage = $difference / 24;
                    break;
                case '3 Month':
                    $fee_percentage = $difference / 3;
                    break;
                case '6 Month':
                    $fee_percentage = $difference / 6;
                    break;
                case '1 Month':
                    $fee_percentage = $difference / 1;
                    break;
                default:
                    $fee_percentage = 0;
            }

            $data->push([
                'Registration ID' => $student->id,
                'Name' => $student->name,
                'Phone No' => $student->father_phone_no ?? '-',
                'Last Fee Amount' => number_format($last_month_fees),
                'Remaining Fee Amount' => number_format($remaining_fees),
                'Last Fee Payment Type' => $last_payment_type,
                'Last Fee Submission Date' => $last_submission_date,          
                'Monthly Fee' => number_format($fee_percentage),
                'Status' => 'Pending',
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

    //Function for show heading excel
    public function headings(): array {
        return ['Registration ID', 'Name', 'Phone No', 'Last Fee Amount', 'Remaining Fee Amount', 'Last Fee Payment Type', 'Last Fee Submission Date', 'Monthly Fee', 'Status'];
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
                $sheet->setCellValue('A1', "Students Pending Fees List :- {$this->currentMonth} {$this->currentYear}");
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
