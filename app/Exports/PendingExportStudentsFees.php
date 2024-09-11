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

    public function __construct()
    {
        $this->currentMonth = Carbon::now()->format('F'); 
        $this->currentYear = Carbon::now()->format('Y'); 
    }

    public function collection()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $students = User::where('user_type', 'Student')->where('user_status', 'Active')
        ->with(['student_fees_detail' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('submission_date', [$startOfMonth, $endOfMonth]);
        }])
        ->get();
    
        $data = new Collection();
        
        foreach ($students as $student) {
            $student_details = User::where('user_type', 'Student')->where('user_status', 'Active')
                ->where('id', $student->id)
                ->with(['student_fees_detail' => function($query) {
                    $query->where('is_down_payment', 'down_payment');
                }])
                ->first(); 
        

            if ($student_details) {
                $total_fees = $student_details->total_fees;
                $down_payment_fee = $student_details->student_fees_detail->first()->user_fees ?? 0;  
        
                $difference = $total_fees - $down_payment_fee;
        
                switch ($student_details->course_duration) {
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
        
                if ($student->student_fees_detail->isEmpty()) {
                    $data->push([
                        'ID' => $student->id,
                        'Name' => $student->name,
                        'Phone No' => $student->student_phone_no,
                        'Monthly Fees' => round($fee_percentage), 
                        'Status' => 'Pending',
                    ]);
                }
            }
        }

        return $data;
    }

    public function headings(): array {
        return ['ID','Name','Phone No','Monthly Fees','Status'];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', "Students Monthly Pending Fees List " . $this->currentMonth . " " . $this->currentYear);
    
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
            },
        ];
    }
}
