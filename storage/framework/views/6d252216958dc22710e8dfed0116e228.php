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
   <h2>All Students Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!--start filter student acc status fees-->
         <select name="fees_status" id="search_student_fees_status" class="search-student-list">
            <option value ="" disabled selected>Monthly Fees Status</option>
            <option value="Paid">Paid</option>
            <option value="Pending">Pending</option>
            <option value="Overdue">Overdue</option>
         </select>
         <!--end filter student acc status fees-->
         <!--start filter student acc course-->
         <select name="course_type" id="search_student_list" class="search-student-list">
            <option value ="" disabled selected>Select Course Type</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Web Development">Web Development</option>
            <option value="PHP Development">PHP Development</option>
            <option value="Graphic">Graphic</option>
            <option value="Full Stack Development">Full Stack Development</option>
         </select>
         <!--filter student acc to course-->
         <a href="<?php echo e(url('admin/add-new-student')); ?>"><img src="<?php echo e(url('public/admin/images/pluse.svg')); ?>">Add New Student</a>
         <!--export students monthly paid fees list -->
         <a href="<?php echo e(route('admin.export.paid.fees')); ?>" class="export">
         <img src="<?php echo e(url('public/admin/images/csv-file.svg')); ?>">Paid 
         </a>
         <!--export students monthly pending fees list -->
         <a href="<?php echo e(route('admin.export.pending.fees')); ?>" class="export">
         <img src="<?php echo e(url('public/admin/images/csv-file.svg')); ?>">Pending
         </a>
         <a href="<?php echo e(url('admin/all-students-trash-list')); ?>" class="export"><img src="<?php echo e(url('public/admin/images/trash.svg')); ?>"></a>
         <!--<a href="<?php echo e(url('admin/add-student-previous-fees')); ?>" class="add-pervious"><img src="<?php echo e(url('public/admin/images/pluse.svg')); ?>">Add Previous Fees</a>-->
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
      <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr class="">
                  <th>S. No</th>
                  <th>Registration ID</th>
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
                  <th>Action</th>
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
                        $pay_fees += $fees['user_fees'];
                        $submissionMonths[] = Carbon::parse($fees['submission_date'])->month;
                     ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
               <?php endif; ?>                 
               <tr>
                  <td><?php echo e($count++); ?></td>
                  <td><?php echo e($student->id); ?> </td>
                  <td data-th="Image">
                     <?php if($student->user_pic): ?>
                     <div class="user-image"> <img src="<?php echo e(url('public/uploads/users/' . $student->user_pic)); ?>" alt="">
                     <?php else: ?>
                     <img src="<?php echo e(url('public/uploads/users/default_user.png')); ?>" alt="">
                     </div>
                     <?php endif; ?>                           
                  </td>
                  <td>
                     <span onclick="openNav()"><a href="#" class="student-link"
                        data-student_id="<?php echo e($student->id); ?>"><?php echo e($student->name); ?></a></span>
                  </td>
                  <td>
                     <?php if($student->student_phone_no): ?>
                     <a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $student->student_phone_no)); ?>"
                        target="_blank">
                     <?php echo e(substr($student->student_phone_no, 0, 5)); ?>-<?php echo e(substr($student->student_phone_no, 5)); ?>

                     </a>
                     <?php else: ?>
                     -
                     <?php endif; ?>
                  </td>
                  <td><?php echo e(\Carbon\Carbon::parse($student->course_joining_date)->format('d M Y')); ?></td>
                  <?php if($student->course_type == 'Full Stack Development'): ?>
                  <td class="lights-blue-color"><span>Full Stack Development</span></td>
                  <?php elseif($student->course_type == 'PHP Development'): ?>
                  <td class="lights-green-color"><span>PHP Development</span></td>
                  <?php elseif($student->course_type == 'Web Development'): ?>
                  <td class="light-yellow-color"><span>Web Development</span></td>
                  <?php elseif($student->course_type == 'Web Designing'): ?>
                  <td class="light-pink-color"><span>Web Designing</span></td>
                  <?php elseif($student->course_type == 'Graphic Designing'): ?>
                  <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  <?php else: ?>
                  <td></td>
                  <?php endif; ?>
                  <td><?php echo e($student->course_duration); ?></td>
                  <?php if($student->total_fees): ?>
                  <td>
                     Rs <?php echo e(number_format($student->total_fees)); ?>

                     <div class="box-pay">
                        <button type="button" class="pay-fes-buton student_pay_fees"
                           data-student_id="<?php echo e($student->id); ?>" data-toggle="modal" data-target="#myModal">Pay
                        Fee</button>
                     </div>
                  </td>
                  <?php else: ?>
                  <td>N/A</td>
                  <?php endif; ?>
                  <td>
                     <?php if(isset($student->student_fees_detail)): ?>
                     <?php      $last_record = $student->student_fees_detail->last(); ?>
                     <?php if($last_record): ?>
                     Rs <?php echo e(number_format($last_record->user_fees)); ?><br>
                     <span class="date-tbl"><?php echo e(Carbon::parse($last_record->submission_date)->format('d M Y')); ?></span>
                     <?php else: ?>
                     -<br>
                     <?php endif; ?>
                     <?php endif; ?>
                  </td>
                  <td>
                  <?php if($pay_fees == 0): ?>
                     -
                  <?php else: ?>
                     Rs <?php echo e(number_format($total_fees - $pay_fees)); ?>

                  <?php endif; ?>
               </td>

                  <?php
                     $isPaid = false;
                     $isPending = false;
                     $isOverdue = false;
                     $lastPaymentDate = null;
                     $noPayment = true;
                     $payment_completed = false;

                     if (isset($student->student_fees_detail)) {
                     foreach ($student->student_fees_detail as $fees) {
                     $submissionMonth = Carbon::parse($fees['submission_date'])->format('m');
                     $submissionYear = Carbon::parse($fees['submission_date'])->format('Y');
                     $lastPaymentDate = Carbon::parse($fees['submission_date']);

                     //Check if the fees for the current month and year are paid
                     if ($submissionMonth == $currentMonth && $submissionYear == $currentYear && !is_null($fees['user_fees'])) {
                        $isPaid = true;
                        break;
                     }
                     }

                     //Check if the last payment date is more than 45 days ago
                     if ($lastPaymentDate && $lastPaymentDate->diffInDays(Carbon::now()) > 45) {
                         $isOverdue = true;
                        } else {
                         $isPending = !$isPaid;
                        }
                     } 

                     //check user total fees
                     if (!empty($student->total_fees) && $student->total_fees !== 0)  {
                        $noPayment = false;
                     }

                  //check user fees completed or not
                  if (isset($student->total_fees) && $student->total_fees == $pay_fees) {
                     $payment_completed = true;
                  }
                  ?>
                  <?php if($noPayment == true): ?>
                  <td>-</td>
                  <?php elseif($isOverdue): ?>
                  <td class="yellow-color"><span>Overdue</span></td>
                  <?php elseif($isPending): ?>
                  <td class="red-color"><span>Pending</span></td>
                  <?php elseif($payment_completed): ?>
                  <td class="ligth-green-color"><span>Fees Complete</span></td>
                  <?php else: ?>
                  <td class="green-color"><span>Paid</span></td>
                  <?php endif; ?>
                  <td>
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button"
                           data-bs-toggle="dropdown" aria-expanded="false"> <img
                           src="<?php echo e(url('public/admin/images/ellips.svg')); ?>" alt="ellips" /> </button>
                        <ul class="dropdown-menu pay-fees-submit">
                           <form class="drop-don-list">
                              <li>
                                 <!-- <a href="<?php echo e(url('admin/single-student-detail', $student->id)); ?>"><img src="<?php echo e(url('public/admin/images/ico-1.png')); ?>">View Student Detail</a> -->
                              </li>
                              <li><a href="<?php echo e(url('admin/edit-student', $student->id)); ?>"><img
                                 src="<?php echo e(url('public/admin/images/ico-4.png')); ?>">Edit</a></li>
                              <!-- <li><button type="submit" class="is_trash_student_record" data-id="<?php echo e($student->id); ?>"><img src="<?php echo e(url('public/admin/images/ico-5.png')); ?>">Trash</button></li> -->
                              <li class="student_trash_record" data-student_id="<?php echo e($student->id); ?>">
                                 <img src="<?php echo e(url('public/admin/images/ico-5.png')); ?>" alt="Trash Icon"> Trash
                              </li>
                           </form>
                        </ul>
                     </div>
                  </td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </tbody>
         </table>
      </div>
      <!--start student pay fees model-->
      <div class="modal fade pay-modal" id="myModal" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Pay Fees</h4>
            </div>
            <div class="modal-body">
               <form action="#" id="is_create_student_fee" Method="POST">
                  <input id="model_student_id" type="hidden" value="" name="student_id">
                  <input type="text" id="fees_amount" name="fees_amount" placeholder="Amount"/>                     
                  <select name="payment_type" id="payment_type">
                     <option value="">Payment Type</option>
                     <option value="online">Online</option>
                     <option value="cash">Cash</option>
                  </select>
                  <select name="first_payment_type" id="first_payment_type">
                     <option value="">First Payment Type</option>
                     <option value="down_payment">Down Payment</option>
                     <option value="monthly">Monthly</option>
                  </select>
                  <div class="button-save"><button type="submit" class="disable-submit">Save</button></div>
               </form>
               <div class="loader com_ajax_loader" style="display:none;">
                  <img src="<?php echo e(url('public/admin/images/200w.gif')); ?>" /> 
               </div>
            </div>
            <div class="student_fee_responce"></div>
         </div>
      </div>
   </div>
   <!--end student pay fees model-->
   <!--start student trash model-->
   <div class="modal" id="modeal_student_id" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modals-header">
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="modal-title">Trash student record</h4>
            </div>
            <div class="modal-body">
               <form action="#" id="trash_student_form" Method="POST">
                  <input id="trash_student_id" type="hidden" value="" name="student_id">                   
                  <p>Please select your student status</p>
                  <input type="radio" id="Leave" name="user_status" value="Leave">
                  <label for="leave">Due to some reason student leave.</label><br>
                  <input type="radio" id="Completed" name="user_status" value="Completed">
                  <label for="completed">Student course are completed.</label><br>
                  <div class="button-saves"><button type="submit" class="disable-submit is_delete_trash_record">Save</button></div>
               </form>
               <div class="loader com_ajax_loader" style="display:none;">
                  <img src="<?php echo e(url('public/admin/images/200w.gif')); ?>" /> 
               </div>
            </div>
            <div class="trash_responce"></div>
         </div>
      </div>
   </div>
  <!--end student trash model-->
</div>
</div>
</div>
</div>
<div id="myNav" class="overlay hide">
   <div class="overlay-content">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loader com_ajax_loaders" style="display: none;">
         <img src="<?php echo e(url('public/admin/images/index.svg')); ?>" />
      </div>
      <div class="student_detail_response"></div>
   </div>
</div>
<script>
function openNav() {
   document.getElementById("myNav").style.width = "68%";
   document.querySelector('.overlay').classList.remove('hide');
   document.querySelector('.loader').style.display = "block"; 
}
function closeNav() {
   document.getElementById("myNav").style.width = "0%";
   document.querySelector('.overlay').classList.add('hide');
   document.querySelector('.loader').style.display = "none"; 
}
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/students/search-students-fees-list.blade.php ENDPATH**/ ?>