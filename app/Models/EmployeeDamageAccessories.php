<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDamageAccessories extends Model
{
    use HasFactory;
    protected $table = 'employee_damage_accessories';
    protected $fillable = ['employee_id','keyboard_damage','mouse_damage','remark'];
}
