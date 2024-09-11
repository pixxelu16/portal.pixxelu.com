@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Add New Inquery</h2>
</div>
<div class="main-table">
   @if (Session::has('success')) 
   <div class="notification-green">
      <p>{{ Session::get('success') }}</p>
   </div>
   @endif 
   @if (Session::has('unsuccess')) 
   <div class="notification-red">
      <p>{{ Session::get('unsuccess') }}</p>
   </div>
   @endif 
   <div class="login-form">
      <form action="{{ route('super.admin.submit.inquery') }}" Method="POST">
         @csrf 
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="name">Name</label>
               <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
            </div>
            <div class="form-design mail">
               <label for="mobile">Mobile</label>
               <input type="mobile" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="Enter mobile" required>
            </div>
         </div>
         <div class="form-group display-column">
         <div class="form-design dob">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="{{ old('address') }}"  placeholder="Enter Address">
            </div>
            <div class="form-design mail">
               <label for="course_type">Course</label>
               <select class="form-control" name="course_type" id="Course Type" required>
                  <option value ="" disabled selected>Select Course Type</option>
                  <option value="Web Designing">Web Designing</option>
                  <option value="Web Development">Web Development</option>
                  <option value="Php Development">PHP Development</option> 
                  <option value="Digital Marketing">Digital Marketing</option>
                  <option value="Graphic">Graphic</option>
                  <option value="Full Stack Development">Full Stack Development</option>
               </select>
            </div>
            <!-- <div class="form-design fees">
               <label for="status">Status</label>
               <select class="form-control" name="status" id="User Status">
                  <option value ="" disabled selected>Select Status Type</option>
                  <option value="Active">Active</option>
               </select>
            </div> -->
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Submit">
            </div>
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