<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTrash extends Model
{
    use HasFactory;
    protected $table = 'employee_trash';
    protected $fillable = ['employee_id'];
}
