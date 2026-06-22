<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentAttendance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;  

class StudentAttendanceController extends Controller
{
    //Function for submit student punch in attendance
    public function submit_student_attendance(Request $request) {
        //Create attendance student
        $is_create_student_attendance = StudentAttendance::create([
            'user_id' => $request->student_id,
            'sift' => $request->sift,
            'sift_type' => $request->sift_type,
            'punch_in_time' => $request->punch_in_time,
            'punch_out_time' => $request->punch_out_time,
            'submission_date' => $request->submission_date,
            'attendance_status' => $request->attendance_status,
        ]);

        //Check if student attendance is updated or not
        if ($is_create_student_attendance) {
            echo '<p style="color:green;">Student attendance updated successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Oops, something went wrong. Please try again.</p>';
        }
    }

    //Function for get all students attenedance list
    public function all_students_attendance_list() {
        //Get the current month and year
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        //Get student details
        $get_student_detail = User::where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->with([
                'student_attendance_detail' => function ($query) use ($month, $year) {
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

        return view('admin.student-attendances.all-students-attendance-list', compact('get_student_detail', 'months', 'days', 'month', 'year', 'sundays', 'alternativeSaturdays', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays', 'daysInMonth'));
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
                    $query->whereYear('submission_date', $year)
                        ->whereMonth('submission_date', $month);
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

        return view('admin.student-attendances.search-student-attendances', compact('get_student_detail', 'get_student_name', 'months', 'days', 'month', 'year', 'daysInMonth', 'sundays', 'alternativeSaturdays', 'total_present_hours', 'total_present_days', 'total_absent_days', 'total_leave_days', 'total_half_day', 'total_holidays'));
    }

    //Function for dounload attendance pdf file
    public function students_attendance_pdf(Request $request) {
        //Get input field request
        $type = $request->type;
        //Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;
        //Course duration filter
        if ($type === 'regular') {
            $courseDurations = ['1 Year', '2 Year', '3 Year'];
            $title = 'Regular Students Attendance Generated Report On';
        } else {
            $courseDurations = ['1 Month', '3 Month', '6 Month'];
            $title = 'Internship Students Attendance Generated Report On';
        }
        //Students fetch with filter
        $students = User::where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->whereIn('course_duration', $courseDurations)
            ->with(['student_attendance_detail' => function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('submission_date', $currentMonth)
                    ->whereYear('submission_date', $currentYear);
            }])
            ->get();
        //Total holidays
        $daysInMonth = Carbon::now()->daysInMonth;
        $totalHolidays = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);
            if ($date->isSunday() || ($date->isSaturday() && in_array($date->weekOfMonth, [2, 4, 6]))) {
                $totalHolidays++;
            }
        }
        //Total working hours
        foreach ($students as $student) {
            $totalHours = 0;
            foreach ($student->student_attendance_detail as $attendance) {
                if (
                    $attendance->attendance_status === 'present' &&
                    $attendance->punch_in_time &&
                    $attendance->punch_out_time
                ) {
                    $punchIn  = Carbon::parse($attendance->punch_in_time);
                    $punchOut = Carbon::parse($attendance->punch_out_time);
                    $totalHours += $punchIn->diffInMinutes($punchOut) / 60;
                }
            }
            $student->total_hours = round($totalHours, 2);
        }
        $data = [
            'students'       => $students,
            'month'          => Carbon::now()->format('F'),
            'year'           => $currentYear,
            'total_holidays' => $totalHolidays,
            'daysInMonth'    => $daysInMonth,
            'title'          => $title
        ];

        $pdf = PDF::loadView(
            'admin.student-attendances.students-attendance-pdf',
            $data
        )->setPaper('A4', 'portrait');

        $fileName =
            strtolower(str_replace(' ', '_', $title)) . '_' .
            Carbon::now()->format('F_Y') . '.pdf';

        return $pdf->download($fileName);
    }

    //Function for single employee generate pdf file
    public function SearchdownloadAttendancePDF($unique_employee_id) {
        //Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        //Get single employee with attendance details for the current month
        $employee = User::where('unique_employee_id', $unique_employee_id)->where('user_type', 'Employee')
            ->where('user_status', 'Active')
            ->with(['employees_attendance_detail' => function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('submission_date', $currentMonth)
                      ->whereYear('submission_date', $currentYear);
            }])
            ->first();
    
        //Calculate total holidays (Sundays + alternate Saturdays)
        $daysInMonth = Carbon::now()->daysInMonth;
        $totalHolidays = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);
            if ($date->isSunday() || ($date->isSaturday() && in_array($date->weekOfMonth, [2, 4, 6]))) {
                $totalHolidays++;
            }
        }
    
        //Calculate total worked hours for the single employee
        $totalHours = 0;
        foreach ($employee->employees_attendance_detail as $attendance) {
            if ($attendance->attendance_status === 'present' && $attendance->punch_in_time && $attendance->punch_out_time) {
                $punchIn = Carbon::parse($attendance->punch_in_time);
                $punchOut = Carbon::parse($attendance->punch_out_time);
                $totalHours += $punchIn->diffInMinutes($punchOut) / 60;
            }
        }
        $employee->total_hours = $totalHours;
    
        //Prepare data for the PDF
        $data = [
            'employee' => $employee,
            'month' => Carbon::now()->format('F'),
            'year' => $currentYear,
            'total_holidays' => $totalHolidays,
            'daysInMonth' => $daysInMonth
        ];
    
        //Generate and download the PDF
        $pdf = Pdf::loadView('admin.employee-attendances.search-employee-attendance-pdf', $data);
        return $pdf->download('employee_attendance_' . Carbon::now()->format('F_Y') . '.pdf');
    }
}
