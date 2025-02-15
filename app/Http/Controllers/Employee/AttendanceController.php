<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\EmployeeAttendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //Function for employee attenedance lists
    public function employee_attendance_list() {
        //Get auth login id
        $is_login_id = Auth::user()->id;

        //Get the current month and year
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        //Get employee details
        $get_employee_detail = User::where('user_type', 'Employee')
            ->where('user_status', 'Active')->where('id', $is_login_id)
            ->with([
                'employees_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('submission_date', $year)->whereMonth('submission_date', $month);
                }
            ])->get();

        //echo "<pre>"; print_r($get_employee_detail->toArray());exit();

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
        foreach ($get_employee_detail as $employee) {
            foreach ($employee->employees_attendance_detail as $attendance) {
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

        //Get all Sundays and alternative Saturdays
        $sundays = [];
        $alternativeSaturdays = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);

            //Check for Sundays
            if ($date->isSunday()) {
                $sundays[] = $day;
            }

            //Check for Saturdays
            if ($date->isSaturday()) {
                $weekOfMonth = ceil($day / 7);
                if (in_array($weekOfMonth, [2, 4, 6])) {
                    $alternativeSaturdays[] = $day;
                }
            }
        }

        //Calculate total holidays
        $total_holidays = count($sundays) + count($alternativeSaturdays);
        return view('employee.attendances.employee-attendance-list', compact('get_employee_detail', 'months', 'days', 'month', 'year', 'sundays', 'alternativeSaturdays', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays', 'daysInMonth'));
    }

    //Function for submit employee punch in attendance
    public function submit_employee_punch_in_attendance(Request $request) {
        //Define your office Wi-Fi IP address or range
        // $office_wifi_ip = '192.168.29.35';          
        //Get the current employee's IP address
        // $employee_ip = $request->ip(); 

        //Check if the employee's IP matches the office Wi-Fi IP
        // if ($employee_ip !== $office_wifi_ip) {
        //     echo '<p style="color:red;">You are not connected to the office Wi-Fi. Please connect to the office network and try again.</p>';
        //     echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        //     return; 
        // }

        //Get the current date and time in IST
        $current_time = Carbon::now('Asia/Kolkata')->format('H:i:s');
        $current_date = Carbon::now('Asia/Kolkata')->toDateString();

        //Check if attendance already exists or not
        $existing_attendance = EmployeeAttendance::where('employee_id', $request->employee_id)
            ->whereDate('submission_date', $current_date)
            ->first();

        //Check if employee attendance already exists for today
        if ($existing_attendance) {
            echo '<p style="color:red;">Your attendance has already been marked for today.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            //Create attendance employee
            $is_create_employee_attendance = EmployeeAttendance::create([
                'employee_id' => $request->employee_id,
                'sift' => $request->sift,
                'sift_type' => $request->sift_type,
                'punch_in_time' => $current_time,
                'submission_date' => $current_date,
                'attendance_status' => $request->attendance_status,
            ]);
            //Check if employee attendance is created or not
            if ($is_create_employee_attendance) {
                echo '<p style="color:green;">Your attendance has been successfully submitted for today.</p>';
                echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
            } else {
                echo '<p style="color:red;">Oops, something went wrong. Please try again.</p>';
            }
        }
    }

    //Function for update employee punch in attendance
    public function update_employee_punch_out_attendance(Request $request) {
        //Get employee id
        $employee_id = $request->employee_id;

        //Get the current date and time in IST
        $current_time = Carbon::now('Asia/Kolkata')->format('H:i:s');
        $current_date = Carbon::now('Asia/Kolkata')->toDateString();

        //Get employee attendance for the current date
        $existing_attendance = EmployeeAttendance::where('employee_id', $employee_id)
            ->whereDate('submission_date', $current_date)
            ->whereNotNull('punch_out_time')
            ->exists();

        //Check if employee attendance already exists for today
        if ($existing_attendance) {
            echo '<p style="color:red;">Your attendance has already been punched out for today.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            //Update employee punch out attendance record
            $is_update_employee_punch_out_attendance = EmployeeAttendance::where('employee_id', $employee_id)
                ->whereDate('submission_date', $current_date)
                ->update([
                    'punch_out_time' => $current_time,
                ]);

            //Check if the punch out attendance is updated or not
            if ($is_update_employee_punch_out_attendance) {
                echo '<p style="color:green;">Your punch-out attendance was successfully submitted for today.</p>';
                echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
            } else {
                echo '<p style="color:red;">Oops, something went wrong. Please try again.</p>';
            }
        }
    }

    //search employee attendance list
    public function search_employee_attendance_list(Request $request) {
        //Get auth login id
        $is_login_id = Auth::user()->id;

        //Get month and year
        $month = $request->month;
        $year = $request->year;

        //Get employee details 
        $get_employee_detail = User::where('user_type', 'Employee')
            ->where('user_status', 'Active')->where('id', $is_login_id)
            ->with([
                'employees_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('submission_date', $year)
                        ->whereMonth('submission_date', $month);
                }
            ])->get();
        //echo "<pre>"; print_r($get_employee_detail->toArray());exit;
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
        foreach ($get_employee_detail as $employee) {
            foreach ($employee->employees_attendance_detail as $attendance) {
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

        //Get all Sundays and alternative Saturdays 
        $sundays = [];
        $alternativeSaturdays = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);

            //Check for Sundays
            if ($date->isSunday()) {
                $sundays[] = $day;
            }

            //Check for Saturdays
            if ($date->isSaturday()) {
                //Calculate which Saturday
                $weekOfMonth = ceil($day / 7);
                if (in_array($weekOfMonth, [2, 4, 6])) {
                    $alternativeSaturdays[] = $day;
                }
            }
        }

        //Calculate total holidays
        $total_holidays = count($sundays) + count($alternativeSaturdays);
        return view('employee.attendances.search-employee-attendances', compact('get_employee_detail', 'months', 'days', 'month', 'year', 'daysInMonth', 'sundays', 'alternativeSaturdays', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays'));
    }
}
