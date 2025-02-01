 
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
   <h2>All Clients Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <a href="<?php echo e(url('super-admin/add-new-client')); ?>"><img src="<?php echo e(url('public/admin/images/pluse.svg')); ?>">Add New Client</a>
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Mobile No</th>
                  <th>Description</th>
                  <th>Country</th>
                  <th>From</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $count = 1; ?>
               <?php $__currentLoopData = $all_clients_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
               <tr>
                  <td><?php echo e($count++); ?></td>
                  <td><?php echo e($client->client_name); ?> </td>
                  <td><a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $client->phone_no)); ?>" target="_blank"><?php echo e(substr($client->phone_no, 0, 5) . '-' . substr($client->phone_no, 5)); ?></a></td>
                  <td><?php echo e($client->desc ??'-'); ?></td>
                  <td><?php echo e($client->country ??'-'); ?></td>
                  <td><?php echo e($client->from ?? '-'); ?></td>
                  <?php if($client->client_status == 'Active'): ?> 
                        <td class="green-color"><span>Active</span></td>
                     <?php elseif($client->client_status == 'Pending'): ?>
                        <td class="red-color"><span>Pending</span></td>
                     <?php elseif($client->client_status == 'Converted'): ?>
                        <td class="purple-color"><span>Converted</span></td>
                     <?php elseif($client->client_status == 'Completed'): ?>
                        <td class="green-color"><span>Completed</span></td>
                     <?php elseif($client->client_status == 'Leave'): ?>
                        <td class="red-color"><span>Leave</span></td>
                     <?php else: ?>
                        <td></td>
                  <?php endif; ?>
                  <td>
                     <a class="btn btn-info btn-sm" href="<?php echo e(url('super-admin/edit-client', $client->id)); ?>"><img src="<?php echo e(url('public/admin/images/ico-4.png')); ?>"></a>
                     <!--<a class="btn btn-danger btn-sm" href="<?php echo e(url('admin/client-inquery', $client->id)); ?>"><i class="fas fa-trash-alt"></i> Delete</a> -->
                  </td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('super-admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/super-admin/clients/all-clients-list.blade.php ENDPATH**/ ?>