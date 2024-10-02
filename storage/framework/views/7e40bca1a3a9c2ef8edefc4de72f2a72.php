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
   <h2>All Employees Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!--start filter employees acc to role-->
         <select name="employee_role" id="employee_role" class="search-student-list">
            <option value ="" disabled selected>Select Employee Role</option>
            <option value="Project Bidder">Project Bidder</option>
            <option value="Php Development">Php Development</option>
            <option value="Web Development">Web Development</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Graphic Designing">Graphic Designing</option>
            <option value="SEO">SEO</option>
         </select>
          <!--end filter employees acc to role-->
         <!-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i class="fa-solid fa-plus"></i>Add Increment</a> -->
         <a href="<?php echo e(url('super-admin/add-new-employee')); ?>"><img src="<?php echo e(url('public/admin/images/pluse.svg')); ?>">Add New Employee</a>
         <a href="<?php echo e(url('super-admin/all-employees-trash-list')); ?>" class="export"><img src="<?php echo e(url('public/admin/images/trash.svg')); ?>"></a>
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
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Employee Role</th>
                  <th>Total Salary</th>
                  <th>Salary Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>

               <?php if($get_employees_detail && $get_employees_detail->isNotEmpty()): ?>
               <?php $count = 1; 
               ?>

               <?php $__currentLoopData = $get_employees_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
               <?php
                  //Get current month
                  $startMonth = \Carbon\Carbon::now()->startOfMonth();
                  $endMonth = \Carbon\Carbon::now()->endOfMonth();

                  // Get all salary records for the current month
                  $currentMonthRecords = $employee->emloyees_salary__detail->filter(function($record) use ($startMonth, $endMonth) {
                     $salarySubmissionDate = \Carbon\Carbon::parse($record->submission_date);
                     return $salarySubmissionDate->between($startMonth, $endMonth);
                  });

                  //Check if salary exists for the current month or not
                  $paidStatus = $currentMonthRecords->isNotEmpty();
                  $status = $paidStatus ? 'Paid' : 'Pending';
               ?>             
               <tr>
                  <td><?php echo e($count++); ?>.</td>
                  <td><?php echo e($employee->unique_employee_id); ?></td>
                  <td data-th="Image">
                     <?php if($employee->user_pic): ?>
                     <div class="user-image"> <img src = "<?php echo e(url('public/uploads/employees/'. $employee->user_pic)); ?>" alt=""></div>
                     <?php endif; ?> 
                  </td>
                  <td>
                     <span onclick="openNav()"><a href="#" class="employee_detail" data-employee_id="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?></a></span>
                  </td>
                  <!-- <td>
                     <div class="box-pay">
                        <button type="button" class="employee-attandace-buton employee_attandance" data-employee_id="<?php echo e($employee->id); ?>" data-employee_name="<?php echo e($employee->name); ?>" data-toggle="modal" data-target="#exampleModalLong">
                        Add Attendance
                     </div>
                  </td> -->
                  <?php if($employee->employee_phone_no): ?>
                  <td><a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $employee->employee_phone_no)); ?>" target="_blank"><?php echo e(substr($employee->employee_phone_no, 0, 5)); ?>-<?php echo e(substr($employee->employee_phone_no, 5)); ?></a></td>
                  <?php else: ?>
                  <td>-</td>
                  <?php endif; ?>
                  <?php if($employee->joining_date): ?>
                     <td><?php echo e(\Carbon\Carbon::parse($employee->joining_date)->format('d M Y')); ?></td>
                  <?php else: ?>
                     <td>-</td>
                  <?php endif; ?>
                  <?php if($employee->employee_role == 'Project Bidder'): ?> 
                        <td class="light-blue-color"><span>Project Bidder</span></td>
                     <?php elseif($employee->employee_role == 'Php Development'): ?>
                        <td class="light-green-color"><span>PHP Development</span></td>
                     <?php elseif($employee->employee_role == 'Web Development'): ?>
                        <td class="light-yellow-color"><span>Web Development</span></td>
                     <?php elseif($employee->employee_role == 'Web Designing'): ?>
                        <td class="light-pink-color"><span>Web Designing</span></td>
                     <?php elseif($employee->employee_role == 'Graphic Designing'): ?>
                        <td class="light-cyan-color"><span>Graphic Designing</span></td>
                     <?php elseif($employee->employee_role == 'SEO'): ?>
                        <td class="light-orange-color"><span>SEO</span></td>
                     <?php else: ?>
                        <td></td>
                  <?php endif; ?> 
                  <?php if($employee->net_salary): ?>  
                  <td>
                  Rs <?php echo e(number_format((int) base64_decode($employee->net_salary))); ?>

                     <div class="box-pay">
                        <button type="button" class="pay-fes-buton employee_pay_salary" data-employee_id="<?php echo e($employee->id); ?>" data-employee_name="<?php echo e($employee->name); ?>" data-employee_amount="<?php echo e(base64_decode($employee->net_salary)); ?>"
                        data-toggle="modal" data-target="#myModal">Pay Salary</button>
                     </div>
                     <?php else: ?>
                  <td>-</td>
                  <?php endif; ?>
                  </td>
                  <!-- <td>
                     <?php if(isset($employee->emloyees_salary__detail)): ?>
                     <?php
                     $last_record = $employee->emloyees_salary__detail->last();
                     ?>
                     <?php if($last_record): ?>
                     Rs <?php echo e(number_format((int) base64_decode($last_record->employee_salary))); ?><br>
                     <span class="date-tbl"><?php echo e(\Carbon\Carbon::parse($last_record->submission_date)->format('d M Y')); ?></span>
                     <?php else: ?>
                     0<br>
                     <?php endif; ?>
                     <?php endif; ?>
                  </td> -->
                     <!-- Show Paid or Pending Status -->
                     <td class="<?php echo e($paidStatus ? 'green-color' : 'red-color'); ?>">
                     <span><?php echo e($status); ?></span>
                  </td>
                  <td>
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <img src="<?php echo e(url('public/admin/images/ellips.svg')); ?>" alt="ellips" /> </button>
                        <ul class="dropdown-menu pay-fees-submit">
                           <form class="drop-don-list">
                              <li button type="button" class="employee_increment_salary" data-employee_id="<?php echo e($employee->id); ?>" data-employee_name="<?php echo e($employee->name); ?>" data-toggle="modal" data-target="#add_salary"><img src="<?php echo e(url('public/admin/images/ico-1.png')); ?>">Add Increment</button></li>
                              <li><a href="<?php echo e(url('super-admin/edit-employee', $employee->id)); ?>"><img src="<?php echo e(url('public/admin/images/ico-4.png')); ?>">Edit</a></li>
                              <li class="employee_trash_record" data-employee_id="<?php echo e($employee->id); ?>"><img src="<?php echo e(url('public/admin/images/ico-5.png')); ?>" alt="Trash Icon">Trash</li>
                           </form>
                        </ul>
                     </div>
                  </td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
               <?php else: ?>
               <tr>
                  <td colspan="4">No Employee are available.</td>
               </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
       <!--start employee attendance modal-->
       <div class="modal" id="exampleModalLong">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Add Attendance To  <span class="employee_attendances"></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form action="#" id="employee_attendance" method="POST">
                        <input type="hidden" id="models_employee_id" name="employee_id" value="" />
                        <div class="form-group">
                              <label for="attendanceStatus">Attendance Status <span class="text-danger">*</span></label>
                              <select class="form-control" name="attendance_status" id="attendanceStatus">
                                 <option value ="" disabled selected>Select Status</option>
                                 <option value="Present">Present</option>
                                 <option value="Absent">Absent</option>
                                 <option value="Leave">Leave</option>
                              </select>
                        </div>
                        <div class="form-group">
                              <label for="shift">Shift <span class="text-danger">*</span></label>
                              <select class="form-control" name="sift" id="shift">
                              <option value ="" disabled selected>Select Shift</option>
                                 <option value="Morning">Morning</option>
                                 <option value="Evening">Evening</option>
                                 <option value="Night">Night</option>
                              </select>
                        </div>
                        <div class="form-group">
                              <label for="shiftType">Shift Type <span class="text-danger">*</span></label>
                              <select class="form-control" name="sift_type" id="shiftType">
                              <option value ="" disabled selected>Select type</option>
                                 <option value="Full Day">Full Day</option>
                                 <option value="Half Day">Half Day</option>
                                 <option value="Quarter Day">Quarter Day</option>
                              </select>
                        </div>
                        <div class="form-group">
                              <label for="punchInTime">Punch In Time <span class="text-danger">*</span></label>
                              <input type="time" class="form-control" name="punch_in_time" id="punchInTime">
                        </div>
                        <div class="form-group">
                              <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                              <input type="time" class="form-control" name="punch_out_time" id="punchOutTime">
                        </div>
                        <div class="modal-footer">
                              <button type="submit" class="btn btn-primary is_create_employee_attendance">Submit</button>
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
      <!--end employee attendance modal-->
      <!--start employee salary model-->
      <div class="modal fade pay-modal" id="myModal" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Pay Salary To<span class="pay_employee_salary"></h4>
               </div>
               <div class="modal-body">
                  <form action="#" id="is_create_employee_salary" Method="POST">
                     <input id="model_employees_id" type="hidden" value="" name="employee_id">
                     <input type="text" id="employee_salary" name="employee_salary" placeholder="Amount"/>                     
                     <select name="payment_type" id="payment_type">
                        <option value="">Payment Type</option>
                        <option value="online">Online</option>
                        <option value="cash">Cash</option>
                     </select>
                     <div class="button-save"><button type="submit" class="disable-submit">Save</button></div>
                  </form>
                  <div class="loader com_ajax_loader" style="display:none;">
                     <img src="<?php echo e(url('public/admin/images/200w.gif')); ?>" /> 
                  </div>
               </div>
               <div class="employee_salary_responce"></div>
            </div>
         </div>
      </div>
      <!--end employee salary model-->
      <!--start employee salary increment model-->
      <div id="add_salary" class="modal custom-modal" role="dialog">
         <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Increment To<span class="add_increment_employee_salary"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form id="employee_salaries" Method="POST">
                     <div class="row">
                        <input id="employee_increment" type="hidden" value="" name="employee_id">
                        <div class="col-sm-6"> 
                           <label class="col-form-label">Increment Amount</label>
                           <input type="text" id="net_salary" name="increment_amount" class="form-control" placeholder="Increment Amount" required>
                        </div>
                     </div>
                     <div class="submit-section">
                        <button type="submit" class="submit-btn is_create_employee_increment_salary">Submit</button>
                     </div>
                  </form>
                  <div class="loader com_ajax_loader" style="display:none;">
                     <img src="<?php echo e(url('public/admin/images/200w.gif')); ?>" /> 
                  </div>
                  <div class="salary_responce"></div>
               </div>
            </div>
         </div>
      </div>
      <!--end employee salary increment model-->
      <!--start employee trash model-->
      <div class="modal" id="model_employee_id" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modals-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Trash Employee record</h4>
               </div>
               <div class="modal-body">
                  <form action="#" id="trash_employee_form" Method="POST">
                     <input id="trash_employee_id" type="hidden" value="" name="employee_id">                   
                     <p>Please select your employee status</p>
                     <input type="radio" id="Leave" name="employee_status" value="Leave">
                     <label for="leave">Due to some reason employee leave.</label><br>
                     <input type="radio" id="Suspend" name="employee_status" value="Suspend">
                     <label for="suspend">Due to some reason employee are suspend.</label><br>
                     <div class="button-saves"><button type="submit" class="disable-submit is_delete_employee_trash_record">Save</button></div>
                  </form>
                  <div class="loader com_ajax_loader" style="display:none;">
                     <img src="<?php echo e(url('public/admin/images/200w.gif')); ?>" /> 
                  </div>
               </div>
               <div class="trash_responce"></div>
            </div>
         </div>
      </div>
      <!--end employee trash model-->
   </div>
</div>
<div id="myNav" class="overlay hide">
   <div class="overlay-content">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loader com_ajax_loaders" style="display: none;">
         <img src="<?php echo e(url('public/admin/images/index.svg')); ?>" />
      </div>
      <div class="employee_detail_response"></div>
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
<script>
   document.addEventListener('DOMContentLoaded', function () {
      const netSalaryInput = document.getElementById('net_salary');
      netSalaryInput.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '');
      });
   });
   document.getElementById('employee_salary').addEventListener('input', function (e) {
   this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/employees/search-employees-list.blade.php ENDPATH**/ ?>