<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\StudentFees;
use Carbon\Carbon;
use DateTime;

class DashboardController extends Controller
{
    //Function for show admin dashboard
    public function dashboard() {
       //Get the start and end dates for the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        //Get all students total fees and all paid fees
        $all_students_total_fees = User::where('user_status', 'Active')->sum('total_fees');
        $all_students_paid_fees = StudentFees::where('user_status', 'Active')->sum('user_fees');

        //Get students total monthly fees 
        $jan_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '1')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $feb_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '2')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $march_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '3')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $april_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '4')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $may_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '5')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $june_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '6')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $july_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '7')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $august_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '8')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $sept_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '9')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $oct_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '10')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $nov_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '11')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');
        $dec_month_fees_detail = StudentFees::where('user_status', 'Active')->whereMonth('submission_date', '12')->whereYear('submission_date', Carbon::now()->year)->sum('user_fees');

        //Get students monthly enrollement details with year 2023
        $jan_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '1')->whereYear('course_joining_date', '2023')->count();
        $feb_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '2')->whereYear('course_joining_date', '2023')->count();
        $march_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '3')->whereYear('course_joining_date', '2023')->count();
        $april_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '4')->whereYear('course_joining_date', '2023')->count();
        $may_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '5')->whereYear('course_joining_date', '2023')->count();
        $june_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '6')->whereYear('course_joining_date', '2023')->count();
        $july_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '7')->whereYear('course_joining_date', '2023')->count();
        $august_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '8')->whereYear('course_joining_date', '2023')->count();
        $sep_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '9')->whereYear('course_joining_date', '2023')->count();
        $oct_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '10')->whereYear('course_joining_date', '2023')->count();
        $nov_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '11')->whereYear('course_joining_date', '2023')->count();
        $dec_month_student_detail_2023 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '12')->whereYear('course_joining_date', '2023')->count();
        //Get all students list 2023
        $all_students_list_2023 = User::where('user_status', 'Active')->where('user_type', 'Student')->whereYear('course_joining_date', '2023')->get();
    
        //Get students monthly enrollement details with year 2024
        $jan_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '1')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $feb_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '2')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $march_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '3')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $april_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '4')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $may_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '5')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $june_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '6')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $july_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '7')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $august_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '8')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $sep_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '9')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $oct_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '10')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $nov_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '11')->whereYear('course_joining_date', Carbon::now()->year)->count();
        $dec_month_student_detail_2024 = User::where('user_status', 'Active')->Where('user_type', 'Student')->whereMonth('course_joining_date', '12')->whereYear('course_joining_date', Carbon::now()->year)->count();

        //Get payment types online or cash
        $payment_type_online = StudentFees::where('user_status', 'Active')->where('payment_type','online')->whereBetween('submission_date', [$startOfMonth, $endOfMonth])->sum('user_fees');
        $payment_type_cash = StudentFees::where('user_status', 'Active')->where('payment_type','cash')->whereBetween('submission_date', [$startOfMonth, $endOfMonth])->sum('user_fees');
      
        //Get total current month paid fees
        $current_month_paid_fees = StudentFees::where('user_status', 'Active')->whereBetween('submission_date', [$startOfMonth, $endOfMonth])->sum('user_fees');
        
        //Get student fees detail list
        $get_student_list = User::where('user_status', 'Active')
        ->whereHas('student_fees_detail', function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('submission_date', [$startOfMonth, $endOfMonth]);
        })
        ->with(['student_fees_detail' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('submission_date', [$startOfMonth, $endOfMonth])
                  ->orderBy('submission_date', 'desc'); 
        }])
        ->get()
        ->sortByDesc(function ($user) {
            return $user->student_fees_detail->first()->submission_date ?? null;
        });

        //Get total course type students list   
        $is_total_students = User::where('user_status', 'Active')->where('user_type', 'Student')->count();
        $is_web_designing_students = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Web Designing')->count();
        $is_web_development_students = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Web Development')->count();
        $is_full_stack_development = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Full Stack Development')->count();
        $is_php = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'PHP Development')->count();
        $digital_marketing = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Digital Marketing')->count();
        $is_graphic = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Graphic')->count();

        return view('super-admin.dashboard', compact('get_student_list','all_students_total_fees','all_students_paid_fees','current_month_paid_fees','payment_type_online','payment_type_cash','jan_month_fees_detail','feb_month_fees_detail','march_month_fees_detail','april_month_fees_detail','may_month_fees_detail','june_month_fees_detail','july_month_fees_detail','august_month_fees_detail','sept_month_fees_detail','oct_month_fees_detail','nov_month_fees_detail','dec_month_fees_detail','jan_month_student_detail_2023','feb_month_student_detail_2023','march_month_student_detail_2023','april_month_student_detail_2023','may_month_student_detail_2023','june_month_student_detail_2023','july_month_student_detail_2023','august_month_student_detail_2023','sep_month_student_detail_2023','oct_month_student_detail_2023','nov_month_student_detail_2023','dec_month_student_detail_2023','jan_month_student_detail_2024','feb_month_student_detail_2024','march_month_student_detail_2024','april_month_student_detail_2024','may_month_student_detail_2024','june_month_student_detail_2024','july_month_student_detail_2024','august_month_student_detail_2024','sep_month_student_detail_2024','oct_month_student_detail_2024','nov_month_student_detail_2024','dec_month_student_detail_2024','all_students_list_2023','is_total_students','is_web_designing_students','is_web_development_students','is_full_stack_development','is_php','is_graphic','digital_marketing'));
    }
  
}
