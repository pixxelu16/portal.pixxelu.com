@extends('super-admin.layouts.master')    
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Student Fees Detail</h2>
</div>
<div class="main-table">
   <div class="login-form">
      <form action="{{ route('super.admin.update.student.fees', $student_fees_detail->id) }}" Method="POST" enctype="multipart/form-data">
         @csrf 
         <div class="form-design last-name">
            <label for="last-name">Date</label>
            <input type="date" id="date" name="submission_date" value="{{ $student_fees_detail->submission_date }}" placeholder="Enter Date Fees">
         </div>
         <div class="form-design mail">
            <label for="user_fees">Fees Amount</label>
            <input type="text" id="user_fees" name="user_fees" value="{{ $student_fees_detail->user_fees  }}" placeholder="Enter Fees Amount">
         </div>
         <div class="form-design mail">
         <label for="user_fees">Payment Type</label>
         <select name="payment_type" id="payment_type">
            <option value="" disabled selected>Select Payment Type</option>
            <option value="online" @if($student_fees_detail->payment_type == 'online') selected @endif>Online</option>
            <option value="cash" @if($student_fees_detail->payment_type == 'cash') selected @endif>Cash</option>
         </select>
         </div>         @include('admin.partials.form-footer-alerts')

         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Update">
            </div>
         </div>
      </form>
   </div>
</div>
@endsection