<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Profile</h2>
</div>
<div class="main-table">
   <?php if(Session::has('success')): ?> 
   <div class="notification-green">
      <p><?php echo e(Session::get('success')); ?></p>
   </div>
   <?php endif; ?> 
   <?php if(Session::has('unsuccess')): ?> 
   <div class="notification-red">
      <p><?php echo e(Session::get('unsuccess')); ?></p>
   </div>
   <?php endif; ?> 
   <div class="login-form">
      <form action="<?php echo e(route('student.update.profile', $user_profile->id)); ?>" Method="POST" enctype="multipart/form-data">
         <?php echo csrf_field(); ?>
         <div class="small-12 medium-2 large-2 columns">
            <div class="avatar-upload">
               <div class="avatar-edit">
                  <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                  <label for="imageUpload"><i class="fas fa-pencil-alt"></i></label>
               </div>
               <div class="add-new-student-pic">
                  <div class="avatar-preview">
                     <?php if($user_profile->user_pic): ?>
                     <img id="imagePreview" src="<?php echo e(url('public/uploads/users/' .$user_profile->user_pic)); ?>" >
                     <?php else: ?>
                     <img id="imagePreview" src="<?php echo e(url('public/uploads/users/default_user.png')); ?>" >
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="first-name">First Name</label>
               <input type="text" id="first-name" name="first_name" class="email-disabled" value="<?php echo e($user_profile->first_name); ?>" placeholder="Enter First Name">
            </div>
            <div class="form-design last-name">
               <label for="last-name">Last Name</label>
               <input type="text" id="last-name" name="last_name" class="email-disabled" value="<?php echo e($user_profile->last_name); ?>" placeholder="Enter Last Name">
            </div>
            <div class="form-design mail">
               <label for="email">Email</label>
               <input type="email" id="email" name="email" class="email-disabled" value="<?php echo e($user_profile->email); ?>" placeholder="Enter email address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design dob">
               <label for="dob">Date of Birth</label>
               <input type="date" id="dob" name="dob" value="<?php echo e($user_profile->dob); ?>">
            </div>
            <div class="form-design father-name">
               <label for="father_name">Father Name</label>
               <input type="text" id="father_name" name="father_name" value="<?php echo e($user_profile->father_name); ?>" placeholder="Enter Father Name">
            </div>
            <div class="form-design phone-no">
               <label for="father_phone_no">Father Phone Number</label>
               <input type="text" id="father_phone_no" name="father_phone_no" value="<?php echo e($user_profile->father_phone_no); ?>" placeholder="Enter Father Phone Number">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design aadhaar-no">
               <label for="aadhar_no">Aadhar Number</label>
               <input type="text" id="aadhar_no" name="aadhaar_no" value="<?php echo e($user_profile->aadhaar_no); ?>" placeholder="Enter Aaadhar Number">
            </div>
            <div class="form-design student-phone-no">
               <label for="student_phone_no">Student Phone Number</label>
               <input type="text" id="student_phone_no" name="student_phone_no" value="<?php echo e($user_profile->student_phone_no); ?>" placeholder="Enter Student Phone Number">
            </div>
            <div class="form-design batch-timing">
               <label for="batch_timing">Batch Timing</label>
               <select id="batch_timing" name="batch_timing" class="email-disabled">
                  <option value ="" disabled selected>Select Batch Timing</option>
                  <option value="10:30 to 5:00" <?php if($user_profile->batch_timing == '10:30 to 5:00'): ?> selected <?php endif; ?>>10:30 to 5:00</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column radio-btn-design">
            <div class="form-group">
               <label>Gender</label>
               <div class="form-design gender-options">
                  <div class="gender male">
                     <input type="radio" name="gender" value="Male" <?php if ($user_profile->gender === 'Male') echo 'checked'; ?>>
                     <span>Male</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="gender" value="Female" <?php if ($user_profile->gender === 'Female') echo 'checked'; ?>>
                     <span>Female</span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Marital Status</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Married" <?php if ($user_profile->marital_status === 'Married') echo 'checked'; ?>>
                     <span>Married</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Unmarried" <?php if ($user_profile->marital_status === 'Unmarried') echo 'checked'; ?>>
                     <span>Unmarried</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Other" <?php if ($user_profile->marital_status === 'Other') echo 'checked'; ?>>
                     <span>Other</span>
                  </div>
               </div>
            </div>
            <div class="form-design category">
               <label for="category">Category</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male"> 
                     <label class="radio-option">
                     <input type="radio" name="category" value="General" <?php if ($user_profile->category === 'General') echo 'checked'; ?>>
                     <span>General</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="ST" <?php if ($user_profile->category === 'ST') echo 'checked'; ?>>
                     <span>ST</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="SC" <?php if ($user_profile->category === 'SC') echo 'checked'; ?>>
                     <span>SC</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="OBC" <?php if ($user_profile->category === 'OBC') echo 'checked'; ?>>
                     <span>OBC</span>
                     </label>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-design qualification">
            <?php $qualification = explode(",", $user_profile['qualification']); ?>
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
               <input type="text" id="address" name="address" value="<?php echo e($user_profile->address); ?>" placeholder="Enter Address">
            </div>
            <div class="form-design district">
               <label for="district">District</label>
               <select name="district" class="form-control" id="district">
                  <option value="" disabled selected>Select District</option>
                  <option value="Bilaspur" <?php if($user_profile->district == 'Bilaspur'): ?> selected <?php endif; ?>>Bilaspur</option>
                  <option value="Chamba" <?php if($user_profile->district == 'Chamba'): ?> selected <?php endif; ?>>Chamba</option>
                  <option value="Hamirpur" <?php if($user_profile->district == 'Hamirpur'): ?> selected <?php endif; ?>>Hamirpur</option>
                  <option value="Kangra" <?php if($user_profile->district == 'Kangra'): ?> selected <?php endif; ?>>Kangra</option>
                  <option value="Kinnaur" <?php if($user_profile->district == 'Kinnaur'): ?> selected <?php endif; ?>>Kinnaur</option>
                  <option value="Kullu" <?php if($user_profile->district == 'Kullu'): ?> selected <?php endif; ?>>Kullu</option>
                  <option value="Lahaul and Spiti" <?php if($user_profile->district == 'Lahaul and Spiti'): ?> selected <?php endif; ?>>Lahaul and Spiti</option>
                  <option value="Mandi" <?php if($user_profile->district == 'Mandi'): ?> selected <?php endif; ?>>Mandi</option>
                  <option value="Shimla" <?php if($user_profile->district == 'Shimla'): ?> selected <?php endif; ?>>Shimla</option>
                  <option value="Sirmaur" <?php if($user_profile->district == 'Sirmaur'): ?> selected <?php endif; ?>>Sirmaur</option>
                  <option value="Solan" <?php if($user_profile->district == 'Solan'): ?> selected <?php endif; ?>>Solan</option>
                  <option value="Una" <?php if($user_profile->district == 'Una'): ?> selected <?php endif; ?>>Una</option>
               </select>
            </div>
            <div class="form-design state">
               <label for="state">State</label>
               <select name="state" class="form-control" id="state">
                  <option value="" disabled selected>Select State</option>
                  <option value="Andhra Pradesh" <?php if($user_profile->state == 'Andhra Pradesh'): ?> selected <?php endif; ?>>Andhra Pradesh</option>
                  <option value="Arunachal Pradesh" <?php if($user_profile->state == 'Arunachal Pradesh'): ?> selected <?php endif; ?>>Arunachal Pradesh</option>
                  <option value="Assam" <?php if($user_profile->state == 'Assam'): ?> selected <?php endif; ?>>Assam</option>
                  <option value="Bihar" <?php if($user_profile->state == 'Bihar'): ?> selected <?php endif; ?>>Bihar</option>
                  <option value="Chhattisgarh" <?php if($user_profile->state == 'Chhattisgarh'): ?> selected <?php endif; ?>>Chhattisgarh</option>
                  <option value="Goa" <?php if($user_profile->state == 'Goa'): ?> selected <?php endif; ?>>Goa</option>
                  <option value="Gujarat" <?php if($user_profile->state == 'Gujarat'): ?> selected <?php endif; ?>>Gujarat</option>
                  <option value="Haryana" <?php if($user_profile->state == 'Haryana'): ?> selected <?php endif; ?>>Haryana</option>
                  <option value="Himachal Pradesh" <?php if($user_profile->state == 'Himachal Pradesh'): ?> selected <?php endif; ?>>Himachal Pradesh</option>
                  <option value="Jharkhand" <?php if($user_profile->state == 'Jharkhand'): ?> selected <?php endif; ?>>Jharkhand</option>
                  <option value="Karnataka" <?php if($user_profile->state == 'Karnataka'): ?> selected <?php endif; ?>>Karnataka</option>
                  <option value="Kerala" <?php if($user_profile->state == 'Kerala'): ?> selected <?php endif; ?>>Kerala</option>
                  <option value="Madhya Pradesh" <?php if($user_profile->state == 'Madhya Pradesh'): ?> selected <?php endif; ?>>Madhya Pradesh</option>
                  <option value="Maharashtra" <?php if($user_profile->state == 'Maharashtra'): ?> selected <?php endif; ?>>Maharashtra</option>
                  <option value="Manipur" <?php if($user_profile->state == 'Manipur'): ?> selected <?php endif; ?>>Manipur</option>
                  <option value="Meghalaya" <?php if($user_profile->state == 'Meghalaya'): ?> selected <?php endif; ?>>Meghalaya</option>
                  <option value="Mizoram" <?php if($user_profile->state == 'Mizoram'): ?> selected <?php endif; ?>>Mizoram</option>
                  <option value="Nagaland" <?php if($user_profile->state == 'Nagaland'): ?> selected <?php endif; ?>>Nagaland</option>
                  <option value="Odisha" <?php if($user_profile->state == 'Odisha'): ?> selected <?php endif; ?>>Odisha</option>
                  <option value="Punjab" <?php if($user_profile->state == 'Punjab'): ?> selected <?php endif; ?>>Punjab</option>
                  <option value="Rajasthan" <?php if($user_profile->state == 'Rajasthan'): ?> selected <?php endif; ?>>Rajasthan</option>
                  <option value="Sikkim" <?php if($user_profile->state == 'Sikkim'): ?> selected <?php endif; ?>>Sikkim</option>
                  <option value="Tamil Nadu" <?php if($user_profile->state == 'Tamil Nadu'): ?> selected <?php endif; ?>>Tamil Nadu</option>
                  <option value="Telangana" <?php if($user_profile->state == 'Telangana'): ?> selected <?php endif; ?>>Telangana</option>
                  <option value="Tripura" <?php if($user_profile->state == 'Tripura'): ?> selected <?php endif; ?>>Tripura</option>
                  <option value="Uttar Pradesh" <?php if($user_profile->state == 'Uttar Pradesh'): ?> selected <?php endif; ?>>Uttar Pradesh</option>
                  <option value="Uttarakhand" <?php if($user_profile->state == 'Uttarakhand'): ?> selected <?php endif; ?>>Uttarakhand</option>
                  <option value="West Bengal" <?php if($user_profile->state == 'West Bengal'): ?> selected <?php endif; ?>>West Bengal</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design pin-code">
               <label for="pin_code">Pin Code</label>
               <input type="text" id="pin_code" name="pin_code" value="<?php echo e($user_profile->pin_code); ?>" placeholder="Enter Pin Code">
            </div>
            <div class="form-design course">
               <label for="course_type">Course Type</label>
               <select class="email-disabled" name="course_type" id="Course Type">
                  <option value ="" disabled selected>Select Course Type</option>
                  <option value="Web Designing" <?php if($user_profile->course_type == 'Web Designing'): ?> selected <?php endif; ?>>Web Designing</option>
                  <option value="Web Development" <?php if($user_profile->course_type == 'Web Development'): ?> selected <?php endif; ?>>Web Development</option>
                  <option value="Php" <?php if($user_profile->course_type == 'Php'): ?> selected <?php endif; ?>>PHP</option>
                  <option value="Graphic" <?php if($user_profile->course_type == 'Graphic'): ?> selected <?php endif; ?>>Graphic</option>
                  <option value="Full Stack Development" <?php if($user_profile->course_type == 'Full Stack Development'): ?> selected <?php endif; ?>>Full Stack Development</option>
               </select>
            </div>
            <div class="form-design duration">
               <label for="course_duration">Course Duration</label>
               <select class="email-disabled" name="course_duration" id="Course Duration">
                  <option value ="" disabled selected>Select Course Duration</option>
                  <option value="1 Month" <?php if($user_profile->course_duration == '1 Month'): ?> selected <?php endif; ?>>1 Month</option>
                  <option value="3 Month" <?php if($user_profile->course_duration == '3 Month'): ?> selected <?php endif; ?>>3 Month</option>
                  <option value="6 Month" <?php if($user_profile->course_duration == '6 Month'): ?> selected <?php endif; ?>>6 Month</option>
                  <option value="1 Year" <?php if($user_profile->course_duration == '1 Year'): ?> selected <?php endif; ?>>1 Year</option>
                  <option value="2 Year" <?php if($user_profile->course_duration == '2 Year'): ?> selected <?php endif; ?>>2 Year</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design join-date">
               <label for="course_joining_date">Course Joining Date</label>
               <input type="date" id="course_joining_date" class="email-disabled" name="course_joining_date" value="<?php echo e($user_profile->course_joining_date); ?>">
            </div>
            <div class="form-design end-date">
               <label for="course_complession_date">Course Complession Date</label>
               <input type="date" id="course_complession_date" name="course_complession_date" class="email-disabled" value="<?php echo e($user_profile->course_complession_date); ?>">
            </div>
            <div class="form-design fees">
               <label for="user_status">Status</label>
               <select class="email-disabled" name="user_status" id="User Status">
                  <option value ="" disabled selected>Select Status Type</option>
                  <option value="Active" <?php if($user_profile->user_status == 'Active'): ?> selected <?php endif; ?>>Active</option>
                  <option value="Pending" <?php if($user_profile->user_status == 'Pending'): ?> selected <?php endif; ?>>Pending</option>
                  <option value="Leave" <?php if($user_profile->user_status == 'Leave'): ?> selected <?php endif; ?>>Leave</option>
                  <option value="Suspend" <?php if($user_profile->user_status == 'Suspend'): ?> selected <?php endif; ?>>Suspend</option>
                  <option value="Completed" <?php if($user_profile->user_status == 'Completed'): ?> selected <?php endif; ?>>Completed</option>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/student/profiles/edit-profile-detail.blade.php ENDPATH**/ ?>