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
    //Function for get students
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
            if ($student->student_fees_detail->isNotEmpty()) {
                foreach ($student->student_fees_detail as $fee) {
                    $data->push([
                        'ID' => $student->id,
                        'Name' => $student->name,
                        'Phone No' => $student->father_phone_no,
                        'Fee Amount' => $fee->user_fees,
                        'Payment Type' => $fee->payment_type,
                        'Fees Submission Date' => $fee->submission_date,
                        'Fees Status' => 'Paid',
                    ]);
                }
            }
        }

        return $data;
    }
    //Function for show heading
    public function headings(): array {
        return ['ID','Name','Phone No','Fee Amount','Payment Type','Fees Submission Date','Fees Status'];
    }

    public function startCell(): string
    {
        return 'A2';
    }
    //Function for excel header
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', "Students Monthly Paid Fees List " . $this->currentMonth . " " . $this->currentYear);
    
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
