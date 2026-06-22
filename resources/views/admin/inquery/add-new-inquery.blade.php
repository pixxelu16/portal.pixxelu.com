@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Add New Inquery</h2>
</div>
<div class="main-table">
   <div class="login-form">
      <form action="{{ route('admin.submit.inquery') }}" Method="POST">
         @csrf 
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="name">Name</label>
               <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
            </div>
            <div class="form-design phone-no">
               <label for="mobile">Mobile</label>
               <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="Enter mobile" required>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design address">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Enter Address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design course">
               <label for="course_type">Course</label>
               <select class="form-control" name="course_type" id="course_type" required>
                  <option value="" disabled selected>Select Course Type</option>
                  <option value="Web Designing">Web Designing</option>
                  <option value="Web Development">Web Development</option>
                  <option value="PHP Development">PHP Development</option>
                  <option value="Digital Marketing">Digital Marketing</option>
                  <option value="Graphic">Graphic</option>
                  <option value="Full Stack Development">Full Stack Development</option>
               </select>
            </div>
            <div class="form-design priority">
               <label for="priority">Priority</label>
               <select class="form-control" name="priority" id="priority" required>
                  <option value="" disabled selected>Select Priority Type</option>
                  <option value="hot">Hot</option>
                  <option value="coldt">Cold</option>
                  <option value="warm">Warm</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design visit">
               <label for="visit">Visit</label>
               <select class="form-control" name="visit" id="visit">
                  <option value="" disabled selected>Select Visit Type</option>
                  <option value="Google">Google</option>
                  <option value="Instagram">Instagram</option>
                  <option value="Facebook">Facebook</option>
                  <option value="Office-Visit">Office-Visit</option>
                  <option value="Website">Website</option>
                  <option value="YouTube">YouTube</option>
                  <option value="Email">Email</option>
                  <option value="WhatsApp">WhatsApp</option>
                  <option value="SMS">SMS</option>
                  <option value="Other">Other</option>
               </select>
            </div>
            <div class="form-design fees">
               <label for="total_fees">Total Fees</label>
               <input type="text" id="total_fees" name="total_fees" value="{{ old('total_fees') }}" placeholder="Enter Total Fees">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design status">
               <label for="status">Status</label>
               <input type="text" class="form-control email-disabled" value="Active" readonly>
               <input type="hidden" name="status" value="Active">
            </div>
         </div>         @include('admin.partials.form-footer-alerts')

         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Submit">
            </div>
         </div>
      </form>
   </div>
</div>
<script>
   const mobileInput = document.getElementById('mobile');
   mobileInput.addEventListener('input', function(event) {
      const inputValue = event.target.value;
      const numericValue = inputValue.replace(/\D/g, ''); 
      const truncatedValue = numericValue.slice(0, 10); 
      event.target.value = truncatedValue;
   });
</script>
@endsection
