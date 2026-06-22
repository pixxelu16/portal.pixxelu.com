@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Student Assign Accessories Detail:</h2>
</div>
<div class="main-table">
   <div class="login-form">
      <form action="{{ route('super.admin.update.assign.accessories.student', $student_accessories_detail->id) }}" Method="POST" enctype="multipart/form-data">
         @csrf 
         <div class="form-design last-name">
            <label for="last-name">Assign Accessories Name</label>
            <input type="text" id="assign_accessories_name" name="assign_accessories_name" value="{{ $student_accessories_detail->assign_accessories_name }}" placeholder="Enter Assign Accessories Student">
         </div>
         <div class="form-design mail">
            <label for="assign_accessories_date">Assign Accessories Date</label>
            <input type="date" id="assign_accessories_date" name="assign_accessories_date" value="{{ $student_accessories_detail->assign_accessories_date  }}" placeholder="Enter Assign Accessories Date">
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