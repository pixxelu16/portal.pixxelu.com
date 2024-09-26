<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StudentFees;
use App\Models\StudentAssignAccessories;
use App\Models\StudentDamageAccessories;
use App\Models\EmployeeAssignAccessories;
use App\Models\EmployeeDamageAccessories;
use App\Models\Stock;
use App\Models\Trash;
use Carbon\Carbon;
use DateTime;

class StudentController extends Controller
{
    //Function for Get all students list
    public function all_students() {
        //Get students details
        $get_students_detail = User::where('user_type', 'Student')->where('user_status', 'Active')->orderBy('id', 'DESC')->with('student_fees_detail')->get();
       
        //Get total students list acc to course  
        $is_total_students = User::where('user_status', 'Active')->where('user_type', 'Student')->count();
        $is_web_designing_students = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Web Designing')->count();
        $is_web_development_students = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Web Development')->count();
        $is_full_stack_development = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Full Stack Development')->count();
        $is_php = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Php Development')->count();
        $is_graphic = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Graphic')->count();
        $digital_marketing = User::where('user_status', 'Active')->where('user_type', 'Student')->where('course_type', 'Digital Marketing')->count();

        return view('admin.students.all-students-list', compact('get_students_detail', 'is_total_students', 'is_web_designing_students','is_web_development_students','is_full_stack_development','is_php','is_graphic','digital_marketing'));
    }

    //Function for add new student
    public function add_student() {
        return view('admin.students.add-new-student');
    }

    //Function for submit student
    public function submit_student(Request $request) {
        //Check if the email already exists
        $is_email_exists = User::where('email', $request->email)->exists();
        if ($is_email_exists) {
            return back()->with('unsuccess', 'Email is already taken, Please try with a new email.');
        }
        //Check if user image exists or not
        $filename = 'default_user.png';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/users'), $filename);
        }

        //Check if qualification exist or not
        $qualification = '';
        if ($request->has('qualification')) {
            //Convert array to string
            $qualification = implode(',', $request->input('qualification'));
        }

        //Calculation course joining date
        $course_joining_date = Carbon::parse($request->course_joining_date);
        $course_completion_date = $course_joining_date->add($request->course_duration);
        //Format the completion date
        $course_completion_date_formatted = $course_completion_date->format('Y-m-d');

        //Create student
        $create_student = User::create([
            'name' => $request->first_name . " " . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'father_name' => $request->father_name,
            'father_phone_no' => $request->father_phone_no,
            'aadhaar_no' => $request->aadhaar_no,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'student_phone_no' => $request->student_phone_no,
            'marital_status' => $request->marital_status,
            'category' => $request->category,
            'address' => $request->address,
            'district' => $request->district,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'qualification' => $qualification,
            'course_type' => $request->course_type,
            'course_duration' => $request->course_duration,
            'course_joining_date' => $request->course_joining_date,
            'course_complession_date' => $course_completion_date_formatted,
            'batch_timing' => $request->batch_timing,
            'total_fees' => $request->total_fees,
            'user_status' => 'Active',
            'user_type' => 'Student',
            'user_pic' => $filename,
        ]);

        //Check if student record created or not
        if ($create_student) {
            return back()->with('success', 'Student record created successfully.');
        } else {
            return back()->with('unsuccess', 'Oops, something went wrong.');
        }
    }

    //Function for edit student
    public function edit_student($id) {
        $student = User::find($id);
        //Check if the status is active after update
        if ($student->user_status === 'Active') {
            //delete trash record and restore record
            Trash::where('user_id', $id)->delete();
        }

        return view('admin.students.edit-student', compact('student'));
    }

    //Function for update student 
    public function update_student(Request $request, $id) {
        //Check if user image is exit or not
        $filename = 'default_user.png';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/users'), $filename);
            //Check if qualification exist or not
            $qualification = '';
            if ($request->has('qualification')) {
                //Convert array to string
                $qualification = implode(',', $request->input('qualification'));
            }
            //Check if the course joining date and course duration exists or not 
            if ($request->has('course_joining_date') && $request->has('course_duration')) {
                //Calculation course joining date
                $course_joining_date = Carbon::parse($request->course_joining_date);
                $course_completion_date = $course_joining_date->add($request->course_duration);
                //Format the completion date
                $course_completion_date_formatted = $course_completion_date->format('Y-m-d');
                //Update student record with image
                $update_student = User::where('id', $id)->update([
                    'course_complession_date' => $course_completion_date_formatted,
                ]);
            }
            //Update student record with image
            $update_student = User::where('id', $id)->update([
                'name' => $request->first_name . " " . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'father_name' => $request->father_name,
                'father_phone_no' => $request->father_phone_no,
                'aadhaar_no' => $request->aadhaar_no,
                'student_phone_no' => $request->student_phone_no,
                'marital_status' => $request->marital_status,
                'category' => $request->category,
                'address' => $request->address,
                'district' => $request->district,
                'state' => $request->state,
                'pin_code' => $request->pin_code,
                'qualification' => $qualification,
                'course_type' => $request->course_type,
                'course_duration' => $request->course_duration,
                'course_joining_date' => $request->course_joining_date,
                'batch_timing' => $request->batch_timing,
                'total_fees' => $request->total_fees,
                'user_status' => $request->user_status,
                'user_type' => 'Student',
                'user_pic' => $filename,
            ]);

            //Check if student record created or not
            if ($update_student) {
                return back()->with('success', 'Student record updated successfully.');
            } else {
                return back()->with('unsuccess', 'Opps something went wrong.');
            }
        } else {
            //Check if qualification exist or not
            $qualification = '';
            if ($request->has('qualification')) {
                //Convert array to string
                $qualification = implode(',', $request->input('qualification'));
            }
            //Check if the course joining date and course duration exists or not 
            if ($request->has('course_joining_date') && $request->has('course_duration')) {
                //Calculation course joining date
                $course_joining_date = Carbon::parse($request->course_joining_date);
                $course_completion_date = $course_joining_date->add($request->course_duration);
                //Format the completion date
                $course_completion_date_formatted = $course_completion_date->format('Y-m-d');
                //Update student record without image
                $update_student = User::where('id', $id)->update([
                    'course_complession_date' => $course_completion_date_formatted,
                ]);
            }
            //Update student record without image
            $update_student = User::where('id', $id)->update([
                'name' => $request->first_name . " " . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'father_name' => $request->father_name,
                'father_phone_no' => $request->father_phone_no,
                'aadhaar_no' => $request->aadhaar_no,
                'student_phone_no' => $request->student_phone_no,
                'marital_status' => $request->marital_status,
                'category' => $request->category,
                'address' => $request->address,
                'district' => $request->district,
                'state' => $request->state,
                'pin_code' => $request->pin_code,
                'qualification' => $qualification,
                'course_type' => $request->course_type,
                'course_duration' => $request->course_duration,
                'course_joining_date' => $request->course_joining_date,
                'batch_timing' => $request->batch_timing,
                'total_fees' => $request->total_fees,
                'user_status' => $request->user_status,
                'user_type' => 'Student',
            ]);

            //Check if student record created or not
            if ($update_student) {
                return back()->with('success', 'Student record updated successfully.');
            } else {
                return back()->with('unsuccess', 'Opps something went wrong.');
            }
        }
    }

    //Function for student submit fees
    public function submit_student_fees(Request $request)  {
        //Get current date and calculate end date
        $now = Carbon::now();
        $newDate = $now->copy()->addDays(30);

        //Create student fees    
        $is_create_student_fees = StudentFees::create([
            'user_id' => $request->student_id,
            'user_fees' => $request->fees_amount,
            'is_down_payment' => $request->first_payment_type,
            'payment_type' => $request->payment_type,
            'submission_date' => $now,
            'end_date' => $newDate,
        ]);
        //Check if student submit fees created or not
        if ($is_create_student_fees) {
            echo '<p style="color:green;">Student fees submitted successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Opps something went wrong.</p>';
        }
    }

    //Function for add previous student fees 
    public function add_previous_fees()   {
        $get_student_details = User::where('user_type', 'Student')->get();
        return view('admin.students.add-student-previous-fees', compact('get_student_details'));
    }

    //Function for submit previous student fees
    public function submit_previous_fees(Request $request) {
        //Get last date submission
        $submission_date = Carbon::parse($request->submission_date);
        $end_date = $submission_date->copy()->addDays(30);

        //Create student fees    
        $is_create_student_fees = StudentFees::create([
            'user_id' => $request->previous_student_id,
            'user_fees' => $request->amount,
            'payment_type' => $request->payment_type,
            'submission_date' => $submission_date,
            'end_date' => $end_date,
        ]);

        //Check if previous student fees exists or not
        if ($is_create_student_fees) {
            return back()->with('success', 'Add student previous fees successfully.');
        } else {
            return back()->with('unsuccess', 'Opps something went wrong.');
        }
    }

     //Function for view single student list
     public function single_student_detail(Request $request)  {
        $studentId = $request->input('studentId');
        //Get student detail
        $get_student_detail = User::where([['id', '=', $studentId], ['user_type', '=', 'Student']])
            ->where('user_status', 'Active')
            ->with('student_fees_detail', 'student_assign_accessories')
            ->first();

        //Get student damage accessories 
        $get_student_damage_accessories = StudentDamageAccessories::where('user_id', $studentId)->get();

        $course_duration = $get_student_detail->course_duration;
        $course_joining_date = Carbon::parse($get_student_detail->course_joining_date);

        //Get course joining date
        $start_date = $course_joining_date->copy();
        $end_date = $course_joining_date->copy();

        //Calculate the end date acc course duration
        if ($course_duration == '1 Month') {
            $end_date->addMonth();
        } elseif ($course_duration == '3 Month') {
            $end_date->addMonths(3);
        } elseif ($course_duration == '6 Month') {
            $end_date->addMonths(6);
        } elseif ($course_duration == '1 Year') {
            $end_date->addYear();
        } elseif ($course_duration == '2 Year') {
            $end_date->addYears(2);
        } else {
            $end_date->addYear();
        }

        ?>
        <div class="all-student">
            <div class="contanier">
                <div class="main-student">
                    <div class="section-name">
                        <div class="name">
                            <div class="profile-image-popup">
                                <img src="<?php echo url('public/uploads/users/' . $get_student_detail->user_pic); ?>"
                                    alt="Student Picture">
                            </div>
                            <h3><?php echo $get_student_detail->name ?></h3>
                            <p><?php echo $get_student_detail->course_type ?></p>
                            <p><?php echo $get_student_detail->email ?></p>
                            <p><?php echo substr($get_student_detail->student_phone_no, 0, 5) . '-' . substr($get_student_detail->student_phone_no, 5) ?></span>
                            </p>
                            <p><span>Joining
                                    Date:-</span><?php echo \Carbon\Carbon::parse($get_student_detail->course_joining_date)->format('d M Y') ?>
                            </p>
                        </div>
                        <div class="info">
                            <h4>information</h4>
                        </div>
                        <div class="detail">
                            <p><em>registration no: </em><span><?php echo $get_student_detail->id ?></span></p>
                            <p><em>father's name:</em><span><?php echo $get_student_detail->father_name ? $get_student_detail->father_name : '-'; ?></span></p>
                            <p><em>father's phone no:</em><span><?php echo substr($get_student_detail->father_phone_no, 0, 5) . '-' . substr($get_student_detail->father_phone_no, 5) ?></span></p>
                            <p><em>batch timing:</em><span><?php echo $get_student_detail->batch_timing ? $get_student_detail->batch_timing : '-'; ?></span></p>
                            <p><em>date of birth:</em><span><?php echo \Carbon\Carbon::parse($get_student_detail->dob)->format('d M Y') ?></span></p>
                            <p><em>sex:</em><span><?php echo $get_student_detail->gender ? $get_student_detail->gender : '-'; ?></span></p>
                            <p><em>category:</em><span><?php echo $get_student_detail->category ? $get_student_detail->category : '-'; ?></span></p>
                            <p><em>Aadhar card no:</em><span><?php echo $get_student_detail->aadhaar_no ? $get_student_detail->aadhaar_no : '-'; ?></span></p>
                            <p><em>current address:</em><span><?php echo $get_student_detail->address . ', ' . $get_student_detail->district . ', ' . $get_student_detail->state . ', ' . $get_student_detail->pin_code; ?></span></p>
                        </div>
                    </div>
                    <!--start students all tables-->
                    <div class="table-all">
                        <!--start students monthly fees table-->
                        <div class="table-qualification">
                            <label>Monthly Fees details</label>
                            <div id="table-scroll" class="table-scroll first-table">
                                <table id="main-table" class="main-table">
                                    <thead>
                                        <tr class="sticky">
                                            <th>Sr.No.</th>
                                            <th>Name Of Month</th>
                                            <th>Payment Type</th>
                                            <th class="small">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="scroll">
                                        <?php if ($get_student_detail): ?>
                                            <?php
                                            $count = 1;
                                            $totalFees = $get_student_detail['total_fees'];
                                            $paidFees = 0;
                                            $currentDate = new \DateTime($start_date);
                                            $endDate = new \DateTime($end_date);
                                            ?>
                                            <?php while ($currentDate < $endDate): ?>
                                                <?php
                                                $monthlyFees = 0;
                                                //sum all payments for the current month
                                                foreach ($get_student_detail['student_fees_detail'] as $fee) {
                                                    $submissionDate = new \DateTime($fee['submission_date']);
                                                    if ($submissionDate->format('m-Y') == $currentDate->format('m-Y')) {
                                                        $monthlyFees += $fee['user_fees'];
                                                        $paidFees += $fee['user_fees'];
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $count++ ?>.</td>
                                                    <td><?php echo $currentDate->format('M Y') ?></td>
                                                    <td>
                                                        <?php
                                                        $feePaidForMonth = false;
                                                        foreach ($get_student_detail['student_fees_detail'] as $fee):
                                                            $submissionDate = new \DateTime($fee['submission_date']);
                                                            //Check if the current month's fee exists
                                                            if ($submissionDate->format('m-Y') === $currentDate->format('m-Y')):
                                                                $feePaidForMonth = true;
                                                                ?>
                                                                <span class="total-paid-payment">
                                                                    <em>(<?php echo $fee['user_fees']; ?> /
                                                                        <?php echo $fee['payment_type']; ?>)</em>
                                                                    <button class="btn btn-primary btn-sm edit-btn"
                                                                        data-fee-id="<?php echo $fee['id']; ?>" 
                                                                        data-fee-month="<?php echo $fee['submission_date']; ?>"                                                                               
                                                                        data-fee-amount="<?php echo $fee['user_fees']; ?>"
                                                                        data-student-name="<?php echo $get_student_detail['name']; ?>">                           
                                                                        <img src="<?php echo url('public/admin/images/edite-icon.svg'); ?>"
                                                                            alt="Edit Icon">
                                                                    </button>
                                                                </span><br>
                                                                <?php
                                                            endif;
                                                        endforeach;
                                                        //If no fee is paid for the current month
                                                        if (!$feePaidForMonth):
                                                            ?>
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (count($get_student_detail['student_fees_detail']) > 0): ?>
                                                            <?php if ($monthlyFees > 0): ?>
                                                                <?php echo number_format($monthlyFees, 0); ?>
                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <!--If no fee records exist-->
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $currentDate->modify('+1 month');
                                                ?>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="tfooter">
                                            <td class="space" colspan="3"><span style="color: black;">Total Fees:</span></td>
                                            <td><strong><?php echo 'Rs.' . number_format($totalFees, 0) ?></strong></td>
                                        </tr>
                                        <tr class="tfooter">
                                            <td class="space" colspan="3"><span style="color: green;">Total Paid Fees:</span>
                                            </td>
                                            <td><strong style="color: green;"><?php echo 'Rs. ' . number_format($paidFees, 0) ?></strong>
                                            </td>
                                        </tr>
                                        <tr class="tfooter">
                                            <td class="space" colspan="3"><span style="color: red;">Remaining Fees:</span></td>
                                            <td><strong
                                                    style="color: red;"><?php echo 'Rs. ' . number_format($totalFees - $paidFees, 0) ?></strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!--end students monthly fees table-->
                        <!--start student assign accessoriess table-->
                        <?php if ($get_student_detail['student_assign_accessories']->count() > 0): ?>
                            <div class="table-qualification">
                                <label>Assign Accessories details</label>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Keyboard</th>
                                            <th>Mouse</th>
                                            <th>Assign Accessories Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($get_student_detail && !empty($get_student_detail['student_assign_accessories'])): ?>
                                            <?php
                                            $count = 1;
                                            ?>
                                            <?php foreach ($get_student_detail['student_assign_accessories'] as $accessories): ?>
                                                <tr>
                                                    <td><?php echo $count++ ?>.</td>
                                                    <td><?php echo $accessories['keyboard_assigned'] ?></td>
                                                    <td><?php echo $accessories['mouse_assigned'] ?></td>
                                                    <td><?= (new DateTime($accessories['created_at']))->format('d M Y') ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4">No accessories assigned to this student.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        <!--end student assign accessoriess table-->
                        <!--start student damage accessoriess table-->
                        <?php if ($get_student_damage_accessories->count() > 0): ?>
                            <div class="table-qualification">
                                <label>Damage Accessories details</label>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Keyboard</th>
                                            <th>Mouse</th>
                                            <th>Damage Accessories Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($get_student_damage_accessories): ?>
                                            <?php
                                            $count = 1;
                                            ?>
                                            <?php foreach ($get_student_damage_accessories as $damage_accessories): ?>
                                                <tr>
                                                    <td><?php echo $count++ ?>.</td>
                                                    <td><?php echo $damage_accessories['keyboard_damaged'] ?></td>
                                                    <td><?php echo $damage_accessories['mouse_damaged'] ?></td>
                                                    <td><?= (new DateTime($damage_accessories['created_at']))->format('d M Y') ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4">No damage accessories assigned to this student.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        <!--end student damage accessoriess table-->
                    </div>
                    <!--end students all tables-->
                </div>
            </div>
        </div>
        <!--start student edit pay fees model-->
        <div class="modal fade pay-modals" id="editFeeModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content edit-pay">
                    <div class="modal-header-damage">
                        <h4 class="modal-title">Edit Pay Fees For <span class="edit_pay_fees"></span></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="editFeeForm" method="POST">
                        <input type="hidden" id="fee_id" name="fee_id">
                        <input type="hidden" id="fee_month" name="fee_month">
                        <div class="form-group">
                            <label for="user_fees">Fees Amount</label>
                            <input type="text" id="model_student_amount" name="user_fees" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="payment_type">Payment Type</label>
                            <select name="payment_type" id="payment_type" class="form-control">
                                <option value="">Select Payment Type</option>
                                <option value="online">Online</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group button-save">
                            <button type="submit" class="disable-submit">Update</button>
                        </div>
                        <!-- Loader -->
                        <div class="loader com_ajax_loader" style="display:none;">
                            <img src="<?php echo url('public/admin/images/200w.gif'); ?>">
                        </div>
                        </form>
                        <div class="student_update_fee_responce"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end student edit pay fees model-->
        <script>
        $(document).ready(function () {
            $('#user_fees').on('input', function () {
                this.value = this.value.replace(/\D/g, '');
            });
        });
        </script>
        <script>
        $(document).ready(function() {
            //Validate Form
            $('#editFeeForm').validate({
                rules: {
                    user_fees: {
                        required: true,
                        number: true
                    },
                    payment_type: {
                        required: true
                    }
                },
                submitHandler: function(form, e) {
                    e.preventDefault();
                    var formData = $(form).serialize();

                    //AJAX request
                    $.ajax({
                        type: 'POST',
                        url: base_url + '/admin/update-student-fees',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $(".com_ajax_loader").show();
                            $('.disable-submit').prop('disabled', true);
                        },
                        success: function(response) {
                            $('.student_update_fee_responce').html(response);
                            $(".disable-submit").prop('disabled', false);
                            $(".com_ajax_loader").hide();
                        }
                    });
                }
            });
        });
        </script>
            <script>
            $(document).ready(function () {
                $('#model_student_amount').on('input', function () {
                    this.value = this.value.replace(/\D/g, '');
                });
            });
            </script>         
        <?php
    }

    //Function for update student fees
    public function update_student_feess(Request $request) {
        //Get input request
        $fee_id = $request->input('fee_id');
        $fee_month = $request->input('fee_month');
        //Update record
        $is_update_student_fees = StudentFees::where('id', $fee_id)->where('submission_date', $fee_month)->update([
            'user_fees' => $request->user_fees,
            'payment_type' => $request->payment_type,
        ]);

        //Check if student submit fees updatd or not
        if ($is_update_student_fees) {
            echo '<p style="color:green;">Student fees updated successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Opps something went wrong.</p>';
        }
    }

    //Function for edit single student fees
    public function edit_student_fees($id) {
        $student_fees_detail = StudentFees::find($id);
        return view('admin.students.edit-student-fees', compact('student_fees_detail'));
    }

    // //Function for update student fees
    // public function update_ssstudent_feess(Request $request, $id){
    //     $update_student_fees = StudentFees::where('id', $id)->update([
    //         'submission_date' =>$request->submission_date,
    //         'user_fees' =>$request->user_fees,
    //         'payment_type' =>$request->payment_type,
    //     ]);
    //     //Check if student fees updated or not
    //     if($update_student_fees){
    //         return back()->with('success', 'Student fees updated successfully.');
    //     } else {
    //         return back()->with('unsuccess', 'Opps something went wrong.');
    //     }
    // }

    // //Function for delete student fees
    // public function delete_student_fees($id){
    //     $delete_student_fees = StudentFees::find($id)->delete();
    //     //Check if student fees deleted or not
    //     if($delete_student_fees){
    //         return back()->with('success', 'Student fees deleted successfully.');
    //     } else {
    //         return back()->with('success', 'Opps something went wrong.');
    //     }
    // }

    //Function for student assign accessories
    public function submit_student_assign_accessories(Request $request) {
        //Get stock
        $stock = Stock::first();
        //Check if stock is exists or not
        if (!$stock) {
            echo '<p style="color:red;">Stock not available. Please create stock first.</p>';
            return;
        }
        //Calculate the total assigned keyboards and mouse
        $totalKeyboardAssigned = StudentAssignAccessories::sum('keyboard_assigned') + $request->keyboard_assigned;
        $totalMouseAssigned = StudentAssignAccessories::sum('mouse_assigned') + $request->mouse_assigned;
        //Check if accessories is available stock or not
        if ($totalKeyboardAssigned > $stock->total_keyboard_stock || $totalMouseAssigned > $stock->total_mouse_stock) {
            echo '<p style="color:red;">Insufficient stock. Please update the stock first.</p>';
            return;
        }
        //Create student assign accessories
        $is_create_student_assign_accessories = StudentAssignAccessories::create([
            'user_id' => $request->student_id,
            'keyboard_assigned' => $request->keyboard_assigned,
            'mouse_assigned' => $request->mouse_assigned,
        ]);

        //Check if student assign is created and updated or not
        if ($is_create_student_assign_accessories) {
            //Update the stock record
            $stock->assign_keyboard = StudentAssignAccessories::sum('keyboard_assigned');
            $stock->assign_mouse = StudentAssignAccessories::sum('mouse_assigned');
            $stock->save();

            echo '<p style="color:green;">Student assign accessories created successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Failed to create student assign accessories.</p>';
        }
    }

    //Function for student edit assign accessories
    // public function edit_student_assign_accessories($id) {
    //     $student_accessories_detail = StudentAssignAccessories::find($id);
    //     return view('admin.students.edit-student-accessories', compact('student_accessories_detail'));
    // }

    // //Function for student update assign accessories
    // public function update_student_assign_accessories(Request $request, $id){
    //     //Update student assign accessories   
    //     $is_update_student_assign_accessories = StudentAssignAccessories::where('id', $id)->update([
    //         'keyboard_assigned' => $request->keyboard_assigned,
    //         'mouse_assigned' => $request->mouse_assigned,
    //     ]);
    //     //Check if student assign accessories detail updated or not
    //     if($is_update_student_assign_accessories) {
    //         return back()->with('success', 'Student assign accessories updated successfully.');
    //     } else {
    //         return back()->with('unsuccess', 'Opps something went wrong.');
    //     }       
    // }

    // //Function for student deleted assign accessories
    // public function delete_student_assign_accessories($id){
    //     //delete student assign accessories  
    //     $is_delete_student_assign_accessories = StudentAssignAccessories::find($id)->delete();
    //     //Check if student assign accessories detail updated or not
    //     if($is_delete_student_assign_accessories) {
    //         return back()->with('success', 'Student assign accessories deleted successfully.');
    //     } else {
    //         return back()->with('unsuccess', 'Opps something went wrong.');
    //     }         
    // }  

    //Function for search stundet course type list
    public function search_students_list(Request $request) {
        //Get all students total fees and all paid fees
        $all_students_total_fees = User::sum('total_fees');
        $all_students_paid_fees = StudentFees::sum('user_fees');

        //Get the last segment from the URL
        $courseType = $request->segment(count($request->segments()));

        //Get search student detail
        $get_students_detail = User::where('user_type', 'Student')->where('user_status', 'Active')->where('course_type', $courseType)->orderBy('id', 'DESC')->with('student_fees_detail')->get();
        return view('admin.students.search-students-list', compact('get_students_detail', 'all_students_total_fees', 'all_students_paid_fees'));
    }

    //Function for search stundet fees accor status
    public function search_students_fees_list(Request $request) {
        //Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        //Get all students total fees and all paid fees
        $all_students_total_fees = User::where('user_status', 'Active')->sum('total_fees');
        $all_students_paid_fees = StudentFees::where('user_status', 'Active')->sum('user_fees');

        //Get the last segment from the URL
        $fees_status = $request->segment(count($request->segments()));

        //Calculate the dates for pending and overdue statuses
        $pendingStartDate = Carbon::now()->subDays(44)->format('Y-m-d');
        $pendingEndDate = Carbon::now()->subDays(32)->format('Y-m-d');
        $overdueDate = Carbon::now()->subDays(45)->format('Y-m-d');

        //Get Current month Paid student list
        $get_paid_students = StudentFees::where('user_status', 'Active')
            ->whereMonth('submission_date', $currentMonth)
            ->whereYear('submission_date', $currentYear)
            ->get();

        //Get Students id in array
        $student_ids = [];
        foreach ($get_paid_students as $student_fees_status) {
            if (isset($student_fees_status->student_current_fees_detail)) {
                $student_ids[] = $student_fees_status->student_current_fees_detail->id;
            }
        }

        //Check if student is Paid
        if ($fees_status == 'Paid') {
            $get_students_list = User::where('user_type', 'Student')
                ->where('user_status', 'Active')
                ->whereIn('id', $student_ids)
                ->with('student_fees_detail')
                ->get();
        }

        //Check if student is Pending
        if ($fees_status == 'Pending') {
            $get_students_list = User::where('user_type', 'Student')
                ->where('user_status', 'Active')
                ->whereNotIn('id', $student_ids)
                ->where(function ($query) use ($pendingStartDate, $pendingEndDate) {
                    $query->whereHas('student_fees_detail', function ($query) use ($pendingStartDate, $pendingEndDate) {
                        $query->whereBetween('submission_date', [$pendingStartDate, $pendingEndDate]);
                    })
                        ->orWhereDoesntHave('student_fees_detail');
                })
                ->with('student_fees_detail')
                ->get();
            //Check if any student not paid fees
            $get_students_list->each(function ($student) {
                $student->status = 'Pending';
            });
        }

        //Check if student is Overdue
        if ($fees_status == 'Overdue') {
            $get_students_list = User::where('user_type', 'Student')
                ->where('user_status', 'Active')
                ->whereNotIn('id', $student_ids)
                ->whereDoesntHave('student_fees_detail', function ($query) use ($overdueDate) {
                    $query->where('submission_date', '>=', $overdueDate);
                })
                ->where(function ($query) use ($pendingStartDate) {
                    $query->whereHas('student_fees_detail', function ($query) use ($pendingStartDate) {
                        $query->where('submission_date', '<', $pendingStartDate);
                    });
                })
                ->with('student_fees_detail')
                ->get();
        }

        return view('admin.students.search-students-fees-list', compact('get_students_list', 'all_students_total_fees', 'all_students_paid_fees'));
    }

    //Function for trash student record 
    public function trash_student(Request $request) {
        //Get request through ajax
        $student_id = $request->input('student_id');
        $status = $request->input('user_status');

        //Trash user record
        $trash = Trash::create([
            'user_id' => $student_id,
        ]);
        //Check if student record is trash or not
        if ($trash) {
            User::where('id', $student_id)->update([
                'user_status' => $request->status,
            ]);
            StudentFees::where('user_id', $student_id)->update([
                'user_status' => $request->status,
            ]);
            echo '<p style="color:green;">Student record trashed successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000); </script>';
        } else {
            echo '<p style="color:red;">Oops something went wrong.</p>';
        }
    }

    //Function for delete student
    public function delete_student(Request $request) {
        //Get student id through ajax
        $id = $request->id;
        $delete_student = User::find($id)->delete();

        //Check if student deleted or not
        if ($delete_student) {
            Trash::where('user_id', $id)->delete();
            StudentFees::where('user_id', $id)->delete();
            StudentAssignAccessories::where('user_id', $id)->delete();
            StudentDamageAccessories::where('user_id', $id)->delete();
            EmployeeAssignAccessories::where('employee_id', $id)->delete();
            EmployeeDamageAccessories::where('employee_id', $id)->delete();
            return back()->with('success', 'Student record deleted successfully.');
        } else {
            return back()->with('unsuccess', 'Opps something went wrong.');
        }
    }

    //Function for get all trash students list
    public function all_trash_students_list() {
        //Get current month
        $currentMonth = Carbon::now()->month;
        $get_students_detail = User::where('user_type', 'Student')->whereIn('user_status', ['Completed', 'Leave'])->orderBy('id', 'DESC')->with('student_fees_detail')->get();
        //Get all students total fees and all paid fees
        $all_students_total_fees = User::sum('total_fees');
        $all_students_paid_fees = StudentFees::sum('user_fees');
        return view('admin.students.all-students-trash-list', compact('get_students_detail', 'all_students_total_fees', 'all_students_paid_fees'));
    }

    //Function for showing all stocks list
    public function all_stocks_list() {
        $all_stocks_list = Stock::orderBy('ID', 'DESC')->get();
        //Calculate total damaged keyboards and mouse
        $total_keyboard_damaged = StudentDamageAccessories::sum('keyboard_damage') + EmployeeDamageAccessories::sum('keyboard_damage');
        $total_mouse_damaged = StudentDamageAccessories::sum('mouse_damage') + EmployeeDamageAccessories::sum('mouse_damage');

        return view('admin.stocks.all-stocks-list', compact('all_stocks_list', 'total_keyboard_damaged', 'total_mouse_damaged'));
    }

    //Function for add new stock
    public function add_new_stock(){
        return view('admin.stocks.add-new-stock');
    }

    // //Function for submit stock
    // public function submit_stock(Request $request) {
    //     // Fetch stock record
    //     $stock = Stock::first();

    //     if ($stock) {
    //         // Calculate total assigned keyboards and mice
    //         $totalKeyboardAssigned = StudentAssignAccessories::sum('keyboard_assigned');
    //         $totalMouseAssigned = StudentAssignAccessories::sum('mouse_assigned');

    //         // Check conditions for stock availability
    //         if ($totalKeyboardAssigned <= $stock->total_keyboard_stock && $totalMouseAssigned <= $stock->total_mouse_stock) {
    //             // Update existing stock
    //             $stock->total_keyboard_stock += $request->total_keyboard_stock;
    //             $stock->total_mouse_stock += $request->total_mouse_stock;
    //             $stock->assign_keyboard = $totalKeyboardAssigned;
    //             $stock->assign_mouse = $totalMouseAssigned;
    //             $stock->save();

    //             return back()->with('success', 'Stocks updated successfully.');
    //         } else {
    //             return back()->with('unsuccess', 'Stock not available.');
    //         }
    //     } else {
    //         // Calculate total assigned keyboards and mouse
    //         $totalKeyboardAssigned = StudentAssignAccessories::sum('keyboard_assigned');
    //         $totalMouseAssigned = StudentAssignAccessories::sum('mouse_assigned');

    //         // Create new stock record
    //         $newStock = Stock::create([
    //             'total_keyboard_stock' => $request->total_keyboard_stock,
    //             'total_mouse_stock' => $request->total_mouse_stock,
    //             'assign_keyboard' => $totalKeyboardAssigned,
    //             'assign_mouse' => $totalMouseAssigned,
    //         ]);

    //         return back()->with('success', 'Stocks created successfully.');
    //     }
    // }

    //Function for student damage accessories
    public function submit_student_damage_accessories(Request $request)  {
        //Create student damage accessories
        $is_create_student_damage_acessories = StudentDamageAccessories::create([
            'user_id' => $request->student_id,
            'keyboard_damage' => $request->keyboard_damage,
            'mouse_damage' => $request->mouse_damage,
            'remark' => $request->remark,
        ]);

        //Check if damage accessories created or not
        if ($is_create_student_damage_acessories) {
            echo '<p style="color:green;">Student damage accessories created successfully.</p>';
            echo '<script> setTimeout(function () { window.location.reload(); }, 3000);</script>';
        } else {
            echo '<p style="color:red;">Opps something went wrong.</p>';
        }
    }
}






