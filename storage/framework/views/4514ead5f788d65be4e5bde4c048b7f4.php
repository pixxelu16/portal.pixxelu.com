<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Inquery detail</h2>
</div>
<div class="main-table">
   <?php if(Session::has('success')): ?>
   <div class="notification-green">
      <p><?php echo e(Session::get('success')); ?></p>
   </div>
   <script>
      setTimeout(function() {
            window.location.href = "<?php echo e(url('super-admin/all-inqueries-list')); ?>";
      }, 2000); 
   </script>
   <?php endif; ?> 
   <?php if(Session::has('unsuccess')): ?>
   <div class="notification-red">
      <p><?php echo e(Session::get('unsuccess')); ?></p>
   </div>
   <?php endif; ?>
   <div class="login-form">
      <form action="<?php echo e(route('super.admin.update.inquery', $inquery->id)); ?>" Method="POST">
         <?php echo csrf_field(); ?> 
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="name">Name</label>
               <input type="text" id="name" name="name" value="<?php echo e($inquery->name); ?>" placeholder="Enter Name" required>
            </div>
            <div class="form-design mail">
               <label for="mobile">Mobile</label>
               <input type="mobile" id="mobile" name="mobile" value="<?php echo e($inquery->mobile); ?>" placeholder="Enter mobile">
            </div>
            <div class="form-design dob">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="<?php echo e($inquery->address); ?>"  placeholder="Enter Address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design mail">
               <label for="course_type">Course</label>
               <select class="form-control" name="course_type" id="course_type">
                  <option value ="" disabled selected>Select Course Type</option>
                  <option value="Web Designing" <?php if($inquery->course_type == 'Web Designing'): ?> selected <?php endif; ?>>Web Designing</option>
                  <option value="Web Development"<?php if($inquery->course_type == 'Web Development'): ?> selected <?php endif; ?>>Web Development</option>
                  <option value="PHP Development" <?php if($inquery->course_type == 'PHP Development'): ?> selected <?php endif; ?>>PHP Development</option>
                  <option value="Digital Marketing" <?php if($inquery->course_type == 'Digital Marketing'): ?> selected <?php endif; ?>>Digital Marketing</option>
                  <option value="Graphic" <?php if($inquery->course_type == 'Graphic'): ?> selected <?php endif; ?>>Graphic</option>
                  <option value="Full Stack Development" <?php if($inquery->course_type == 'Full Stack Development'): ?> selected <?php endif; ?>>Full Stack Development</option>
               </select>
            </div>
            <div class="form-design fees">
               <label for="status">Priority</label>
               <select class="form-control" name="priority" id="User Status">
                  <option value ="" disabled selected>Select Priority Type</option>
                  <option value="hot" <?php if($inquery->priority == 'hot'): ?> selected <?php endif; ?>>Hot</option>
                  <option value="cold" <?php if($inquery->priority == 'cold'): ?> selected <?php endif; ?>>Cold</option>
                  <option value="warm" <?php if($inquery->priority == 'warm'): ?> selected <?php endif; ?>>Warm</option>
               </select>
            </div>
            <div class="form-design fees">
               <label for="total_fees">Total Fees</label>
               <input type="text" id="total_fees" name="total_fees" value="<?php echo e($inquery->total_fees); ?>" placeholder="Enter Total Fees">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design mail">
               <label for="status">Status</label>
               <select class="form-control" name="status" id="User Status">
                  <option value ="" disabled selected>Select Status Type</option>
                  <option value="Active" <?php if($inquery->status == 'Active'): ?> selected <?php endif; ?>>Active</option>
                  <option value="Office_Visited" <?php if($inquery->status == 'Office_Visited'): ?> selected <?php endif; ?>>Office Visited</option>
                  <option value="Closed" <?php if($inquery->status == 'Closed'): ?> selected <?php endif; ?>>Closed</option>
                  <option value="Converted" <?php if($inquery->status == 'Converted'): ?> selected <?php endif; ?>>Converted</option>
                  <option value="Hot_Lead" <?php if($inquery->status == 'Hot_Lead'): ?> selected <?php endif; ?>>Hot Lead</option>
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
<?php echo $__env->make('super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/inquery/edit-inquery.blade.php ENDPATH**/ ?>