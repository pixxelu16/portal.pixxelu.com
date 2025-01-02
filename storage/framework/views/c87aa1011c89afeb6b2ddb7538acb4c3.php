<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="TemplateMo">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
         integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
      <title>Admin Login</title>
      <!--additional cSS files-->
      <link rel="stylesheet" href="<?php echo e(url('public/admin/css/style.css')); ?>">
   </head>
   <style>
      .position-relative {
      position: relative;
      }
      .position-absolute {
      position: absolute;
      margin: 20px 0px 0px;
      }
      .toggle-password {
      cursor: pointer;
      font-size: 12px; 
      }
      #password {
      padding-right: 40px; 
      }
   </style>
   <body>
      <div class="login-page">
         <div class="container">
            <div class="main-tech">
               <div class="tech-logo">
                  <div class="logo">
                     <img src="<?php echo e(url('public/admin/images/logo-login.png')); ?>" alt="login-logo">
                  </div>
               </div>
               <div class="tech-login">
                  <div class="login">
                     <form class="login-container" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="email">
                           <label>Email</label>
                           <div class="col-md-6">
                              <p><img src="<?php echo e(url('public/admin/images/mail.svg')); ?>" alt="mail">
                                 <input id="login" type="text" class="form-control <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="login" value="<?php echo e(old('login')); ?>" required autocomplete="login" autofocus placeholder="Enter Email">
                              </p>
                              <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                              <span class="invalid-feedback" role="alert">
                              <strong><?php echo e($message); ?></strong>
                              </span>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>
                        </div>
                        <div class="pass position-relative">
                           <label>Password</label>
                           <div class="col-md-6">
                              <p class="lock">
                                 <img src="<?php echo e(url('public/admin/images/lock.svg')); ?>" alt="lock">
                                 <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password" style="padding-right: 40px;" placeholder="Enter Password">
                              </p>
                              <!--eye icon for toggling password visibility-->
                              <span class="toggle-password position-absolute" onclick="togglePasswordVisibility()" style="right: 10px; top: 18px;">
                              <i id="toggleIcon" class="fas fa-eye-slash" aria-hidden="true"></i>
                              </span>
                              <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                              <span class="invalid-feedback" role="alert">
                              <strong><?php echo e($message); ?></strong>
                              </span>
                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>
                        </div>
                        <div class="sign-up">
                           <button type="submit" class="btn btn-primary login-submit">Sign In
                           <span class="login-arrow"> <i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script>
         function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");
            if (passwordInput.type === "password") {
               passwordInput.type = "text";
               toggleIcon.classList.remove("fa-eye");
               toggleIcon.classList.add("fa-eye-slash");
            } else {
               passwordInput.type = "password";
               toggleIcon.classList.remove("fa-eye-slash");
               toggleIcon.classList.add("fa-eye");
            }
         }
      </script>
   </body>
</html><?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/auth/login.blade.php ENDPATH**/ ?>