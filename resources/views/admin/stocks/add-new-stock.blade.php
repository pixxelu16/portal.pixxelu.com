@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Add New Stock</h2>
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
      <form action="{{ route('common.submit.stock') }}" Method="POST">
         @csrf 
         <div class="form-group display-column">
            <div class="form-design mail">
               <label for="total_keyboard_stock">Keyboard Stock</label>
               <input type="text" id="total_keyboard_stock" name="total_keyboard_stock" value="{{ old('total_keyboard_stock') }}" placeholder="Enter Total Keyboard Stock">
            </div>
            <div class="form-design mail">
               <label for="total_mouse_stock">Mouse Stock</label>
               <input type="text" id="total_mouse_stock" name="total_mouse_stock" value="{{ old('total_mouse_stock') }}" placeholder="Enter Total Mouse Stock">
            </div>
         </div>
         <div class="form-group display-column">
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Submit">
            </div>
         </div>
      </form>
   </div>
</div>
<script>
document.getElementById('total_keyboard_stock').addEventListener('input', function (e) {
   // Ensure only digits are allowed
   this.value = this.value.replace(/\D/g, '');
});
document.getElementById('total_mouse_stock').addEventListener('input', function (e) {
   // Ensure only digits are allowed
   this.value = this.value.replace(/\D/g, '');
});
</script>
@endsection
