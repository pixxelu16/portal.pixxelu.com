<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryIncrement extends Model
{
    use HasFactory;
    protected $table = 'employees_salary_increment';
    protected $fillable = ['employee_id','increment_amount','date'];
}
