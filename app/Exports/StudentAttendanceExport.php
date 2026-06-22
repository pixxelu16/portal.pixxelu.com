<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentAttendanceExport implements FromArray, WithHeadings
{
    //protected
    protected $days;
    protected $month;
    
    //Function for construct
    public function __construct($month) {
        $this->month = $month;
        $this->days = Carbon::parse($month)->daysInMonth;
    }

    //Function for headings
    public function headings(): array {
        $headers = [
            'Sr No',
            'Registration ID',
            'Name',
            'Batch',
            'Batch Timing'
        ];
        for ($i = 1; $i <= $this->days; $i++) {
            $day = Carbon::parse($this->month)->day($i)->format('d D'); 
            $headers[] = $day;
        }
        return $headers;
    }

    //Function for all students
    public function array(): array {
        //Get students
        $students = User::where('user_type', 'Student')->where('user_status', 'Active')->orderBy('id')->get();
        $data = [];
        $count = 1;
        //Get students
        foreach ($students as $stu) {
            $row = [
                $count++,
                $stu->registration_id,
                $stu->name,
                $stu->batch ?? '-',
                $stu->batch_time ?? '-',
            ];
            for ($i = 1; $i <= $this->days; $i++) {
                $row[] = "";  
            }
            $data[] = $row;
        }
        return $data;
    }
}
