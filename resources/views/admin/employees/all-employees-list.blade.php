@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   @include('admin.partials.page-alerts')

   <div class="portal-page-header">
      <h2>All Employees</h2>
      <span class="portal-record-count">{{ $get_employees_detail ? $get_employees_detail->count() : 0 }} employees</span>
   </div>
</div>

<div class="portal-listing">
   <div class="portal-listing-toolbar">
      <div class="portal-listing-toolbar-left">
         <select name="employee_role" id="employee_role" class="portal-select">
            <option value="" disabled selected>Filter by Role</option>
            <option value="Project Bidder">Project Bidder</option>
            <option value="Php Development">Php Development</option>
            <option value="Web Development">Web Development</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Graphic Designing">Graphic Designing</option>
            <option value="SEO">SEO</option>
         </select>
      </div>
   </div>

   <div class="portal-listing-body">
      <table id="portalListingTable" class="portal-table">
         <thead>
            <tr>
               <th>#</th>
               <th>Employee</th>
               <th>Attendance</th>
               <th>Phone</th>
               <th>Joined</th>
               <th>Role</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            @if($get_employees_detail && $get_employees_detail->isNotEmpty())
               @php $count = 1; @endphp
               @foreach($get_employees_detail as $employee)
               @php
                  $rolePill = match($employee->employee_role) {
                     'Project Bidder'    => 'portal-pill-blue',
                     'Php Development'   => 'portal-pill-green',
                     'Web Development'   => 'portal-pill-yellow',
                     'Web Designing'     => 'portal-pill-pink',
                     'Graphic Designing' => 'portal-pill-cyan',
                     'SEO'               => 'portal-pill-orange',
                     default             => 'portal-pill-gray',
                  };
                  $statusBadge = match($employee->user_status) {
                     'Active'  => 'portal-badge-success',
                     'Pending' => 'portal-badge-warning',
                     'Suspend' => 'portal-badge-muted',
                     'Leave'   => 'portal-badge-danger',
                     default   => 'portal-badge-muted',
                  };
                  $statusLabel = match($employee->user_status) {
                     'Active'  => 'Working',
                     'Pending' => 'Pending',
                     'Suspend' => 'Suspended',
                     'Leave'   => 'On Leave',
                     default   => $employee->user_status,
                  };
               @endphp
               <tr>
                  <td class="col-num">{{ $count++ }}</td>
                  <td>
                     <div class="portal-person">
                        <div class="portal-avatar">
                           @if($employee->user_pic)
                              <img src="{{ url('public/uploads/employees/' . $employee->user_pic) }}" alt="">
                           @else
                              <img src="{{ url('public/uploads/users/default_user.png') }}" alt="">
                           @endif
                        </div>
                        <div class="portal-person-info">
                           <a href="#" class="portal-person-name employee_detail" data-employee_id="{{ $employee->id }}" onclick="openNav(); return false;">{{ $employee->name }}</a>
                           <span class="portal-person-meta">ID: {{ $employee->unique_employee_id }}</span>
                        </div>
                     </div>
                  </td>
                  <td>
                     <div class="portal-row-actions">
                        <button type="button" class="portal-btn-sm portal-btn-sm-in employee_punch_in_attendance employee-punch-in-buton"
                           data-employee_id="{{ $employee->id }}" data-employee_name="{{ $employee->name }}"
                           data-toggle="modal" data-target="#punchInModel">Punch In</button>
                        <button type="button" class="portal-btn-sm portal-btn-sm-out employee_punch_out_attendance employee-punch-out-buton"
                           data-employee_id="{{ $employee->id }}" data-employee_name="{{ $employee->name }}"
                           data-toggle="modal" data-target="#punchOutModel">Punch Out</button>
                     </div>
                  </td>
                  <td>
                     @if($employee->employee_phone_no)
                        <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $employee->employee_phone_no) }}" target="_blank" class="portal-phone">
                           {{ substr($employee->employee_phone_no, 0, 5) }}-{{ substr($employee->employee_phone_no, 5) }}
                        </a>
                     @else
                        <span class="portal-muted">—</span>
                     @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') }}</td>
                  <td><span class="portal-pill {{ $rolePill }}">{{ $employee->employee_role ?: '—' }}</span></td>
                  <td><span class="portal-badge {{ $statusBadge }}">{{ $statusLabel }}</span></td>
               </tr>
               @endforeach
            @else
               <tr><td colspan="7" class="portal-no-data">No employees found.</td></tr>
            @endif
         </tbody>
      </table>
   </div>
</div>

{{-- Punch In Modal --}}
<div class="modal" id="punchInModel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Punch In <span class="employee_attendances"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form action="#" id="employee_punch_in_attendance" method="POST">
               <input type="hidden" id="models_employee_id" name="employee_id" value="" />
               <div class="form-group">
                  <label for="attendanceStatus">Attendance Status <span class="text-danger">*</span></label>
                  <select class="form-control" name="attendance_status" id="attendance_status">
                     <option value="" disabled selected>Select Status</option>
                     <option value="present">Present</option>
                     <option value="half_day">Half Day</option>
                     <option value="absent">Absent</option>
                     <option value="leave">Leave</option>
                     <option value="holiday">Holiday</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="shift">Shift <span class="text-danger">*</span></label>
                  <select class="form-control" name="sift" id="sift">
                     <option value="" disabled selected>Select Shift</option>
                     <option value="morning">Morning</option>
                     <option value="evening">Evening</option>
                     <option value="night">Night</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="shiftType">Shift Type <span class="text-danger">*</span></label>
                  <select class="form-control" name="sift_type" id="sift_type">
                     <option value="" disabled selected>Select type</option>
                     <option value="full_day">Full Day</option>
                     <option value="half_day">Half Day</option>
                     <option value="quarter_day">Quarter Day</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="punchInTime">Punch In Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_in_time" id="punchInTime">
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary is_create_employee_attendance">Submit</button>
               </div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;"><img src="{{ url('public/admin/images/200w.gif') }}" /></div>
            <div class="employee_attendance_responce"></div>
         </div>
      </div>
   </div>
</div>

{{-- Punch Out Modal --}}
<div class="modal" id="punchOutModel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Punch Out Of <span class="employee_attendances"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
            <div class="loader com_ajax_loader" style="display:none;"><img src="{{ url('public/admin/images/200w.gif') }}" /></div>
            <div class="employee_attendance_responce"></div>
         </div>
      </div>
   </div>
</div>

<div id="myNav" class="overlay hide">
   <div class="overlay-content">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loader com_ajax_loaders" style="display: none;"><img src="{{ url('public/admin/images/index.svg') }}" /></div>
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
