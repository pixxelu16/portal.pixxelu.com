 
<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Add New Employee Record</h2>
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
      <form action="<?php echo e(route('super.admin.submit.employee')); ?>" Method="POST" enctype="multipart/form-data">
         <?php echo csrf_field(); ?> 
         <div class="small-12 medium-2 large-2 columns">
            <div class="avatar-upload">
               <div class="avatar-edit">
                  <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                  <label for="imageUpload"><i class="fas fa-pencil-alt"></i></label>
               </div>
               <div class="add-new-student-pic">
                  <div class="avatar-preview">
                     <img id="imagePreview" src="<?php echo e(url('public/uploads/users/default_user.png')); ?>" >
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="first-name">First Name</label>
               <input type="text" id="first-name" name="first_name" value="<?php echo e(old('first_name')); ?>" placeholder="Enter First Name" required>
            </div>
            <div class="form-design last-name">
               <label for="last-name">Last Name</label>
               <input type="text" id="last-name" name="last_name" value="<?php echo e(old('last_name')); ?>" placeholder="Enter Last Name">
            </div>
            <div class="form-design mail">
               <label for="email">Email</label>
               <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Enter email address" required>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design password">
               <label for="password">Password</label>
               <input type="password" id="password" name="password" value="<?php echo e(old('password')); ?>" placeholder="Enter Password" required>
            </div>
            <div class="form-design dob">
               <label for="dob">Date of Birth</label>
               <input type="date" id="dob" name="dob" value="<?php echo e(old('dob')); ?>">
            </div>
            <div class="form-design phone-no">
               <label for="phone_no">Phone Number</label>
               <input type="text" id="phone_no" name="employee_phone_no" value="<?php echo e(old('employee_phone_no')); ?>" placeholder="Enter Phone Number">
            </div>
         </div>
         <div class="form-group display-column radio-btn-design">
            <div class="form-group">
               <label>Gender</label>
               <div class="form-design gender-options">
                  <div class="gender male">
                     <input type="radio" name="gender" value="Male"  />
                     <span>Male</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="gender" value="Female">
                     <span>Female</span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Marital Status</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Married">
                     <span>Married</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Unmarried">
                     <span>Unmarried</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Other">
                     <span>Other</span>
                  </div>
               </div>
            </div>
            <div class="form-design category">
               <label for="category">Category</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male"> 
                     <label class="radio-option">
                     <input type="radio" name="category" value="General">
                     <span>General</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="ST">
                     <span>ST</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="SC">
                     <span>SC</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="OBC">
                     <span>OBC</span>
                     </label>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-design qualification">
            <label for="qualification">Qualification</label>
            <div class="qualification-ftp">
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="12th">
                  <span>12th</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Graduation">
                  <span>Graduation</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Other">
                  <span>Other</span>
               </div>
            </div>
         </div>
         <br>
         <div class="form-group display-column">
            <div class="form-design aadhaar-no">
               <label for="aadhaar_no">Aaadhar Number</label>
               <input type="text" id="aadhar_no" name="aadhaar_no" value="<?php echo e(old('aadhaar_no')); ?>" placeholder="Enter Aaadhar Number">
            </div>
            <div class="form-design address">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="<?php echo e(old('address')); ?>" placeholder="Enter Address">
            </div>
            <div class="form-design state">
               <label for="state">State</label>
               <select name="state" class="form-control" id="state">
                  <option value="" disabled selected>Select State</option>
                  <option value="Andhra Pradesh">Andhra Pradesh</option>
                  <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                  <option value="Assam">Assam</option>
                  <option value="Bihar">Bihar</option>
                  <option value="Chhattisgarh">Chhattisgarh</option>
                  <option value="Goa">Goa</option>
                  <option value="Gujarat">Gujarat</option>
                  <option value="Haryana">Haryana</option>
                  <option value="Himachal Pradesh">Himachal Pradesh</option>
                  <option value="Jharkhand">Jharkhand</option>
                  <option value="Karnataka">Karnataka</option>
                  <option value="Kerala">Kerala</option>
                  <option value="Madhya Pradesh">Madhya Pradesh</option>
                  <option value="Maharashtra">Maharashtra</option>
                  <option value="Manipur">Manipur</option>
                  <option value="Meghalaya">Meghalaya</option>
                  <option value="Mizoram">Mizoram</option>
                  <option value="Nagaland">Nagaland</option>
                  <option value="Odisha">Odisha</option>
                  <option value="Punjab">Punjab</option>
                  <option value="Rajasthan">Rajasthan</option>
                  <option value="Sikkim">Sikkim</option>
                  <option value="Tamil Nadu">Tamil Nadu</option>
                  <option value="Telangana">Telangana</option>
                  <option value="Tripura">Tripura</option>
                  <option value="Uttar Pradesh">Uttar Pradesh</option>
                  <option value="Uttarakhand">Uttarakhand</option>
                  <option value="West Bengal">West Bengal</option>
                  <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                  <option value="Chandigarh">Chandigarh</option>
                  <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                  <option value="Lakshadweep">Lakshadweep</option>
                  <option value="Delhi">Delhi</option>
                  <option value="Puducherry">Puducherry</option>
                  <option value="Ladakh">Ladakh</option>
                  <option value="Jammu and Kashmir">Jammu and Kashmir</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design district">
               <label for="district">District</label>
               <select name="district" class="form-control" id="district">
                  <option value="" disabled selected>Select District</option>
                  <option value="Bilaspur">Bilaspur</option>
                  <option value="Chamba">Chamba</option>
                  <option value="Hamirpur">Hamirpur</option>
                  <option value="Kangra">Kangra</option>
                  <option value="Kinnaur">Kinnaur</option>
                  <option value="Kullu">Kullu</option>
                  <option value="Lahaul and Spiti">Lahaul and Spiti</option>
                  <option value="Mandi">Mandi</option>
                  <option value="Shimla">Shimla</option>
                  <option value="Sirmaur">Sirmaur</option>
                  <option value="Solan">Solan</option>
                  <option value="Una">Una</option>
               </select>
            </div>
            <div class="form-design pin_code">
               <label for="pin_code">Pin Code</label>
               <input type="text" id="pin_code" name="pin_code" value="<?php echo e(old('pin_code')); ?>" placeholder="Enter Pin Code">
            </div>
            <div class="form-design employee_role">
               <label for="employee_role">Employee Role</label>
               <select class="form-control" name="employee_role" id="employee_roles">
                  <option value ="" disabled selected>Select Employee Role</option>
                  <option value="Project Bidder">Project Bidder</option>
                  <option value="Php Development">Php Development</option>
                  <option value="Web Development">Web Development</option>
                  <option value="Web Designing">Web Designing</option>
                  <option value="Graphic Designing">Graphic Designing</option>
                  <option value="SEO">SEO</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design experince">
               <label for="experince">Experince</label>
               <select name="experince" class="form-control" id="experince">
                  <option value="" disabled selected>Select Experince</option>
                  <option value="Fresher">Fresher</option>
                  <option value="6 Month">6 Month</option>
                  <option value="1 Year">1 Year</option>
                  <option value="2 Year">2 Year</option>
                  <option value="3 Year">3 Year</option>
                  <option value="4 Year">4 Year</option>
                  <option value="5 Year">5 Year</option>
                  <option value="6 Year">6 Year</option>
                  <option value="7 Year">7 Year</option>
                  <option value="8 Year">8 Year</option>
                  <option value="9 Year">9 Year</option>
                  <option value="10 Year">10 Year</option>
                  <option value="11 Year">11 Year</option>
                  <option value="12 Year">12 Year</option>
                  <option value="13 Year">13 Year</option>
                  <option value="14 Year">14 Year</option>
                  <option value="15 Year">15 Year</option>
               </select>
            </div>
            <div class="form-design joining_date">
               <label for="joining_date">Joining Date</label>
               <input type="date" id="joining_date" name="joining_date" value="<?php echo e(old('joining_date')); ?>">
            </div>
            <div class="form-design resign_date">
               <label for="resign_date">Resign Date</label>
               <input type="date" id="resign_date" name="resign_date" class="email-disabled" value="<?php echo e(old('resign_date')); ?>">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design total_salary">
               <label for="net_salary">Net Salary</label>
               <input type="text" id="total_salary" name="net_salary" value="<?php echo e(old('net_salary')); ?>" placeholder="Enter amount">
            </div>
            <div class="form-design user_status">
               <label for="user_status">Status</label>
               <select class="form-control" name="user_status" id="user_status">
                  <option value ="" disabled selected>Select Status Type</option>
                  <option value="Active">Active</option>
                  <option value="Pending">Pending</option>
                  <option value="Leave">Leave</option>
                  <option value="Suspend">Suspend</option>
               </select>
            </div>
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Submit">
            </div>
         </div>
      </form>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/employees/add-new-employee.blade.php ENDPATH**/ ?>