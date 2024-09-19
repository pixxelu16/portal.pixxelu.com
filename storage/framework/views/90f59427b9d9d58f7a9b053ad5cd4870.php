<?php $__env->startSection('content'); ?>
<?php
use Carbon\Carbon;
?>
<div class="space-remove"></div>
<!-- <div class="title-subheading">
   <h2>Personal Details</h2>
</div> -->
<div class="main-single-student">
   <div class="name-user">
      <div class="student-name">
         <div class="edit-student-detail">
            <li><a href="<?php echo e(url('student/profile')); ?>"><i class="fa-solid fa-pencil"></i></a></li>
         </div>
         <div class="profile-user-popup">
            <?php if($get_student_detail->user_pic): ?>
            <img src="<?php echo e(url('public/uploads/users/'. $get_student_detail->user_pic)); ?>" alt="">
            <?php else: ?>
            <img src="<?php echo e(url('public/uploads/users/user_pic')); ?>" alt="">
            <?php endif; ?>               
         </div>
         <div class="student-attendance">
            <div class="box-pay">
               <button type="button" class="student-punch-in-buton student_punch_in_attendances" data-student_id="<?php echo e($get_student_detail->id); ?>" data-student_name="<?php echo e($get_student_detail->name); ?>" data-toggle="modal" data-target="#punchInModel">Punch in
            </div>
            <div class="box-pay">
               <button type="button" class="student-punch-out-buton student_punch_out_attendance" data-student_id="<?php echo e($get_student_detail->id); ?>" data-student_name="<?php echo e($get_student_detail->name); ?>" data-toggle="modal" data-target="#punchOutModel">Punch Out
            </div>
         </div>
         <h3><?php echo e($get_student_detail->name ?? '-'); ?></h3>
         <p><?php echo e($get_student_detail->email ?? '-'); ?></p>
         <p><?php echo e(substr($get_student_detail->student_phone_no ?? '', 0, 5) . '-' . substr($get_student_detail->student_phone_no ?? '', 5)); ?></span></p>
         <p><em>Joining Date:-</em> <?php echo e(Carbon::parse($get_student_detail->course_joining_date)->format('d F Y') ?? '-'); ?></p>
      </div>
      <div class="info-student">
         <h4>Information</h4>
      </div>
      <div class="detail-info">
         <p><em>Registration no:-</em> <span><?php echo e($get_student_detail->id ?? '-'); ?></span></p>
         <p><em>Father's name:-</em> <span><?php echo e($get_student_detail->father_name ?? '-'); ?></span></p>
         <p><em>Father's phone no:-</em><span><?php echo e(substr($get_student_detail->father_phone_no ?? '', 0, 5) . '-' . substr($get_student_detail->father_phone_no ?? '', 5)); ?></span></p>
         <p><em>Batch timing:-</em><span><?php echo e($get_student_detail->batch_timing ?? '-'); ?></span></p>
         <p><em>Date of birth:-</em><span><?php echo e(Carbon::parse($get_student_detail->dob)->format('d F Y') ?? '-'); ?></span></p>
         <p><em>Sex:-</em><span><?php echo e($get_student_detail->gender ?? '-'); ?></span></p>
         <p><em>Category:-</em><span><?php echo e($get_student_detail->category ?? '-'); ?></span></p>
         <p><em>Adhar card no:-</em><span><?php echo e($get_student_detail->aadhaar_no ?? '-'); ?></span></p>
         <p><em>Current Address:-</em><span><?php echo e($get_student_detail->address); ?>, <?php echo e($get_student_detail->district); ?>, <?php echo e($get_student_detail->state); ?> (<?php echo e($get_student_detail->pin_code); ?>)</span></p>
      </div>
   </div>
   <div class="table-all">
     <!--start student monthly fees table-->
      <!-- <div class="table-qualification">
         <label>Monthly Fees details According to Course Duration</label>
         <div id="table-scroll" class="table-scroll first-table">
            <table id="main-table" class="main-table">
               <thead>
                  <tr class="sticky">
                     <th>Sr.No.</th>
                     <th>Name Of Month</th>
                     <th class="small">Amount</th>
                  </tr>
               </thead>
               <tbody class="scroll">
                  <?php if($get_student_detail): ?>
                  <?php
                  $count = 1;
                  $totalFees = $get_student_detail->total_fees; 
                  $paidFees = 0;
                  $course_duration = $get_student_detail->course_duration;
                  //months show course duration
                  $monthsToShow = 0;
                  if ($course_duration == '1 Month') {
                  $monthsToShow = 1;
                  } elseif ($course_duration == '3 Month') {
                  $monthsToShow = 3;
                  } elseif ($course_duration == '6 Month') {
                  $monthsToShow = 6;
                  } elseif ($course_duration == '1 Year') {
                  $monthsToShow = 12;
                  } elseif ($course_duration == '2 Year') {
                  $monthsToShow = 24;
                  }
                  $currentDate = Carbon::parse($course_joining_date);
                  ?>
                  <?php for($i = 0; $i < $monthsToShow; $i++): ?>
                  <?php
                  $fee_detail = $get_student_detail->student_fees_detail->first(function($fee) use ($currentDate) {
                  return Carbon::parse($fee->submission_date)->month == $currentDate->month &&
                  Carbon::parse($fee->submission_date)->year == $currentDate->year;
                  });
                  ?>
                  <tr>
                     <td><?php echo e($count++); ?>.</td>
                     <td><?php echo e($currentDate->format('M Y')); ?></td>
                     <td>
                        <table>
                           <tbody>
                              <tr class="amount-table">
                                 <td class="bold-amount">
                                    <?php if($fee_detail): ?>
                                    <?php echo e($fee_detail->user_fees); ?>

                                    <?php
                                    $paidFees += $fee_detail->user_fees;
                                    ?>
                                    <?php if($fee_detail->payment_type == 'cash'): ?>
                                 <td>(Cash)</td>
                                 <?php elseif($fee_detail->payment_type == 'online'): ?>
                                 <td>(Online)</td>
                                 <?php else: ?>
                                 <td></td>
                                 <?php endif; ?>
                                 <?php else: ?>
                                 <td>-</td>
                                 <?php endif; ?>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
                  <?php
                  $currentDate->addMonth();
                  ?>
                  <?php endfor; ?>
               </tbody>
               <tfoot>
                  <tr class="tfooter">
                     <td class="space" colspan="2"><span style="color: black;">Total Fees:</span></td>
                     <td><strong><?php echo e(number_format($totalFees, 0)); ?></strong></td>
                  </tr>
                  <tr class="tfooter">
                     <td class="space" colspan="2"><span style="color: green;">Paid Fees:</span></td>
                     <td><strong style="color: green;"><?php echo e(number_format($paidFees, 0)); ?></strong></td>
                  </tr>
                  <tr class="tfooter">
                     <td class="space" colspan="2"><span style="color: red;">Remaining Fees:</span></td>
                     <td><strong style="color: red;"><?php echo e(number_format($totalFees - $paidFees, 0)); ?></strong></td>
                  </tr>
               </tfoot>
            </table>
         </div>
         </div>
         <?php endif; ?> -->
         <!--end student monthly fees table-->
         <!--start student assign accessories table-->
         <div class="table-qualification">
            <label>Assign Accessories details</label>
            <table>
               <thead>
                  <tr>
                     <th>Sr.No.</th>
                     <th>Keyboard</th>
                     <th>Mouse</th>
                     <th>Assign Accessories Date</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if($get_student_detail && $get_student_detail->student_assign_accessories->isNotEmpty()): ?>
                  <?php
                  $count = 1;
                  ?>
                  <?php $__currentLoopData = $get_student_detail->student_assign_accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo e($count++); ?>.</td>
                     <td><?php echo e($accessories->keyboard_assigned); ?></td>
                     <td><?php echo e($accessories->mouse_assigned); ?></td>
                     <td><?php echo e(Carbon::parse($accessories->created_at)->format('d M Y')); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                  <tr>
                     <td colspan="4">No accessories assigned</td>
                  </tr>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
         <!--end student assign accessories table-->
         <!--start student damage accessories table-->
         <div class="table-qualification">
            <label>Damage Accessories details</label>
            <table>
               <thead>
                  <tr>
                     <th>Sr.No.</th>
                     <th>Keyboard</th>
                     <th>Mouse</th>
                     <th>Damage Accessories Date</th>
                     <th>Remark</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if($get_student_damage_accessories && $get_student_damage_accessories->isNotEmpty()): ?>
                  <?php
                  $count = 1;
                  ?>
                  <?php $__currentLoopData = $get_student_damage_accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo e($count++); ?>.</td>
                     <td><?php echo e($accessories->keyboard_damage); ?></td>
                     <td><?php echo e($accessories->mouse_damage); ?></td>
                     <td><?php echo e(Carbon::parse($accessories->created_at)->format('d M Y')); ?></td>
                     <td><?php echo e($accessories->remark); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                  <tr>
                     <td colspan="5">No accessories damaged</td>
                  </tr>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
         <!--end student damage accessories table-->
         <!--start student punch in attendance modal-->
         <div class="modal" id="punchInModel">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Punch In  <span class="student_attendances"></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form action="#" id="student_punch_in_attendance" method="POST">
                        <input type="hidden" id="model_student_id" name="student_id" value="" />
                        <div class="form-group">
                           <label for="attendanceStatus">Attendance Status <span class="text-danger">*</span></label>
                           <select class="form-control" name="attendance_status" id="attendanceStatus">
                              <option value ="" disabled selected>Select Status</option>
                              <option value="present">Present</option>
                              <option value="half_day">Half Day</option>
                              <option value="absent">Absent</option>
                              <option value="leave">Leave</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="batch">Batch <span class="text-danger">*</span></label>
                           <select class="form-control" name="batch" id="batch">
                              <option value ="" disabled selected>Select Batch</option>
                              <option value="Morning">Morning</option>
                              <option value="Evening">Evening</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="batch_time">Batch Timings <span class="text-danger">*</span></label>
                           <select class="form-control" name="batch_time" id="batch_time" required>
                              <option value="" disabled selected>Select Batch Timing</option>
                              <option value="10:00 AM - 1:30 PM">10:00 AM - 1:30 PM</option>
                              <option value="2:30 PM - 6:00 PM">2:30 PM - 6:00 PM</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="punch_in_time">Punch In Time <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="punch_in_time" id="punch_in_time">
                        </div>
                        <!-- <div class="form-group">
                           <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="punch_out_time" id="punchOutTime">
                        </div> -->
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary is_create_student_punch_in_attendance">Submit</button>
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
         <!--end student punch in attendance modal-->
         <!--start student punch out attendance modal-->
         <div class="modal" id="punchOutModel">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Punch Out Of <span class="student_attendance_name"></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form action="#" id="student_punch_out_attendance" method="POST">
                        <input type="hidden" id="model_punch_out_student_id" name="employee_id" value="" />
                        <div class="form-group">
                           <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="punch_out_time" id="punch_out_time">
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary is_create_student_punch_out_attendance">Submit</button>
                        </div>
                     </form>
                     <div class="loader com_ajax_loader" style="display:none;">
                        <img src="<?php echo e(url('public/admin/images/200w.gif')); ?>" /> 
                     </div>
                     <div class="student_attendance_responce"></div>
                  </div>
               </div>
            </div>
         </div>
         <!--end student punch out attendance modal-->
   </div>
</div>
<script>
   //Function for current time in punch Iin and punch out
   function setCurrentTimeInIST() {
      //Get current time in IST
      var currentISTTime = new Date().toLocaleTimeString('en-US', {
         timeZone: 'Asia/Kolkata',
         hour12: false, 
         hour: '2-digit',
         minute: '2-digit'
      });
      //Set the current time for punch In
      document.getElementById('punch_in_time').value = currentISTTime;
      //Set the current time for punch Out
      document.getElementById('punch_out_time').value = currentISTTime;
   }
   //Set the current time when the page loads
   window.onload = setCurrentTimeInIST;
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/student/dashboard.blade.php ENDPATH**/ ?>