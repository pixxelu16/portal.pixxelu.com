<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
   <head>
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!----======== CSS ======== -->
      <link rel="stylesheet" href="<?php echo e(url('public/admin/css/style.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(url('public/admin/css/styles.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(url('public/admin/css/dark-mode.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(url('public/admin/css/mobile.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(url('public/admin/css/bootstrap.min.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(url('public/admin/css/table-custom.css')); ?>">
      <!-- SweetAlert2 CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
      <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
      <!----===== Iconscout CSS ===== -->
      <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
         integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!-- jQuery CDN -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
      <!-- SweetAlert2 JS -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
      <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">-->
      <!-- Charts scripts -->
      <script src="https://code.highcharts.com/highcharts.js"></script>
      <!-- End Charts scripts -->
      <title>Admin Dashboard</title>
   </head>
   <body>
      <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <section class="dashboard">
         <?php echo $__env->make('admin.layouts.top-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php echo $__env->yieldContent('content'); ?>
         <div class="footer-code">
            <div class="copyright-code">
               <span>© 2014-2024 Pixxelu. All rights reserved</span>
            </div>
         </div>
      </section>
      <script>
         var base_url = '<?php echo e(url("/")); ?>'; 
      </script>  
      <script src="<?php echo e(url('public/admin/js/custom-ajax.js')); ?>"></script>
      <script src="<?php echo e(url('public/admin/js/script.js')); ?>"></script>
      <script src="<?php echo e(url('public/admin/js/custom-script.js')); ?>"></script>
      <script src="<?php echo e(url('public/admin/js/bootstrap.min.js')); ?>"></script>
      <script src="<?php echo e(url('public/admin/js/bootstrap.bundle.min.js')); ?>"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
      <script src="https://use.fontawesome.com/774c27057f.js"></script>
      <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->
      <!-- DataTables JS CDN -->
      <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
      <script>
      $(document).ready(function() {
         $('#example1').DataTable({
               aLengthMenu: [
                  [20, 50, 100, 200, -1],
                  [20, 50, 100, 200, "All"]
               ],
               iDisplayLength: 20
         });
      });
   </script>
      <script>
         // Get all the <li> elements
         const navLinks = document.querySelectorAll('.nav-links li');
         
         // Add click event listener to each <li>
         navLinks.forEach(link => {
             link.addEventListener('click', function () {
                 // Remove 'active' class from all <li>
                 navLinks.forEach(nav => nav.classList.remove('active'));
         
                 // Add 'active' class to the clicked <li>
                 this.classList.add('active');
             });
         });
      </script>
   </body>
</html><?php /**PATH D:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/layouts/master.blade.php ENDPATH**/ ?>