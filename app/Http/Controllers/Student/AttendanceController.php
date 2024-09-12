<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentAttendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //Function for student attenedance lists
    public function student_attendance_list() {
        //Get auth login id
        $is_login_id = Auth::user()->id;

        //Get the current month and year
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        //Get student details
        $get_student_detail = User::where('user_type', 'Student')
            ->where('user_status', 'Active')->where('id', $is_login_id)
            ->with([
                'student_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
                }
            ])->get();

            //echo "<pre>"; print_r($get_student_detail->toArray());exit;

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
            return view('student.attendances.student-attendance-list', compact('get_student_detail', 'months', 'days', 'month', 'year', 'sundays', 'lastSaturday'));
    }

    //Function for submit student punch in attendance
    public function submit_student_punch_attendance(Request $request) {
        //Define your office Wi-Fi IP address or range
        // $office_wifi_ip = '192.168.29.35'; 

        //Get the current student's IP address
        // $student_ip = $request->ip(); 

        //Check if the student's IP matches the office Wi-Fi IP
        // if ($student_ip !== $office_wifi_ip) {
        //     echo '<p style="color:red;">You are not connected to the office Wi-Fi. Please connect to the office network and try again.</p>';
        //     echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        //     return; 
        // }

        //Get the current date and time in IST
        $current_time = Carbon::now('Asia/Kolkata')->format('H:i:s');
        $current_date = Carbon::now('Asia/Kolkata')->toDateString();

        //Check if attendance already exists or not
        $existing_attendance = StudentAttendance::where('user_id', $request->student_id)
            ->whereDate('created_at', $current_date)
            ->first();

        //Check if student attendance already exists for today
        if ($existing_attendance) {
            echo '<p style="color:red;">Your attendance has already been marked for today.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            //Create attendance student
            $is_create_student_attendance = StudentAttendance::create([
                'user_id' => $request->student_id,
                'batch' => $request->batch,
                'batch_time' => $request->batch_time,
                'punch_in_time' => $current_time,
                'attendance_status' => $request->attendance_status,
            ]);

            //Check if student attendance is created or not
            if ($is_create_student_attendance) {
                echo '<p style="color:green;">Your attendance has been successfully submitted for today.</p>';
                echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
            } else {
                echo '<p style="color:red;">Oops, something went wrong. Please try again.</p>';
            }
        }
    }

    //Function for update student punch in attendance
    public function update_student_punch_out_attendance(Request $request) {
        //Get student id
        $student_id = $request->student_id;

        //Get the current date and time in IST
        $current_time = Carbon::now('Asia/Kolkata')->format('H:i:s');
        $current_date = Carbon::now('Asia/Kolkata')->toDateString();

        //Get student attendance for the current date
        $existing_attendance = StudentAttendance::where('user_id', $student_id)
            ->whereDate('created_at', $current_date)
            ->whereNotNull('punch_out_time')
            ->exists();

        //Check if student attendance already exists for today
        if ($existing_attendance) {
            echo '<p style="color:red;">Your attendance has already been punched out for today.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            //Update student punch out attendance record
            $is_update_student_punch_out_attendance = StudentAttendance::where('user_id', $student_id)
                ->whereDate('created_at', $current_date)
                ->update([
                    'punch_out_time' => $current_time,
                ]);

            //Check if the punch out attendance is updated or not
            if ($is_update_student_punch_out_attendance) {
                echo '<p style="color:green;">Your punch-out attendance was successfully submitted for today.</p>';
                echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
            } else {
                echo '<p style="color:red;">Oops, something went wrong. Please try again.</p>';
            }
        }
    }

    //search employee attendance list
    public function search_student_attendance_list(Request $request) {
        //Get auth login id
        $is_login_id = Auth::user()->id;

        //Get month and year
        $month = $request->month;
        $year = $request->year;

        //Get student details 
        $get_student_detail = User::where('user_type', 'Student')
            ->where('user_status', 'Active')->where('id', $is_login_id)
            ->with([
                'student_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month);
                }
            ])->get();

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
        return view('student.attendances.search-student-attendances', compact('get_student_detail', 'months', 'days', 'month', 'year', 'sundays', 'lastSaturday'));
    }
}
