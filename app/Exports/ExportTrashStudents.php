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

class ExportTrashStudents implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, ShouldAutoSize
{
    //Get user status for export controller
    protected $user_status;

    public function __construct($user_status) {
        $this->user_status = $user_status;
    }

    public function collection() {
        //Get trash students detail
        $query = User::orderBy('ID', 'ASC')
            ->where('user_type', 'Student')
            ->whereIn('user_status', ['Leave', 'Completed']);

        //Filter students acc user status
        if ($this->user_status !== 'all') {
            $query->where('user_status', $this->user_status);
        }

        $students_detail = $query->get();

        //Students fees
        $totalFeesSum = 0;
        $paidFeesSum = 0;
        $remainingFeesSum = 0;
        $data = [];

        //Get students fees detail
        foreach ($students_detail as $student) {
            $totalFees = $student->total_fees;
            $paidFees = $student->student_fees_detail->sum('user_fees');
            $remainingFees = $totalFees - $paidFees;

            $totalFeesSum += $totalFees;
            $paidFeesSum += $paidFees;
            $remainingFeesSum += $remainingFees;

            //Determine months based on course duration
            switch ($student->course_duration) {
                case '1 Year': $months = 12; break;
                case '6 Month': $months = 6; break;
                case '3 Month': $months = 3; break;
                case '1 Month': $months = 1; break;
                default: $months = 0;
            }

            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email ?? '-',
                'dob' => $student->dob ?? '-',
                'gender' => $student->gender ?? '-',
                'father_name' => $student->father_name ?? '-',
                'father_phone_no' => $student->father_phone_no ?? '-',
                'student_phone_no' => $student->student_phone_no ?? '-',
                'marital_status' => $student->marital_status ?? '-',
                'category' => $student->category ?? '-',
                'address' => $student->address ?? '-',
                'district' => $student->district ?? '-',
                'state' => $student->state ?? '-',
                'pin_code' => $student->pin_code ?? '-',
                'qualification' => $student->qualification ?? '-',
                'course_type' => $student->course_type ?? '-',
                'course_duration' => $student->course_duration ?? '-',
                'course_joining_date' => $student->course_joining_date ?? '-',
                'batch_timing' => $student->batch_timing ?? '-',
                'course_complession_date' => $student->course_complession_date ?? '-',
                'total_fees' => number_format($totalFees),
                'paid_fees' => number_format($paidFees),
                'remaining_fees' => number_format($remainingFees),
                'user_status' => $student->user_status ?? '-',
            ];
        }

        //Totals Row
        $data[] = [
            'id' => '',
            'name' => '',
            'email' => '',
            'dob' => '',
            'gender' => '',
            'father_name' => '',
            'father_phone_no' => '',
            'student_phone_no' => '',
            'marital_status' => '',
            'category' => '',
            'address' => '',
            'district' => '',
            'state' => '',
            'pin_code' => '',
            'qualification' => '',
            'course_type' => '',
            'course_duration' => '',
            'course_joining_date' => '',
            'batch_timing' => '',
            'course_complession_date' => 'Totals',
            'total_fees' => number_format($totalFeesSum),
            'paid_fees' => number_format($paidFeesSum),
            'remaining_fees' => number_format($remainingFeesSum),
            'user_status' => '',
        ];

        return collect($data);
    }

    //Function for export header
    public function headings(): array {
        return [
            'Registration ID', 'Name', 'Email', 'Dob', 'Gender', 'Father Name', 'Father Phone Number', 'Student Phone Number',
            'Marital Status', 'Category', 'Address', 'District', 'State', 'Pin Code', 'Qualification', 'Course Type',
            'Course Duration', 'Course Joining Date', 'Batch Timing', 'Course Completion Date',
            'Total Fees', 'Paid Fees', 'Remaining Fees', 'Status'
        ];
    }

    //Function for cell
    public function startCell(): string {
        return 'A2';
    }

    //Function for custom header with design
    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:X1');
                $sheet->setCellValue('A1', "All Trash Students List");

                $headerStyle = [
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'font' => ['bold' => true, 'size' => 14],
                ];
                $sheet->getStyle('A1')->applyFromArray($headerStyle);
                $sheet->getStyle('A2:X2')->applyFromArray(['font' => ['bold' => true]]);

                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A{$lastRow}:X{$lastRow}")->applyFromArray([
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
