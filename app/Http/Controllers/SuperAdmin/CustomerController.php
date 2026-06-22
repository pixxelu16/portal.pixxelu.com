<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\EmployeeTrash;

class CustomerController extends Controller
{
    //Function for all employees  
    public function all_employees () {
        //Get customers
        $all_customers = User::OrderBy('ID','ASC')->where('user_status', 'Active')->where('user_type', 'Employee')->get();
        return view('super-admin.customers.all-customers', compact('all_customers'));
    }

    //Function for search employee
    public function search_employee(Request $request) {
        //Get ajax request for employee name
        $customer_name = $request->customer_name;
        $customers = User::where('user_type', 'Employee')->where('user_status', 'Active')->where('name', 'like', '%' . $customer_name . '%')->orderBy('id', 'DESC')->get();
        //Get html response
        $html = '';
        $html .= '<div id="fullList" class="row g-4">';
        //Check if employee is exists or not
        if ($customers->count() > 0) {
            foreach ($customers as $customer) {
                $image = $customer->image
                    ? url('public/uploads/employees/' . $customer->image)
                    : url('public/uploads/users/default_user.png');
                //Get url
                $viewLink = url('super-admin/employee-report/' . $customer->id);
                $editLink = url('super-admin/edit-employee/' . $customer->id);
                $deleteLink = url('super-admin/delete-employee'); 
                //Get blade html
                $html .= '<div class="col-md-3 col-sm-6">
                    <div class="employee-card">
                        <img src="' . $image . '" class="profile-img" alt="Thakur Singh">
                        <p class="emp-name">' . htmlspecialchars($customer->name) . '</p>
                        <p class="emp-role">' . htmlspecialchars($customer->employee_role) . '</p>
                        <div class="action-icons">
                            <a href="javascript:void(0);" class="action-btn btn-view tooltip-custom" data-title="View Details" title="View Details" data-link="' . $viewLink . '">
                                <i class="bi bi-search"></i>
                            </a>
                            <a href="javascript:void(0);" class="action-btn btn-edit tooltip-custom" data-title="Edit" title="Edit" data-link="' . $editLink . '">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="javascript:void(0);" class="action-btn btn-delete tooltip-custom is_delete_customer_record" 
                                data-employee_id="' . $customer->unique_employee_id . '" data-link="' . $deleteLink . '"  title="Delete" data-title="Delete">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            $html .= '<div class="col-12 text-danger">No Employee record found.</div>';
        }
        //append add new card 
        $html .= '<div class="col-md-3 col-sm-6">
            <div class="add-new" id="addNewCard" data-link="' . url('super-admin/add-new-employee') . '">
                <i class="bi bi-person-plus" style="font-size: 2rem;"></i>
                <p class="mb-0 mt-2">Add New</p>
            </div>
        </div>';
        $html .= '</div>';
        //return html
        return response($html);
    }

    //Function for add new employee 
    public function add_employee() {
        return view('super-admin.customers.add-new-customer');
    }

    //Function for submit employee 
    public function submit_employee(Request $request) {
        //Validate input fields
        $request->validate([
            'name' => 'required|string|',
            'email' => 'required|string',
            'dob' => 'required|string',
            'father_name' => 'required|string',
            'national_id' => 'required|string',
            'employee_phone_no' => 'required|string',
            'gender' => 'required|string',
            'joining_date' => 'required|string',
            'qualification' => 'required|string',
            'blood' => 'required|string',
            'religion' => 'required|string',
            'experince' => 'required|string',
            'address' => 'required|string',
            'net_salary' => 'required|string',
            'employee_role' => 'required|string',
        ]);
        //Check if the email already exists
        $IsEmailExists = User::where('email', $request->email)->exists();
        if($IsEmailExists) {
            return back()->with('unsuccess', 'Email is already taken. Please try with a new email.');
        }
        //Check if any employee exists
        $get_employee = User::where('user_type', 'Employee')->count();
        if ($get_employee == 0) {
            $next_employee_id = '0001';
        } else {
            //Get last highest unique_employee_id
            $last_insert_record = User::where('user_type', 'Employee')
                ->whereNotNull('unique_employee_id')
                ->orderByDesc('unique_employee_id')
                ->first();

            if ($last_insert_record && is_numeric($last_insert_record->unique_employee_id)) {
                $last_employee_id = intval($last_insert_record->unique_employee_id);
                $next_employee_id = str_pad($last_employee_id + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $next_employee_id = '0001'; 
            }
        }
        //Check if image is exit or not
        $filename = "";
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/employees'), $filename);
        }
        //Create employee
        $is_create_customer = User::create([
            'unique_employee_id' => $next_employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'father_name' => $request->father_name,
            'national_id' => $request->national_id,
            'employee_phone_no' => $request->employee_phone_no,
            'gender' => $request->gender,
            'joining_date' => $request->joining_date,
            'qualification' => $request->qualification,
            'blood' => $request->blood,
            'religion' => $request->religion,
            'experince' => $request->experince,
            'address' => $request->address,
            'net_salary' => $request->net_salary,
            'employee_role' => $request->employee_role,
            'user_type' => 'Employee',
            'user_status' => 'Active',
            'user_pic' => $filename ,
        ]);
        //Get last inserted id employee
        $new_customer_id = $is_create_customer->id;
        //Check if employee created or not
        if($is_create_customer) {
            return redirect()->route('job.letter', $new_customer_id)->with('success', 'Employee created successfully.');
        } else {
            return back()->with('unsucess', 'Opps something went wrong!');
        }
    }

    public function search_employee_name(Request $request) {
        //Get ajax request for employee names
        $query = $request->customer_names;
        //Get employee
        $employee = User::where('user_type', 'Employee')->where('user_status', 'Active')->where('name', 'like', $query . '%')->first();
        if ($employee) {
            echo $employee->id; exit;
        }
        echo '<p style="color:red;">The employee name you entered was not found in our records. Please enter the correct name</p>';
        echo '<script>setTimeout(function () { window.location.reload(); }, 4000);</script>';
        exit;
    }

    //Function for edit employee
    public function edit_employee($id) {
        //Get employee detail
        $customer_detail = User::find($id);
        return view('super-admin.customers.edit-customer', compact('customer_detail'));
    }

    //Function for update employee
    public function update_employee(Request $request, $id) {
        //Validate input fields
        $request->validate([
            'name' => 'required|string|',
            'dob' => 'required|string',
            'father_name' => 'required|string',
            'national_id' => 'required|string',
            'employee_phone_no' => 'required|string',
            'gender' => 'required|string',
            'joining_date' => 'required|string',
            'qualification' => 'required|string',
            'blood' => 'required|string',
            'religion' => 'required|string',
            'experince' => 'required|string',
            'address' => 'required|string',
            'net_salary' => 'required|string',
            'employee_role' => 'required|string',
        ]);
        //Check if image is exit or not
        $filename = "";
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/employees'), $filename);
            //Update empoyee with image
            $is_update_employee = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $request->dob,
                'father_name' => $request->father_name,
                'national_id' => $request->national_id,
                'employee_phone_no' => $request->employee_phone_no,
                'gender' => $request->gender,
                'joining_date' => $request->joining_date,
                'qualification' => $request->qualification,
                'blood' => $request->blood,
                'religion' => $request->religion,
                'experince' => $request->experince,
                'address' => $request->address,
                'net_salary' => $request->net_salary,
                'employee_role' => $request->employee_role,
                'user_type' => 'Employee',
                'user_status' => $request->user_status,
                'user_pic' => $filename ,
            ]);
            //Check if employee updated or not
            if ($is_update_employee) {
                return back()->with('success', 'Employee updated successfully.');
            } else {
                return back()->with('unsuccess', 'Opps something went wrong!');
            }
        } else {
           //Update empoyee without image
            $is_update_employee = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $request->dob,
                'father_name' => $request->father_name,
                'national_id' => $request->national_id,
                'employee_phone_no' => $request->employee_phone_no,
                'gender' => $request->gender,
                'joining_date' => $request->joining_date,
                'qualification' => $request->qualification,
                'blood' => $request->blood,
                'religion' => $request->religion,
                'experince' => $request->experince,
                'address' => $request->address,
                'net_salary' => $request->net_salary,
                'employee_role' => $request->employee_role,
                'user_type' => 'Employee',
                'user_status' => $request->user_status,
            ]);
            //Check if employee updated or not
            if ($is_update_employee) {
                return back()->with('success', 'Employee updated successfully.');
            } else {
                return back()->with('unsuccess', 'Opps something went wrong!');
            }
        }
    }

    //Function for delete employee
    public function delete_employee(Request $request) {
        //Get ajax request for employee id
        $employee_id = $request->employee_id;
        //Trash user record
        $trash = EmployeeTrash::create([
            'employee_id' => $employee_id,
        ]);
        //Check if employee deleted or not
        if($trash) {
            User::where('unique_employee_id', $employee_id)->update([
                'user_status' =>'Suspend',
            ]);
            echo '<p style="color:green;">Employee deleted successfully.</p>';
        } else {
            echo '<p style="color:red;">Opps something went wrong!</p>';
        }
    }

    //Function for trash employees list
    public function trash_employees() {
        //Get customers
        $all_customers = User::OrderBy('ID','DESC')->where('user_status', 'Suspend')->get();
        return view('super-admin.customers.customers-trash', compact('all_customers'));
    }

    //Function for submit after job letter page
    public function job_letter($id) {
        //Get employee detail
        $employee_detail = User::where('id', $id)->where('user_status', 'Active')->where('user_type', 'Employee')->first();
        return view('super-admin.customers.job-letter', compact('employee_detail'));
    }

    //Function for search job letter
    public function search_job_letter() {
        return view('super-admin.customers.search-job-letter');
    }

    //Function for print job letter 
    public function print_job_letter($id) {
        //Get employee detail 
        $employee_detail = User::findOrFail($id); 
        return view('super-admin.customers.print', compact('employee_detail'));
    }

    //Function for employee report
    public function employee_report($id) {
        //Get employee detail 
        $employee_detail = User::where('id', $id)->where('user_status', 'Active')->where('user_type', 'Employee')->first();
        //echo "<pre>"; print_r($employee_detail->toArray());exit;
        return view('super-admin.customers.customer-report', compact('employee_detail'));
    }
}
