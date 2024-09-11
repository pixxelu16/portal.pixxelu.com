<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDamageAccessories extends Model
{
    use HasFactory;
    protected $table = 'student_damage_accessories';
    protected $fillable = ['user_id','keyboard_damage','mouse_damage','remark'];

    
}
