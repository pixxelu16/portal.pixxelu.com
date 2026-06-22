@extends('super-admin.layouts.master') 
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   @include('notification')
   <h2>All Converted Inqueries Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <a href="{{ url('super-admin/all-inqueries-list') }}">
            <span class="login-arrow">
               <i class="fa fa-arrow-left" style="margin-right: 5px;" aria-hidden="true"></i>
               Back
            </span>
         </a>
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
                  <th>Visit</th>
                  <th>Inqury Date</th>
                  <th>Status</th>
                  <!--<th>Action</th>-->
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
                  <!--check if course types exists or not-->
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
                     <td>-</td>
                  @endif
                  <!--check if visit exists or not-->
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
                     <td>-</td>
                  @endif
                  <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d M, Y') }}</td>
                  <!--check if status exists or not-->
                  @if($list->status == 'Active') 
                     <td class="green-color"><span>Active</span></td>
                  @elseif($list->status == 'Office_Visited')
                     <td class="pink-color"><span>Office Visited</span></td>
                  @elseif($list->status == 'Closed')
                     <td class="red-color"><span>Closed</span></td>
                  @elseif($list->status == 'Converted')
                     <td class="purple-color"><span>Converted</span></td>
                  @else
                     <td>-</td>
                  @endif
                  <!-- <td>
                     <a class="btn btn-info btn-sm" href="{{ url('super-admin/edit-inquery', $list->id) }}">
                     <img src="{{ url('public/admin/images/ico-4.png') }}">
                     </a>
                     <a class="btn btn-danger btn-sm" href="{{ url('super-admin/delete-inquery', $list->id) }}">
                        <i class="fas fa-trash-alt"></i> Delete
                        </a>
                     </td> -->
               </tr>
               @endforeach 
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection