<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;  
use App\Models\EmployeeAssignAccessories;
use App\Models\EmployeeDamageAccessories;
use App\Models\Stock; 
use Carbon\Carbon;
use DateTime;

class EmployeeController extends Controller
{
    //Function for show all employees list
    public function all_employees_list() {
        $get_employees_detail = User::where('user_type', 'Employee')->Orderby('ID', 'ASC')->get();
        return view('admin.employees.all-employees-list', compact('get_employees_detail'));
    }

    //Function for employee role type
    public function search_employee_list(Request $request) {
        //Get the last segment from the URL
        $employee_role = $request->segment(count($request->segments()));
        $get_employees_detail = User::where('user_type', 'Employee')->where('user_status', 'Active')->where('employee_role', $employee_role)->Orderby('ID', 'ASC')->get();
        return view('admin.employees.search-employees-list', compact('get_employees_detail'));       
    }

    //Function to get single employee detail
    public function single_employee_detail(Request $request) {
        $employee_id = $request->input('employee_id');
        //Get single employee details
        $get_employee_detail = User::where([
            ['id', '=', $employee_id],
            ['user_type', '=', 'Employee']
        ])
        ->where('user_status', 'Active')
        ->first();

        //Get employee assigned accessories
        $get_employee_assign_accessories = EmployeeAssignAccessories::where('employee_id', $employee_id)->get();         
        //Get employee damaged accessories
        $get_employee_damage_accessories = EmployeeDamageAccessories::where('employee_id', $employee_id)->get(); 
    ?>    
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
                    <p><em>Registration No: </em><span><?php echo $get_employee_detail->unique_employee_id ?></span></p>
                    <p><em>Date of Birth: </em><span><?php echo \Carbon\Carbon::parse($get_employee_detail->dob)->format('d M Y') ?? '-' ?></span></p>
                    <p><em>Sex: </em><span><?php echo $get_employee_detail->gender ?? '-' ?></span></p>
                    <p><em>Category: </em><span><?php echo $get_employee_detail->category ?? '-' ?></span></p>
                    <p><em>Aadhar Card No: </em><span><?php echo $get_employee_detail->aadhar_no ?? '-' ?></span></p>
                    <p><em>Current Address: </em><span><?php echo $get_employee_detail->address . ', ' . $get_employee_detail->district . ', ' . $get_employee_detail->state . ', ' . $get_employee_detail->pin_code; ?></span></p>
                    </div>
                </div>
                <!--start all employees table-->
                <div class="table-all">
                    <!--start employee assign accessories table-->
                    <div class="table-qualification">
                    <div class="box-pay-assign">
                        <label>Assign Accessories Details</label>
                        <button type="button" class="pay-fes-buton employee_assign_accessori" data-employee_id= <?php echo $get_employee_detail['id']; ?> data-toggle="modal" data-target="#myModal">Employee Assign Accessories</button>
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
                    <div class="box-pay-damage">
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
                                <td><?php echo $damage_accessory->keyboard_damage ?></td>
                                <td><?php echo $damage_accessory->mouse_damage ?></td>
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
                    <!--end employee damage accessories table-->
                </div>
                <!--end all accessories table-->
            </div>
        </div>
        </div>
        <!--start employee asssign accessorie model-->
        <div class="modal fade pay-modal" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Employee Assign Accessories</h4>
                </div>
                <div class="modal-body">
                    <form action="#" id="employee_assign_accessoriess" Method="POST">
                    <input id="assign_model_employee_id" type="hidden" value="" name="employee_id">
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
        <!--end employee asssign accessorie model-->
        <!--start employee damage accessorie model-->
        <div class="modal pay-modals" id="myModals" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header-damage">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Employee Damage Accessories</h4>
                </div>
                <div class="modal-body-damage">
                    <form action="#" id="employee_damage_accessoriess" Method="POST">
                    <input id="damage_model_employee_id" type="hidden" value="" name="employee_id">
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
        <!--end employee damage accessorie model-->
    <?php
    }
    
    //Function for assign employee accessories
    public function submit_employee_assign_accessories(Request $request) {
        //Get stock detail
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
