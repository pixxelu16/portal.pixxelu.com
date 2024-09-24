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
   <h2>All Employees Trash Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-trash-back">
         <a href="{{ url('super-admin/all-employees-list') }}">
         <span class="login-arrow">
         <i class="fa fa-arrow-left" style="margin-right: 5px;" aria-hidden="true"></i>Back
         </span>
         </a>
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>Sr.No.</th>
                  <th>Employee ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Employee Role</th>
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Salary</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @if($get_trash_employees_detail && $get_trash_employees_detail->isNotEmpty())
               @php $count = 1; 
               @endphp
               @foreach($get_trash_employees_detail as $employee)   
               <tr>
                  <td>{{ $count++ }}.</td>
                  <td>{{ $employee->id }}</td>
                  <td data-th="Image">
                     @if($employee->user_pic)
                        <div class="user-image"> <img src = "{{ url('public/uploads/employees/'. $employee->user_pic)}}" alt=""></div>
                     @endif 
                  </td>
                  <td>{{ $employee->name }}</td>
                  <td>{{ $employee->email }} </td>
                  <td>{{ $employee->employee_role }} </td>
                  <td><a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $employee->employee_phone_no) }}" target="_blank">{{ substr($employee->employee_phone_no, 0, 5) }}-{{ substr($employee->employee_phone_no, 5) }}</a></td>
                  <td>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') }}</td>
                  <td>{{ $employee->net_salary }} </td>
                  @if($employee->user_status == 'Active') 
                        <td class="green-color"><span>Active</span></td>
                     @elseif($employee->user_status == 'Pending')
                        <td class="red-color"><span>Pending</span></td>
                     @elseif($employee->user_status == 'Suspend')
                        <td class="purple-color"><span>Suspend</span></td>
                     @elseif($employee->user_status == 'Leave')
                        <td class="red-color"><span>Leave</span></td>
                     @else
                        <td></td>
                  @endif
                  <td>
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <img src="{{ url('public/admin/images/ellips.svg') }}" alt="ellips" /> </button>
                        <ul class="dropdown-menu pay-fees-submit">
                           <form class="drop-don-list">
                              <!-- <li><a href="{{ url('super-admin/edit-employee', $employee->id) }}"><img src="{{ url('public/admin/images/ico-4.png') }}">Edit</a></li> -->
                              <li><button type="submit" class="is_delete_employee_record" data-employee_id="{{ $employee->id }}"><img src="{{ url('public/admin/images/ico-5.png') }}">Delete</button></li>
                           </form>
                        </ul>
                     </div>
                  </td>
               </tr>
               @endforeach 
               @else
               <tr>
                  <td colspan="4">No Trash Employees are available.</td>
               </tr>
               @endif
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection