 
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
   <h2>All Inqueries Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!-- Filter by Inquiry Status -->
         <select name="inquery_status" id="search_inquery_status_list" class="search-student-list">
            <option value="" disabled selected>Select Inquiry Status</option>
            <option value="Active">Active</option>
            <option value="Office_Visited">Office Visited</option>
            <option value="Closed">Closed</option>
            <option value="Converted">Converted</option>
         </select>
         <!-- Filter by Course Type -->
         <select name="course_type" id="search_inquery_course_type_list" class="search-student-list">
            <option value="" disabled selected>Select Course Type</option>
            <option value="PHP Development">PHP Development</option>
            <option value="Web Development">Web Development</option>
            <option value="Digital Marketing">Digital Marketing</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Graphic Designing">Graphic Designing</option>
            <option value="Full Stack Development">Full Stack Development</option>
         </select>
         <a href="<?php echo e(url('admin/export-inqueries')); ?>" class="export"><img src="<?php echo e(url('public/admin/images/csv-file.svg')); ?>"></a>
         <a href="<?php echo e(url('admin/all-converted-inqueries-list')); ?>">All Converted Inqueries</a>
         <a href="<?php echo e(url('admin/add-new-inquery')); ?>"><img src="<?php echo e(url('public/admin/images/pluse.svg')); ?>">Add New Inquery</a>
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Address</th>
                  <th>Course Type</th>
                  <th>Inqury Date</th>
                  <th>Priority</th>
                  <th>Total Fees</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $count = 1; 
               ?>
               <?php $__currentLoopData = $all_inqueries_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
               <tr>
                  <td><?php echo e($count++); ?></td>
                  <td><?php echo e($list->name); ?> </td>
                  <td><a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $list->mobile)); ?>" target="_blank"><?php echo e(substr($list->mobile, 0, 5) . '-' . substr($list->mobile, 5)); ?></a></td>
                  <td><?php echo e($list->address ??'-'); ?></td>
                  <?php if($list->course_type == 'Full Stack Development'): ?> 
                  <td class="lights-blue-color"><span>Full Stack Development</span></td>
                  <?php elseif($list->course_type == 'PHP Development'): ?>
                  <td class="lights-green-color"><span>PHP Development</span></td>
                  <?php elseif($list->course_type == 'Web Development'): ?>
                  <td class="light-yellow-color"><span>Web Development</span></td>
                  <?php elseif($list->course_type == 'Digital Marketing'): ?>
                  <td class="light-organge-color"><span>Digital Marketing</span></td>
                  <?php elseif($list->course_type == 'Web Designing'): ?>
                  <td class="light-pink-color"><span>Web Designing</span></td>
                  <?php elseif($list->course_type == 'Graphic Designing'): ?>
                  <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  <?php else: ?>
                  <td></td>
                  <?php endif; ?>
                  <td><?php echo e(\Carbon\Carbon::parse($list->created_at)->format('d M Y')); ?></td>
                  <?php if($list->priority == 'hot'): ?> 
                  <td class="priority-hot"><span>Hot</span></td>
                  <?php elseif($list->priority == 'cold'): ?>
                  <td class="priority-cold"><span>Cold</span></td>
                  <?php elseif($list->priority == 'warm'): ?>
                  <td class="priority-warm"><span>Warm</span></td>
                  <?php else: ?>
                  <td>-</td>
                  <?php endif; ?>
                  <td><?php echo e($list->total_fees); ?> </td>
                  <?php if($list->status == 'Active'): ?> 
                  <td class="green-color"><span>Active</span></td>
                  <?php elseif($list->status == 'Office_Visited'): ?> 
                  <td class="pink-color"><span>Office Visited</span></td>
                  <?php elseif($list->status == 'Closed'): ?>
                  <td class="red-color"><span>Closed</span></td>
                  <?php elseif($list->status == 'Converted'): ?>
                  <td class="purple-color"><span>Converted</span></td>
                  <?php else: ?>
                  <td></td>
                  <?php endif; ?>
                  <td>
                     <a class="btn btn-info btn-sm" href="<?php echo e(url('admin/edit-inquery', $list->id)); ?>">
                     <img src="<?php echo e(url('public/admin/images/ico-4.png')); ?>">
                     </a>
                     <!-- <a class="btn btn-danger btn-sm" href="<?php echo e(url('admin/delete-inquery', $list->id)); ?>">
                        <i class="fas fa-trash-alt"></i> Delete
                        </a> -->
                  </td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/inquery/all-inqueries-list.blade.php ENDPATH**/ ?>