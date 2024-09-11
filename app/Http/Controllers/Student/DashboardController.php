<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\StudentFees;  
use App\Models\StudentAssignAccessories;
use App\Models\StudentDamageAccessories;
use App\Models\EmployeeAssignAccessories;
use App\Models\EmployeeDamageAccessories;
use Carbon\Carbon;

class DashboardController extends Controller
{ 
    //Function for view single student detail
    public function student_detail() {
        //Get auth login student id
        $id = Auth::user()->id;
        //Get student detail
        $get_student_detail = User::where([['id', '=', $id], ['user_type', '=', 'Student']])->where('user_status', 'Active')->with('student_fees_detail', 'student_assign_accessories')->first();           
        //Get student damage accessories 
        $get_student_damage_accessories = StudentDamageAccessories::where('user_id', $id)->get(); 

        $course_duration = $get_student_detail->course_duration;
        $course_joining_date = Carbon::parse($get_student_detail->course_joining_date);
    
        $end_date = clone $course_joining_date;
        if ($course_duration == '1 Month') {
            $end_date->addMonth();
        } elseif ($course_duration == '3 Month') {
            $end_date->addMonths(3);
        } elseif ($course_duration == '6 Month') {
            $end_date->addMonths(6);
        } elseif ($course_duration == '1 Year') {
            $end_date->addYear();
        } elseif ($course_duration == '2 Year') {
            $end_date->addYears(2);
        }
    
        return view('student.dashboard', compact('get_student_detail','course_joining_date','end_date','get_student_damage_accessories'));
    }
}





