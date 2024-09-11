<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;
    protected $table = 'employee_attendances';
    protected $fillable = ['employee_id','sift','sift_type','punch_in_time','punch_out_time','attendance_status'];
}
