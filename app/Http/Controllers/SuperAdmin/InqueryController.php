<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inquery;
use Carbon\Carbon;

class InqueryController extends Controller
{
    //Function for all inqueries list
    public function all_inqueries() {
        //Get inqueries list
        $all_inqueries_list = Inquery::OrderBy('ID', 'DESC')->where('status', '!=', 'Converted')->get();
            return view('super-admin.inquery.all-inqueries-list', compact('all_inqueries_list'));
    }

    //Function for all converted inqueries list
    public function all_converted_inqueries() { 
        //Get converted  queries list
        $all_inqueries_list = Inquery::orderBy('ID', 'DESC')->where('status', 'Converted')->get();
            return view('super-admin.inquery.all-converted-inqueries-list', compact('all_inqueries_list'));
    }
    
    //Function for search inqury acc status
    public function search_inquery_status_list(Request $request) {
        //Get the last segment from the URL
        $inquery_status = $request->segment(count($request->segments()));
        //Get inqueries detail
        $all_inqueries_list = Inquery::OrderBy('id', 'DESC')->where('status', $inquery_status)->get();                                   
            return view('super-admin.inquery.search-inqueries-status-type', compact('all_inqueries_list'));
    }

    //Function for search inqury acc status
    public function search_inquery_course_type_list(Request $request) {
        //Get the last segment from the URL
        $course_type = $request->segment(count($request->segments()));
        //Get inqueries detail
        $all_inqueries_list = Inquery::OrderBy('id', 'DESC')->where('course_type', $course_type)->get();                                
            return view('super-admin.inquery.search-inqueries-course-type', compact('all_inqueries_list'));
    }

    //Function for add new inquery
    public function add_inquery() {
        return view('super-admin.inquery.add-new-inquery');
    }

    //Function for submit inquery
    public function submit_inquery(Request $request) {
        //Check if mobile no is exist or not
        $is_mobile_exist = Inquery::where('mobile', $request->mobile)->exists();
        if ($is_mobile_exist) {
            return back()->with('unsuccess', 'This mobile no is already used, please try new no.');
        }

        //Create inquery
        $is_create_inquery = Inquery::create([
            'name' => $request->name, 
            'mobile' => $request->mobile,
            'address' => $request->address,
            'course_type' => $request->course_type,
            'priority' => $request->priority,
            'total_fees' => $request->total_fees,
            'status' => 'Active',
        ]);

        //Check if inquery is created or not
        if ($is_create_inquery) {
            return back()->with('success', 'Inquery created successfully.');
        } else {
            return back()->with('unsuccess', 'Opps something went wrong.');
        }
    }

    //Function for edit inquery
    public function edit_inquery($id) {
        //Get inquery detail
        $inquery = Inquery::find($id);
        return view('super-admin.inquery.edit-inquery', compact('inquery'));
    }

    //Function for update inquery
    public function update_inquery(Request $request, $id) {
        //Get inquery detail
        $inquiry = Inquery::find($id);
        //concrate name
        $nameParts = explode(' ', $inquiry->name);
        $first_name = $nameParts[0];
        $last_name = isset($nameParts[1]) ? $nameParts[1] : '';
        
        //Update inquery
        $is_update_inquery = $inquiry->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'course_type' => $request->course_type,
            'priority' => $request->priority,
            'total_fees' => $request->total_fees,
            'status' => $request->status,
        ]);

        //Check if inquery is updated or not
        if ($is_update_inquery) {
            if ($request->status === 'Converted') {
                //Default image
                $filename = 'default_user.png';	
                //Get current day
                $now = Carbon::now();
                //Check if inquery is craeted or not
                User::create([
                    'name' => $first_name . " " . $last_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'password' => Hash::make($request->mobile),
                    'student_phone_no' => $request->mobile,
                    'course_joining_date' => $now,
                    'address' => $request->address,
                    'course_type' => $request->course_type,
                    'priority' => $request->priority,
                    'total_fees' => $request->total_fees,
                    'user_status' => 'Active',
                    'user_type' => 'Student',
                    'user_pic' => $filename,
                ]);
            }
            //Show success massage
            session()->flash('success', 'Inquiry updated successfully.');
            return redirect()->route('super.admin.students.list', ['id' => $id]);
        } else {
            session()->flash('unsuccess', 'Oops, something went wrong.');
            return redirect()->back();
        }
    }

    //Function for delete inquery detail
    // public function delete_inquery($id) {
    //     $is_delete = Inquery::where('id', $id)->delete();

    //     //Check if inquery is created or not
    //     if($is_delete){
    //         return back()->with('success', 'Inquery deleted successfully.');
    //     } else {
    //         return back()->with('unsuccess', 'Opps something went wrong.');
    //     }       
    // }
}
