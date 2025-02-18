<?php $__env->startSection('content'); ?>
<div class="space-remove"></div>
<div class="title-subheading">
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
   <div class ="search-header">
   <h2 class="attendance-header">Monthly Attendance List:-  <?php echo e(date('F Y')); ?></h2>
   </div>
   <!--start six boxes employee attendance on header-->
   <div class="boxes-wrapper student-attendance-header">
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/working_hours.svg')); ?>" alt="Working Hours">
         <h3>Working Hours</h3>
         <p><?php echo e(number_format($total_present_hours, 2)); ?> Hrs</p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/present_icon.svg')); ?>" alt="Present">
         <h3>Presents</h3>
         <p><?php echo e($total_present_days); ?></p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/absent_icon.svg')); ?>" alt="Absent">
         <h3>Absents</h3>
         <p><?php echo e($total_absent_days); ?></p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/leave_icon.svg')); ?>" alt="Leave">
         <h3>Leaves</h3>
         <p><?php echo e($total_leave_days); ?></p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/half_day_leave.svg')); ?>" alt="Half Day">
         <h3>Half Days</h3>
         <p><?php echo e($total_half_day); ?></p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/holiday.svg')); ?>" alt="Holidays">
         <h3>Holidays</h3>
         <p><?php echo e($total_holidays); ?></p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/total_days_in_month.svg')); ?>" alt="daysInMonth">
         <h3>Days in month</h3>
         <p><?php echo e($daysInMonth); ?></p>
      </div>
   </div>
   <!--end six boxes employee attendance on header-->
</div>
<form action="<?php echo e(url('employee/search-attendance')); ?>" method="GET">
   <!--start search filter-->
   <div class="row search-student-attendance">
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
            <select class="select floating" name="month">
               <option value="">Select Month</option>
               <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo e($key); ?>" <?php echo e(\Carbon\Carbon::now()->month === $key ? 'selected' : ''); ?>>
               <?php echo e($name); ?>

               </option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
         </div>
      </div>
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
            <select class="select floating" name="year">
               <option value="">Select Year</option>
               <?php for($i = date('Y'); $i >= 2023; $i--): ?>
               <option value="<?php echo e($i); ?>" <?php echo e($i == date('Y') ? 'selected' : ''); ?>>
               <?php echo e($i); ?>

               </option>
               <?php endfor; ?>
            </select>
         </div>
      </div>
      <div class="col-sm-6 col-md-3">
         <div class="d-grid">
            <input type="submit" class="btn btn-success" value="Search" />     
         </div>
      </div>
   </div>
</form>
<!--end search filter-->
<div class="row">
   <div class="col-lg-12">
      <div class="table-responsive">
         <table class="table table-striped custom-table table-nowrap mb-0">
            <thead>
               <tr>
                  <th>Sr No.</th>
                  <th>Employee ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Shift</th>
                  <th>Shift Type</th>
                  <!--start month header-->
                  <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php
                        $date = \Carbon\Carbon::create($year, $month, $day);
                        $dayOfWeek = $date->format('D'); 
                        $dayNumber = $date->format('d'); 
                        $isSunday = $dayOfWeek === 'Sun';
                        $isAlternativeSaturday = in_array($day, $alternativeSaturdays);
                     ?>
                        <th class="<?php echo e($isSunday || $isAlternativeSaturday ? 'text-danger' : ''); ?>">
                           <?php echo e($dayNumber); ?> <?php echo e($dayOfWeek); ?>

                        </th>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <!--end month header-->
               </tr>
            </thead>
            <tbody>
               <?php $count = 1; ?>
               <!--start get employee detail-->
               <?php $__empty_1 = true; $__currentLoopData = $get_employee_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr>
                     <td><?php echo e($count++); ?>.</td>
                     <td><?php echo e($employee->unique_employee_id); ?></td>
                     <td data-th="Image">
                        <?php if($employee->user_pic): ?>
                        <div class="user-image">
                           <img src="<?php echo e(url('public/uploads/employees/'. $employee->user_pic)); ?>" alt="">
                        </div>
                        <?php else: ?>
                        <img src="<?php echo e(url('public/uploads/employees/default_user.png')); ?>" alt="">
                        <?php endif; ?>
                     </td>
                     <td class="batch-time"><?php echo e($employee->name); ?></td>
                     <td><?php echo e($employee['employees_attendance_detail']['0']['sift'] ?? '-'); ?></td>
                     <td class="batch-time"><?php echo e($employee['employees_attendance_detail'][0]['sift_type'] ?? '-'); ?></td>
                     <!--start get employee attendance-->
                     <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                        $attendance = $employee->employees_attendance_detail->first(function ($att) use ($date) {
                        return \Carbon\Carbon::parse($att->submission_date)->format('Y-m-d') === $date;
                        });

                        //Get punch in and out
                        $punchIn = null;
                        $punchOut = null;
                        $formattedDuration = null;

                        if ($attendance) {
                           $punchIn = \Carbon\Carbon::parse($attendance->punch_in_time);
                           $punchOut = $attendance->punch_out_time ? \Carbon\Carbon::parse($attendance->punch_out_time) : null;
                        
                           if ($punchOut) {
                              $duration = $punchIn->diff($punchOut);
                              $hours = $duration->h;
                              $minutes = $duration->i;
                              $formattedDuration = sprintf('%d:%02d Hrs', $hours, $minutes);
                           }
                        }
                        
                        $isSunday = in_array($day, $sundays);
                        $isAlternativeSaturday = in_array($day, $alternativeSaturdays);
                        ?>
                        <td>
                           <!--show holiday icon-->
                           <?php if($isSunday): ?>
                                 <img src="<?php echo e(url('public/admin/images/sunday.svg')); ?>" alt="Holiday">
                              <?php elseif($isAlternativeSaturday): ?>
                                 <img src="<?php echo e(url('public/admin/images/saturday.svg')); ?>" alt="Holiday">
                              <?php else: ?>
                              <?php if($attendance): ?>
                                 <?php if($attendance->attendance_status == 'present'): ?>
                                       <img src="<?php echo e(url('public/admin/images/present_icon.svg')); ?>" alt="Present">
                                       <p class="student-attendance-duration"><?php echo e($formattedDuration ?? 'N/A'); ?></p>
                                    <?php elseif($attendance->attendance_status == 'absent'): ?>
                                       <img src="<?php echo e(url('public/admin/images/absent_icon.svg')); ?>" alt="Absent">
                                    <?php elseif($attendance->attendance_status == 'leave'): ?>
                                       <img src="<?php echo e(url('public/admin/images/leave_icon.svg')); ?>" alt="Leave">
                                    <?php elseif($attendance->attendance_status == 'half_day'): ?>
                                       <img src="<?php echo e(url('public/admin/images/half_day_leave.svg')); ?>" alt="Half Day">
                                    <?php elseif($attendance->attendance_status == 'holiday'): ?>
                                       <img src="<?php echo e(url('public/admin/images/Holiday.svg')); ?>" alt="Holiday Day">
                                 <?php endif; ?>
                                 <?php else: ?> 
                              <?php endif; ?>
                           <?php endif; ?>
                        </td>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <tr>
                     <td colspan="<?php echo e(count($days) + 6); ?>" class="text-center">No Attendance found</td>
                  </tr>
               <?php endif; ?>
               <!--end get employee detail-->
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('employee.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/employee/attendances/employee-attendance-list.blade.php ENDPATH**/ ?>