<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssignAccessories extends Model
{
    use HasFactory;
    protected $table = 'employee_assign_accessories';
    protected $fillable = ['employee_id','keyboard_assigned','mouse_assigned'];
}
