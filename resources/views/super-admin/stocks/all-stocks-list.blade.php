@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
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
   <h2>All Stocks Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <a href="{{ url('super-admin/add-new-stock') }}"><img src="{{ url('public/admin/images/pluse.svg') }}">Add New Stock</a>
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No.</th>
                  <th>Keyboard Stock</th>
                  <th>Assigned Keyboard</th>
                  <th>Remaining Keyboard</th>
                  <th>Damage Keyboard</th>
                  <th>Mouse Stock</th>
                  <th>Assigned Mouse</th>
                  <th>Remaining Mouse</th>
                  <th>Damage Mouse</th>
               </tr>
            </thead>
            <tbody>
               @if($all_stocks_list && $all_stocks_list->isNotEmpty())
               @php $count = 1; 
               @endphp
               @foreach($all_stocks_list as $list)   
               <tr>
                  <td>{{ $count++ }}.</td>
                  <td>{{ $list->total_keyboard_stock }}</td>
                  <td>{{ $list->assign_keyboard }}</td>
                  <td>{{ $list->total_keyboard_stock - $list->assign_keyboard }}</td>
                  <td>{{ $total_keyboard_damaged ?? 0 }}</td>
                  <td>{{ $list->total_mouse_stock }}</td>
                  <td>{{ $list->assign_mouse }}</td>
                  <td>{{ $list->total_mouse_stock - $list->assign_mouse }}</td>
                  <td>{{ $total_mouse_damaged ?? 0 }}</td>
               </tr>
               @endforeach 
               @else
               <tr>
                  <td colspan="4">No Stocks are available.</td>
               </tr>
               @endif
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection