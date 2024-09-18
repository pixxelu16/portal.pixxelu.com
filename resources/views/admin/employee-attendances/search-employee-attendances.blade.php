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
   <div class ="search-header">
    <h2 class="attendance-header">Search Employee Attendance List</h2>
   </div>
   <!--start employee attendance boxes-->
   <div class="boxes-wrapper student-attendance-header">
      <div class="box">
         <img src="{{ url('public/admin/images/working_hours.svg') }}" alt="Working Hours">
         <h3>Working Hours</h3>
         <p>{{ number_format($total_present_hours, 2) }} Hrs</p>
      </div>
      <div class="box">
         <img src="{{ url('public/admin/images/present_icon.svg') }}" alt="Present">
         <h3>Presents</h3>
         <p>{{ $total_present_days }}</p>
      </div>
      <div class="box">
         <img src="{{ url('public/admin/images/absent_icon.svg') }}" alt="Absent">
         <h3>Absent</h3>
         <p>{{ $total_absent_days }}</p>
      </div>
      <div class="box">
         <img src="{{ url('public/admin/images/leave_icon.svg') }}" alt="Leave">
         <h3>Leave</h3>
         <p>{{ $total_leave_days }}</p>
      </div>
      <div class="box">
         <img src="{{ url('public/admin/images/half_day_leave.svg') }}" alt="Half Day">
         <h3>Half Day</h3>
         <p>{{ $total_half_day }}</p>
      </div>
      <div class="box">
         <img src="{{ url('public/admin/images/holiday.svg') }}" alt="Holidays">
         <h3>Holidays</h3>
         <p>{{ $total_holidays }}</p>
      </div>
      <div class="box">
         <img src="{{ url('public/admin/images/total_days_in_month.svg') }}" alt="daysInMonth">
         <h3>Days in month</h3>
         <p>{{ $daysInMonth }}</p>
      </div>
   </div>
   <!--end employee attendance boxes-->
</div>
<!--start search filter-->
<form action="{{ url('admin/search-employee-attendance') }}" method="GET">
   <div class="row search-all-students-attendance">
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus">
            <select class="select floating" name="employee_name">
               <option value="">Select Employee Name</option>
               @foreach ($get_employee_name as $employee)
               <option value="{{$employee->name}}" {{request()->input('employee_name') === $employee->name ? 'selected="selected"' : ''}}>{{$employee->name}}</option>
               @endforeach
            </select>
         </div>
      </div>
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
            <select class="select floating" name="month">
               <option value="">Select Month</option>
               @foreach ($months as $key => $name)
               <option value="{{ $key }}" {{ request()->input('month') == $key ? 'selected' : '' }}>
               {{ $name }}
               </option>
               @endforeach
            </select>
         </div>
      </div>
      @php
      $currentYear = date('Y');
      $startYear = 2023; 
      @endphp
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
            <select class="select floating" name="year">
               <option value="">Select Year</option>
               @for ($i = $currentYear; $i >= $startYear; $i--)
               <option value="{{ $i }}" {{ request()->input('year') == $i ? 'selected' : '' }}>
               {{ $i }}
               </option>
               @endfor
            </select>
         </div>
      </div>
      <div class="col-sm-6 col-md-3">
         <div class="d-grid">
            <input type="submit" class="btn btn-success" value="Search" />   
         </div>
      </div>
   </div>
</form>
<!--end search filter-->
<div class="row">
   <div class="col-lg-12">
      <div class="table-responsive">
         <table class="table table-striped custom-table table-nowrap mb-0">
            <thead>
               <tr>
                  <th>Sr No.</th>
                  <th>Employee ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Sift</th>
                  <th>Sift Type</th>
                  @foreach ($days as $day)
                  @php
                  $date = \Carbon\Carbon::create($year, $month, $day);
                  $dayOfWeek = $date->format('D'); 
                  $dayNumber = $date->format('d'); 
                  $isSunday = $dayOfWeek === 'Sun';
                  $isLastSaturday = $dayOfWeek === 'Sat' && $day == $lastSaturday;
                  @endphp
                  <th class="{{ $isSunday ? 'text-danger' : ($isLastSaturday ? 'text-primary' : '') }}">
                     {{ $dayNumber }} {{ $dayOfWeek }}
                  </th>
                  @endforeach
               </tr>
            </thead>
            <tbody>
               @php
               $count = 1;
               @endphp
               @forelse ($get_employee_detail as $employee)
               <tr>
                  <td>{{ $count++ }}.</td>
                  <td>{{ $employee->unique_employee_id }}</td>
                  <td data-th="Image">
                     @if($employee->user_pic)
                     <div class="user-image">
                        <img src="{{ url('public/uploads/employees/'. $employee->user_pic) }}" alt="">
                     </div>
                     @else
                     <img src="{{ url('public/uploads/employees/default_user.png') }}" alt="">
                     @endif
                  </td>
                  <td>{{ $employee->name }}</td>
                  <td>{{ $employee['employees_attendance_detail']['0']['sift'] ?? '-'}}</td>
                  <td class="batch-time">{{ $employee['employees_attendance_detail'][0]['sift_type'] ?? '-'}}</td>
                  @foreach ($days as $day)
                  @php
                  $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                  $attendance = $employee->employees_attendance_detail->first(function ($att) use ($date) {
                  return \Carbon\Carbon::parse($att->created_at)->format('Y-m-d') === $date;
                  });
                  $punchIn = null;
                  $punchOut = null;
                  $formattedDuration = null;

                  if ($attendance) {
                     $punchIn = \Carbon\Carbon::parse($attendance->punch_in_time);
                     $punchOut = $attendance->punch_out_time ? \Carbon\Carbon::parse($attendance->punch_out_time) : null;
                     if ($punchOut) {
                        $duration = $punchIn->diff($punchOut);
                        $hours = $duration->h;
                        $minutes = $duration->i;
                        $formattedDuration = sprintf('%d:%02d Hrs', $hours, $minutes);
                     }
                  }
                  
                  $isSunday = in_array($day, $sundays);
                  $isLastSaturday = $day == $lastSaturday;
                  @endphp
                  <td>
                     <!--show holiday icon-->
                     @if ($isSunday)
                     <img src="{{ url('public/admin/images/sunday.svg') }}" alt="Holiday">
                     @elseif ($isLastSaturday)
                     <img src="{{ url('public/admin/images/saturday.svg') }}" alt="Holiday">
                     @else
                     @if ($attendance)
                     @if ($attendance->attendance_status == 'present')
                     <img src="{{ url('public/admin/images/present_icon.svg') }}" alt="Present">
                     <p class="student-attendance-duration">{{ $formattedDuration ?? 'N/A' }}</p>
                     @elseif ($attendance->attendance_status == 'absent')
                     <img src="{{ url('public/admin/images/absent_icon.svg') }}" alt="Absent">
                     @elseif ($attendance->attendance_status == 'leave')
                     <img src="{{ url('public/admin/images/leave_icon.svg') }}" alt="Leave">
                     @elseif ($attendance->attendance_status == 'half_day')
                     <img src="{{ url('public/admin/images/half_day_leave.svg') }}" alt="Half Day">
                     @endif
                     @else
                     @endif
                     @endif
                  </td>
                  @endforeach
               </tr>
               @empty
               <tr>
                  <td colspan="{{ count($days) + 6 }}" class="text-center">No attendance found</td>
               </tr>
               @endforelse
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection