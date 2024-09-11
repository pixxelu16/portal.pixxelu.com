
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
   <h2>All Stocks Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <a href="<?php echo e(url('admin/add-new-stock')); ?>"><img src="<?php echo e(url('public/admin/images/pluse.svg')); ?>">Add New Stock</a>
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No.</th>
                  <th>Keyboard Stock</th>
                  <th>Assigned Keyboard</th>
                  <th>Remaining Keyboard</th>
                  <th>Damage Keyboard</th>
                  <th>Mouse Stock</th>
                  <th>Assigned Mouse</th>
                  <th>Remaining Mouse</th>
                  <th>Damage Mouse</th>
               </tr>
            </thead>
            <tbody>
               <?php if($all_stocks_list && $all_stocks_list->isNotEmpty()): ?>
               <?php $count = 1; 
               ?>
               <?php $__currentLoopData = $all_stocks_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
               <tr>
                  <td><?php echo e($count++); ?>.</td>
                  <td><?php echo e($list->total_keyboard_stock); ?></td>
                  <td><?php echo e($list->assign_keyboard); ?></td>
                  <td><?php echo e($list->total_keyboard_stock - $list->assign_keyboard); ?></td>
                  <td><?php echo e($total_keyboard_damaged ?? 0); ?></td>
                  <td><?php echo e($list->total_mouse_stock); ?></td>
                  <td><?php echo e($list->assign_mouse); ?></td>
                  <td><?php echo e($list->total_mouse_stock - $list->assign_mouse); ?></td>
                  <td><?php echo e($total_mouse_damaged ?? 0); ?></td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
               <?php else: ?>
               <tr>
                  <td colspan="4">No Stocks are available.</td>
               </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pixxeluclients/public_html/php-dev/pixxelu-student-portal/resources/views/admin/stocks/all-stocks-list.blade.php ENDPATH**/ ?>