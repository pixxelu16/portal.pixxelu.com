@extends('admin.layouts.master') 
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Add Student Previous Fees</h2>
</div>
<div class="main-table">
   <div class="login-form">
      <form action="{{ route('admin.student.submit.fees') }}" Method="POST" enctype="multipart/form-data">
         @csrf 
         <div class="form-design-previous-fees first-name">
            <label for="previous-students">Students Name</label><br>
            <select id="previous-students" name="previous_student_id">
               <option value ="" disabled selected>Select student previous fees</option>
               @foreach($get_student_details as $student)
               <option value="{{ $student->id }}">{{$student->id }}. {{ $student->name }} ({{ $student->course_type }})</option>
               @endforeach
            </select>
         </div>
         <div class="form-design-previous-fees mail">
            <label for="amount">Fees Amount</label><br>
            <input type="text" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Enter Fees Amount" required>
         </div>
         <div class="form-design-previous-fees last-name">
            <label for="last-name">Date Fees</label><br>
            <input type="date" id="date" name="submission_date" value="{{ old('submission_date') }}" placeholder="Enter Date Fees">
         </div>         @include('admin.partials.form-footer-alerts')

         <div class="form-button">
            <div class="back-button-previous-fees">
               <input type="submit" class="btn btn-success" name="submit" value="Submit">
            </div>
         </div>
      </form>
   </div>
</div>
@endsection