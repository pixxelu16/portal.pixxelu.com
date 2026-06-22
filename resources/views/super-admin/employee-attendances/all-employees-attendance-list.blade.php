@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   @include('admin.partials.page-alerts')

   <div class="portal-attendance-header">
      <div>
         <h2>Employee Attendance</h2>
         <span class="portal-attendance-period">{{ date('F Y') }}</span>
      </div>
</div>

   @include('admin.partials.attendance-stats')
</div>

<div class="portal-listing portal-attendance-listing">
   <form action="{{ url('super-admin/search-employee-attendance') }}" method="GET" class="portal-attendance-filters">
      <select class="portal-select" name="employee_name">
         <option value="">All Employees</option>
         @foreach ($get_employee_detail as $employee)
            <option value="{{ $employee->name }}">({{ $employee->unique_employee_id }}) {{ $employee->name }}</option>
         @endforeach
      </select>
      <select class="portal-select" name="month">
         <option value="">Month</option>
         @foreach ($months as $key => $name)
            <option value="{{ $key }}" {{ \Carbon\Carbon::now()->month === $key ? 'selected' : '' }}>{{ $name }}</option>
         @endforeach
      </select>
      <select class="portal-select" name="year">
         <option value="">Year</option>
         @for ($i = date('Y'); $i >= 2023; $i--)
            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
         @endfor
      </select>
      <button type="submit" class="portal-btn-primary"><i class="bi bi-search"></i> Search</button>
   </form>

   <div class="portal-attendance-legend">
      <span><img src="{{ url('public/admin/images/present_icon.svg') }}" alt=""> Present</span>
      <span><img src="{{ url('public/admin/images/absent_icon.svg') }}" alt=""> Absent</span>
      <span><img src="{{ url('public/admin/images/leave_icon.svg') }}" alt=""> Leave</span>
      <span><img src="{{ url('public/admin/images/half_day_leave.svg') }}" alt=""> Half Day</span>
      <span><img src="{{ url('public/admin/images/sunday.svg') }}" alt=""> Sunday</span>
      <span><img src="{{ url('public/admin/images/saturday.svg') }}" alt=""> Alt. Saturday</span>
   </div>

   <div class="portal-attendance-scroll">
      <table id="example10" class="portal-table portal-attendance-table">
         <thead>
            <tr>
               <th class="att-sticky-col att-col-1">#</th>
               <th class="att-sticky-col att-col-2">Employee</th>
               <th class="att-sticky-col att-col-3">Shift</th>
               <th class="att-sticky-col att-col-4">Type</th>
               @foreach ($days as $day)
               @php
                  $date = \Carbon\Carbon::create($year, $month, $day);
                  $dayOfWeek = $date->format('D');
                  $dayNumber = $date->format('d');
                  $isSunday = $dayOfWeek === 'Sun';
                  $isAlternativeSaturday = in_array($day, $alternativeSaturdays);
                  $headClass = $isSunday ? 'sun' : ($isAlternativeSaturday ? 'sat' : '');
               @endphp
               <th class="att-day-col att-day-head {{ $headClass }}">{{ $dayNumber }}<br>{{ $dayOfWeek }}</th>
               @endforeach
            </tr>
         </thead>
         <tbody>
            @php $count = 1; @endphp
            @foreach ($get_employee_detail as $employee)
            <tr>
               <td class="att-sticky-col att-col-1 col-num">{{ $count++ }}</td>
               <td class="att-sticky-col att-col-2">
                  <div class="portal-person">
                     <div class="portal-avatar">
                        @if($employee->user_pic)
                           <img src="{{ url('public/uploads/employees/' . $employee->user_pic) }}" alt="">
                        @else
                           <img src="{{ url('public/uploads/users/default_user.png') }}" alt="">
                        @endif
                     </div>
                     <div class="portal-person-info">
                        <span class="portal-person-name" style="cursor:default;">{{ $employee->name }}</span>
                        <span class="portal-person-meta">ID: {{ $employee->unique_employee_id }}</span>
                     </div>
                  </div>
               </td>
               <td class="att-sticky-col att-col-3">{{ $employee['employees_attendance_detail']['0']['sift'] ?? '—' }}</td>
               <td class="att-sticky-col att-col-4">{{ $employee['employees_attendance_detail'][0]['sift_type'] ?? '—' }}</td>
               @foreach ($days as $day)
               @php
                  $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                  $attendance = $employee->employees_attendance_detail->first(function ($att) use ($date) {
                     return \Carbon\Carbon::parse($att->submission_date)->format('Y-m-d') === $date;
                  });
                  $punchIn = null;
                  $punchOut = null;
                  $formattedDuration = null;
                  if ($attendance) {
                     $punchIn = \Carbon\Carbon::parse($attendance->punch_in_time);
                     $punchOut = $attendance->punch_out_time ? \Carbon\Carbon::parse($attendance->punch_out_time) : null;
                     if ($punchOut) {
                        $duration = $punchIn->diff($punchOut);
                        $formattedDuration = sprintf('%d:%02d', $duration->h, $duration->i);
                     }
                  }
                  $isAttendanceMissing = !$attendance;
                  $isSunday = in_array($day, $sundays);
                  $isAlternativeSaturday = in_array($day, $alternativeSaturdays);
                  $isHoliday = $isSunday || $isAlternativeSaturday;
               @endphp
               <td class="att-day-col">
                  <div class="att-cell">
                     @if ($isHoliday)
                        @if ($isSunday)
                           <img class="att-icon" src="{{ url('public/admin/images/sunday.svg') }}" alt="Sun" title="Sunday">
                        @else
                           <img class="att-icon" src="{{ url('public/admin/images/saturday.svg') }}" alt="Sat" title="Holiday">
                        @endif
                     @elseif ($isAttendanceMissing)
                        <button type="button" class="att-edit-btn employee_attendance employee-punch-in-buton"
                           data-employee_id="{{ $employee->id }}" data-missing_date="{{ $date }}"
                           data-employee_name="{{ $employee->name }}" data-toggle="modal" data-target="#editAttendance" title="Add attendance">
                           <img src="{{ url('public/admin/images/edit.svg') }}" alt="Edit">
                        </button>
                     @elseif ($attendance)
                        @if ($attendance->attendance_status == 'present')
                           <img class="att-icon" src="{{ url('public/admin/images/present_icon.svg') }}" alt="P" title="Present">
                           @if($formattedDuration)<p class="att-duration">{{ $formattedDuration }}</p>@endif
                        @elseif ($attendance->attendance_status == 'absent')
                           <img class="att-icon" src="{{ url('public/admin/images/absent_icon.svg') }}" alt="A" title="Absent">
                        @elseif ($attendance->attendance_status == 'leave')
                           <img class="att-icon" src="{{ url('public/admin/images/leave_icon.svg') }}" alt="L" title="Leave">
                        @elseif ($attendance->attendance_status == 'half_day')
                           <img class="att-icon" src="{{ url('public/admin/images/half_day_leave.svg') }}" alt="H" title="Half Day">
                        @elseif ($attendance->attendance_status == 'holiday')
                           <img class="att-icon" src="{{ url('public/admin/images/holiday.svg') }}" alt="Holiday">
                        @endif
                     @endif
                  </div>
               </td>
               @endforeach
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>

{{-- Edit Attendance Modal --}}
<div class="modal" id="editAttendance">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header-damage">
            <h4 class="modal-title">Edit Attendance — <span class="employee_attendances"></span></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form action="#" id="employee_attendances" method="POST">
               <input type="hidden" id="attendances_employee_id" name="employee_id" value="" />
               <div class="form-group">
                  <label>Attendance Status <span class="text-danger">*</span></label>
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
                  <label>Shift <span class="text-danger">*</span></label>
                  <select class="form-control" name="sift" id="sift">
                     <option value="" disabled selected>Select Shift</option>
                     <option value="morning">Morning</option>
                     <option value="evening">Evening</option>
                     <option value="night">Night</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Shift Type <span class="text-danger">*</span></label>
                  <select class="form-control" name="sift_type" id="sift_type">
                     <option value="" disabled selected>Select type</option>
                     <option value="full_day">Full Day</option>
                     <option value="half_day">Half Day</option>
                     <option value="quarter_day">Quarter Day</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Date <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="submission_date" id="date">
               </div>
               <div class="form-group">
                  <label>Punch In <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_in_time" id="punch_in_time">
               </div>
               <div class="form-group">
                  <label>Punch Out <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_out_time" id="punchOutTime">
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary is_create_employee_punch_in_attendance portal-btn-primary">Update</button>
               </div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;"><img src="{{ url('public/admin/images/200w.gif') }}" /></div>
            <div class="employee_attendance_responce"></div>
         </div>
      </div>
   </div>
</div>
@endsection
