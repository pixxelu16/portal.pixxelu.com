<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    //Function for get profile detail
    public function edit_profile() {
        //Get auth login id
        $is_login_id = Auth::user()->id;
        $user_profile = User::where('id', $is_login_id)->first();
        return view('super-admin.profiles.edit-profile-detail', compact('user_profile'));
    }

    //Function for update user profile
    public function update_profile(Request $request, $id){
        //Check if image is exit or not
        $filename = "default_user.png";
        if($request->hasFile('images')) {
            $file = $request->file('images');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/users'), $filename);
            //Check if qualification exist or not
            $qualification = '';
            if($request->has('qualification')) {
                //Convert array to string
                $qualification = implode(',', $request->input('qualification'));
            }
            //Update profile with image
            $update_profile = User::where('id', $id)->update([
                'name' => $request->first_name." ".$request->last_name,
                'first_name' =>$request->first_name,
                'last_name' =>$request->last_name,
                'dob' =>$request->dob,
                'employee_phone_no' =>$request->employee_phone_no,
                'aadhaar_no' =>$request->aadhaar_no,
                'gender' =>$request->gender,
                'marital_status' =>$request->marital_status,
                'category' =>$request->category,
                'qualification' => $qualification,
                'address' =>$request->address,
                'district' =>$request->district,
                'state' =>$request->state,
                'pin_code' =>$request->pin_code,
                'joining_date' =>$request->joining_date,
                'user_status' =>$request->user_status,
                'user_pic' =>$filename,
            ]);

            //Check if profile updated or not
            if($update_profile){
                return back()->with('success', 'Profile updated successfully.');
            } else {
                return back()->with('unsucess', 'Opps something went wrong.');
            }
        } else {
            //Check if qualification exist or not
            $qualification = '';
            if($request->has('qualification')) {
                //Convert array to string
                $qualification = implode(',', $request->input('qualification'));
            }
            //Update profile without image
            $update_profile = User::where('id', $id)->update([
                'name' => $request->first_name." ".$request->last_name,
                'first_name' =>$request->first_name,
                'last_name' =>$request->last_name,
                'dob' =>$request->dob,
                'employee_phone_no' =>$request->employee_phone_no,
                'aadhaar_no' =>$request->aadhaar_no,
                'gender' =>$request->gender,
                'marital_status' =>$request->marital_status,
                'category' =>$request->category,
                'qualification' => $qualification,
                'address' =>$request->address,
                'district' =>$request->district,
                'state' =>$request->state,
                'pin_code' =>$request->pin_code,
                'joining_date' =>$request->joining_date,
                'user_status' =>$request->user_status,
            ]);

            //Check if profile updated or not
            if($update_profile){
                return back()->with('success', 'Profile updated successfully.');
            } else {
                return back()->with('unsucess', 'Opps something went wrong.');
            }
        }
    }

    //Function for changed password
    public function changed_password() {
        //Get auth login id
        $is_login_id = Auth::user()->id;
        $user_profile = User::where('id', $is_login_id)->first();
        return view('super-admin.profiles.change-password', compact('user_profile'));
    }

    //Function for submit change password 
    public function submit_changed_password(Request $request) {   
        //Check the current password
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('unsuccess', 'Your current password does not match the password you provided.');
        }
        //Update the password if new and confirm passwords match
        if ($request->new_password !== $request->confirm_password) {
            return redirect()->back()->with('unsuccess', 'New password and confirm password do not match.');
        }
        //Check is user password updated or not
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Your password has been changed successfully.');
    }
}

