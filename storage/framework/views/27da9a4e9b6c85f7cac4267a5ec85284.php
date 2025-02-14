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
   <h2>All Students Trash List</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-trash-back">
         <a href="<?php echo e(url('admin/all-students-list')); ?>">
         <span class="login-arrow">
         <i class="fa fa-arrow-left" style="margin-right: 5px;" aria-hidden="true"></i>Back
         </span>
         </a>
      </div>
   </div>
   <div class="scrolling-data-table" style="margin-inline: 10px;">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>S. No</th>
                  <th>Student ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Course</th>
                  <th>Course Duration</th>
                  <th>Total Fees</th>
                  <th>Last Paid Fees</th>
                  <th>Pending Fees</th>
                  <th>Status</th>
                  <!-- <th>Action</th> -->
               </tr>
            </thead>
            <tbody>
               <?php 
               $count = 1;
               use Carbon\Carbon;
               $currentMonth = Carbon::now()->month;
               $currentYear = Carbon::now()->year;
               ?>
               <?php $__currentLoopData = $get_students_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php 
               $total_fees = $student->total_fees;
               $pay_fees = 0;
               ?>
               <?php if(isset($student->student_fees_detail)): ?> 
               <?php $__currentLoopData = $student->student_fees_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php 
               $total_fees = $student->total_fees;
               $pay_fees  += $fees['user_fees'];
               $submissionMonths[] = Carbon::parse($fees['submission_date'])->month;
               ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
               <?php endif; ?>     
               <tr>
                  <td><?php echo e($count++); ?></td>
                  <td><a href="<?php echo e(url('admin/download-receipt/' . $student->id)); ?>" target="_blank"><i class="fas fa-download"></i> <?php echo e($student->id); ?></a></td>
                  <td data-th="Image">
                     <?php if($student->user_pic): ?>
                     <div class="user-image"> <img src = "<?php echo e(url('public/uploads/users/'. $student->user_pic)); ?>" alt=""></div>
                     <?php endif; ?> 
                  </td>
                  <td>
                     <span onclick="openNav()"><a href="#" class="student-link"
                        data-student_id="<?php echo e($student->id); ?>"><?php echo e($student->name); ?></a></span>
                  </td>
                  <td><a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $student->student_phone_no)); ?>" target="_blank"><?php echo e(substr($student->student_phone_no, 0, 5)); ?>-<?php echo e(substr($student->student_phone_no, 5)); ?></a></td>
                  <td><?php echo e(\Carbon\Carbon::parse($student->course_joining_date)->format('d M Y')); ?></td>
                  <?php if($student->course_type == 'Full Stack Development'): ?> 
                  <td class="lights-blue-color"><span>Full Stack Development</span></td>
                  <?php elseif($student->course_type == 'PHP Development'): ?>
                  <td class="lights-green-color"><span>PHP Development</span></td>
                  <?php elseif($student->course_type == 'Web Development'): ?>
                  <td class="light-yellow-color"><span>Web Development</span></td>
                  <?php elseif($student->course_type == 'Web Designing'): ?>
                  <td class="light-pink-color"><span>Web Designing</span></td>
                  <?php elseif($student->course_type == 'Digital Marketing'): ?>
                  <td class="light-organge-color"><span>Digital Marketing</span></td>
                  <?php elseif($student->course_type == 'Graphic Designing'): ?>
                  <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  <?php else: ?>
                  <td></td>
                  <?php endif; ?>
                  <td><?php echo e($student->course_duration ?? '-'); ?></td>
                  <?php if($student->total_fees): ?>
                  <td>
                     Rs <?php echo e(number_format($student->total_fees)); ?>

                     <!-- <div class="box-pay">
                        <button type="button" class="pay-fes-buton student_pay_fees" data-student_id="<?php echo e($student->id); ?>" data-toggle="modal" data-target="#myModal">Pay Fee</button>
                        </div> -->
                  </td>
                  <?php else: ?>
                  <td>-</td>
                  <?php endif; ?>
                  <td>
                     <?php if(isset($student->student_fees_detail) && count($student->student_fees_detail) > 0): ?>
                     <?php
                     $get_last_submit_fees = collect($student->student_fees_detail)->sortByDesc(function ($fee) {
                     });
                     //Get the last paid fee
                     $lastPaidFee = $get_last_submit_fees->first();
                     ?>
                     <?php if($lastPaidFee): ?>
                     Rs <?php echo e(number_format($lastPaidFee['user_fees'])); ?><br>
                     <span class="date-tbl"><?php echo e(Carbon::parse($lastPaidFee['submission_date'])->format('d M Y')); ?></span>
                     <?php else: ?>
                     -
                     <?php endif; ?>
                     <?php else: ?>
                     -
                     <?php endif; ?>
                  </td>
                  <?php if($pay_fees): ?>
                  <td>Rs <?php echo e(number_format($total_fees - $pay_fees)); ?></td>
                  <?php else: ?>
                  <td>-</td>
                  <?php endif; ?>
                  <?php if($student->user_status == 'Active'): ?> 
                  <td class="green-color"><span>Active</span></td>
                  <?php elseif($student->user_status == 'Pending'): ?>
                  <td class="red-color"><span>Pending</span></td>
                  <?php elseif($student->user_status == 'Suspend'): ?>
                  <td class="purple-color"><span>Suspend</span></td>
                  <?php elseif($student->user_status == 'Completed'): ?>
                  <td class="green-color"><span>Complete</span></td>
                  <?php elseif($student->user_status == 'Leave'): ?>
                  <td class="red-color"><span>Leave</span></td>
                  <?php else: ?>
                  <td></td>
                  <?php endif; ?>
                  <!-- <?php
                     $isPending = false;
                     if (isset($student->student_fees_detail)) {
                        foreach ($student->student_fees_detail as $fees) {
                              $submissionMonth = Carbon::parse($fees['submission_date'])->format('m');
                              $submissionYear = Carbon::parse($fees['submission_date'])->format('Y');                          
                              if ($submissionMonth == $currentMonth && $submissionYear == $currentYear && !is_null($fees['user_fees'])) {
                                 $isPending = true;
                                 break;
                              }
                        }
                     }
                     ?>
                     <?php if(!$isPending): ?>
                     <td class="red-color"><span>Pending</span></td>
                     <?php else: ?>
                     <td class="green-color"><span>Paid</span></td>
                     <?php endif; ?> -->
                  <!-- <td>
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <img src="<?php echo e(url('public/admin/images/ellips.svg')); ?>" alt="ellips" /> </button>
                        <ul class="dropdown-menu pay-fees-submit">
                           <form class="drop-don-list">
                            <li> 
                                 <a href="<?php echo e(url('admin/single-student-detail', $student->id)); ?>"><img src="<?php echo e(url('public/admin/images/ico-1.png')); ?>">View Student Detail</a>
                                 </li> -->
                  <!-- <li><a href="<?php echo e(url('admin/edit-student', $student->id)); ?>"><img src="<?php echo e(url('public/admin/images/ico-4.png')); ?>">Edit</a></li> -->
                  <!-- <li><button type="submit" class="is_delete_student_record" data-id="<?php echo e($student->id); ?>"><img src="<?php echo e(url('public/admin/images/ico-5.png')); ?>">Delete</button></li>
                     </form>
                     </ul>
                     </div> 
                     </td> -->
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/students/all-students-trash-list.blade.php ENDPATH**/ ?>