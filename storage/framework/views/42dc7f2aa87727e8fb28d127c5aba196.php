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
      <h2 class="attendance-header">Search Employee Attendances List</h2>
   </div>
   <!--start employee attendance boxes-->
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
         <h3>Absent</h3>
         <p><?php echo e($total_absent_days); ?></p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/leave_icon.svg')); ?>" alt="Leave">
         <h3>Leave</h3>
         <p><?php echo e($total_leave_days); ?></p>
      </div>
      <div class="box">
         <img src="<?php echo e(url('public/admin/images/half_day_leave.svg')); ?>" alt="Half Day">
         <h3>Half Day</h3>
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
   <!--end employee attendance boxes-->
</div>
<!--start search filter-->
<form action="<?php echo e(url('admin/search-employee-attendance')); ?>" method="GET">
   <div class="row search-all-students-attendance">
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus">
            <select class="select floating" name="employee_name">
               <option value="">Select Employee Name</option>
               <?php $__currentLoopData = $get_employee_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo e($employee->name); ?>" <?php echo e(request()->input('employee_name') === $employee->name ? 'selected="selected"' : ''); ?>><?php echo e($employee->name); ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
         </div>
      </div>
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
            <select class="select floating" name="month">
               <option value="">Select Month</option>
               <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo e($key); ?>" <?php echo e(request()->input('month') == $key ? 'selected' : ''); ?>>
               <?php echo e($name); ?>

               </option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
         </div>
      </div>
      <?php
      $currentYear = date('Y');
      $startYear = 2023; 
      ?>
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
            <select class="select floating" name="year">
               <option value="">Select Year</option>
               <?php for($i = $currentYear; $i >= $startYear; $i--): ?>
               <option value="<?php echo e($i); ?>" <?php echo e(request()->input('year') == $i ? 'selected' : ''); ?>>
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
                  <th>Sift</th>
                  <th>Sift Type</th>
                  <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                  $date = \Carbon\Carbon::create($year, $month, $day);
                  $dayOfWeek = $date->format('D'); 
                  $dayNumber = $date->format('d'); 
                  $isSunday = $dayOfWeek === 'Sun';
                  $isLastSaturday = $dayOfWeek === 'Sat' && $day == $lastSaturday;
                  ?>
                  <th class="<?php echo e($isSunday ? 'text-danger' : ($isLastSaturday ? 'text-primary' : '')); ?>">
                     <?php echo e($dayNumber); ?> <?php echo e($dayOfWeek); ?>

                  </th>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tr>
            </thead>
            <tbody>
               <?php
               $count = 1;
               ?>
               <?php $__empty_1 = true; $__currentLoopData = $get_employee_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
               <?php if($get_employee_detail->first()->employees_attendance_detail->count() > 0): ?>
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
                  <td><?php echo e($employee->name); ?></td>
                  <td><?php echo e($employee['employees_attendance_detail']['0']['sift'] ?? '-'); ?></td>
                  <td class="batch-time"><?php echo e($employee['employees_attendance_detail'][0]['sift_type'] ?? '-'); ?></td>
                  <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                  <?php
                  $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                  $attendance = $employee->employees_attendance_detail->first(function ($att) use ($date) {
                  return \Carbon\Carbon::parse($att->submission_date)->format('Y-m-d') === $date;
                  });

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

                  $isAttendanceMissing = !$attendance;
                  $isSunday = in_array($day, $sundays);
                  $isLastSaturday = $day == $lastSaturday;
                  $isHoliday = $isSunday || $isLastSaturday; 
                  ?>
                  <td>
                     <?php
                     //Get current month and year
                     $currentMonth = \Carbon\Carbon::now()->month;
                     $currentYear = \Carbon\Carbon::now()->year;
                     //Extract the month and year from the attendance date
                     $attendanceMonth = \Carbon\Carbon::parse($date)->month;
                     $attendanceYear = \Carbon\Carbon::parse($date)->year;
                     ?>

                     <?php if($isAttendanceMissing && !$isHoliday && $attendanceMonth == $currentMonth && $attendanceYear == $currentYear): ?> 
                     <button type="button" class="studentss-punch-in-buton employee_attendance" data-employee_id="<?php echo e($employee->id); ?>" data-missing_date="<?php echo e($date); ?>" data-employee_name="<?php echo e($employee->name); ?>" data-toggle="modal" data-target="#editAttendance">
                        <img src="<?php echo e(url('public/admin/images/edit.svg')); ?>" alt="Edit Icon">
                     </button>
                     <?php endif; ?>
                     <!--show holiday icon-->
                     <?php if($isHoliday): ?>
                        <?php if($isSunday): ?>
                           <img src="<?php echo e(url('public/admin/images/sunday.svg')); ?>" alt="Holiday">
                        <?php elseif($isLastSaturday): ?>
                           <img src="<?php echo e(url('public/admin/images/saturday.svg')); ?>" alt="Holiday">
                        <?php endif; ?>
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
                     <?php endif; ?>
                     <?php endif; ?>
                  </td>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tr>
               <?php else: ?>
               <tr>
                  <td colspan="20" class="no-attendance-fond">
                     "No employee attendance records found for the selected month and year."
                  </td>
               </tr>
               <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
               <tr>
               <td colspan="20" class="no-attendance-fond">
               "No attendance records found for the selected, Please select an employee name first."
               </td>
               </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<!--start employee punch in attendance modal-->
<div class="modal" id="editAttendance">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Edit Attendance  <span class="employee_attendances"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="#" id="employee_attendances" method="POST">
               <input type="hidden" id="attendances_employee_id" name="employee_id" value="" />
               <!-- <input type="hidden" id="date" name="submission_date" value="" /> -->
               <div class="form-group">
                  <label for="attendanceStatus">Attendance Status <span class="text-danger">*</span></label>
                  <select class="form-control" name="attendance_status" id="attendanceStatus">
                     <option value ="" disabled selected>Select Status</option>
                     <option value="present">Present</option>
                     <option value="half_day">Half Day</option>
                     <option value="absent">Absent</option>
                     <option value="leave">Leave</option>
                     <option value="holiday">Holiday</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="sift">Shift<span class="text-danger">*</span></label>
                  <select class="form-control" name="sift" id="sift">
                     <option value ="" disabled selected>Select Shift</option>
                     <option value="Morning">Morning</option>
                     <option value="Evening">Evening</option>
                     <option value="Night">Night</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="shiftType">Shift Type <span class="text-danger">*</span></label>
                  <select class="form-control" name="sift_type" id="sift_type">
                     <option value ="" disabled selected>Select Shift type</option>
                     <option value="Full Day">Full Day</option>
                     <option value="Half Day">Half Day</option>
                     <option value="Quarter Day">Quarter Day</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="submission_date">Date <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="submission_date" id="date">
               </div>
               <div class="form-group">
                  <label for="punch_in_time">Punch In Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_in_time" id="punch_in_time">
               </div>
               <div class="form-group">
                  <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_out_time" id="punchOutTime">
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary is_create_employee_punch_in_attendance">Submit</button>
               </div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;">
               <img src="<?php echo e(url('public/admin/images/200w.gif')); ?>" /> 
            </div>
            <div class="employee_attendance_responce"></div>
         </div>
      </div>
   </div>
</div>
<!--end employee punch in attendance modal-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/employee-attendances/search-employee-attendances.blade.php ENDPATH**/ ?>