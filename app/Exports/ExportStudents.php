<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportStudents implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents, WithCustomStartCell
{
    //Get request course type
    protected $courseType;

    //Function for construct course type
    public function __construct($courseType) {
        $this->courseType = $courseType;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        //Get students deatils
        $query = User::OrderBy('ID','ASC')->where('user_type', 'Student')->where('user_status', 'Active');

        //Filter students acc course type
        if ($this->courseType !== 'all') {
            $query->where('course_type', $this->courseType);
        }

        $students_detail = $query->get();

        $totalFeesSum = 0;
        $paidFeesSum = 0;
        $remainingFeesSum = 0;
        $monthlyFeesSum = 0;
        $data = [];

        //Get students Fees
        foreach ($students_detail as $student) {
            $totalFees = $student->total_fees;
            $paidFees = $student->student_fees_detail->sum('user_fees');
            $remainingFees = $totalFees - $paidFees;

            $totalFeesSum += $totalFees;
            $paidFeesSum += $paidFees;
            $remainingFeesSum += $remainingFees;

            //Calculate monthly fees
            switch ($student->course_duration) {
                case '1 Year':
                    $months = 12;
                    break;
                case '6 Month':
                    $months = 6;
                    break;
                case '3 Month':
                    $months = 3;
                    break;
                case '1 Month':
                    $months = 1;
                    break;
                default:
                    $months = 0;
            }

            $monthlyFees = ($months > 0) ? $remainingFees / $months : 0;
            $monthlyFeesSum += $monthlyFees;

            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email ??'-',
                'dob' => $student->dob ??'-',
                'gender' => $student->gender ??'-',
                'father_name' => $student->father_name ??'-',
                'father_phone_no' => $student->father_phone_no ??'-',
                'student_phone_no' => $student->student_phone_no ??'-',
                'marital_status' => $student->marital_status ??'-',
                'category' => $student->category ??'-',
                'address' => $student->address ??'-',
                'district' => $student->district ??'-',
                'state' => $student->state ??'-',
                'pin_code' => $student->pin_code ??'-',
                'qualification' => $student->qualification ??'-',
                'course_type' => $student->course_type ??'-',
                'course_duration' => $student->course_duration ??'-',
                'course_joining_date' => $student->course_joining_date ??'-',
                'batch_timing' => $student->batch_timing ??'-',
                'course_complession_date' => $student->course_complession_date ??'-',
                'total_fees' => number_format($totalFees) ??'-',
                'paid_fees' => number_format($paidFees) ??'-',
                'remaining_fees' => number_format($remainingFees) ??'-',
                'Monthly Fees(Down Payment)' => number_format($monthlyFees) ??'-',
                'user_status' => $student->user_status ??'-',
            ];
        }

        //Append the total sums row
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
            'Monthly Fees(Down Payment)' => number_format($monthlyFeesSum),
            'user_status' => '',
        ];

        return collect($data);
    }

    //Function for heading CSV file
    public function headings(): array {
        return ['Registration ID', 'Name', 'Email', 'Dob', 'Gender', 'Father Name', 'Father Phone Number', 'Student Phone Number', 'Marital Status', 'Category', 'Address', 'District', 'State', 'Pin Code', 'Qualification', 'Course Type', 'Course Duration', 'Course Joining Date', 'Batch Timing', 'Course Completion Date', 'Total Fees', 'Paid Fees', 'Remaining Fees', 'Monthly Fees(Down Payment)', 'Status'];
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
                $sheet->mergeCells('A1:Y1');
                $sheet->setCellValue('A1', "All Students List");
                $headerStyle = [
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'font' => ['bold' => true, 'size' => 14],
                ];
                $sheet->getStyle('A1')->applyFromArray($headerStyle);
                $sheet->getStyle('A2:Y2')->applyFromArray(['font' => ['bold' => true]]);

                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A{$lastRow}:Y{$lastRow}")->applyFromArray([
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
