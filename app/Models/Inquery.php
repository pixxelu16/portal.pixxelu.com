<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquery extends Model
{
    use HasFactory;

    protected $table = 'inqueries';
    protected $fillable = ['name','f_name','l_name','email','state','city','mobile','address','desc','course_type','priority','visit','total_fees','status'];
}
