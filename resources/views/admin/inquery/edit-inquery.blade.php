@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Inquery detail</h2>
</div>
<div class="main-table">
   @if (Session::has('success'))
   <div class="notification-green">
      <p>{{ Session::get('success') }}</p>
   </div>
   <script>
      setTimeout(function() {
            window.location.href = "{{ url('admin/all-inqueries-list') }}";
      }, 2000); 
   </script>
   @endif 
   @if (Session::has('unsuccess'))
   <div class="notification-red">
      <p>{{ Session::get('unsuccess') }}</p>
   </div>
   @endif
   <div class="login-form">
      <form action="{{ route('admin.update.inquery', $inquery->id) }}" Method="POST">
         @csrf 
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="name">Name</label>
               <input type="text" id="name" name="name" value="{{$inquery->name}}" placeholder="Enter Name" required>
            </div>
            <div class="form-design mail">
               <label for="mobile">Mobile</label>
               <input type="mobile" id="mobile" name="mobile" value="{{$inquery->mobile}}" placeholder="Enter mobile">
            </div>
            <div class="form-design dob">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="{{$inquery->address}}"  placeholder="Enter Address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design mail">
               <label for="course_type">Course</label>
               <select class="form-control" name="course_type" id="Course Type">
                  <option value ="" disabled selected>Select Course Type</option>
                  <option value="Web Designing" @if($inquery->course_type == 'Web Designing') selected @endif>Web Designing</option>
                  <option value="Web Development"@if($inquery->course_type == 'Web Development') selected @endif>Web Development</option>
                  <option value="PHP Development" @if($inquery->course_type == 'PHP Development') selected @endif>PHP Development</option>
                  <option value="Digital Marketing" @if($inquery->course_type == 'Digital Marketing') selected @endif>Digital Marketing</option>
                  <option value="Graphic" @if($inquery->course_type == 'Graphic') selected @endif>Graphic</option>
                  <option value="Full Stack Development" @if($inquery->course_type == 'Full Stack Development') selected @endif>Full Stack Development</option>
               </select>
            </div> 
            <div class="form-design fees">
               <label for="status">Priority</label>
               <select class="form-control" name="priority" id="User Status">
                  <option value ="" disabled selected>Select Priority Type</option>
                  <option value="hot" @if($inquery->priority == 'hot') selected @endif>Hot</option>
                  <option value="cold" @if($inquery->priority == 'cold') selected @endif>Cold</option>
                  <option value="warm" @if($inquery->priority == 'warm') selected @endif>Warm</option>
               </select>
            </div>
            <div class="form-design fees">
               <label for="status">Status</label>
               <select class="form-control" name="status" id="User Status">
                  <option value ="" disabled selected>Select Status Type</option>
                  <option value="Active" @if($inquery->status == 'Active') selected @endif>Active</option>
                  <option value="Office_Visited" @if($inquery->status == 'Office_Visited') selected @endif>Office Visited</option>
                  <option value="Closed" @if($inquery->status == 'Closed') selected @endif>Closed</option>
                  <option value="Converted" @if($inquery->status == 'Converted') selected @endif>Converted</option>
                  <option value="Hot_Lead" @if($inquery->status == 'Hot_Lead') selected @endif>Hot Lead</option>
               </select>
            </div>
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Update">
            </div>
         </div>
      </form>
   </div>
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