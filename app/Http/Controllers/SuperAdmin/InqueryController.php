<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquery;

class InqueryController extends Controller
{
    //Function for add new inquery
    public function add_inquery() {
        return view('super-admin.inquery.add-new-inquery');
    }

    //Function for submit inquery
    public function submit_inquery(Request $request) {
        //Check mobile no is exist or not
        $is_mobile_exist = Inquery::where('mobile', $request->mobile)->exists();
        if($is_mobile_exist) {
            return back()->with('unsuccess', 'This mobile no is already used, please try new no.');
        }
        //Create inquery
        $is_create_inquery = Inquery::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'course_type' => $request->course_type,
            'status' => 'Active',
        ]);

        //Check if inquery is created or not
        if($is_create_inquery){
            return back()->with('success', 'Inquery created successfully.');
        } else {
            return back()->with('unsuccess', 'Opps something went wrong.');
        }
    }

    //Function for all inqueries list
    public function all_inqueries() {
        //Get queries list
        $all_inqueries_list = Inquery::OrderBy('ID', 'DESC')->get();
        return view('super-admin.inquery.all-inqueries-list', compact('all_inqueries_list'));
    }

    //Function for edit inquery
    public function edit_inquery($id) {
        //Get inquery detail
        $inquery = Inquery::find($id);
        return view('super-admin.inquery.edit-inquery', compact('inquery'));
    }

    //Function for update inquery
    public function update_inquery(Request $request, $id) {
        //Update inquery
        $is_update_inquery = Inquery::where('id', $id)->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'course_type' => $request->course_type,
            'status' => $request->status,
        ]);

        //Check if inquery is updated or not
        if($is_update_inquery){
            session()->flash('success', 'Inquiry updated successfully.');
            return redirect()->route('super.admin.edit.success', ['id' => $id]);
        } else {
            return back()->with('unsuccess', 'Opps something went wrong.');
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
