<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
    //Check if user type
    $user = Auth::user();
        //Check if user type Super_Admin or not
        if($user->user_type == 'Super_Admin'){
            return redirect('super-admin/dashboard');
        //Check if user type Admin or not
        } elseif ($user->user_type == 'Admin'){
            return redirect('admin/all-students-list');
        //Check if user type Student or not
        } elseif ($user->user_type == 'Student'){
            return redirect('student/dashboard');
        //Check if user type Employee or not
        } elseif ($user->user_type == 'Employee'){
            return redirect('employee/dashboard');
        //Check if user type Subscriber or not
        } elseif ($user->user_type == 'Subscriber'){
            return redirect('subscriber/dashboard');
        } else {
            return view('home');
        }
    }
}
