<nav>
   <div class="logo-name">
      <div class="logo-image">
      <i class="uil uil-bars sidebar-toggle"><img src="<?php echo e(url('public/admin/images/Menu.svg')); ?>" alt=""></i> 
      </div>
   </div>
   <div class="menu-items">
      <ul class="nav-links">
         <li class="<?php echo e(request()->is('employee/dashboard') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('employee/dashboard')); ?>">
            <img src="<?php echo e(url('public/admin/images/dashboard.svg')); ?>" alt="dashboard" />
            <span class="link-name">Dashboard</span>
            </a>
         </li>
         <li class="<?php echo e(request()->is('employee/employee-attendance-list') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('employee/employee-attendance-list')); ?>">
               <img src="<?php echo e(url('public/admin/images/attendance.svg')); ?>" alt="attendance" />
               <span class="link-name">Attendance</span>
            </a>
         </li>
         <!-- <li class="<?php echo e(request()->is('employee/attendance') ? 'active' : ''); ?>">
            <a href="aatendance.html">
               <img src="<?php echo e(url('public/admin/images/attendance.svg')); ?>" alt="attendance" />
               <span class="link-name">Attendance</span>
            </a>
            </li> -->
         <li class="nav-item">
            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
            <img src="<?php echo e(url('public/admin/images/logout.svg')); ?>" alt="leads" />
            <?php echo e(__('Logout')); ?>

            </a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
               <?php echo csrf_field(); ?>
            </form>
         </li>
         <li class="mode">
            <a href="#">
            <i class="uil uil-moon"></i>
            <span class="link-name">Dark Mode</span>
            </a>
            <div class="mode-toggle">
               <span class="switch"></span>
            </div>
         </li>
      </ul>
   </div>
</nav><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/employee/layouts/sidebar.blade.php ENDPATH**/ ?>