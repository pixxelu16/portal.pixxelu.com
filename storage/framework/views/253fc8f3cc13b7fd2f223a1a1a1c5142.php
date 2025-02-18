 
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
   <h2>All Contacts List</h2>
</div>
<div class="main-table">
    <div class="data-table-listing">
        <div class="btn-pixxelu">
            <a href="<?php echo e(url('admin/export-contacts')); ?>" class="export"><img src="<?php echo e(url('public/admin/images/csv-file.svg')); ?>"></a>
        </div>
    </div>
    <div class="scrolling-data-table">
        <div class="card-body">
            <table id="example1" class="rwd-table cloud-path">
                <thead>
                <tr  class="sticky">
                    <th>Sr.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Companye</th>
                    <th>Message</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 1; ?>
                <?php $__currentLoopData = $all_contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                    <tr>
                        <td><?php echo e($count++); ?></td>
                        <td><?php echo e($contact->name); ?> </td>
                        <td><?php echo e($contact->email ??'-'); ?></td>
                        <td><a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $contact->mobile)); ?>" target="_blank"><?php echo e(substr($contact->mobile, 0, 5) . '-' . substr($contact->mobile, 5)); ?></a></td>
                        <td><?php echo e($contact->company ??'-'); ?></td>
                        <td><?php echo e($contact->message ??'-'); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('d M Y')); ?></td>
                        <?php if($contact->status == 'Active'): ?> 
                            <td class="green-color"><span>Active</span></td>
                        <?php elseif($contact->status == 'Pending'): ?> 
                            <td class="pink-color"><span>Pending</span></td>
                        <?php elseif($contact->status == 'Suspend'): ?>
                            <td class="red-color"><span>Suspend</span></td>
                        <?php elseif($contact->status == 'Approved'): ?>
                            <td class="purple-color"><span>Approved</span></td>
                        <?php else: ?>
                            <td></td>
                        <?php endif; ?>
                        <td>
                            <a class="btn btn-danger btn-sm delete_contact_record" data-contact_id="<?php echo e($contact->id); ?>"><i class="fas fa-trash" aria-hidden="true"></i>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/contacts/all-contacts.blade.php ENDPATH**/ ?>