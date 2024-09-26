<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Stock;
use App\Models\User; 
use App\Models\EmployeeSalary;
use App\Models\EmployeeSalaryIncrement;
use App\Models\EmployeeTrash;  
use App\Models\EmployeeAssignAccessories;
use App\Models\EmployeeDamageAccessories;
use Carbon\Carbon;
use DateTime;

class EmployeeController extends Controller
{
    //Function for show all employees list
    public function all_employees_list() {
        $get_employees_detail = User::where('user_type', 'Employee')->Orderby('ID', 'ASC')->with('emloyees_salary__detail','emloyees_salary_increment_detail')->get();
        return view('super-admin.employees.all-employees-list', compact('get_employees_detail'));
    }

    //Function for add new employee
    public function add_employee() {
        return view('super-admin.employees.add-new-employee');
    }

    //Function for submit employee
    public function submit_employee(Request $request) {
        //Check employee
        $get_employees = User::where('user_type', 'Employee')->count();
        
        //Check if employee is exists or not
        if ($get_employees == 0) {
            $next_employee_id = '0001';
        } else {
            //Get the last inserted employee record
            $last_insert_record = User::where('user_type', 'Employee')->latest()->first();
            //Increment last employee ID
            $last_employee_id = intval($last_insert_record->employee_id);
            $next_employee_id = str_pad($last_employee_id + 1, 4, '0', STR_PAD_LEFT);
        }

        //Check if the email already exists or not
        $is_email_exists = User::where('email', $request->email)->exists();
        if($is_email_exists) {
            return back()->with('unsuccess', 'Email is already taken, Please try with a new email.');
        } 
            //Check if image is exit or not
            $filename = 'default_user.png';
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('uploads/employees'), $filename);
            }

            //Check if qualification exist or not
            $qualification = '';
            if($request->has('qualification')) {
                //Convert array to string
                $qualification = implode(',', $request->input('qualification'));
            }
                //Create employees
                $is_create_employee = User::create([
                    'employee_id' => $next_employee_id,
                    'name' =>$request->first_name . " " . $request->last_name,
                    'first_name' =>$request->first_name,
                    'last_name' =>$request->last_name,
                    'email' =>$request->email,
                    'password' => Hash::make($request['password']),
                    'dob' =>$request->dob,
                    'aadhaar_no' =>$request->aadhaar_no,
                    'employee_phone_no' =>$request->employee_phone_no,
                    'gender' =>$request->gender,
                    'marital_status' =>$request->marital_status,
                    'category' =>$request->category,
                    'qualification' =>$qualification,
                    'address' =>$request->address,
                    'district' =>$request->district,
                    'state' =>$request->state,
                    'pin_code' =>$request->pin_code,
                    'joining_date' =>$request->joining_date,
                    'resign_date' =>$request->resign_date,
                    'net_salary' => base64_encode($request->net_salary),
                    'experince' =>$request->experince, 
                    'employee_role' =>$request->employee_role,
                    'user_type' => 'Employee',
                    'user_status' => 'Active',
                    'user_pic' => $filename, 
                ]);

                //Check if employee created or not
                if($is_create_employee){
                    return back()->with('success', 'Employee created successfully.');
                } else {
                    return back()->with('unsuccess', 'Opps something went wrong.');
                }
    }

    //Function for edit employee
    public function edit_employee($id) {
        //Get employee record
        $employee = User::find($id);
        //Check if the status is active after update
        if($employee->user_status === 'Active') {
            //delete trash record and resstore record
            EmployeeTrash::where('employee_id', $id)->delete();
        }

        return view('super-admin.employees.edit-employee', compact('employee'));
    }

    //Function for update employee
    public function update_employee(Request $request, $id) {
        //Check if image is exit or not
        $filename = 'default_user.png';
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/employees'), $filename);

            //Check if qualification exist or not
            $qualification = '';
            if($request->has('qualification')) {
                //Convert array to string
                $qualification = implode(',', $request->input('qualification'));
            }

            //Update employee with image
            $is_update_employee = User::where('id', $id)->update([
                'name' =>$request->first_name . " " . $request->last_name,
                'first_name' =>$request->first_name,
                'last_name' =>$request->last_name,
                'email' =>$request->email,
                'dob' =>$request->dob,
                'aadhaar_no' =>$request->aadhaar_no,
                'employee_phone_no' =>$request->employee_phone_no,
                'gender' =>$request->gender,
                'marital_status' =>$request->marital_status,
                'category' =>$request->category,
                'qualification' =>$qualification,
                'address' =>$request->address,
                'district' =>$request->district,
                'state' =>$request->state,
                'pin_code' =>$request->pin_code,
                'joining_date' =>$request->joining_date,
                'resign_date' =>$request->resign_date,
                'net_salary' => base64_encode($request->net_salary),
                'experince' =>$request->experince, 
                'employee_role' =>$request->employee_role,
                'user_type' => 'Employee',
                'user_status' =>$request->user_status,
                'user_pic' => $filename,
            ]);

            //Check if employee updated or not
            if($is_update_employee){
                return back()->with('success', 'Employee updated successfully.');
            } else {
                return back()->with('unsuccess', 'Opps something went wrong.');
            }
        } else {

            //Check if qualification exist or not
            $qualification = '';
            if($request->has('qualification')) {
                //Convert array to string
                $qualification = implode(',', $request->input('qualification'));
            }

            //Update employee without image
            $is_update_employee = User::where('id', $id)->update([
                'name' =>$request->first_name . " " . $request->last_name,
                'first_name' =>$request->first_name,
                'last_name' =>$request->last_name,
                'email' =>$request->email,
                'dob' =>$request->dob,
                'aadhaar_no' =>$request->aadhaar_no,
                'employee_phone_no' =>$request->employee_phone_no,
                'gender' =>$request->gender,
                'marital_status' =>$request->marital_status,
                'category' =>$request->category,
                'qualification' =>$qualification,
                'address' =>$request->address,
                'district' =>$request->district,
                'state' =>$request->state,
                'pin_code' =>$request->pin_code,
                'joining_date' =>$request->joining_date,
                'resign_date' =>$request->resign_date,
                'net_salary' => base64_encode($request->net_salary),
                'experince' =>$request->experince, 
                'employee_role' =>$request->employee_role,
                'user_type' => 'Employee',
                'user_status' =>$request->user_status,
            ]);

            //Check if employee updated or not
            if($is_update_employee){
                return back()->with('success', 'Employee updated successfully.');
            } else {
                return back()->with('unsuccess', 'Opps something went wrong.');
            }
        }        
    }

    //Function for employee role type
    public function search_employee_list(Request $request) {
        //Get the last segment from the URL
        $employee_role = $request->segment(count($request->segments()));
        $get_employees_detail = User::where('user_type', 'Employee')->where('user_status', 'Active')->where('employee_role', $employee_role)->Orderby('ID', 'DESC')->get();
        return view('super-admin.employees.search-employees-list', compact('get_employees_detail'));       
    }

    //Function to pay employee salary
    public function submit_employee_salary(Request $request) {
        $employe_slary = (int)$request->employee_salary;
        //Get the current date
        $current_date = Carbon::now();

        //Calculate the end date (30 days from the current date)
        $newDate = $current_date->copy()->addDays(30);

        //Get employee details
        $employee = User::find($request->employee_id);

        //Decode net salary
        $netSalary = base64_decode($employee->net_salary);

        //get first record of employe salary
        $salariesThisMonth = EmployeeSalary::where('employee_id', $request->employee_id)->first();

        $totalPaidThisMonth = 0;
        if ($salariesThisMonth) {
            $get_last_paid_date = $salariesThisMonth->submission_date;
            $get_end_date = $salariesThisMonth->end_date;
    
            $all_salaries_paid = EmployeeSalary::where('employee_id', $request->employee_id)
            ->whereBetween('submission_date', [$get_last_paid_date, $get_end_date])
            ->get();
    
            // Calculate the total paid salary for this month
            foreach ($all_salaries_paid as $salary) { 
                $total_salary = base64_decode($salary->employee_salary);
                $totalPaidThisMonth += (int)$total_salary;
            }
        }
        //Check if the total salary paid this month exceeds the net salary
        if (($totalPaidThisMonth + $employe_slary) > $netSalary) {
            echo '<p style="color:red;">The total salary payments for the current month exceed the net salary, Please enter a valid salary amount.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
            return;
        }

        //Create employee salary record
        $is_create_employee_salary = EmployeeSalary::create([
            'employee_id' => $request->employee_id,
            'employee_name' => $request->employee_name,
            'employee_salary' => base64_encode($request->employee_salary),
            'payment_type' => 'Online',
            'submission_date' => $current_date,
            'end_date' => $newDate,
            'employee_status' => 'Active',
        ]);

        // Check if employee salary is created successfully
        if ($is_create_employee_salary) {
            echo '<p style="color:green;">Employee salary submitted successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Oops, something went wrong.</p>';
        }
    }

        
    //Function for submit employee salary
    public function submit_employee_salary_increment(Request $request) {
        // Get current date
        $now = Carbon::now();
        
        // Create employee salary increment
        $is_create_salary = EmployeeSalaryIncrement::create([
            'employee_id' => $request->employee_id,
            'employee_name' => $request->employee_name,
            'increment_amount' => base64_encode($request->increment_amount),
            'date' => $now,
        ]);  
        
        // Check if employee salary increment was created
        if($is_create_salary) {
            $increment_amount = (float) $request->input('increment_amount');
            
            // Get employee record
            $employee = User::find($request->employee_id);
            if ($employee) {
                // Decode the current net salary
                $current_salary = (float) base64_decode($employee->net_salary);
                
                // Update the net salary by adding the increment amount
                $updated_salary = $current_salary + $increment_amount;
                
                // Encode the updated net salary before saving it
                $employee->net_salary = base64_encode($updated_salary);
                $employee->save();
        
                echo '<p style="color:green;">Employee increment created successfully.</p>';
                echo '<script> setTimeout(function () { window.location.reload(); }, 2000); </script>';
            } else {
                echo '<p style="color:red;">Employee not found.</p>';
            }
        } else {
            echo '<p style="color:red;">Oops something went wrong.</p>';
        }
    }
     
    //Function for employee single detail
    public function single_employee_detail(Request $request) {
        $employee_id = $request->input('employee_id');       
        //Get single employee details
        $get_employee_detail = User::where([
            ['id', '=', $employee_id],
            ['user_type', '=', 'Employee']
        ])
        ->where('user_status', 'Active')
        ->with('emloyees_salary_increment_detail')->first();
    
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
        
        //Get the current year
        $currentYear = Carbon::now()->year;
    
        //Get salary and increment 
        $baseSalaries = [];
        $incrementsForMonth = [];

        //Function to decode base64 encoded salary
        function decodeSalary($encodedSalary) {
            return (float) base64_decode($encodedSalary);
        }
        
        //Get salary and increment amounts
        foreach ($months as $month => $monthName) {
            //Get paid salaries for the current month
            $encodedSalaries = EmployeeSalary::where('employee_status', 'Active')
                ->where('employee_id', $employee_id)
                ->whereMonth('submission_date', $month)
                ->whereYear('submission_date', $currentYear)
                ->pluck('employee_salary'); 
    
            //Decode and sum paid salaries
            $paidAmount = $encodedSalaries->map(function ($encodedSalary) {
                return decodeSalary($encodedSalary);
            })->sum(); 
            
            //Decode the base salary and add increment
            $baseSalary = $paidAmount;
            $increments = $get_employee_detail->emloyees_salary_increment_detail;
            $incrementAmount = $increments->filter(function ($increment) use ($month) {
                return date('m', strtotime($increment->date)) == $month;
            })->map(function ($increment) {
                return decodeSalary($increment->increment_amount);
            })->sum();
    
            $baseSalaries[$monthName] = $baseSalary; 
            $incrementsForMonth[$monthName] = $incrementAmount; 
        }
    
        //Get the start and end dates for the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        //Total paid salary for the current month
        $total_paid_salary = EmployeeSalary::where('employee_status', 'Active')
            ->where('employee_id', $employee_id)
            ->whereBetween('submission_date', [$startOfMonth, $endOfMonth])
            ->sum('employee_salary');
        
        //Get employee assigned accessories
        $get_employee_assign_accessories = EmployeeAssignAccessories::where('employee_id', $employee_id)->get();     
        //Get employee damaged accessories
        $get_employee_damage_accessories = EmployeeDamageAccessories::where('employee_id', $employee_id)->get(); 
    
    ?>    
        <!--start employee detail-->
        <div class="all-student">
        <div class="container">
            <div class="main-student">
                <div class="section-name">
                    <div class="name">
                    <div class="profile-image-popup">
                        <img src="<?php echo url('public/uploads/employees/' . $get_employee_detail->user_pic); ?>" alt="Employee Picture">
                    </div>
                    <h3><?php echo $get_employee_detail->name ?? '-' ?></h3>
                    <p><?php echo $get_employee_detail->employee_role ?? '-'?></p>
                    <p><?php echo $get_employee_detail->email ?? '-' ?></p>
                    <p><?php echo substr($get_employee_detail->employee_phone_no, 0, 5) . '-' . substr($get_employee_detail->employee_phone_no, 5) ?></p>
                    <?php if($get_employee_detail->joining_date) { ?>
                    <p><span>Joining Date: </span><?php echo \Carbon\Carbon::parse($get_employee_detail->joining_date)->format('d M Y') ?? '-' ?></p>
                    <?php } else { ?>
                        <p><span>Joining Date: </span>-</p>
                    <?php } ?>
                    </div>
                    <div class="info">
                    <h4>Information</h4>
                    </div>
                    <div class="detail">
                    <p><em>Employee ID: </em><span><?php echo $get_employee_detail->unique_employee_id ?></span></p>
                    <p><em>Date of Birth: </em><span><?php echo \Carbon\Carbon::parse($get_employee_detail->dob)->format('d M Y') ?? '-' ?></span></p>
                    <p><em>Sex: </em><span><?php echo $get_employee_detail->gender ?? '-' ?></span></p>
                    <p><em>Category: </em><span><?php echo $get_employee_detail->category ?? '-' ?></span></p>
                    <p><em>Aadhar Card No: </em><span><?php echo $get_employee_detail->aadhar_no ?? '-' ?></span></p>
                    <p><em>Current Address: </em><span><?php echo $get_employee_detail->address . ', ' . $get_employee_detail->district . ', ' . $get_employee_detail->state . ', ' . $get_employee_detail->pin_code; ?></span></p>
                    </div>
                </div>
                <!--end employee detail-->
                <!--start all employee table-->
                <div class="table-all">
                    <!--start employee monthly salary table-->
                    <div class="table-qualification">
                    <label>Employee Monthly Salary Details</label>
                    <div id="table-scroll" class="table-scroll first-table">
                        <table id="main-table" class="main-table">
                            <thead>
                                <tr>
                                <th>Sr. No.</th>
                                <th>Month</th>
                                <th>Increment Amount</th>
                                <th>Paid Amount</th>
                                </tr>
                            </thead>
                            <tbody class="scroll">
                                <?php
                                $months = [
                                    'April' => $baseSalaries['April'] ?? 0,
                                    'May' => $baseSalaries['May'] ?? 0,
                                    'June' => $baseSalaries['June'] ?? 0,
                                    'July' => $baseSalaries['July'] ?? 0,
                                    'August' => $baseSalaries['August'] ?? 0,
                                    'September' => $baseSalaries['September'] ?? 0,
                                    'October' => $baseSalaries['October'] ?? 0,
                                    'November' => $baseSalaries['November'] ?? 0,
                                    'December' => $baseSalaries['December'] ?? 0,
                                    'January' => $baseSalaries['January'] ?? 0,
                                    'February' => $baseSalaries['February'] ?? 0,
                                    'March' => $baseSalaries['March'] ?? 0,
                                ];
                                
                                $count = 1;
                                $total_paid_salary = 0;
                                $total_increment = 0;
                                
                                foreach ($months as $month => $baseSalary) {
                                    $increment = $incrementsForMonth[$month] ?? 0;
                                
                                    ?>
                                <tr>
                                <td><?php echo $count++; ?>.</td>
                                <td><?php echo htmlspecialchars($month); ?></td>
                                <td>
                                    <?php 
                                        echo $increment > 0 ? number_format($increment) : '-';
                                        ?>
                                </td>
                                <td>
                                    <?php 
                                        //Show paid amount 
                                        echo $baseSalary > 0 ? number_format($baseSalary) : '-';
                                        ?>
                                </td>
                                </tr>
                                <?php
                                //Calculate total paid salary and total increment
                                $total_paid_salary += $baseSalary;
                                $total_increment += $increment;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="tfooter">
                                <td class="space" colspan="3">
                                    <span style="color: green;">
                                    Total Paid Salary for the Year:-<?php echo Carbon::now()->year; ?>
                                    </span>
                                </td>
                                <td><strong style="color: black;"><?php echo number_format($total_paid_salary); ?></strong></td>
                                </tr>
                                <tr class="tfooter">
                                <td class="space" colspan="3">
                                    <span style="color: black;">
                                    Total Net Salary:
                                    </span>
                                </td>
                                <td><strong style="color: black;"><?php echo $get_employee_detail->net_salary > 0 ? number_format(decodeSalary($get_employee_detail->net_salary)) : '-'; ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    </div>
                    <!--end employee monthly salary table-->
                    <!--start employee assign accessories table-->
                    <div class="table-qualification">
                    <div class="box-pay">
                        <label>Assign Accessories Details</label>
                        <button type="button" class="pay-fes-buton employee_assign_accessori" data-employee_id= <?php echo $get_employee_detail['id']; ?> data-toggle="modal" data-target="#Assign_Accessories">Employee Assign Accessories</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Keyboard</th>
                                <th>Mouse</th>
                                <th>Assign Accessories Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($get_employee_assign_accessories->isNotEmpty()) : ?>
                            <?php $count = 1; ?>
                            <?php foreach ($get_employee_assign_accessories as $accessory) : ?>
                            <tr>
                                <td><?php echo $count++ ?>.</td>
                                <td><?php echo $accessory->keyboard_assigned ?></td>
                                <td><?php echo $accessory->mouse_assigned ?></td>
                                <td><?php echo (new DateTime($accessory->created_at))->format('d M Y') ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="4">No accessories assigned to this employee.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                    <!--end employee assign accessories table-->
                    <!--start employee damage accessories table-->
                    <div class="table-qualification">
                    <div class="box-pay">
                        <label>Damage Accessories Details</label>                    
                        <button type="button" class="pay-fes-buton employee_damage_accessories" data-employee_id=<?php echo $get_employee_detail['id']; ?> data-toggle="modal" data-target="#myModals">Employee Damage Accessories</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Keyboard</th>
                                <th>Mouse</th>
                                <th>Damage Accessories Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($get_employee_damage_accessories->isNotEmpty()) : ?>
                            <?php $count = 1; ?>
                            <?php foreach ($get_employee_damage_accessories as $damage_accessory) : ?>
                            <tr>
                                <td><?php echo $count++ ?>.</td>
                                <td><?php echo $damage_accessory->keyboard_damaged ?></td>
                                <td><?php echo $damage_accessory->mouse_damaged ?></td>
                                <td><?php echo (new DateTime($damage_accessory->created_at))->format('d M Y') ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="4">No damaged accessories recorded for this employee.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
       <!--end employee damage accessories table-->
        </div>
        <!--end all employee table-->
        <!--start employee asssign model-->
        <div class="modal pay-modal" id="Assign_Accessories" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Employee Assign Accessories</h4>
                </div>
                <div class="modal-body">
                    <form action="#" id="employee_assign_accessoriess" Method="POST">
                    <input id="models_employee_id" type="hidden" value="" name="employee_id">
                    <input type="text" id="keyboard_assigned" name="keyboard_assigned" placeholder="Keyboard Assigned" />
                    <input type="text" id="mouse_assigned" name="mouse_assigned" placeholder="Mouse Assigned"/>
                    <div class="button-save is_create_employee_assign_accessories"><button type="submit">Save</button></div>
                    </form>
                    <div class="loader com_ajax_loader" style="display:none;">
                    <img src="<?php echo url('public/admin/images/200w.gif'); ?>">
                    </div>
                </div>
                <div class="assign_accessorie_responce"></div>
            </div>
        </div>
        </div>
        <!--end employee asssign model-->
        <!--start employee damage model-->
        <div class="modal pay-modals" id="myModals" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Employee Damage Accessories</h4>
                </div>
                <div class="modal-body">
                    <form action="#" id="employee_damage_accessoriess" Method="POST">
                    <input id="modeal_employee_id" type="hidden" value="" name="employee_id">
                    <input type="text" id="keyboard_damage" name="keyboard_damage" placeholder="Keyboard Damage" />
                    <input type="text" id="mouse_damage" name="mouse_damage" placeholder="Mouse Damage"/>
                    <input type="text" id="remark" name="remark" placeholder="Remark"/>
                    <div class="button-save is_create_damage_damage_accessories"><button type="submit">Save</button></div>
                    </form>
                    <div class="loader com_ajax_loader" style="display:none;">
                    <img src="<?php echo url('public/admin/images/200w.gif'); ?>">
                    </div>
                </div>
                <div class="damage_accessorie_responce"></div>
            </div>
        </div>
        </div>
        <!--end employee asssign model-->
        <?php
    }

    //Function for show trash employees list
    public function all_trash_employees_list() {
        $get_trash_employees_detail = User::Orderby('ID', 'DESC')->where('user_type', 'Employee')->whereIn('user_status', ['Leave', 'Suspend'])->with('employee_trash_detail')->get();
        return view('super-admin.employees.all-employees-trash-list', compact('get_trash_employees_detail'));
    }

    //Function for trash employee record
    public function trash_employee(Request $request) {
        //Get request through ajax
        $employee_id = $request->input('employee_id');
        $employee_status = $request->input('employee_status');

        //Create trash employee record
        $employee_trash = EmployeeTrash::create([
            'employee_id' =>$request->employee_id,
        ]);
        //Check if employee record is trash or not
        if($employee_trash) {
            User::where('id', $employee_id)->update([
                'user_status' =>$request->employee_status,
            ]);
            echo '<p style="color:green;">Employee record trashed successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000); </script>';
        } else {
            echo '<p style="color:red;">Oops something went wrong.</p>';
        }        
    }

    //Function for delete employee
    public function delete_employee(Request $request) {
        //Get ajax request 
        $employee_id = $request->employee_id;
        //Delete employee record
        $is_delete_employee = User::where('id', $employee_id)->delete();
        //Check if employee trash record deleted or not
        if($is_delete_employee) { 
            EmployeeTrash::where('employee_id', $employee_id)->delete();
            EmployeeSalaryIncrement::where('employee_id', $employee_id)->delete();
            EmployeeAssignAccessories::where('employee_id', $employee_id)->delete();
            EmployeeDamageAccessories::where('employee_id', $employee_id)->delete();
            return back()->with('success', 'Employee deleted successfullly.');
        } else {
            return back()->with('Oppps something went wrong.');
        }
    }
    
    //Function for assign accessories
    public function submit_employee_assign_accessories(Request $request) {
        //Get stock
        $stock = Stock::first();
        //Check if stock is exists or not
        if (!$stock) {
            echo '<p style="color:red;">Stock not available. Please create stock first.</p>';
            return;
        }
        //Calculate the total assigned keyboards and mouse
        $totalKeyboardAssigned = EmployeeAssignAccessories::sum('keyboard_assigned') + $request->keyboard_assigned;
        $totalMouseAssigned = EmployeeAssignAccessories::sum('mouse_assigned') + $request->mouse_assigned;
        //Check if accessories is available stock or not
        if ($totalKeyboardAssigned > $stock->total_keyboard_stock || $totalMouseAssigned > $stock->total_mouse_stock) {
            echo '<p style="color:red;">Insufficient stock. Please update the stock first.</p>';
            return;
        }    

        //Create employee assign accessories
        $is_create_employee_assign_accessories = EmployeeAssignAccessories::create([
            'employee_id' => $request->employee_id,
            'keyboard_assigned' => $request->keyboard_assigned,
            'mouse_assigned' => $request->mouse_assigned,
        ]);

        //Check if employee assign is created and updated or not
        if ($is_create_employee_assign_accessories) {
            //Update the stock record
            $stock->assign_keyboard = EmployeeAssignAccessories::sum('keyboard_assigned');
            $stock->assign_mouse = EmployeeAssignAccessories::sum('mouse_assigned');
            $stock->save();
    
            echo '<p style="color:green;">Employee assign accessories created successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Failed to create employee assign accessories.</p>';
        }
    } 

    //Function for damage employee accessories
    public function submit_employee_damage_accessories(Request $request) {
        //Create employee damage accessories
        $is_create_employee_damage_acessories = EmployeeDamageAccessories::create([
            'employee_id' => $request->employee_id, 
            'keyboard_damage' => $request->keyboard_damage,
            'mouse_damage' => $request->mouse_damage,
            'remark' => $request->remark,
        ]);

        //Check if damage accessories created or not
        if ($is_create_employee_damage_acessories) {
            echo '<p style="color:green;">Employee damage accessories created successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Opps something went wrong.</p>';
        }
    } 
}
