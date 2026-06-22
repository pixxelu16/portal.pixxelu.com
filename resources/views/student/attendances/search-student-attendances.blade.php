@extends('student.layouts.master')
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
         <h2>Search My Attendance</h2>
         <span class="portal-attendance-period">{{ $periodLabel }}</span>
      </div>
   </div>
   @include('admin.partials.attendance-stats')
</div>

<div class="portal-listing portal-attendance-listing">
   <form action="{{ url('student/search-attendance') }}" method="GET" class="portal-attendance-filters">
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
      <span><img src="{{ url('public/admin/images/sunday.svg') }}" alt=""> Sunday</span>
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
            @php $count = 1; @endphp
            @if($get_student_detail->isNotEmpty() && $get_student_detail->first()->student_attendance_detail->count() > 0)
               @foreach ($get_student_detail as $student)
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
                     $isSunday = in_array($day, $sundays);
                     $isAlternativeSaturday = in_array($day, $alternativeSaturdays);
                     $isHoliday = $isSunday || $isAlternativeSaturday;
                  @endphp
                  <td class="att-day-col">
                     <div class="att-cell">
                        @if ($isHoliday)
                           @if ($isSunday)
                              <img class="att-icon" src="{{ url('public/admin/images/sunday.svg') }}" alt="Sun">
                           @else
                              <img class="att-icon" src="{{ url('public/admin/images/saturday.svg') }}" alt="Sat">
                           @endif
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
               @endforeach
            @else
               <tr>
                  <td colspan="{{ count($days) + 4 }}" class="portal-no-data">No attendance records found for the selected month and year.</td>
               </tr>
            @endif
         </tbody>
      </table>
   </div>
</div>
@endsection
