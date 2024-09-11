<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Function for show subscriber dashboard
    public function dashboard(){
        return view('subscriber.dashboard');
    }
}
