@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   @include('admin.partials.page-alerts')
   <div class="portal-page-header">
      <h2>All Stocks</h2>
      <span class="portal-record-count">{{ $all_stocks_list ? $all_stocks_list->count() : 0 }} records</span>
   </div>
</div>

<div class="portal-listing">
   <div class="portal-listing-toolbar">
      <div class="portal-listing-toolbar-right" style="margin-left:auto;">
         <a href="{{ url('admin/add-new-stock') }}" class="portal-btn-primary">
            <img src="{{ url('public/admin/images/pluse.svg') }}" alt=""> Add New Stock
         </a>
      </div>
   </div>
   <div class="portal-listing-body">
      <table id="portalListingTable" class="portal-table">
         <thead>
            <tr>
               <th>#</th>
               <th>Keyboard Stock</th>
               <th>Assigned</th>
               <th>Remaining</th>
               <th>Damage</th>
               <th>Mouse Stock</th>
               <th>Assigned</th>
               <th>Remaining</th>
               <th>Damage</th>
            </tr>
         </thead>
         <tbody>
            @if($all_stocks_list && $all_stocks_list->isNotEmpty())
               @php $count = 1; @endphp
               @foreach($all_stocks_list as $list)
               <tr>
                  <td class="col-num">{{ $count++ }}</td>
                  <td><strong>{{ $list->total_keyboard_stock }}</strong></td>
                  <td>{{ $list->assign_keyboard }}</td>
                  <td>{{ $list->total_keyboard_stock - $list->assign_keyboard }}</td>
                  <td>{{ $total_keyboard_damaged ?? 0 }}</td>
                  <td><strong>{{ $list->total_mouse_stock }}</strong></td>
                  <td>{{ $list->assign_mouse }}</td>
                  <td>{{ $list->total_mouse_stock - $list->assign_mouse }}</td>
                  <td>{{ $total_mouse_damaged ?? 0 }}</td>
               </tr>
               @endforeach
            @else
               <tr><td colspan="9" class="portal-no-data">No stock records found.</td></tr>
            @endif
         </tbody>
      </table>
   </div>
</div>
@endsection
