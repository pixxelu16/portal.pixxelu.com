<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    //Redirect users after successful login
    protected $redirectTo = '/home';

    /**
     * Constructor to define middleware for authentication
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Determines if the login field is email or student_phone_no
     */
    public function username() {
        $login = request()->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_phone_no';
        request()->merge([$field => $login]);
        return $field;
    }

    /**
     * Attempt to log the user into the application.
     */
    protected function attemptLogin(Request $request){
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Handle a failed login attempt and provide specific error messages.
     */
    protected function sendFailedLoginResponse(Request $request){
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_phone_no';

        //Get user email or phone number
        $user = $this->guard()->getProvider()->retrieveByCredentials([$field => $request->input($field)]);

        //Check if user is exists or not
        if (!$user) {
            throw ValidationException::withMessages([
                'login' => ['Your email or username is incorrect.'], 
            ]);
        }

        //Check if user exists but the password is incorrect
        if (!\Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Your password is incorrect.'],
            ]);
        }
    }

    protected function authenticated(Request $request, $user) {
        //Check if user access is exists or not
        if ($user->access_type === 'Inquery') {
            return redirect()->route('admin.students.list'); 
        }
    }
}
