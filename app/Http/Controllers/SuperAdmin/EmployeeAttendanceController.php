<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeAttendance;  
use Carbon\Carbon;  

class EmployeeAttendanceController extends Controller
{
    //Function for employee attendance
    public function employee_attendance(Request $request) {
        //Get Current day
        $today = Carbon::today()->format('Y-m-d');
        
       //Check if employee attendance is already exists or not
        $existing_attendance = EmployeeAttendance::where('employee_id', $request->employee_id)->whereDate('created_at', $today)->first();     
       
        //Employee attendance is already 
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
}
