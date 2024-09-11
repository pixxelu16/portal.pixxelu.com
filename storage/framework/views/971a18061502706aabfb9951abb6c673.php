<?php $__env->startSection('content'); ?>
<?php
use Carbon\Carbon;
?>
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Personal Details</h2>
</div>
<div class="main-single-student">
   <div class="name-user">
      <div class="student-name">
         <div class="edit-student-detail">
            <li><a href="<?php echo e(url('employee/profile')); ?>"><i class="fa-solid fa-pencil"></i></a></li>
         </div>
         <div class="profile-user-popup">
            <?php if(isset($get_employee_detail->user_pic)): ?>
            <img src="<?php echo e(url('public/uploads/employees/'. $get_employee_detail->user_pic)); ?>" alt="">
            <?php else: ?>
            <img src="<?php echo e(url('public/uploads/users/default_user.png')); ?>" alt="">
            <?php endif; ?>
         </div>
         <h3><?php echo e($get_employee_detail->name ?? '-'); ?></h3>
         <p><?php echo e($get_employee_detail->employee_role ?? '-'); ?></p>
         <p><?php echo e($get_employee_detail->email ?? '-'); ?></p>
         <p><?php echo e(substr($get_employee_detail->employee_phone_no, 0, 5) . '-' . substr($get_employee_detail->employee_phone_no, 5)); ?></p>
         <?php if(isset($get_employee_detail->joining_date)): ?>
         <p><em>Joining Date:</em> <?php echo e(($get_employee_detail->joining_date) ? Carbon::parse($get_employee_detail->joining_date)->format('d M Y') : '-'); ?></p>
         <?php else: ?>
         -
         <?php endif; ?>
      </div>
      <div class="info-student">
         <h4>Information</h4>
      </div>
      <div class="detail-info">
         <p><em>Registration No: </em><span><?php echo e($get_employee_detail->unique_employee_id); ?></span></p>
         <p><em>Date of Birth:</em><span><?php echo e(($get_employee_detail->dob) ? Carbon::parse($get_employee_detail->dob)->format('d M Y') : '-'); ?></span></p>
         <p><em>Sex: </em><span><?php echo e($get_employee_detail->gender ?? '-'); ?></span></p>
         <p><em>Category: </em><span><?php echo e($get_employee_detail->category ?? '-'); ?></span></p>
         <p><em>Aadhar Card No: </em><span><?php echo e($get_employee_detail->aadhaar_no ?? '-'); ?></span></p>
         <p><em>Current Address: </em><span><?php echo e($get_employee_detail->address . ', ' . $get_employee_detail->district . ', ' . $get_employee_detail->state . ', ' . $get_employee_detail->pin_code); ?></span></p>
      </div>
   </div>
   <!--start all employees table-->
   <div class="table-all">
      <!--start employee monthly salary table-->
      <div class="table-qualification">
         <label>Employee Monthly Salary Details</label>
         <div id="table-scroll" class="table-scroll first-table">
            <table id="main-table" class="main-table">
               <thead>
                  <tr>
                     <th>Sr. No.</th>
                     <th>Month</th>
                     <th>Increment Amount</th>
                     <th>Paid Amount</th>
                  </tr>
               </thead>
               <tbody class="scroll">
                  <?php
                  $count = 1;
                  $total_paid_salary = 0;
                  $total_increment = 0;
                  ?>
                  <?php $__currentLoopData = $baseSalaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $baseSalary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                  $incrementAmount = $incrementsForMonth[$month] ?? 0;
                  $total_paid_salary += $baseSalary;
                  $total_increment += $incrementAmount;
                  ?>
                  <tr>
                     <td><?php echo e($count++); ?>.</td>
                     <td><?php echo e($month); ?></td>
                     <td><?php echo e($incrementAmount > 0 ? number_format($incrementAmount) : '-'); ?></td>
                     <td><?php echo e($baseSalary > 0 ? number_format($baseSalary) : '-'); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
               <tfoot>
                  <tr class="tfooter">
                     <td class="space" colspan="3">
                        <span style="color: green;">
                        Total Paid Salary for the Year: <?php echo e(now()->year); ?>

                        </span>
                     </td>
                     <td><strong style="color: black;"><?php echo e(number_format($total_paid_salary)); ?></strong></td>
                  </tr>
                  <tr class="tfooter">
                     <td class="space" colspan="3">
                        <span style="color: black;">
                        Total Net Salary:
                        </span>
                     </td>
                     <td><strong style="color: black;"><?php echo e($get_employee_detail->net_salary > 0 ? number_format(base64_decode($get_employee_detail->net_salary)) : '-'); ?></strong></td>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
      <!--end employee monthly salary table-->
      <!--start employee assign accessoriese-->
      <div class="table-qualification">
         <label>Assign Accessories Details</label>
         <table>
            <thead>
               <tr>
                  <th>Sr. No.</th>
                  <th>Keyboard</th>
                  <th>Mouse</th>
                  <th>Assign Accessories Date</th>
               </tr>
            </thead>
            <tbody>
               <?php if($get_employee_assign_accessories->isNotEmpty()): ?>
               <?php  $count = 1; ?>
               <?php $__currentLoopData = $get_employee_assign_accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><?php echo e($count++); ?>.</td>
                  <td><?php echo e($accessory->keyboard_assigned); ?></td>
                  <td><?php echo e($accessory->mouse_assigned); ?></td>
                  <td><?php echo e(Carbon::parse($accessory->created_at)->format('d M Y')); ?></td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php else: ?>
               <tr>
                  <td colspan="4">No accessories assigned to this employee.</td>
               </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
      <!--end employee assign accessoriese-->
      <!--start employee damage accessoriese-->
      <div class="table-qualification">
         <label>Damage Accessories Details</label>
         <table>
            <thead>
               <tr>
                  <th>Sr. No.</th>
                  <th>Keyboard</th>
                  <th>Mouse</th>
                  <th>Damage Accessories Date</th>
               </tr>
            </thead>
            <tbody>
               <?php if($get_employee_damage_accessories->isNotEmpty()): ?>
               <?php  $count = 1; ?>
               <?php $__currentLoopData = $get_employee_damage_accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $damage_accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><?php echo e($count++); ?>.</td>
                  <td><?php echo e($damage_accessory->keyboard_damaged); ?></td>
                  <td><?php echo e($damage_accessory->mouse_damaged); ?></td>
                  <td><?php echo e(Carbon::parse($damage_accessory->created_at)->format('d M Y')); ?></td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php else: ?>
               <tr>
                  <td colspan="4">No damaged accessories recorded for this employee.</td>
               </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
      <!--end employee damage accessoriese-->
   </div>
   <!--end all employees table-->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('employee.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pixxeluclients/public_html/php-dev/pixxelu-student-portal/resources/views/employee/dashboard.blade.php ENDPATH**/ ?>