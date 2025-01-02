<?php $__env->startSection('content'); ?>
<style>
   element {
   width: 229.883px;
   text-align: ;
   }
</style>
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
   <!--start four boxes studens fees-->
   <div class="boxes-wrapper">
      <div class="box">
         <h3>Total Fees</h3>
         <p>Rs <?php echo e(number_format($all_students_total_fees)); ?></p>
      </div>
      <div class="box">
         <h3><span style="color: green;">Paid Fees</span></h3>
         <p>Rs <?php echo e(number_format($all_students_paid_fees)); ?></p>
      </div>
      <div class="box">
         <h3><span style="color: red;">Pending Fees</span></h3>
         <!--calculate pending fees-->
         <?php
         $all_students_pending_fees = $all_students_total_fees - $all_students_paid_fees;
         ?> 
         <p>Rs <?php echo e(number_format($all_students_pending_fees,  0, '.', ',')); ?></p>
      </div>
      <div class="box">
         <!--paid monthly fees-->
         <h3><span style="color: green;">Paid Fees This Month</span></h3>
         <p>Rs <?php echo e(number_format($current_month_paid_fees,  0, '.', ',')); ?></p>
         <div class="p-flex">
            <p><strong style="color: green;">Online:-</strong> Rs <?php echo e(number_format($payment_type_online,  0, '.', ',')); ?></p>
            <p><strong style="color: green;">Cash:-</strong> Rs <?php echo e(number_format($payment_type_cash,  0, '.', ',')); ?></p>
         </div>
      </div>
   </div>
   <!--end four boxes studens fees-->
   <!--start six boxes students information-->
   <div class="boxes-wrapperers">
      <div class="box">
         <h3>Total Students</h3>
         <p><?php echo e($is_total_students); ?></p>
      </div>
      <div class="box">
         <h3>Web Designing</h3>
         <p><?php echo e($is_web_designing_students); ?></p>
      </div>
      <div class="box">
         <h3>Web Development</h3>
         <p><?php echo e($is_web_development_students); ?></p>
      </div>
      <div class="box">
         <h3>Php Development</h3>
         <p><?php echo e($is_php); ?></p>
      </div>
      <div class="box">
         <h3>Full Stack Development</h3>
         <p><?php echo e($is_full_stack_development); ?></p>
      </div>
      <div class="box">
         <h3>Digital Marketing</h3>
         <p><?php echo e($digital_marketing); ?></p>
      </div>
      <div class="box">
         <h3>Graphic</h3>
         <p><?php echo e($is_graphic); ?></p>
      </div>
   </div>
   <!--end six boxes students information-->
   <div class="chart-design">
      <figure class=".highcharts-figure">
         <div id="students_monthly_fees_detail"></div>
         <!--<button id="plain">Plain</button>
            <button id="inverted">Inverted</button>
            <button id="polar">Polar</button>-->
      </figure>
      <figure class=".highcharts-figure">
         <div id="total_students_detail"></div>
   </div>
   </figure>
   <?php
      use Carbon\Carbon as MyCarbon;
      ?>
</div>
<div class="student-header">
   <h6>All Students Monthly Fees List:- <?php echo MyCarbon::now()->format('F Y'); ?></h6>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!--stokes list-->
         <a href="<?php echo e(url('admin/all-stocks-list')); ?>" class="export">Stock List</a>
         <!--end stokes list-->
         <!--export students monthly paid fees list -->
         <a href="<?php echo e(route('admin.export.paid.fees')); ?>" class="export">
         <img src="<?php echo e(url('public/admin/images/csv-file.svg')); ?>">Paid
         </a>
         <!--export students monthly pending fees list -->
         <a href="<?php echo e(route('admin.export.pending.fees')); ?>" class="export">
         <img src="<?php echo e(url('public/admin/images/csv-file.svg')); ?>">Pending  
         </a>
      </div>
   </div>
   <!--start students monthly table-->
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr class="sticky">
                  <th>S. No</th>
                  <th>Registration ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Course</th>
                  <th>Fees Paid this Month</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $count = 1;
               use Carbon\Carbon;
               ?>
               <?php $__currentLoopData = $get_student_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
               <tr>
                  <td><?php echo e($count++); ?></td>
                  <td><?php echo e($student->id); ?> </td>
                  <td data-th="Image">
                     <div class="user-image">
                        <?php if($student->user_pic): ?>
                        <img src="<?php echo e(url('public/uploads/users/' . $student->user_pic)); ?>" alt="User Image">
                        <?php else: ?>
                        <img src="<?php echo e(url('public/uploads/users/default_user.png')); ?>" alt="Default User Image">
                        <?php endif; ?>
                     </div>
                  </td>
                  <td>
                     <span onclick="openNav()"><a href="#" class="student-link" data-student_id="<?php echo e($student->id); ?>"><?php echo e($student->name); ?></a></span>
                  </td>
                  <td>
                     <?php if($student->student_phone_no): ?>
                     <a href="https://wa.me/<?php echo e(str_replace(['+', '-', ' '], '', $student->student_phone_no)); ?>" target="_blank">
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
                  <?php elseif($student->course_type == 'Digital Marketing'): ?>
                  <td class="light-organge-color"><span>Digital Marketing</span></td>
                  <?php elseif($student->course_type == 'Graphic Designing'): ?>
                  <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  <?php else: ?>
                  <td>-</td>             
                  <?php endif; ?>
                  <td style="text-align:left;">
                  <?php
                     $total_fees = 0;
                  ?>  

                  <?php $__currentLoopData = $student->student_fees_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php
                           $total_fees += $fees_detail->user_fees;
                     ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <!-- Display total fees after the loop -->
                  Rs <?php echo e(number_format($total_fees)); ?> <br>
                  <!-- Display submission date, if it exists -->
                    <?php echo e(\Carbon\Carbon::parse($student->student_fees_detail->first()->submission_date)->format('d M Y')); ?>

               </td>
               </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>
   <!--end students monthly table-->
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
<!--start students monthly fees chart-->
<script>
   var currentYear = new Date().getFullYear();
   document.addEventListener('DOMContentLoaded', function () {
      const chartOptions = {
         chart: {
            renderTo: 'students_monthly_fees_detail'
         },
         title: {
            text: 'Students Monthly Fees Detail, ' + currentYear,
            align: 'center'
         },
         credits: {
            enabled: false 
         },
         colors: [
            '#4caefe', '#3fbdf3', '#35c3e8', '#2bc9dc', '#20cfe1',
            '#16d4e6', '#0dd9db', '#03dfd0', '#00e4c5', '#00e9ba',
            '#00eeaf', '#23e274'
         ],
         xAxis: {
            categories: [
                  'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                  'October', 'November', 'December'
            ]
         },
         series: [{
            type: 'column',
            name: 'This Month Total Students Fees Rs',
            borderRadius: 5,
            colorByPoint: true,
            data: [
               <?php echo e($jan_month_fees_detail); ?>, 
               <?php echo e($feb_month_fees_detail); ?>, 
               <?php echo e($march_month_fees_detail); ?>, 
               <?php echo e($april_month_fees_detail); ?>, 
               <?php echo e($may_month_fees_detail); ?>, 
               <?php echo e($june_month_fees_detail); ?>, 
               <?php echo e($july_month_fees_detail); ?>, 
               <?php echo e($august_month_fees_detail); ?>,
               <?php echo e($sept_month_fees_detail); ?>, 
               <?php echo e($oct_month_fees_detail); ?>, 
               <?php echo e($nov_month_fees_detail); ?>, 
               <?php echo e($dec_month_fees_detail); ?>

            ],
            showInLegend: false
         }]
      };
       
      var chart = new Highcharts.Chart(chartOptions);
   });
</script>
<!--end students monthly fees chart-->

<!--start total students chart-->
<script>
   document.addEventListener('DOMContentLoaded', function () {
       Highcharts.chart('total_students_detail', {
           chart: {
               type: 'spline'
           },
           title: {
               text: 'Students Enrollments per Month - 2023, 2024 & 2025'
           },
           xAxis: {
               categories: [
                   'January', 'February', 'March', 'April', 'May', 'June',
                   'July', 'August', 'September', 'October', 'November', 'December'
               ], 
               accessibility: {
                   description: 'Months of the year'
               }
           },
           yAxis: {
               title: {
                   text: 'Number of Students'
               },
               labels: {
                   format: '{value}'
               }
           },
           tooltip: {
               crosshairs: true,
               shared: true,
               valueSuffix: ' students'
           },
           plotOptions: {
               spline: {
                   marker: {
                       radius: 4,
                       lineColor: '#666666',
                       lineWidth: 1
                   }
               }
           },
           credits: {
               enabled: false  
           },
           //start students enrollments 2025//
           series: [{
               name: 'Enrollments 2025',
               marker: {
                   symbol: 'circle',
                   fillColor: 'green',  
                   lineColor: 'green',  
                   lineWidth: 2         
               },
               data: [
                  <?php echo e($jan_month_student_detail_2025); ?>,
                  <?php echo e($feb_month_student_detail_2025); ?>,
                  <?php echo e($march_month_student_detail_2025); ?>,
                  <?php echo e($april_month_student_detail_2025); ?>,
                  <?php echo e($may_month_student_detail_2025); ?>,
                  <?php echo e($june_month_student_detail_2025); ?>,
                  <?php echo e($july_month_student_detail_2025); ?>,
                  <?php echo e($august_month_student_detail_2025); ?>,
                  <?php echo e($sep_month_student_detail_2025); ?>,
                  <?php echo e($oct_month_student_detail_2025); ?>,
                  <?php echo e($nov_month_student_detail_2025); ?>,
                  <?php echo e($dec_month_student_detail_2025); ?>

               ]
            }, 
            //end students enrollments 2025//
            //start students enrollments 2024//
            {
               name: 'Enrollments 2024',
               marker: {
                   symbol: 'square',
                   fillColor: 'blue',  
                   lineColor: 'blue',  
                   lineWidth: 2
               },
               data: [
                   <?php echo e($jan_month_student_detail_2024); ?>,
                   <?php echo e($feb_month_student_detail_2024); ?>,
                   <?php echo e($march_month_student_detail_2024); ?>,
                   <?php echo e($april_month_student_detail_2024); ?>,
                   <?php echo e($may_month_student_detail_2024); ?>,
                   <?php echo e($june_month_student_detail_2024); ?>,
                   <?php echo e($july_month_student_detail_2024); ?>,
                   <?php echo e($august_month_student_detail_2024); ?>,
                   <?php echo e($sep_month_student_detail_2024); ?>,
                   <?php echo e($oct_month_student_detail_2024); ?>,
                   <?php echo e($nov_month_student_detail_2024); ?>,
                   <?php echo e($dec_month_student_detail_2024); ?>

               ]
            }, 
            //end students enrollments 2024//
            //start students enrollments 2023//
            {
               name: 'Enrollments 2023',
               marker: {
                   symbol: 'circle',
                   fillColor: 'purple',  
                   lineColor: 'purple',  
                   lineWidth: 2
               },
               data: [
                  <?php echo e($jan_month_student_detail_2023); ?>,
                  <?php echo e($feb_month_student_detail_2023); ?>,
                  <?php echo e($march_month_student_detail_2023); ?>,
                  <?php echo e($april_month_student_detail_2023); ?>,
                  <?php echo e($may_month_student_detail_2023); ?>,
                  <?php echo e($june_month_student_detail_2023); ?>,
                  <?php echo e($july_month_student_detail_2023); ?>,
                  <?php echo e($august_month_student_detail_2023); ?>,
                  <?php echo e($sep_month_student_detail_2023); ?>,
                  <?php echo e($oct_month_student_detail_2023); ?>,
                  <?php echo e($nov_month_student_detail_2023); ?>,
                  <?php echo e($dec_month_student_detail_2023); ?>

               ]
            }, 
            //end students enrollments 2023//
            //start total students 2025//
            {
               name: 'Total Students 2025',
               marker: {
                   symbol: 'diamond',
                   fillColor: 'green',  
                   lineColor: 'green',  
                   lineWidth: 2         
               },
               data: [
                  <?php echo e($jan_month_student_detail_2025); ?>,
                  <?php echo e($feb_month_student_detail_2025); ?>,
                  <?php echo e($march_month_student_detail_2025); ?>,
                  <?php echo e($april_month_student_detail_2025); ?>,
                  <?php echo e($may_month_student_detail_2025); ?>,
                  <?php echo e($june_month_student_detail_2025); ?>,
                  <?php echo e($july_month_student_detail_2025); ?>,
                  <?php echo e($august_month_student_detail_2025); ?>,
                  <?php echo e($sep_month_student_detail_2025); ?>,
                  <?php echo e($oct_month_student_detail_2025); ?>,
                  <?php echo e($nov_month_student_detail_2025); ?>,
                  <?php echo e($dec_month_student_detail_2025); ?>

               ]
            },
            //end total students 2025//
            //start total students 2024//
            {
               name: 'Total Students 2024',
               marker: {
                   symbol: 'diamond',
                   fillColor: 'blue',  
                   lineColor: 'blue',  
                   lineWidth: 2         
               },
               data: [
                  <?php echo e($jan_month_student_detail_2024); ?>,
                  <?php echo e($feb_month_student_detail_2024); ?>,
                  <?php echo e($march_month_student_detail_2024); ?>,
                  <?php echo e($april_month_student_detail_2024); ?>,
                  <?php echo e($may_month_student_detail_2024); ?>,
                  <?php echo e($june_month_student_detail_2024); ?>,
                  <?php echo e($july_month_student_detail_2024); ?>,
                  <?php echo e($august_month_student_detail_2024); ?>,
                  <?php echo e($sep_month_student_detail_2024); ?>,
                  <?php echo e($oct_month_student_detail_2024); ?>,
                  <?php echo e($nov_month_student_detail_2024); ?>,
                  <?php echo e($dec_month_student_detail_2024); ?>

               ]
            }, 
            //end total students 2024//
            //start total students 2023//
            {
               name: 'Total Students 2023',
               marker: {
                   symbol: 'diamond',
                   fillColor: 'purple',  
                   lineColor: 'purple',  
                   lineWidth: 2         
               },
               data: [
                  <?php echo e($jan_month_student_detail_2023); ?>,
                  <?php echo e($feb_month_student_detail_2023); ?>,
                  <?php echo e($march_month_student_detail_2023); ?>,
                  <?php echo e($april_month_student_detail_2023); ?>,
                  <?php echo e($may_month_student_detail_2023); ?>,
                  <?php echo e($june_month_student_detail_2023); ?>,
                  <?php echo e($july_month_student_detail_2023); ?>,
                  <?php echo e($august_month_student_detail_2023); ?>,
                  <?php echo e($sep_month_student_detail_2023); ?>,
                  <?php echo e($oct_month_student_detail_2023); ?>,
                  <?php echo e($nov_month_student_detail_2023); ?>,
                  <?php echo e($dec_month_student_detail_2023); ?>

               ]
            }]
            //end total students 2023//
       });
   });
</script>
<!--end total students chart-->

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>