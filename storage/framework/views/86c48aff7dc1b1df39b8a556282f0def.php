<nav>
   <div class="logo-name">
      <div class="logo-image">
         <i class="uil uil-bars sidebar-toggle"><img src="<?php echo e(url('public/admin/images/Menu.svg')); ?>" alt=""></i>
      </div>
   </div>
   <div class="menu-items">
      <ul class="nav-links">
         <li class="<?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/dashboard')); ?>">
            <img src="<?php echo e(url('public/admin/images/dashboard.svg')); ?>" alt="dashboard" />
            <span class="link-name">Dashboard</span>
            </a>
         </li>
         <li class="<?php echo e(request()->is('admin/all-students-list') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/all-students-list')); ?>">
            <img src="<?php echo e(url('public/admin/images/student.svg')); ?>" alt="student" />
            <span class="link-name">All Students</span>
            </a>
         </li>
         <!--<li class="<?php echo e(request()->is('admin/all-employees-attendance-list') ? 'active' : ''); ?>">-->
         <!--   <a href="<?php echo e(url('admin/all-employees-attendance-list')); ?>">-->
         <!--      <img src="<?php echo e(url('public/admin/images/attendance.svg')); ?>" alt="attendance" />-->
         <!--      <span class="link-name">Attendance</span>-->
         <!--   </a>-->
         <!--</li>-->
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php echo e(request()->is('admin/all-employees-attendance-list') || request()->is('admin/all-students-attendance-list') ? 'active' : ''); ?>" 
               href="#" id="attendanceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo e(url('public/admin/images/attendance.svg')); ?>" alt="attendance"/>
            <span class="link-name">Attendance</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="attendanceDropdown">
               <li class="<?php echo e(request()->is('admin/all-employees-attendance-list') ? 'active' : ''); ?>">
                  <a class="dropdown-item" href="<?php echo e(url('admin/all-employees-attendance-list')); ?>">
                  Staff 
                  </a>
               </li>
               <li class="<?php echo e(request()->is('admin/all-students-attendance-list') ? 'active' : ''); ?>">
                  <a class="dropdown-item" href="<?php echo e(url('admin/all-students-attendance-list')); ?>">
                  Student
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php echo e(request()->is('admin/all-employees-list') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/all-employees-list')); ?>">
            <img src="<?php echo e(url('public/admin/images/staff.svg')); ?>" alt="staff" />
            <span class="link-name">All Employees</span>
            </a>
         </li>
         <!-- <li class="<?php echo e(request()->is('admin/leads') ? 'active' : ''); ?>">
            <a href="#">
               <img src="<?php echo e(url('public/admin/images/leads.svg')); ?>" alt="leads" />
               <span class="link-name">Leads</span>
            </a>
            </li> -->
         <li class="<?php echo e(request()->is('admin/all-inqueries-list') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/all-inqueries-list')); ?>">
            <img src="<?php echo e(url('public/admin/images/all_inquries.svg')); ?>" alt="inqueries" />
            <span class="link-name">All Inqueries</span>
            </a>
         </li>
      </ul>
      <ul class="logout-mode">
         <li><a href="#">
            <img src="<?php echo e(url('public/admin/images/help.svg')); ?>" alt="leads" />
            <span class="link-name">Help</span>
            </a>
         </li> 
         <!-- <li><a href="#">
            <img src="<?php echo e(url('public/admin/images/setting.svg')); ?>" alt="setting" />
            <span class="link-name">Settings</span>
            </a>
         </li> -->
         <li class="<?php echo e(request()->is('admin/setting') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/setting')); ?>">
            <img src="<?php echo e(url('public/admin/images/setting.svg')); ?>" alt="leads" />
            <span class="link-name">Settings</span>
            </a>
         </li>
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
</nav><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>