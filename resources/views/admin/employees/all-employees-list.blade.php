@extends('admin.layouts.master')
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
   <h2>All Employees Listing</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!--filter employees acc role-->
         <select name="employee_role" id="employee_role" class="search-student-list">
            <option value ="" disabled selected>Select Employee Role</option>
            <option value="Project Bidder">Project Bidder</option>
            <option value="Php Development">Php Development</option>
            <option value="Web Development">Web Development</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Graphic Designing">Graphic Designing</option>
            <option value="SEO">SEO</option>
         </select>
         <!--end filter employees acc role-->
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
                  <th>Attendance</th>
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Employee Role</th>
                  <th>Employee Status</th>
                  <!--<th>Action</th>-->
               </tr>
            </thead>
            <tbody>
               @if($get_employees_detail && $get_employees_detail->isNotEmpty())
                  @php $count = 1; @endphp
                  @foreach($get_employees_detail as $employee)   
                     <tr>
                        <td>{{ $count++ }}.</td>
                        <td>{{ $employee->unique_employee_id }}</td>
                        <td data-th="Image">
                           @if($employee->user_pic)
                           <div class="user-image"> <img src = "{{ url('public/uploads/employees/'. $employee->user_pic)}}" alt=""></div>
                           @endif 
                        </td>
                        <td>
                           <span onclick="openNav()"><a href="#" class="employee_detail" data-employee_id="{{ $employee->id }}">{{ $employee->name }}</a></span>
                        </td>
                        <td>
                        @php
                           $today = \Carbon\Carbon::today()->format('Y-m-d');
                        @endphp
                        <div class="box-pay">
                              <button type="button" class="employee-punch-in-buton employee_punch_in_attendance" data-employee_id="{{ $employee->id }}" data-employee_name="{{ $employee->name }}" data-missing_date="{{ $today }}" data-toggle="modal" data-target="#punchInModel">
                              Punch in
                           </div>
                           <div class="box-pay">
                              <button type="button" class="employee-punch-out-buton employee_punch_out_attendance" data-employee_id="{{ $employee->id }}" data-employee_name="{{ $employee->name }}" data-toggle="modal" data-target="#punchOutModel">
                              Punch Out
                           </div>
                        </td>
                        @if($employee->employee_phone_no)
                           <td><a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $employee->employee_phone_no) }}" target="_blank">{{ substr($employee->employee_phone_no, 0, 5) . '-' . substr($employee->employee_phone_no, 5) }}</a></td>
                           @else
                           <td>-</td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') }}</td>
                           @if($employee->employee_role == 'Project Bidder') 
                                 <td class="light-blue-color"><span>Project Bidder</span></td>
                              @elseif($employee->employee_role == 'Php Development')
                                 <td class="light-green-color"><span>PHP Development</span></td>
                              @elseif($employee->employee_role == 'Web Development')
                                 <td class="light-yellow-color"><span>Web Development</span></td>
                              @elseif($employee->employee_role == 'Web Designing')
                                 <td class="light-pink-color"><span>Web Designing</span></td>
                              @elseif($employee->employee_role == 'Graphic Designing')
                                 <td class="light-cyan-color"><span>Graphic Designing</span></td>
                              @elseif($employee->employee_role == 'SEO')
                                 <td class="light-orange-color"><span>SEO</span></td>
                              @else
                                 <td></td>
                           @endif
                        <!-- <td>
                           {{ $employee->total_salary }} 
                           <div class="box-pay">
                              <button type="button" class="pay-fes-buton employee_pay_salary" data-employee_id="{{ $employee->id }}" data-toggle="modal" data-target="#myModal">Pay Salary</button>
                              </div> 
                           </td> -->
                        @if($employee->user_status == 'Active') 
                              <td class="green-color"><span>Working</span></td>
                           @elseif($employee->user_status == 'Pending')
                              <td class="red-color"><span>Pending</span></td>
                           @elseif($employee->user_status == 'Suspend') 
                              <td class="purple-color"><span>Suspend</span></td>
                           @elseif($employee->user_status == 'Leave')
                              <td class="red-color"><span>Leave</span></td>
                           @else
                           <td></td>
                        @endif
                        <!-- <td>
                           <div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <img src="{{ url('public/admin/images/ellips.svg') }}" alt="ellips" /> </button>
                              <ul class="dropdown-menu pay-fees-submit">
                                 <form class="drop-don-list">
                                    <li><a href="{{ url('admin/employee-detail', $employee->id) }}"><img src="{{ url('public/admin/images/ico-1.png') }}">View Employee Detail</a></li>
                                    <li><a href="{{ url('super-admin/edit-employee', $employee->id) }}"><img src="{{ url('public/admin/images/ico-4.png') }}">Edit</a></li>
                                    <li class="employee_trash_record" data-employee_id="{{ $employee->id }}"><img src="{{ url('public/admin/images/ico-5.png') }}" alt="Trash Icon">Trash</li> 
                                 </form>
                              </ul>
                           </div>
                           </td> -->
                     </tr>
                  @endforeach 
                  @else
                  <tr>
                     <td colspan="4">No Employee are available.</td>
                  </tr>
               @endif
            </tbody>
         </table>
      </div>
   </div>
</div> 
<!--start employee punch in attendance modal -->
<div class="modal" id="punchInModel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Punch In  <span class="employee_attendances"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="#" id="employee_punch_in_attendance" method="POST">
               <input type="hidden" id="models_employee_id" name="employee_id" value="" />
               <input type="hidden" id="date" name="submission_date" value="" />
               <div class="form-group">
                  <label for="attendanceStatus">Attendance Status <span class="text-danger">*</span></label>
                  <select class="form-control" name="attendance_status" id="attendanceStatus">
                     <option value ="" disabled selected>Select Status</option>
                     <option value="present">Present</option>
                     <option value="half_day">Half Day</option>
                     <option value="absent">Absent</option>
                     <option value="leave">Leave</option>
                     <option value="holiday">Holiday</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="shift">Shift <span class="text-danger">*</span></label>
                  <select class="form-control" name="sift" id="shift">
                     <option value ="" disabled selected>Select Shift</option>
                     <option value="Morning">Morning</option>
                     <option value="Evening">Evening</option>
                     <option value="Night">Night</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="shiftType">Shift Type <span class="text-danger">*</span></label>
                  <select class="form-control" name="sift_type" id="shiftType">
                     <option value ="" disabled selected>Select type</option>
                     <option value="Full Day">Full Day</option>
                     <option value="Half Day">Half Day</option>
                     <option value="Quarter Day">Quarter Day</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="punchInTime">Punch In Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_in_time" id="punchInTime">
               </div>
               <!-- <div class="form-group">
                  <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_out_time" id="punchOutTime">
               </div> -->
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary is_create_employee_attendance">Submit</button>
               </div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;">
               <img src="{{ url('public/admin/images/200w.gif') }}" /> 
            </div>
            <div class="employee_attendance_responce"></div>
         </div>
      </div>
   </div>
</div>
<!--end employee punch in attendance modal -->
<!--start employee punch out attendance modal -->
<div class="modal" id="punchOutModel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Punch Out Of <span class="employee_attendances"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="#" id="employee_punch_out_attendance" method="POST">
               <input type="hidden" id="models_employee_id" name="employee_id" value="" />
               <div class="form-group">
                  <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_out_time" id="punch_out_time">
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary is_create_employee_punch_out_attendance">Submit</button>
               </div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;">
               <img src="{{ url('public/admin/images/200w.gif') }}" /> 
            </div>
            <div class="employee_attendance_responce"></div>
         </div>
      </div>
   </div>
</div>
<!--end employee punch out attendance modal -->
<div id="myNav" class="overlay hide">
   <div class="overlay-content">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loader com_ajax_loaders" style="display: none;">
         <img src="{{ url('public/admin/images/index.svg') }}" />
      </div>
      <div class="employee_detail_response"></div>
   </div>
</div>
<script>
function openNav() {
   document.getElementById("myNav").style.width = "68%";
   document.querySelector('.overlay').classList.remove('hide');
   document.querySelector('.loader').style.display = "block"; 
}
function closeNav() {
   document.getElementById("myNav").style.width = "0%";
   document.querySelector('.overlay').classList.add('hide');
   document.querySelector('.loader').style.display = "none"; 
}
</script>
@endsection