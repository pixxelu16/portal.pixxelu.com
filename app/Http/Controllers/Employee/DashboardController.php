<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\EmployeeSalary;
use App\Models\EmployeeAssignAccessories;
use App\Models\EmployeeDamageAccessories;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //Function to show employee details
    public function employee_detail() {
        //Get auth login
        $employee_id = Auth::user()->id;
        //Get employee detail
        $get_employee_detail = User::where([
            ['id', '=', $employee_id],
            ['user_type', '=', 'Employee']
        ])
        ->where('user_status', 'Active')
        ->with('emloyees_salary_increment_detail')
        ->first();

       //Get months
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        //Get monthly and increment amount
        $currentYear = Carbon::now()->year;
        $baseSalaries = [];
        $incrementsForMonth = [];

        //Decode Base64 encoded salary
        $decodeBase64 = function ($encodedValue) {
            return (float) base64_decode($encodedValue);
        };

        //Get employee monthly salary
        foreach ($months as $month => $monthName) {
            $encodedSalaries = EmployeeSalary::where('employee_status', 'Active')
                ->where('employee_id', $employee_id)
                ->whereMonth('submission_date', $month)
                ->whereYear('submission_date', $currentYear)
                ->pluck('employee_salary');

            $paidAmount = $encodedSalaries->map($decodeBase64)->sum();

            $increments = $get_employee_detail->emloyees_salary_increment_detail ?? collect();
            $incrementAmount = $increments->filter(function ($increment) use ($month) {
                return date('m', strtotime($increment->date)) == $month;
            })->map(function ($increment) use ($decodeBase64) {
                return $decodeBase64($increment->increment_amount);
            })->sum();

            $baseSalaries[$monthName] = $paidAmount;
            $incrementsForMonth[$monthName] = $incrementAmount;
        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        //Current month paid salary
        $total_paid_salary = EmployeeSalary::where('employee_status', 'Active')
            ->where('employee_id', $employee_id)
            ->whereBetween('submission_date', [$startOfMonth, $endOfMonth])
            ->sum('employee_salary');

        //Get employee assigned accessories
        $get_employee_assign_accessories = EmployeeAssignAccessories::where('employee_id', $employee_id)->get();
        //Get employee damaged accessories
        $get_employee_damage_accessories = EmployeeDamageAccessories::where('employee_id', $employee_id)->get();

        return view('employee.dashboard', compact('get_employee_detail','baseSalaries','incrementsForMonth','total_paid_salary','get_employee_assign_accessories','get_employee_damage_accessories'));
    }
}


