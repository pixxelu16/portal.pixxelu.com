<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Changed Password</h2>
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
   <div class="student-change-password">
      <form action="<?php echo e(route('admin.changed.password', $user_profile->id)); ?>" method="POST" enctype="multipart/form-data">
         <?php echo csrf_field(); ?>
         <div class="form-designs first-name">
            <label for="email">Email Address</label>
            <input type="email" id="email" class="email-disabled" name="email" value="<?php echo e($user_profile->email); ?>" readonly>
         </div>
         <div class="form-designs first-name">
            <label for="current_password">Current Password</label>
            <div class="input-icon">
               <input type="password" id="current_password" name="current_password" placeholder="Enter Current Password" required>
               <i class="fas fa-eye" id="toggleCurrentPassword"></i>
            </div>
         </div>
         <div class="form-designs first-name">
            <label for="new_password">New Password</label>
            <div class="input-icon">
               <input type="password" id="new_password" name="new_password" placeholder="Enter New Password" required>
               <i class="fas fa-eye" id="toggleNewPassword"></i>
            </div>
         </div>
         <div class="form-designs first-name">
            <label for="confirm_password">Confirm Password</label>
            <div class="input-icon">
               <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" required>
               <i class="fas fa-eye" id="toggleConfirmPassword"></i>
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
<script>
function togglePasswordVisibility(fieldId, icon) {
   const field = document.getElementById(fieldId);
   if (!field) return; 
   if (field.type === 'password') {
      field.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
   } else {
      field.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
   }
}
document.getElementById('toggleCurrentPassword')?.addEventListener('click', function() {
   togglePasswordVisibility('current_password', this);
});
document.getElementById('toggleNewPassword')?.addEventListener('click', function() {
   togglePasswordVisibility('new_password', this);
});
document.getElementById('toggleConfirmPassword')?.addEventListener('click', function() {
   togglePasswordVisibility('confirm_password', this);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/profiles/change-password.blade.php ENDPATH**/ ?>