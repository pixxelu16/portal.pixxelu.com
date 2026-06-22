@extends('admin.layouts.master') 
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   @include('notification')
   <h2>All Inqueries Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
       <!--start filter by inquiry acc status-->
        <select name="inquery_status" id="search_inquery_status_list" class="search-student-list">
            <option value="" disabled {{ request()->segment(count(request()->segments())) ? '' : 'selected' }}>Select Inquiry Status</option>
            <option value="Active" {{ request()->segment(count(request()->segments())) == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Office_Visited" {{ request()->segment(count(request()->segments())) == 'Office_Visited' ? 'selected' : '' }}>Office Visited</option>
            <option value="Closed" {{ request()->segment(count(request()->segments())) == 'Closed' ? 'selected' : '' }}>Closed</option>
            <option value="Converted" {{ request()->segment(count(request()->segments())) == 'Converted' ? 'selected' : '' }}>Converted</option>
         </select>
         <!--end filter by inquiry acc status-->
         <!--start filter by acco course type-->
         <select name="course_type" id="search_inquery_course_type_list" class="search-student-list">
            <option value="" disabled {{ request()->segment(count(request()->segments())) ? '' : 'selected' }}>Select Course Type</option>
            <option value="PHP Development" {{ request()->segment(count(request()->segments())) == 'PHP Development' ? 'selected' : '' }}>PHP Development</option>
            <option value="Web Development" {{ request()->segment(count(request()->segments())) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
            <option value="Digital Marketing" {{ request()->segment(count(request()->segments())) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
            <option value="Web Designing" {{ request()->segment(count(request()->segments())) == 'Web Designing' ? 'selected' : '' }}>Web Designing</option>
            <option value="Graphic Designing" {{ request()->segment(count(request()->segments())) == 'Graphic Designing' ? 'selected' : '' }}>Graphic Designing</option>
            <option value="Full Stack Development" {{ request()->segment(count(request()->segments())) == 'Full Stack Development' ? 'selected' : '' }}>Full Stack Development</option>
         </select>
         <!--end filter by acc course type-->
         <a href="{{ url('admin/all-converted-inqueries-list') }}">All Converted Inqueries</a>
         <a href="{{ url('admin/add-new-inquery') }}"><img src="{{ url('public/admin/images/pluse.svg') }}">Add New Inquery</a>
      </div>
   </div>
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
                  <th>Inqury Date</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @php $count = 1; 
               @endphp
               @foreach($all_inqueries_list as $list)   
               <tr>
                  <td>{{ $count++ }}.</td>
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
                  @elseif($list->course_type == 'Graphic Designing')
                     <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  @else
                     <td></td>
                  @endif
                  <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d M Y') }}</td>
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
                     <a class="btn btn-info btn-sm" href="{{ url('admin/edit-inquery', $list->id) }}">
                     <img src="{{ url('public/admin/images/ico-4.png') }}">
                     </a>
                     <!-- <a class="btn btn-danger btn-sm" href="{{ url('admin/delete-inquery', $list->id) }}">
                        <i class="fas fa-trash-alt"></i> Delete
                        </a> -->
                  </td>
               </tr>
               @endforeach 
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection