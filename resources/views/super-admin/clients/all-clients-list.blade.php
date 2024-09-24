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
   <h2>All Clients Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <a href="{{ url('super-admin/add-new-client') }}"><img src="{{ url('public/admin/images/pluse.svg') }}">Add New Client</a>
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Mobile No</th>
                  <th>Description</th>
                  <th>Country</th>
                  <th>From</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @php $count = 1; @endphp
               @foreach($all_clients_list as $client)   
               <tr>
                  <td>{{ $count++ }}</td>
                  <td>{{ $client->client_name }} </td>
                  <td><a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $client->phone_no) }}" target="_blank">{{ substr($client->phone_no, 0, 5) . '-' . substr($client->phone_no, 5) }}</a></td>
                  <td>{{ $client->desc ??'-' }}</td>
                  <td>{{ $client->country ??'-' }}</td>
                  <td>{{ $client->from ?? '-' }}</td>
                  @if($client->client_status == 'Active') 
                        <td class="green-color"><span>Active</span></td>
                     @elseif($client->client_status == 'Pending')
                        <td class="red-color"><span>Pending</span></td>
                     @elseif($client->client_status == 'Converted')
                        <td class="purple-color"><span>Converted</span></td>
                     @elseif($client->client_status == 'Completed')
                        <td class="green-color"><span>Completed</span></td>
                     @elseif($client->client_status == 'Leave')
                        <td class="red-color"><span>Leave</span></td>
                     @else
                        <td></td>
                  @endif
                  <td>
                     <a class="btn btn-info btn-sm" href="{{ url('super-admin/edit-client', $client->id) }}"><img src="{{ url('public/admin/images/ico-4.png') }}"></a>
                     <!--<a class="btn btn-danger btn-sm" href="{{ url('admin/client-inquery', $client->id) }}"><i class="fas fa-trash-alt"></i> Delete</a> -->
                  </td>
               </tr>
               @endforeach 
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection