@extends('student.layouts.master')
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
   <h2>Search Attendances</h2>
   </div>
</div>
<form action="{{ url('student/search-attendance') }}" method="GET">
   <!--start search filter-->
   <div class="row search-student-attendance">
      <!-- <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus">
             <input type="text" class="form-control" name="name" id="name" 
                 value="{{ request()->input('name') }}" placeholder="Enter Your Name">
         </div>
         </div> -->
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
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
            <select class="select floating" name="year">
               <option value="">Select Year</option>
               @for ($i = date('Y'); $i >= 2023; $i--)
               <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
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
               <th>Registration ID</th>
               <th>Image</th>
               <th>Name</th>
               <th>Batch</th>
               <th>Batch Timing</th>
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
            @forelse ($get_student_detail as $student)
            <tr>
               <td>{{ $count++ }}.</td>
               <td>{{ $student->id }}</td>
               <td data-th="Image">
                  @if($student->user_pic)
                  <div class="user-image">
                     <img src="{{ url('public/uploads/users/'. $student->user_pic) }}" alt="">
                  </div>
                  @else
                  <img src="{{ url('public/uploads/users/default_user.png') }}" alt="">
                  @endif
               </td>
               <td>{{ $student->name }}</td>
               <td>{{ $student['student_attendance_detail']['0']['batch'] ?? '-'}}</td>
               <td class="batch-time">{{ $student['student_attendance_detail'][0]['batch_time'] ?? '-'}}</td>
               @foreach ($days as $day)
               @php
               $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
               $attendance = $student->student_attendance_detail->first(function ($att) use ($date) {
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
                  <p class="duration">{{ $formattedDuration ?? 'N/A' }}</p>
                  @elseif ($attendance->attendance_status == 'absent')
                  <img src="{{ url('public/admin/images/absent_icon.svg') }}" alt="Absent">
                  @elseif ($attendance->attendance_status == 'leave')
                  <img src="{{ url('public/admin/images/leave_icon.svg') }}" alt="Leave">
                  @elseif ($attendance->attendance_status == 'half_day')
                  <img src="{{ url('public/admin/images/half_day_leave.svg') }}" alt="Half Day">
                  @endif
                  @else
                  <img src="{{ url('public/admin/images/absent_icon.svg') }}" alt="Absent">
                  @endif
                  @endif
               </td>
               @endforeach
            </tr>
            @empty
            <tr>
               <td colspan="{{ count($days) + 6 }}" class="text-center">No Student found</td>
            </tr>
            @endforelse
         </tbody>
         </table>
      </div>
   </div>
</div>
@endsection



