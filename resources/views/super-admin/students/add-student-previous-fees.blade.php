@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Add Student Previous Fees</h2>
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
      <form action="{{ route('super.admin.student.submit.fees') }}" Method="POST" enctype="multipart/form-data">
         @csrf 
         <div class="form-design first-name">
            <label for="previous-students">Students Name</label>
            <select id="previous-students" name="previous_student_id">
               <option value ="" disabled selected>Select student previous fees</option>
               @foreach($get_student_details as $student)
               <option value="{{ $student->id }}">{{$student->id }}. {{ $student->name }} ({{ $student->course_type }})</option>
               @endforeach
            </select>
         </div>
         <div class="form-design last-name">
            <label for="last-name">Date Fees</label>
            <input type="date" id="date" name="submission_date" value="{{ old('submission_date') }}" placeholder="Enter Date Fees">
         </div>
         <div class="form-design mail">
            <label for="amount">Fees Amount</label>
            <input type="text" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Enter Fees Amount">
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Submit">
            </div>
         </div>
      </form>
   </div>
</div>
@endsection