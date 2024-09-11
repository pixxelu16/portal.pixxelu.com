<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeAttendance;  
use Carbon\Carbon;  

class EmployeeAttendanceController extends Controller
{

    //Function for all employees attenedance lists
    public function all_employees_attendance_list() { 
    // Get the current month and year
    $month = Carbon::now()->month;
    $year = Carbon::now()->year;

    // Get employee details along with their attendance records for the current month only
    $get_all_employees_list = User::where('user_type', 'Employee')
                                   ->where('user_status', 'Active')
                                   ->with(['employees_attendance_detail' => function ($query) use ($month, $year) {
                                       $query->whereYear('created_at', $year)
                                             ->whereMonth('created_at', $month);
                                   }])
                                   ->get();
                          
    // Define months
    $months = [
        '01' => 'Jan', '02' => 'Feb', '03' => 'March', '04' => 'April',
        '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
        '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
    ];

    // Get number of days in the current month
    $daysInMonth = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;
    $days = range(1, $daysInMonth);
 
    return view('admin.employees.all-employees-attendance-list', compact('get_all_employees_list', 'months', 'days', 'month', 'year'));
}


    //Function for update 
    public function employee_punch_out_attendance(Request $request) {
        //Get employee id
         $employee_id = $request->employee_id;
        ////Get Current day
        //  $today = Carbon::today()->format('Y-m-d');
      
        //  //Get employee attendance
        //  $existing_attendance = EmployeeAttendance::where('employee_id', $request->employee_id)->whereDate('created_at', $today)->first();   
 
        //  //Check if employee attendance is already exists or not
        //  if ($existing_attendance) {
        //      echo '<p style="color:red;">Employee has already marked punch out attendance for today.</p>';
        //      echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        //  } else {

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
    

    //Function for submit employee attendance
    public function employee_attendance(Request $request) {
        //Get Current day
        $today = Carbon::today()->format('Y-m-d');
      
        //Get employee attendance
        $existing_attendance = EmployeeAttendance::where('employee_id', $request->employee_id)->whereDate('created_at', $today)->first();   

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

    //search employee attendance list
    public function search_employee_attendance_list(Request $request) {
        //Capture query parameters
        $employeeName = $request->employee_name;
        $month = $request->month;
        $year = $request->year;
    
        //Get employee detail 
        $get_all_employees_list = User::where('user_type', 'Employee')->where('user_status', 'Active')->get();

        //Get name
        $get_name = User::where('user_type', 'Employee')->where('user_status', 'Active')->where('name', $employeeName)->first();

        //echo $get_name;exit;

        //Build the query
        $query = User::where('user_type', 'Employee')
                     ->where('user_status', 'Active')
                     ->with('employees_attendance_detail');
    
        //Filter by employee name 
        if ($employeeName) {
            $query->where('name', 'like', '%' . $employeeName . '%');
        }
    
        //Execute the query
        $get_employees_detail = $query->orderBy('ID', 'ASC')->get();
    
        //Define months
        $months = [
            'Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'August', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
    
        //Selected month
        if ($month && $year) {
            $monthNumber = array_search($month, $months) + 1; 
            $daysInMonth = \Carbon\Carbon::create($year, $monthNumber, 1)->daysInMonth;
        } else {
            $daysInMonth = 31; 
        }
    
        $days = range(1, $daysInMonth);

        return view('admin.employees.search-employee-attendances', compact('get_employees_detail', 'get_all_employees_list', 'get_name', 'months', 'days', 'month', 'year'));
    }
    

    
}
