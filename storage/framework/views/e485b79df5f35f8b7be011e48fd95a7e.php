<div class="top">
   <div class="logo-bar"><img src="<?php echo e(url('public/admin/images/black-pixxelu.svg')); ?>"></div>
   <div class="dropdown-admin-panel">
      <div class="btn-pixxeluss">
         <a href="<?php echo e(url('super-admin/add-new-inquery')); ?>"><img src="<?php echo e(url('public/admin/images/pluse.svg')); ?>">Add New Inquery</a>
      </div>
      <div class="dropdown-content-panel">
         <div class="img-admin-panel">
            
         </div>
         <div class="dropdown">
            <div class="user-info dropbtn">
               <img src="<?php echo e(url('public/uploads/users/'.auth()->user()->user_pic)); ?>" alt="<?php echo e(auth()->user()->user_pic); ?>" class="user-pic">
               <p class="user-name"><?php echo e(auth()->user()->name); ?></p>
            </div>
            <div class="dropdown-content">
               <a href="<?php echo e(url('super-admin/profile')); ?>">Profile</a>
               <a href="<?php echo e(url('super-admin/change-password')); ?>">Change Password</a>
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
</div>
</div><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/layouts/top-bar.blade.php ENDPATH**/ ?>