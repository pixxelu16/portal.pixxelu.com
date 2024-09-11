<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquery;

class LeadController extends Controller
{
    //Function for submit inquery
    public function submit_inquery(Request $request) {
        //Create inquery
        $is_create_inquery = Inquery::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'desc' => $request->desc,
            'course_type' => $request->course_type,
            'status' => $request->status,
        ]);

        //Check if inquery is created or not
        if ($is_create_inquery) {
            $success['status'] = 200;
            $success['message'] = "Inquery created successfully";
            $success['data'] = [$is_create_inquery];
            return response()->json($success, 200);

        } else {
            $success['status'] = 400;
            $success['message'] = "Oops Something Wrong.";
            $success['data'] = [];
            return response()->json($success, 400);
        } 
    }
}
