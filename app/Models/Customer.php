<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";
    protected $fillable = ['name','email','dob','father_name','national_id','mobile','gender','joining_date','education','blood','religion','experience','home_address','monthly_salary','employee_role','image','status'];
}
