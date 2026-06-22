<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    
    // Add this method to automatically set the ID with leading zeros
    public static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $nextId = static::getNextId();
            $model->id = str_pad($nextId, 4, '0', STR_PAD_LEFT);
        });
    }
    
    // Add this method to get the next available ID
    public static function getNextId()
    {
        // Customize this logic to fetch the next available ID from your data source
        // For example, you could get the maximum current ID and increment it by 1
        $maxId = static::max('id');
        $nextId = $maxId ? intval($maxId) + 1 : 1;
        return str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['unique_employee_id','name','email','password','first_name','last_name','dob','gender','father_name','father_phone_no','aadhaar_no','student_phone_no','marital_status','category','address','district','pin_code','state','qualification','course_type','course_duration','course_joining_date','batch_timing','course_complession_date','total_fees','employee_phone_no','joining_date','resign_date','national_id','blood','religion','experince','net_salary','employee_role','user_pic','user_status','user_type','is_internship'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Function for get student fees details
    public function student_fees_detail() {
        return $this->HasMany(StudentFees::class, 'user_id');
    }

    //Function for get student assign accessories
    public function student_assign_accessories() {
        return $this->HasMany(StudentAssignAccessories::class, 'user_id');
    }

    //Function for get employees trash list
    public function employee_trash_detail() {
        return $this->HasMany(EmployeeTrash::class, 'employee_id');
    }

    //Function for get employees salary details
      public function emloyees_salary__detail() {
        return $this->HasMany(EmployeeSalary::class, 'employee_id');
    }

    //Function for get employee salary increment details
    public function emloyees_salary_increment_detail() {
        return $this->HasMany(EmployeeSalaryIncrement::class, 'employee_id');
    }

    //Function for get employee attendance details
    public function employees_attendance_detail() {
        return $this->HasMany(EmployeeAttendance::class, 'employee_id');
    }

    //Function for get student attendance details
    public function student_attendance_detail() {
        return $this->HasMany(StudentAttendance::class, 'user_id');
    }

    public function scopeActiveStudents($query)
    {
        return $query->where('user_type', 'Student')->where('user_status', 'Active');
    }

    public function scopeRegularStudents($query)
    {
        return $query->activeStudents()->where(function ($q) {
            $q->where('is_internship', false)->orWhereNull('is_internship');
        });
    }

    public function scopeInternships($query)
    {
        return $query->activeStudents()->where('is_internship', true);
    }
}
 