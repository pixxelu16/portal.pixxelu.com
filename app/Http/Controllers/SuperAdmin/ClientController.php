<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Client;

class ClientController extends Controller
{
    //Function for show clients list
    public function all_clients_list() {
        //Get clients list
        $all_clients_list = Client::Orderby('ID', 'DESC')->get();
        return view('super-admin.clients.all-clients-list', compact('all_clients_list'));
    }

    //Function for add client
    public function add_client() {
        return view('super-admin.clients.add-new-client');
    }

    //Function for submit client
    public function submit_client(Request $request) {
        //Create client
        $is_create_client = Client::create([
            'client_name' =>$request->client_name,
            'phone_no' =>$request->phone_no,
            'desc' =>$request->desc,
            'country' =>$request->country,
            'from' =>$request->from,
            'client_status' =>'Active',
        ]);

        //Check if client is created or not
        if($is_create_client) {
            return back()->with('success', 'Client created successfully');
        } else {
            return back()->with('unsucess', 'Opps something went wrong');
        }
    }

    //Function for edit client
    public function edit_client($id) {
        $client_detail = Client::find($id);
        return view('super-admin.clients.edit-client', compact('client_detail'));
    }

    //Function for update client
    public function update_client(Request $request, $id) {
        //Update client
        $is_update_client = Client::where('id', $id)->update([
            'client_name' =>$request->client_name,
            'phone_no' =>$request->phone_no,
            'desc' =>$request->desc,
            'country' =>$request->country,
            'from' =>$request->from,
            'client_status' =>$request->client_status,
        ]);
        
        //Check if client updated or not
        if($is_update_client) {
            return back()->with('success', 'Client updated successfully');
        } else {
            return back()->with('unsuccess', 'Opps something went wrong');
        }
    }
}
