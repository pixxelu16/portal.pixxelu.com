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
   <h2>All Inqueries Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!--start filter acc inquiry status-->
         <select name="inquery_status" id="search_inquery_status_list" class="search-student-list">
            <option value="" disabled selected>Select Inquiry Status</option>
            <option value="Active">Active</option>
            <option value="Office_Visited">Office Visited</option>
            <option value="Closed">Closed</option>
            <option value="Converted">Converted</option>
         </select>
         <!--end filter acc inquiry status-->
         <!--start filter acc course-->
         <select name="course_type" id="search_inquery_course_type_list" class="search-student-list">
            <option value="" disabled selected>Select Course Type</option>
            <option value="PHP Development">PHP Development</option>
            <option value="Web Development">Web Development</option>
            <option value="Digital Marketing">Digital Marketing</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Graphic Designing">Graphic Designing</option>
            <option value="Full Stack Development">Full Stack Development</option>
         </select>
         <!--end filter acc course-->
         <!--start main header meenu-->
         <!-- <a href="{{ url('super-admin/export-inqueries') }}" class="export"><img src="{{ url('public/admin/images/csv-file.svg') }}"></a> -->
         <a href="{{ url('super-admin/all-converted-inqueries-list') }}">Converted Inqueries</a>
         <a href="{{ url('super-admin/add-new-inquery') }}"><img src="{{ url('public/admin/images/pluse.svg') }}">Add New Inquery</a>
         <!--end main header meenu-->
      </div>
   </div>
      <!--start export inqueries filter-->
      <form action="{{ url('super-admin/export-inqueries') }}" method="GET">
      <div class="filter-admin-csv">
         <select name="course_type" id="course_type" class="types">
            <option value="" disabled selected>Inqueries CSV</option>
            <option value="all">All Inqueries</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Web Development">Web Development</option>
            <option value="PHP Development">PHP Development</option>
            <option value="Digital Marketing">Digital Marketing</option>
            <option value="Full Stack Development">Full Stack Development</option>
            <option value="Graphic">Graphic</option>
         </select>
         <div class="form-group">
            <button class="btn btn-success" type="submit">Export</button>
         </div>
      </div>
   </form>
   <!--end export inqueries filter-->
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Address</th>
                  <th>Course Type</th>
                  <th>Visit</th>
                  <th>Inqury Date</th>
                  <th>Priority</th>
                  <th>Total Fees</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @php $count = 1; @endphp
               @foreach($all_inqueries_list as $list)   
                  <tr>
                     <td>{{ $count++ }}</td>
                     <td>{{ $list->name }} </td>
                     <td><a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $list->mobile) }}" target="_blank">{{ substr($list->mobile, 0, 5) . '-' . substr($list->mobile, 5) }}</a></td>
                     <td>{{ $list->address ??'-' }}</td>
                     @if($list->course_type == 'Full Stack Development') 
                           <td class="lights-blue-color"><span>Full Stack Development</span></td>
                        @elseif($list->course_type == 'PHP Development')
                           <td class="lights-green-color"><span>PHP Development</span></td>
                        @elseif($list->course_type == 'Web Development')
                           <td class="light-yellow-color"><span>Web Development</span></td>
                        @elseif($list->course_type == 'Digital Marketing')
                           <td class="light-organge-color"><span>Digital Marketing</span></td>
                        @elseif($list->course_type == 'Web Designing')
                           <td class="light-pink-color"><span>Web Designing</span></td>
                        @elseif($list->course_type == 'Graphic')
                           <td class="lights-blue-color"><span>Graphic Designing</span></td>
                        @else
                        <td></td>
                     @endif
                     @if($list->visit == 'Google') 
                        <td class="lights-blue-color"><span>Google</span></td>
                     @elseif($list->visit == 'Instagram') 
                        <td class="lights-green-color"><span>Instagram</span></td>
                     @elseif($list->visit == 'Facebook') 
                        <td class="light-yellow-color"><span>Facebook</span></td>
                     @elseif($list->visit == 'Office-Visit') 
                        <td class="light-organge-color"><span>Office-Visit</span></td>
                     @elseif($list->visit == 'Website') 
                        <td class="light-pink-color"><span>Website</span></td>
                     @elseif($list->visit == 'YouTube') 
                        <td class="light-cyan-color"><span>YouTube</span></td>
                     @elseif($list->visit == 'Walk-in') 
                        <td class="light-brown-color"><span>Walk-in</span></td>
                     @elseif($list->visit == 'Email') 
                        <td class="light-yellow-color"><span>Email</span></td>
                     @elseif($list->visit == 'WhatsApp') 
                        <td class="lights-green-color"><span>WhatsApp</span></td>
                     @elseif($list->visit == 'SMS') 
                        <td class="light-organge-color"><span>SMS</span></td>
                     @elseif($list->visit == 'Other') 
                        <td class="light-cyan-color"><span>Other</span></td>
                     @else
                        <td></td>
                     @endif
                     <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d M Y') }}</td>
                        @if($list->priority == 'hot') 
                           <td class="priority-hot"><span>Hot</span></td>
                        @elseif($list->priority == 'cold')
                           <td class="priority-cold"><span>Cold</span></td>
                        @elseif($list->priority == 'warm')
                           <td class="priority-warm"><span>Warm</span></td>
                        @else
                           <td>-</td>
                        @endif
                        <td>{{ $list->total_fees ?? '-'}} </td>
                           @if($list->status == 'Active') 
                              <td class="green-color"><span>Active</span></td>
                           @elseif($list->status == 'Office_Visited') 
                              <td class="pink-color"><span>Office Visited</span></td>
                           @elseif($list->status == 'Closed')
                              <td class="red-color"><span>Closed</span></td>
                           @elseif($list->status == 'Converted')
                              <td class="purple-color"><span>Converted</span></td>
                           @else
                              <td></td>
                           @endif
                        <td>
                        <a class="btn btn-info btn-sm" href="{{ url('super-admin/edit-inquery', $list->id) }}"><img src="{{ url('public/admin/images/ico-4.png') }}"></a>
                        <!--<a class="btn btn-danger btn-sm" href="{{ url('admin/delete-inquery', $list->id) }}"><i class="fas fa-trash-alt"></i> Delete</a> -->
                     </td>
                  </tr>
               @endforeach 
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection