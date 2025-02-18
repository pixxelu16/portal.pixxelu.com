<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactUs;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    //Function for create contact
    public function create_contact(Request $request) {
        //Create contact
        $contact_data = ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company' => $request->company,
            'message' => $request->message,
        ]);

        //Send email
        Mail::to(['kapoorthakur906@gmail.com', $request->email])->send(new ContactMail($contact_data));

        //Check if email is created or not
        if ($contact_data) {
            //Success response
            $success['status'] = 200;
            $success['message'] = 'Email sent successfully.';
            $success['data'] = $contact_data;
            return response()->json($success, 200);
        } else {
            //Unsuccess response
            $responce = array(
            'status' => 202,
            'message' => 'Email Not Sent');
            return response()->json($responce);
        }
    }
}
