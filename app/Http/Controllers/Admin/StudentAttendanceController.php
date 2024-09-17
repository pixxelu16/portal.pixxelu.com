<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentAttendance;
use Carbon\Carbon;

class StudentAttendanceController extends Controller
{
    //Function for student attenedance lists
    public function all_students_attendance_list() {
        //Get the current month and year
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        //Get student details
        $get_student_detail = User::where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->with([
                'student_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
                }
            ])->get();

        //Get attendance details
        $total_present_hours = 0;
        $total_present_days = 0;
        $total_absent_days = 0;
        $total_leave_days = 0;
        $total_half_day = 0;

        //Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        //Calculate totals
        foreach ($get_student_detail as $student) {
            foreach ($student->student_attendance_detail as $attendance) {
                //Get punch in and outs
                $punchIn = Carbon::parse($attendance->punch_in_time);
                $punchOut = $attendance->punch_out_time ? Carbon::parse($attendance->punch_out_time) : null;

                //Check if attendance current month and year
                if ($punchIn->month == $currentMonth && $punchIn->year == $currentYear) {
                    //Check attendance status 
                    if ($attendance->attendance_status == 'present') {
                        //Calculate total present hours
                        if ($punchOut) {
                            $duration = $punchIn->diff($punchOut);
                            $total_present_hours += ($duration->h + $duration->i / 60);
                        }
                        //Count the day as present
                        $total_present_days++;
                    } elseif ($attendance->attendance_status == 'absent') {
                        $total_absent_days++;
                    } elseif ($attendance->attendance_status == 'leave') {
                        $total_leave_days++;
                    } elseif ($attendance->attendance_status == 'half_day') {
                        $total_half_day++;
                    }
                }
            }
        }
        //Define months
        $months = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        //Get current month
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $days = range(1, $daysInMonth);

        //Get all Sundays and last Saturday of the month
        $sundays = [];
        $lastSaturday = null;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);

            //Check for Sundays
            if ($date->isSunday()) {
                $sundays[] = $day;
            }

            //Check for the last Saturday
            if ($date->isSaturday() && $day >= ($daysInMonth - 6)) {
                $lastSaturday = $day;
            }
        }
        //Get total holidays all Sundays and last Saturday
        $total_holidays = count($sundays) + ($lastSaturday ? 1 : 0);

        return view('admin.student-attendances.all-students-attendance-list', compact('get_student_detail', 'months', 'days', 'month', 'year', 'sundays', 'lastSaturday', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays', 'daysInMonth'));
    }

    //Function for search student attendance list
     public function search_student_attendance_list(Request $request) {
        //Get month and year
        $student_name = $request->student_name;
        $month = $request->month;
        $year = $request->year;


        //Get student details 
        $get_student_detail = User::where('user_type', 'Student')
            ->where('user_status', 'Active')->where('name', $student_name)
            ->with([
                'student_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month);
                }
            ])->get();
            
        //Get student name
        $get_student_name = User::select('name')->where('user_type', 'Student')->where('user_status', 'Active')->get();

        //Get attendance details
        $total_present_hours = 0;
        $total_present_days = 0;
        $total_absent_days = 0;
        $total_leave_days = 0;
        $total_half_day = 0;

        //Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        //Calculate totals
        foreach ($get_student_detail as $student) {
            foreach ($student->student_attendance_detail as $attendance) {
                //Get punch in and outs
                $punchIn = Carbon::parse($attendance->punch_in_time);
                $punchOut = $attendance->punch_out_time ? Carbon::parse($attendance->punch_out_time) : null;

                //Check if attendance current month and year
                if ($punchIn->month == $currentMonth && $punchIn->year == $currentYear) {
                    //Check attendance status 
                    if ($attendance->attendance_status == 'present') {
                        //Calculate total present hours
                        if ($punchOut) {
                            $duration = $punchIn->diff($punchOut);
                            $total_present_hours += ($duration->h + $duration->i / 60);
                        }
                        //Count the day as present
                        $total_present_days++;
                    } elseif ($attendance->attendance_status == 'absent') {
                        $total_absent_days++;
                    } elseif ($attendance->attendance_status == 'leave') {
                        $total_leave_days++;
                    } elseif ($attendance->attendance_status == 'half_day') {
                        $total_half_day++;
                    }
                }
            }
        }
        //Define months
        $months = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        //Get current month
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $days = range(1, $daysInMonth);

        //Get all Sundays and last Saturday of the month
        $sundays = [];
        $lastSaturday = null;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);

            //Check for Sundays
            if ($date->isSunday()) {
                $sundays[] = $day;
            }

            //Check for the last Saturday
            if ($date->isSaturday() && $day >= ($daysInMonth - 6)) {
                $lastSaturday = $day;
            }
        }
        //Get total holidays all Sundays and last Saturday
        $total_holidays = count($sundays) + ($lastSaturday ? 1 : 0);

        return view('admin.student-attendances.search-student-attendances', compact('get_student_detail', 'get_student_name', 'months', 'days', 'month', 'year', 'daysInMonth', 'sundays', 'lastSaturday', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays'));
    }

}
