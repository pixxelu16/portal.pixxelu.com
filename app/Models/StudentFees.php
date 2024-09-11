<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFees extends Model
{
    use HasFactory;
    protected $table = 'student_fees';
    protected $fillable = ['user_id','user_fees','payment_type','is_down_payment','submission_date','end_date','user_status'];
    
    //Function for get student fees details
    public function student_fees_detail() {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    //Function for get student current fees details
    public function student_current_fees_detail() {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
