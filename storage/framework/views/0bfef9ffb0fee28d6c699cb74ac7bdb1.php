<div class="top">
   <div class="logo-bar"><img src="<?php echo e(url('public/admin/images/black-pixxelu.svg')); ?>"></div>
   <div class="dropdown-admin-panel">
      <div class="dropdown-content-panel">
         <div class="img-admin-panel">          
         </div>
         <div class="dropdown">
            <div class="user-info dropbtn">
               <img src="<?php echo e(url('public/uploads/employees/'.auth()->user()->user_pic)); ?>" alt="<?php echo e(auth()->user()->user_pic); ?>" class="user-pic">
               <p class="user-name"><?php echo e(auth()->user()->name); ?></p>
            </div>
            <div class="dropdown-content">
               <a href="<?php echo e(url('employee/profile')); ?>">Profile</a>
               <a href="<?php echo e(url('employee/change-password')); ?>">Change Password</a>
               <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
               <?php echo e(__('Logout')); ?>

               </a>
               <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                  <?php echo csrf_field(); ?>
               </form>
            </div>
         </div>
      </div>
   </div>
</div><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/employee/layouts/top-bar.blade.php ENDPATH**/ ?>