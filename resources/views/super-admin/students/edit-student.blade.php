@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Student Record</h2>
</div>
<div class="main-table">
   @if (Session::has('success')) 
   <div class="notification-green">
      <p>{{ Session::get('success') }}</p>
   </div>
   @endif 
   @if (Session::has('unsuccess')) 
   <div class="notification-red">
      <p>{{ Session::get('unsuccess') }}</p>
   </div>
   @endif 
   <div class="login-form">
      <form action="{{ route('super.admin.update.student', $student->id) }}" Method="POST" enctype="multipart/form-data">
      @csrf
      <div class="small-12 medium-2 large-2 columns">
            <div class="avatar-upload">
               <div class="avatar-edit">
                  <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                  <label for="imageUpload"><i class="fas fa-pencil-alt"></i></label>
               </div>
               <div class="add-new-student-pic">
               <div class="avatar-preview">
               @if($student->user_pic)
                  <img id="imagePreview" src="{{ url('public/uploads/users/' .$student->user_pic) }}" >
               @else
                  <img id="imagePreview" src="{{ url('public/uploads/users/default_user.png') }}" >
               @endif
                </div>
                </div>
            </div>
         </div>
         <div class="student-accessories">
            <div class="box-pay">
                     <button type="button" class="pay-fes-buton student_assign_accessories" data-student_id="{{ $student->id }}" data-toggle="modal" data-target="#myModal">Assign Accessories</button>
                  </div>
                  <div class="box-pays">
                     <button type="button" class="pay-fes-buton student_damage_accessories" data-student_id="{{ $student->id }}" data-toggle="modal" data-target="#myModals">Damage Accessories</button>
               </div>
            </div>
         
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="first-name">First Name</label>
               <input type="text" id="first-name" name="first_name" value="{{ $student->first_name }}" placeholder="Enter First Name">
            </div>
            <div class="form-design last-name">
               <label for="last-name">Last Name</label>
               <input type="text" id="last-name" name="last_name" value="{{ $student->last_name }}" placeholder="Enter Last Name">
            </div>
            <div class="form-design mail">
               <label for="email">Email</label>
               <input type="email" id="email" name="email" class="email-disabled" value="{{ $student->email }}" placeholder="Enter email address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design dob">
               <label for="dob">Date of Birth</label>
               <input type="date" id="dob" name="dob" value="{{ $student->dob }}">
            </div>
            <div class="form-design father-name">
               <label for="father_name">Father Name</label>
               <input type="text" id="father_name" name="father_name" value="{{ $student->father_name }}" placeholder="Enter Father Name">
            </div>
            <div class="form-design phone-no">
               <label for="father_phone_no">Father Phone Number</label>
               <input type="text" id="father_phone_no" name="father_phone_no" value="{{ $student->father_phone_no }}" placeholder="Enter Father Phone Number">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design aadhaar-no">
               <label for="aadhar_no">Aadhar Number</label>
               <input type="text" id="aadhar_no" name="aadhaar_no" value="{{ $student->aadhaar_no }}" placeholder="Enter Aaadhar Number">
            </div>
            <div class="form-design student-phone-no">
               <label for="student_phone_no">Student Phone Number</label>
               <input type="text" id="student_phone_no" name="student_phone_no" value="{{ $student->student_phone_no }}" placeholder="Enter Student Phone Number">
            </div>
            <div class="form-design status">
               <label for="total-fees">Total Fees</label>
               <input type="text" id="total_fees" name="total_fees" value="{{ $student->total_fees }}" placeholder="Enter amount">
            </div>
         </div>
         <div class="form-group display-column radio-btn-design">
            <div class="form-group">
               <label>Gender</label>
               <div class="form-design gender-options">
                  <div class="gender male">
                     <input type="radio" name="gender" value="Male" <?php if ($student->gender === 'Male') echo 'checked'; ?>>
                     <span>Male</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="gender" value="Female" <?php if ($student->gender === 'Female') echo 'checked'; ?>>
                     <span>Female</span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Marital Status</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Married" <?php if ($student->marital_status === 'Married') echo 'checked'; ?>>
                     <span>Married</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Unmarried" <?php if ($student->marital_status === 'Unmarried') echo 'checked'; ?>>
                     <span>Unmarried</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Other" <?php if ($student->marital_status === 'Other') echo 'checked'; ?>>
                     <span>Other</span>
                  </div>
               </div>
            </div>
            <div class="form-design category">
               <label for="category">Category</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male"> 
                     <label class="radio-option">
                     <input type="radio" name="category" value="General" <?php if ($student->category === 'General') echo 'checked'; ?>>
                     <span>General</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="ST" <?php if ($student->category === 'ST') echo 'checked'; ?>>
                     <span>ST</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="SC" <?php if ($student->category === 'SC') echo 'checked'; ?>>
                     <span>SC</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="OBC" <?php if ($student->category === 'OBC') echo 'checked'; ?>>
                     <span>OBC</span>
                     </label>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-design qualification">
            <?php $qualification = explode(",", $student['qualification']); ?>
            <label for="qualification">Qualification</label>
            <div class="qualification-ftp">
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="12th" <?php if(in_array('12th', $qualification)){ echo 'checked="checked"'; } ?>>
                  <span>12th</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="12th_Pursuing" <?php if(in_array('12th_Pursuing', $qualification)){ echo 'checked="checked"'; } ?>>
                  <span>12th Pursuing</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Graduation" <?php if(in_array('Graduation', $qualification)){ echo 'checked="checked"'; } ?>>
                  <span>Graduation</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Graduation_Pursuing" <?php if(in_array('Graduation_Pursuing', $qualification)){ echo 'checked="checked"'; } ?>>
                  <span>Graduation Pursuing</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Other" <?php if(in_array('Other', $qualification)){ echo 'checked="checked"'; } ?>>
                  <span>Other</span>
               </div>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design address">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="{{ $student->address }}" placeholder="Enter Address">
            </div>
            <div class="form-design district">
               <label for="district">District</label>
               <select name="district" class="form-control" id="district">
                  <option value="" disabled selected>Select District</option>
                  <option value="Bilaspur" @if($student->district == 'Bilaspur') selected @endif>Bilaspur</option>
                  <option value="Chamba" @if($student->district == 'Chamba') selected @endif>Chamba</option>
                  <option value="Hamirpur" @if($student->district == 'Hamirpur') selected @endif>Hamirpur</option>
                  <option value="Kangra" @if($student->district == 'Kangra') selected @endif>Kangra</option>
                  <option value="Kinnaur" @if($student->district == 'Kinnaur') selected @endif>Kinnaur</option>
                  <option value="Kullu" @if($student->district == 'Kullu') selected @endif>Kullu</option>
                  <option value="Lahaul and Spiti" @if($student->district == 'Lahaul and Spiti') selected @endif>Lahaul and Spiti</option>
                  <option value="Mandi" @if($student->district == 'Mandi') selected @endif>Mandi</option>
                  <option value="Shimla" @if($student->district == 'Shimla') selected @endif>Shimla</option>
                  <option value="Sirmaur" @if($student->district == 'Sirmaur') selected @endif>Sirmaur</option>
                  <option value="Solan" @if($student->district == 'Solan') selected @endif>Solan</option>
                  <option value="Una" @if($student->district == 'Una') selected @endif>Una</option>
               </select>
            </div>
            <div class="form-design state">
               <label for="state">State</label>
               <input type="text" id="state" name="state" value="{{ $student->state }}" placeholder="Enter State">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design pin-code">
               <label for="pin_code">Pin Code</label>
               <input type="text" id="pin_code" name="pin_code" value="{{ $student->pin_code }}" placeholder="Enter Pin Code">
            </div>
            <div class="form-design course">
               <label for="course_type">Course Type</label>
               <select class="form-control" name="course_type" id="Course Type">
                  <option value ="" disabled selected>Select Course Type</option>
                  <option value="Web Designing" @if($student->course_type == 'Web Designing') selected @endif>Web Designing</option>
                  <option value="Web Development" @if($student->course_type == 'Web Development') selected @endif>Web Development</option>
                  <option value="Php" @if($student->course_type == 'Php') selected @endif>PHP</option>
                  <option value="Graphic" @if($student->course_type == 'Graphic') selected @endif>Graphic</option>
                  <option value="Full Stack Development" @if($student->course_type == 'Full Stack Development') selected @endif>Full Stack Development</option>
               </select>
            </div>
            <div class="form-design duration">
               <label for="course_duration">Course Duration</label>
               <select class="form-control" name="course_duration" id="Course Duration">
                  <option value ="" disabled selected>Select Course Duration</option>
                  <option value="1 Month" @if($student->course_duration == '1 Month') selected @endif>1 Month</option>
                  <option value="3 Month" @if($student->course_duration == '3 Month') selected @endif>3 Month</option>
                  <option value="6 Month" @if($student->course_duration == '6 Month') selected @endif>6 Month</option>
                  <option value="1 Year" @if($student->course_duration == '1 Year') selected @endif>1 Year</option>
                  <option value="2 Year" @if($student->course_duration == '2 Year') selected @endif>2 Year</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design join-date">
               <label for="course_joining_date">Course Joining Date</label>
               <input type="date" id="course_joining_date" name="course_joining_date" value="{{ $student->course_joining_date }}">
            </div>
            <div class="form-design end-date">
               <label for="course_complession_date">Course Complession Date</label>
               <input type="date" id="course_complession_date" name="course_complession_date" class="email-disabled" value="{{ $student->course_complession_date }}">
            </div>
            <div class="form-design batch-timing">
               <label for="batch_timing">Batch Timing</label>
               <select id="batch_timing" name="batch_timing" class="form-control">
                  <option value ="" disabled selected>Select Batch Timing</option>
                  <option value="10:30 to 5:00" @if($student->batch_timing == '10:30 to 5:00') selected @endif>10:30 to 5:00</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design fees">
               <label for="user_status">Status</label>
               <select class="form-control" name="user_status" id="User Status">
                  <option value ="" disabled selected>Select Status Type</option>
                  <option value="Active" @if($student->user_status == 'Active') selected @endif>Active</option>
                  <option value="Pending" @if($student->user_status == 'Pending') selected @endif>Pending</option>
                  <option value="Suspend" @if($student->user_status == 'Suspend') selected @endif>Suspend</option>
                  <option value="Leave" @if($student->user_status == 'Leave') selected @endif>Leave</option>
                  <option value="Completed" @if($student->user_status == 'Completed') selected @endif>Completed</option>
               </select>
            </div>
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Update">
            </div>
         </div>
      </form>
   </div>
</div>
<div class="modal fade pay-modal" id="myModal" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Assign Accessories</h4>
            </div>
            <div class="modal-body">
               <form action="#" id="student_accessories" Method="POST">
                  <input id="model_student_id" type="hidden" value="" name="student_id">
                  <input type="text" id="keyboard_assigned" name="keyboard_assigned" placeholder="Keyboard Assigned" />
                  <input type="text" id="mouse_assigned" name="mouse_assigned" placeholder="Mouse Assigned"/>
                  <div class="button-save is_create_student_assign_accessorie"><button type="submit">Save</button></div>
               </form>
               <div class="loader com_ajax_loader" style="display:none;">
                  <img src="{{ url('public/admin/images/200w.gif') }}" /> 
               </div>
            </div>
            <div class="assign_accessorie_responce"></div>
         </div>
      </div>
   </div>
   <!-- Damage accessories model-->
   <div class="modal pay-modals" id="myModals" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header-damage">
            <h4 class="modal-title">Damage Accessories</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body-damage">
               <form action="#" id="student_damage_accessories" Method="POST">
                  <input id="modeal_student_id" type="hidden" value="" name="student_id">
                  <input type="text" id="keyboard_damage" name="keyboard_damage" placeholder="Keyboard Damage" />
                  <input type="text" id="mouse_damage" name="mouse_damage" placeholder="Mouse Damage"/>
                  <input type="text" id="remark" name="remark" placeholder="Remark"/>
                  <div class="button-save is_create_student_damage_accessorie"><button type="submit">Save</button></div>
               </form>
               <div class="loader com_ajax_loader" style="display:none;">
                  <img src="{{ url('public/admin/images/200w.gif') }}" /> 
               </div>
            </div>
            <div class="damage_accessorie_responce"></div>
         </div>
      </div>
   </div>
</div>
</div>
@endsection