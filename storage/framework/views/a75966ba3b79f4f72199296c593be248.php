<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Add New Inquery</h2>
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
      <form action="<?php echo e(route('super.admin.submit.inquery')); ?>" Method="POST">
         <?php echo csrf_field(); ?> 
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="name">Name</label>
               <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Name" required>
            </div>
            <div class="form-design mail">
               <label for="mobile">Mobile</label>
               <input type="mobile" id="mobile" name="mobile" value="<?php echo e(old('mobile')); ?>" placeholder="Enter mobile" required>
            </div>
            <div class="form-design dob">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="<?php echo e(old('address')); ?>"  placeholder="Enter Address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design mail">
               <label for="course_type">Course</label>
               <select class="form-control" name="course_type" id="Course Type" required>
                  <option value ="" disabled selected>Select Course Type</option>
                  <option value="Web Designing">Web Designing</option>
                  <option value="Web Development">Web Development</option>
                  <option value="PHP Development">PHP Development</option>
                  <option value="Digital Marketing">Digital Marketing</option>
                  <option value="Graphic">Graphic</option>
                  <option value="Full Stack Development">Full Stack Development</option>
               </select>
            </div>
            <div class="form-design mail">
               <label for="priority">Priority</label>
               <select class="form-control" name="priority" id="Priority Type" required>
                  <option value ="" disabled selected>Select Priority Type</option>
                  <option value="hot">Hot</option>
                  <option value="coldt">Cold</option>
                  <option value="warm">Warm</option>
               </select>
            </div>
            <div class="form-design dob">
               <label for="total_fees">Total Fees</label>
               <input type="text" id="total_fees" name="total_fees" value="<?php echo e(old('total_fees')); ?>"  placeholder="Enter Total Fees">
            </div>
            <!-- <div class="form-design fees">
               <label for="status">Status</label>
               <select class="form-control" name="status" id="User Status">
                  <option value ="" disabled selected>Select Status Type</option>
                  <option value="Active">Active</option>
               </select>
               </div> -->
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Submit">
            </div>
         </div>
   </div>
   </form>
</div>
</div>
<script>
   const mobileInput = document.getElementById('mobile');
   mobileInput.addEventListener('input', function(event) {
      const inputValue = event.target.value;
      const numericValue = inputValue.replace(/\D/g, ''); 
      const truncatedValue = numericValue.slice(0, 10); 
      event.target.value = truncatedValue;
   });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/inquery/add-new-inquery.blade.php ENDPATH**/ ?>