<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Employee Detail</h2>
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
      <form action="<?php echo e(route('employee.update.profile', $employee->id)); ?>" Method="POST" enctype="multipart/form-data">
         <?php echo csrf_field(); ?> 
         <div class="small-12 medium-2 large-2 columns">
            <div class="avatar-upload">
               <div class="avatar-edit">
                  <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                  <label for="imageUpload"><i class="fas fa-pencil-alt"></i></label>
               </div>
               <div class="add-new-student-pic">
                  <div class="avatar-preview">
                     <?php if($employee->user_pic): ?>
                     <img id="imagePreview" src="<?php echo e(url('public/uploads/employees/' .$employee->user_pic)); ?>" >
                     <?php else: ?>
                     <img id="imagePreview" src="<?php echo e(url('public/uploads/employees/default_employee.png')); ?>" >
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="first-name">First Name</label>
               <input type="text" id="first-name" name="first_name" value="<?php echo e($employee->first_name); ?>" placeholder="Enter First Name">
            </div>
            <div class="form-design last-name">
               <label for="last-name">Last Name</label>
               <input type="text" id="last-name" name="last_name" value="<?php echo e($employee->last_name); ?>" placeholder="Enter Last Name">
            </div>
            <div class="form-design mail">
               <label for="email">Email</label>
               <input type="email" id="email" name="email" value="<?php echo e($employee->email); ?>" class="email-disabled" placeholder="Enter email address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design dob">
               <label for="dob">Date of Birth</label>
               <input type="date" id="dob" name="dob" value="<?php echo e($employee->dob); ?>">
            </div>
            <div class="form-design aadhaar-no">
               <label for="aadhaar_no">Aaadhar Number</label>
               <input type="text" id="aadhar_no" name="aadhaar_no" value="<?php echo e($employee->aadhaar_no); ?>" placeholder="Enter Aaadhar Number">
            </div>
            <div class="form-design phone-no">
               <label for="employee_phone_no">Phone Number</label>
               <input type="text" id="phone_no" name="employee_phone_no" value="<?php echo e($employee->employee_phone_no); ?>" placeholder="Enter Phone Number">
            </div>
         </div>
         <div class="form-group display-column radio-btn-design">
            <div class="form-group">
               <label>Gender</label>
               <div class="form-design gender-options">
                  <div class="gender male">
                     <input type="radio" name="gender" value="Male" <?php if($employee->gender == 'Male'): ?> checked <?php endif; ?>>
                     <span>Male</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="gender" value="Female" <?php if($employee->gender == 'Female'): ?> checked <?php endif; ?>>
                     <span>Female</span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Marital Status</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Married" <?php if($employee->marital_status == 'Married'): ?> checked <?php endif; ?>>
                     <span>Married</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Unmarried" <?php if($employee->marital_status == 'Unmarried'): ?> checked <?php endif; ?>>
                     <span>Unmarried</span>
                  </div>
                  <div class="gender male">
                     <input type="radio" name="marital_status" value="Other" <?php if($employee->marital_status == 'Other'): ?> checked <?php endif; ?>>  
                     <span>Other</span>
                  </div>
               </div>
            </div>
            <div class="form-design category">
               <label for="category">Category</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male"> 
                     <label class="radio-option">
                     <input type="radio" name="category" value="General" <?php if($employee->category == 'General'): ?> checked <?php endif; ?>>
                     <span>General</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="ST" <?php if($employee->category == 'ST'): ?> checked <?php endif; ?>>
                     <span>ST</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="SC" <?php if($employee->category == 'SC'): ?> checked <?php endif; ?>>
                     <span>SC</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="OBC" <?php if($employee->category == 'OBC'): ?> checked <?php endif; ?>>
                     <span>OBC</span>
                     </label>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-design qualification">
            <?php $qualification = explode(",", $employee['qualification']); ?>
            <label for="qualification">Qualification</label>
            <div class="qualification-ftp">
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="12th" <?php if(in_array('12th', $qualification)): ?> checked <?php endif; ?>>
                  <span>12th</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Graduation" <?php if(in_array('Graduation', $qualification)): ?> checked <?php endif; ?>>
                  <span>Graduation</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Other" <?php if(in_array('Other', $qualification)): ?> checked <?php endif; ?>>
                  <span>Other</span>
               </div>
            </div>
         </div>
         <br>
         <div class="form-group display-column">
            <div class="form-design address">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="<?php echo e($employee->address); ?>" placeholder="Enter Address">
            </div>
            <div class="form-design state">
               <label for="state">State</label>
               <select name="state" class="form-control" id="state">
                  <option value="" disabled selected>Select State</option>
                  <option value="Andhra Pradesh" <?php if($employee->state == 'Andhra Pradesh'): ?> selected <?php endif; ?>>Andhra Pradesh</option>
                  <option value="Arunachal Pradesh" <?php if($employee->state == 'Arunachal Pradesh'): ?> selected <?php endif; ?>>Arunachal Pradesh</option>
                  <option value="Assam" <?php if($employee->state == 'Assam'): ?> selected <?php endif; ?>>Assam</option>
                  <option value="Bihar" <?php if($employee->state == 'Bihar'): ?> selected <?php endif; ?>>Bihar</option>
                  <option value="Chhattisgarh" <?php if($employee->state == 'Chhattisgarh'): ?> selected <?php endif; ?>>Chhattisgarh</option>
                  <option value="Goa" <?php if($employee->state == 'Goa'): ?> selected <?php endif; ?>>Goa</option>
                  <option value="Gujarat" <?php if($employee->state == 'Gujarat'): ?> selected <?php endif; ?>>Gujarat</option>
                  <option value="Haryana" <?php if($employee->state == 'Haryana'): ?> selected <?php endif; ?>>Haryana</option>
                  <option value="Himachal Pradesh" <?php if($employee->state == 'Himachal Pradesh'): ?> selected <?php endif; ?>>Himachal Pradesh</option>
                  <option value="Jharkhand" <?php if($employee->state == 'Jharkhand'): ?> selected <?php endif; ?>>Jharkhand</option>
                  <option value="Karnataka" <?php if($employee->state == 'Karnataka'): ?> selected <?php endif; ?>>Karnataka</option>
                  <option value="Kerala" <?php if($employee->state == 'Kerala'): ?> selected <?php endif; ?>>Kerala</option>
                  <option value="Madhya Pradesh" <?php if($employee->state == 'Madhya Pradesh'): ?> selected <?php endif; ?>>Madhya Pradesh</option>
                  <option value="Maharashtra" <?php if($employee->state == 'Maharashtra'): ?> selected <?php endif; ?>>Maharashtra</option>
                  <option value="Manipur" <?php if($employee->state == 'Manipur'): ?> selected <?php endif; ?>>Manipur</option>
                  <option value="Meghalaya" <?php if($employee->state == 'Meghalaya'): ?> selected <?php endif; ?>>Meghalaya</option>
                  <option value="Mizoram" <?php if($employee->state == 'Mizoram'): ?> selected <?php endif; ?>>Mizoram</option>
                  <option value="Nagaland" <?php if($employee->state == 'Nagaland'): ?> selected <?php endif; ?>>Nagaland</option>
                  <option value="Odisha" <?php if($employee->state == 'Odisha'): ?> selected <?php endif; ?>>Odisha</option>
                  <option value="Punjab" <?php if($employee->state == 'Punjab'): ?> selected <?php endif; ?>>Punjab</option>
                  <option value="Rajasthan" <?php if($employee->state == 'Rajasthan'): ?> selected <?php endif; ?>>Rajasthan</option>
                  <option value="Sikkim" <?php if($employee->state == 'Sikkim'): ?> selected <?php endif; ?>>Sikkim</option>
                  <option value="Tamil Nadu" <?php if($employee->state == 'Tamil Nadu'): ?> selected <?php endif; ?>>Tamil Nadu</option>
                  <option value="Telangana" <?php if($employee->state == 'Telangana'): ?> selected <?php endif; ?>>Telangana</option>
                  <option value="Tripura" <?php if($employee->state == 'Tripura'): ?> selected <?php endif; ?>>Tripura</option>
                  <option value="Uttar Pradesh" <?php if($employee->state == 'Uttar Pradesh'): ?> selected <?php endif; ?>>Uttar Pradesh</option>
                  <option value="Uttarakhand" <?php if($employee->state == 'Uttarakhand'): ?> selected <?php endif; ?>>Uttarakhand</option>
                  <option value="West Bengal" <?php if($employee->state == 'West Bengal'): ?> selected <?php endif; ?>>West Bengal</option>
                  <option value="Andaman and Nicobar Islands" <?php if($employee->state == 'Andaman and Nicobar Islands'): ?> selected <?php endif; ?>>Andaman and Nicobar Islands</option>
                  <option value="Chandigarh" <?php if($employee->state == 'Chandigarh'): ?> selected <?php endif; ?>>Chandigarh</option>
                  <option value="Dadra and Nagar Haveli and Daman and Diu" <?php if($employee->state == 'Dadra and Nagar Haveli and Daman and Diu'): ?> selected <?php endif; ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                  <option value="Lakshadweep" <?php if($employee->state == 'Lakshadweep'): ?> selected <?php endif; ?>>Lakshadweep</option>
                  <option value="Delhi" <?php if($employee->state == 'Delhi'): ?> selected <?php endif; ?>>Delhi</option>
                  <option value="Puducherry" <?php if($employee->state == 'Puducherry'): ?> selected <?php endif; ?>>Puducherry</option>
                  <option value="Ladakh" <?php if($employee->state == 'Ladakh'): ?> selected <?php endif; ?>>Ladakh</option>
                  <option value="Jammu and Kashmir" <?php if($employee->state == 'Jammu and Kashmir'): ?> selected <?php endif; ?>>Jammu and Kashmir</option>
               </select>
            </div>
            <div class="form-design district">
               <label for="district">District</label>
               <select name="district" class="form-control" id="district">
                  <option value="" disabled selected>Select District</option>
                  <option value="Bilaspur" <?php if($employee->district == 'Bilaspur'): ?> selected <?php endif; ?>>Bilaspur</option>
                  <option value="Chamba" <?php if($employee->district == 'Chamba'): ?> selected <?php endif; ?>>Chamba</option>
                  <option value="Hamirpur" <?php if($employee->district == 'Hamirpur'): ?> selected <?php endif; ?>>Hamirpur</option>
                  <option value="Kangra" <?php if($employee->district == 'Kangra'): ?> selected <?php endif; ?>>Kangra</option>
                  <option value="Kinnaur" <?php if($employee->district == 'Kinnaur'): ?> selected <?php endif; ?>>Kinnaur</option>
                  <option value="Kullu" <?php if($employee->district == 'Kullu'): ?> selected <?php endif; ?>>Kullu</option>
                  <option value="Lahaul and Spiti" <?php if($employee->district == 'Lahaul and Spiti'): ?> selected <?php endif; ?>>Lahaul and Spiti</option>
                  <option value="Mandi" <?php if($employee->district == 'Mandi'): ?> selected <?php endif; ?>>Mandi</option>
                  <option value="Shimla" <?php if($employee->district == 'Shimla'): ?> selected <?php endif; ?>>Shimla</option>
                  <option value="Sirmaur" <?php if($employee->district == 'Sirmaur'): ?> selected <?php endif; ?>>Sirmaur</option>
                  <option value="Solan" <?php if($employee->district == 'Solan'): ?> selected <?php endif; ?>>Solan</option>
                  <option value="Una" <?php if($employee->district == 'Una'): ?> selected <?php endif; ?>>Una</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design pin_code">
               <label for="pin_code">Pin Code</label>
               <input type="text" id="pin_code" name="pin_code" value="<?php echo e($employee->pin_code); ?>" placeholder="Enter Pin Code">
            </div>
            <div class="form-design joining_date">
               <label for="joining_date">Joining Date</label>
               <input type="date" id="joining_date" name="joining_date" value="<?php echo e($employee->joining_date); ?>">
            </div>
            <div class="form-design experince">
               <label for="experince">Experince</label>
               <select name="experince" class="form-control" id="experince">
                  <option value="" disabled selected>Select Experince</option>
                  <option value="Fresher" <?php if($employee->experince == 'Fresher'): ?> selected <?php endif; ?>>Fresher</option>
                  <option value="6 Month" <?php if($employee->experince == '6 Month'): ?> selected <?php endif; ?>>6 Month</option>
                  <option value="1 Year" <?php if($employee->experince == '1 Year'): ?> selected <?php endif; ?>>1 Year</option>
                  <option value="2 Year" <?php if($employee->experince == '2 Year'): ?> selected <?php endif; ?>>2 Year</option>
                  <option value="3 Year" <?php if($employee->experince == '3 Year'): ?> selected <?php endif; ?>>3 Year</option>
                  <option value="4 Year" <?php if($employee->experince == '4 Year'): ?> selected <?php endif; ?>>4 Year</option>
                  <option value="5 Year" <?php if($employee->experince == '5 Year'): ?> selected <?php endif; ?>>5 Year</option>
                  <option value="6 Year" <?php if($employee->experince == '6 Year'): ?> selected <?php endif; ?>>6 Year</option>
                  <option value="7 Year" <?php if($employee->experince == '7 Year'): ?> selected <?php endif; ?>>7 Year</option>
                  <option value="8 Year" <?php if($employee->experince == '8 Year'): ?> selected <?php endif; ?>>8 Year</option>
                  <option value="9 Year" <?php if($employee->experince == '9 Year'): ?> selected <?php endif; ?>>9 Year</option>
                  <option value="10 Year" <?php if($employee->experince == '10 Year'): ?> selected <?php endif; ?>>10 Year</option>
                  <option value="11 Year" <?php if($employee->experince == '11 Year'): ?> selected <?php endif; ?>>11 Year</option>
                  <option value="12 Year" <?php if($employee->experince == '12 Year'): ?> selected <?php endif; ?>>12 Year</option>
                  <option value="13 Year" <?php if($employee->experince == '13 Year'): ?> selected <?php endif; ?>>13 Year</option>
                  <option value="14 Year" <?php if($employee->experince == '14 Year'): ?> selected <?php endif; ?>>14 Year</option>
                  <option value="15 Year" <?php if($employee->experince == '15 Year'): ?> selected <?php endif; ?>>15 Year</option>
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
<?php echo $__env->make('employee.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/employee/profiles/edit-profile-detail.blade.php ENDPATH**/ ?>