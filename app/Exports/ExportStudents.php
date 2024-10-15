<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportStudents implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    protected $courseType;

    public function __construct($courseType)
    {
        $this->courseType = $courseType;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //Get students deatils
        $query = User::where('user_type', 'Student')->where('user_status', 'Active');

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
                'email' => $student->email,
                'dob' => $student->dob,
                'gender' => $student->gender,
                'father_name' => $student->father_name,
                'father_phone_no' => $student->father_phone_no,
                'student_phone_no' => $student->student_phone_no,
                'marital_status' => $student->marital_status,
                'category' => $student->category,
                'address' => $student->address,
                'district' => $student->district,
                'state' => $student->state,
                'pin_code' => $student->pin_code,
                'qualification' => $student->qualification,
                'course_type' => $student->course_type,
                'course_duration' => $student->course_duration,
                'course_joining_date' => $student->course_joining_date,
                'batch_timing' => $student->batch_timing,
                'course_complession_date' => $student->course_complession_date,
                'total_fees' => $totalFees,
                'paid_fees' => $paidFees,
                'remaining_fees' => $remainingFees,
                'Monthly Fees(Down Payment)' => round($monthlyFees),
                'user_status' => $student->user_status,
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
            'total_fees' => $totalFeesSum,
            'paid_fees' => $paidFeesSum,
            'remaining_fees' => $remainingFeesSum,
            'Monthly Fees(Down Payment)' => round($monthlyFeesSum),
            'user_status' => '',
        ];

        return collect($data);
    }

    //Function for heading CSV file
    public function headings(): array {
        return ['Registration No', 'Name', 'Email', 'Dob', 'Gender', 'Father Name', 'Father Phone Number', 'Student Phone Number', 'Marital Status', 'Category', 'Address', 'District', 'State', 'Pin Code', 'Qualification', 'Course Type', 'Course Duration', 'Course Joining Date', 'Batch Timing', 'Course Completion Date', 'Total Fees', 'Paid Fees', 'Remaining Fees', 'Monthly Fees(Down Payment)', 'Status'];
    }

    //Function for header sum fees
    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $highestRow = $event->sheet->getHighestRow();
                $cellRange = 'A' . $highestRow . ':Y' . $highestRow;
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF000000'],
                    ],
                ]);
            },
        ];
    }
}
