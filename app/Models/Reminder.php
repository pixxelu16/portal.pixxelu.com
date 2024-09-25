<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'reminder_number', 
        'sent_at'
    ];

    // Define the relationship with the User (student)
    public function student()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
