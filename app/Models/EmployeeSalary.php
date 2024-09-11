<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;
    protected $table =  'employee_salaries';
    protected $fillable = ['employee_id','employee_salary','payment_type','submission_date','end_date','employee_status'];
}
