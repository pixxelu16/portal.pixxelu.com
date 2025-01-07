<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeAttendance;  
use Carbon\Carbon;  

class EmployeeAttendanceController extends Controller
{


    
    //Function for submit employee punch in attendance
    public function submit_employee_attendance(Request $request) {
    // //Get the current date and time in IST
    // $current_time = Carbon::now('Asia/Kolkata')->format('H:i:s');
    // $current_date = Carbon::now('Asia/Kolkata')->toDateString();

    // //Check if attendance already exists or not
    // $existing_attendance = EmployeeAttendance::where('employee_id', $request->employee_id)
    //     ->whereDate('created_at', $current_date)
    //     ->first();

    // //Check if employee attendance already exists for today
    // if ($existing_attendance) {
    //     echo '<p style="color:red;">Your attendance has already been marked for today.</p>';
    //     echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
    // } else {
      
        //Create attendance employee
        $is_create_employee_attendance = EmployeeAttendance::create([
            'employee_id' => $request->employee_id,
            'sift' => $request->sift,
            'sift_type' => $request->sift_type,
            'punch_in_time' => $request->punch_in_time,
            'punch_out_time' => $request->punch_out_time,
            'submission_date' => $request->submission_date,
            'attendance_status' => $request->attendance_status,
        ]);

        //Check if employee attendance is updated or not
        if ($is_create_employee_attendance) {
            echo '<p style="color:green;">Employee attendance updated successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Oops, something went wrong. Please try again.</p>';
        }
    }

    //Function for all employees attenedance lists
    public function all_employees_attendance_list() { 
        //Get the current month and year
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        //Get employee details
        $get_employee_detail = User::where('user_type', 'Employee')
            ->where('user_status', 'Active')
            ->with([
                'employees_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('submission_date', $year)->whereMonth('submission_date', $month);
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

        //Calculate Sundays and the last Saturday of the month
        $sundays = [];
        $secondSaturday = null;
        $lastSaturday = null;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);

            if ($date->isSunday()) {
                $sundays[] = $day; 
            }

            if ($date->isSaturday()) {
                $weekNumber = $date->weekOfMonth;

                // Identify the second Saturday
                if ($weekNumber === 2) {
                    $secondSaturday = $day;
                }

                // Identify the last Saturday
                if ($day >= ($daysInMonth - 6)) {
                    $lastSaturday = $day;
                }
            }
        }

        //Calculate total holidays (Sundays + Second Saturday + Last Saturday)
        $total_holidays = count($sundays) + ($secondSaturday ? 1 : 0) + ($lastSaturday ? 1 : 0);

        return view('admin.employee-attendances.all-employees-attendance-list', compact('get_employee_detail', 'months', 'days', 'month', 'year', 'sundays', 'lastSaturday', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays', 'daysInMonth'));
    }

    //Function for employee panch in attendance
    public function employee_attendance(Request $request) {
        //Get Current day
        $current_date = Carbon::today()->format('Y-m-d');
      
        //Get employee attendance
        $existing_attendance = EmployeeAttendance::where('employee_id', $request->employee_id)->whereDate('submission_date', $current_date)->first();   

        //Check if employee attendance is already exists or not
        if ($existing_attendance) {
            echo '<p style="color:red;">Employee has already marked attendance for today.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            //Create employee attendance
            $is_create_employee_attendance = EmployeeAttendance::create([
                'employee_id' => $request->employee_id,
                'sift' => $request->sift,
                'sift_type' => $request->sift_type,
                'punch_in_time' => $request->punch_in_time,
                'punch_out_time' => $request->punch_out_time,
                'submission_date' => $current_date,
                'attendance_status' => $request->attendance_status,
            ]); 
            //Check if employee attendance was created successfully
            if ($is_create_employee_attendance) {
                echo '<p style="color:green;">Employee attendance created today successfully.</p>';
                echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
            } else {
                echo '<p style="color:red;">Oops, something went wrong.</p>';
            }
        }        
    }

    //Function for employee panch out attendance
    public function employee_punch_out_attendance(Request $request) {
        //Get employee id
        $employee_id = $request->employee_id;
        //Get Current day
        $current_date = Carbon::today()->format('Y-m-d');      
        //Get employee attendance 
        $existing_attendance = EmployeeAttendance::where('employee_id', $employee_id)->whereDate('submission_date', $current_date)->whereNotNull('punch_out_time')->exists(); 
        //Check if employee attendance is already exists or not
        if ($existing_attendance) {
             echo '<p style="color:red;">Employee has already marked punch out attendance for today.</p>';
             echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            //update employee punch out attendance record
            $is_update_employee_punch_out_attendance = EmployeeAttendance::where('employee_id', $employee_id)->update([
                'punch_out_time' =>$request->punch_out_time,
            ]);

            //Check if employee punch out attendance is update or not
            if($is_update_employee_punch_out_attendance) {
                echo '<p style="color:green;">Employee punch out attendance submitted today successfully.</p>';
                echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
            } else {
                echo '<p style="color:red;">Oops, something went wrong.</p>';
            }
        }
    }

    //search employee attendance list
    public function search_employee_attendance_list(Request $request) {
        //Get month and year
        $employee_name = $request->employee_name;
        $month = $request->month;
        $year = $request->year;


        //Get employee details 
        $get_employee_detail = User::where('user_type', 'Employee')
            ->where('user_status', 'Active')->where('name', $employee_name)
            ->with([
                'employees_attendance_detail' => function ($query) use ($month, $year) {
                    $query->whereYear('submission_date', $year)
                        ->whereMonth('submission_date', $month);
                }
            ])->get();

            //echo "<pre>"; print_r($get_employee_detail->toArray());exit;
            
        //Get employee name
        $get_employee_name = User::select('name')->where('user_type', 'Employee')->where('user_status', 'Active')->get();

        //Get attendance details
        $total_present_hours = 0;
        $total_present_days = 0;
        $total_absent_days = 0;
        $total_leave_days = 0; 
        $total_half_day = 0; 
        $total_holidays = 0; 

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
                    } elseif ($attendance->attendance_status == 'holiday') {
                        $total_holidays++;
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

        //Calculate Sundays and the last Saturday of the month
        $sundays = [];
        $secondSaturday = null;
        $lastSaturday = null;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);

            if ($date->isSunday()) {
                $sundays[] = $day; 
            }

            if ($date->isSaturday()) {
                $weekNumber = $date->weekOfMonth;

                // Identify the second Saturday
                if ($weekNumber === 2) {
                    $secondSaturday = $day;
                }

                // Identify the last Saturday
                if ($day >= ($daysInMonth - 6)) {
                    $lastSaturday = $day;
                }
            }
        }

        //Calculate total holidays (Sundays + Second Saturday + Last Saturday)
        $total_holidays = count($sundays) + ($secondSaturday ? 1 : 0) + ($lastSaturday ? 1 : 0);

        return view('admin.employee-attendances.search-employee-attendances', compact('get_employee_detail', 'get_employee_name', 'months', 'days', 'month', 'year', 'daysInMonth', 'sundays', 'lastSaturday', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays'));
    }
}







