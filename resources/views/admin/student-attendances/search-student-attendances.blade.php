@extends('admin.layouts.master')
@section('content')
@php
   $periodLabel = (request('month') && request('year'))
      ? \Carbon\Carbon::create(request('year'), request('month'), 1)->format('F Y')
      : date('F Y');
@endphp
<div class="space-remove"></div>
<div class="title-subheading">
   @include('admin.partials.page-alerts')
   <div class="portal-attendance-header">
      <div>
         <h2>Search Student Attendance</h2>
         <span class="portal-attendance-period">{{ $periodLabel }}</span>
      </div>
   </div>
   @include('admin.partials.attendance-stats')
</div>

<div class="portal-listing portal-attendance-listing">
   <form action="{{ url('admin/search-student-attendance') }}" method="GET" class="portal-attendance-filters">
      <select class="portal-select" name="student_name">
         <option value="">All Students</option>
         @foreach ($get_student_name as $student)
            <option value="{{ $student->name }}" {{ request()->input('student_name') === $student->name ? 'selected' : '' }}>{{ $student->name }}</option>
         @endforeach
      </select>
      <select class="portal-select" name="month">
         <option value="">Month</option>
         @foreach ($months as $key => $name)
            <option value="{{ $key }}" {{ request()->input('month') == $key ? 'selected' : '' }}>{{ $name }}</option>
         @endforeach
      </select>
      <select class="portal-select" name="year">
         <option value="">Year</option>
         @for ($i = date('Y'); $i >= 2023; $i--)
            <option value="{{ $i }}" {{ request()->input('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
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
      <table class="portal-table portal-attendance-table">
         <thead>
            <tr>
               <th class="att-sticky-col att-col-1">#</th>
               <th class="att-sticky-col att-col-2">Student</th>
               <th class="att-sticky-col att-col-3">Batch</th>
               <th class="att-sticky-col att-col-4">Timing</th>
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
            @php $count = 1; $currentMonth = \Carbon\Carbon::now()->month; $currentYear = \Carbon\Carbon::now()->year; @endphp
            @forelse ($get_student_detail as $student)
            @if($get_student_detail->first()->student_attendance_detail->count() > 0)
            <tr>
               <td class="att-sticky-col att-col-1 col-num">{{ $count++ }}</td>
               <td class="att-sticky-col att-col-2">
                  <div class="portal-person">
                     <div class="portal-avatar">
                        @if($student->user_pic)
                           <img src="{{ url('public/uploads/users/' . $student->user_pic) }}" alt="">
                        @else
                           <img src="{{ url('public/uploads/users/default_user.png') }}" alt="">
                        @endif
                     </div>
                     <div class="portal-person-info">
                        <span class="portal-person-name" style="cursor:default;">{{ $student->name }}</span>
                        <span class="portal-person-meta">Reg #{{ $student->id }}</span>
                     </div>
                  </div>
               </td>
               <td class="att-sticky-col att-col-3">{{ $student['student_attendance_detail']['0']['batch'] ?? '—' }}</td>
               <td class="att-sticky-col att-col-4">{{ $student['student_attendance_detail']['0']['batch_time'] ?? '—' }}</td>
               @foreach ($days as $day)
               @php
                  $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                  $attendance = $student->student_attendance_detail->first(function ($att) use ($date) {
                     return \Carbon\Carbon::parse($att->submission_date)->format('Y-m-d') === $date;
                  });
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
                  $attendanceMonth = \Carbon\Carbon::parse($date)->month;
                  $attendanceYear = \Carbon\Carbon::parse($date)->year;
                  $canEdit = $isAttendanceMissing && !$isHoliday && $attendanceMonth == $currentMonth && $attendanceYear == $currentYear;
               @endphp
               <td class="att-day-col">
                  <div class="att-cell">
                     @if ($isHoliday)
                        @if ($isSunday)
                           <img class="att-icon" src="{{ url('public/admin/images/sunday.svg') }}" alt="Sun">
                        @else
                           <img class="att-icon" src="{{ url('public/admin/images/saturday.svg') }}" alt="Sat">
                        @endif
                     @elseif ($canEdit)
                        <button type="button" class="att-edit-btn student_attendance studentss-punch-in-buton"
                           data-student_id="{{ $student->id }}" data-missing_date="{{ $date }}"
                           data-student_name="{{ $student->name }}" data-toggle="modal" data-target="#editStudentAttendance" title="Add attendance">
                           <img src="{{ url('public/admin/images/edit.svg') }}" alt="Edit">
                        </button>
                     @elseif ($attendance)
                        @if ($attendance->attendance_status == 'present')
                           <img class="att-icon" src="{{ url('public/admin/images/present_icon.svg') }}" alt="P">
                           @if($formattedDuration)<p class="att-duration">{{ $formattedDuration }}</p>@endif
                        @elseif ($attendance->attendance_status == 'absent')
                           <img class="att-icon" src="{{ url('public/admin/images/absent_icon.svg') }}" alt="A">
                        @elseif ($attendance->attendance_status == 'leave')
                           <img class="att-icon" src="{{ url('public/admin/images/leave_icon.svg') }}" alt="L">
                        @elseif ($attendance->attendance_status == 'half_day')
                           <img class="att-icon" src="{{ url('public/admin/images/half_day_leave.svg') }}" alt="H">
                        @elseif ($attendance->attendance_status == 'holiday')
                           <img class="att-icon" src="{{ url('public/admin/images/holiday.svg') }}" alt="Holiday">
                        @endif
                     @endif
                  </div>
               </td>
               @endforeach
            </tr>
            @else
            <tr>
               <td colspan="{{ count($days) + 4 }}" class="portal-no-data">No student attendance records found for the selected month and year.</td>
            </tr>
            @endif
            @empty
            <tr>
               <td colspan="{{ count($days) + 4 }}" class="portal-no-data">No attendance records found. Please select a student name first.</td>
            </tr>
            @endforelse
         </tbody>
      </table>
   </div>
</div>
<!--start student edit attendance modal-->
<div class="modal" id="editStudentAttendance">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header-damage">
            <h4 class="modal-title">Edit Attendance For <span class="student_attendances"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="#" id="student_attendances" method="POST">
               <input type="hidden" id="attendances_student_id" name="student_id" value="" />
               <div class="form-group">
                  <label for="attendanceStatus">Attendance Status For<span class="text-danger">*</span></label>
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
                  <label for="batch">Batch <span class="text-danger">*</span></label>
                  <select class="form-control" name="batch" id="batch">
                     <option value ="" disabled selected>Select Batch</option>
                     <option value="morning">Morning</option>
                     <option value="evening">Evening</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="batch_time">Batch Timings <span class="text-danger">*</span></label>
                  <select class="form-control" name="batch_time" id="batch_time">
                     <option value="" disabled selected>Select Batch Timing</option>
                     <option value="9:45 AM - 1:30 PM">9:45 AM - 1:30 PM</option>
                     <option value="2:15 PM - 6:00 PM">2:15 PM - 6:00 PM</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="submission_date">Date <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="submission_date" id="date">
               </div>
               <div class="form-group">
                  <label for="punch_in_time">Punch In Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_in_time" id="punch_in_time">
               </div>
               <div class="form-group">
                  <label for="punch_out_time">Punch Out Time <span class="text-danger">*</span></label>
                  <input type="time" class="form-control" name="punch_out_time" id="punch_out_time">
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary is_create_student_attendance">Update</button>
               </div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;">
               <img src="{{ url('public/admin/images/200w.gif') }}" /> 
            </div>
            <div class="student_attendance_responce"></div>
         </div>
      </div>
   </div>
</div>
<!--end student edit attendance modal-->
<script>
//Function for current time in punch Iin and punch out
function setCurrentTimeInIST() {
   //Get current time in IST
   var currentISTTime = new Date().toLocaleTimeString('en-US', {
      timeZone: 'Asia/Kolkata',
      hour12: false, 
      hour: '2-digit',
      minute: '2-digit'
   });
   //Set the current time for punch In
   document.getElementById('punch_in_time').value = currentISTTime;
   //Set the current time for punch Out
   document.getElementById('punch_out_time').value = currentISTTime;
}
//Set the current time when the page loads
window.onload = setCurrentTimeInIST;
</script>
@endsection