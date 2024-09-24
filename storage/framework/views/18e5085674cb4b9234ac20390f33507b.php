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
   <h2>All Employees Trash Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-trash-back">
         <a href="<?php echo e(url('super-admin/all-employees-list')); ?>">
         <span class="login-arrow">
         <i class="fa fa-arrow-left" style="margin-right: 5px;" aria-hidden="true"></i>Back
         </span>
         </a>
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No.</th>
                  <th>Employee ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Employee Role</th>
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Salary</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php if($get_trash_employees_detail && $get_trash_employees_detail->isNotEmpty()): ?>
               <?php $count = 1; 
               ?>
               <?php $__currentLoopData = $get_trash_employees_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
               <tr>
                  <td><?php echo e($count++); ?>.</td>
                  <td><?php echo e($employee->id); ?></td>
                  <td data-th="Image">
                     <?php if($employee->user_pic): ?>
                        <div class="user-image"> <img src = "<?php echo e(url('public/uploads/employees/'. $employee->user_pic)); ?>" alt=""></div>
                     <?php endif; ?> 
                  </td>
                  <td><?php echo e($employee->name); ?></td>
                  <td><?php echo e($employee->email); ?> </td>
                  <td><?php echo e($employee->employee_role); ?> </td>
                  <td><a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $employee->employee_phone_no)); ?>" target="_blank"><?php echo e(substr($employee->employee_phone_no, 0, 5)); ?>-<?php echo e(substr($employee->employee_phone_no, 5)); ?></a></td>
                  <td><?php echo e(\Carbon\Carbon::parse($employee->joining_date)->format('d M Y')); ?></td>
                  <td><?php echo e($employee->net_salary); ?> </td>
                  <?php if($employee->user_status == 'Active'): ?> 
                        <td class="green-color"><span>Active</span></td>
                     <?php elseif($employee->user_status == 'Pending'): ?>
                        <td class="red-color"><span>Pending</span></td>
                     <?php elseif($employee->user_status == 'Suspend'): ?>
                        <td class="purple-color"><span>Suspend</span></td>
                     <?php elseif($employee->user_status == 'Leave'): ?>
                        <td class="red-color"><span>Leave</span></td>
                     <?php else: ?>
                        <td></td>
                  <?php endif; ?>
                  <td>
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <img src="<?php echo e(url('public/admin/images/ellips.svg')); ?>" alt="ellips" /> </button>
                        <ul class="dropdown-menu pay-fees-submit">
                           <form class="drop-don-list">
                              <!-- <li><a href="<?php echo e(url('super-admin/edit-employee', $employee->id)); ?>"><img src="<?php echo e(url('public/admin/images/ico-4.png')); ?>">Edit</a></li> -->
                              <li><button type="submit" class="is_delete_employee_record" data-employee_id="<?php echo e($employee->id); ?>"><img src="<?php echo e(url('public/admin/images/ico-5.png')); ?>">Delete</button></li>
                           </form>
                        </ul>
                     </div>
                  </td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
               <?php else: ?>
               <tr>
                  <td colspan="4">No Trash Employees are available.</td>
               </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/employees/all-employees-trash-list.blade.php ENDPATH**/ ?>