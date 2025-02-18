<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    //Function for all contacts
    public function all_contacts() {
        //Get all contacts
        $all_contacts = ContactUs::OrderBy('ID', 'DESC')->get();
        return view('admin.contacts.all-contacts', compact('all_contacts'));
    }

    //Function for delete contact
    public function delete_contact(Request $request) {
        //Get ajax request
        $contact_id->contact_id;

        // echo ($contact_id);exit;
    }
}
