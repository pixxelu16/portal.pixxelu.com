<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignAccessories extends Model
{
    use HasFactory;
    protected $table = 'student_assign_accessories';
    protected $fillable = ['user_id','keyboard_assigned','mouse_assigned'];
}
   

