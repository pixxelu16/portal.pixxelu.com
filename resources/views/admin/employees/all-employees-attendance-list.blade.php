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
   <h2>All Employee Attendance Listing</h2>
</div>
<form action="{{ url('admin/search-employee-attendance') }}" method="GET">
   <!-- Search Filter -->
   <div class="row filter-row">
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus">
            <select class="select floating" name="employee_name">
               <option value="">Select Employee Name</option>
               @foreach ($get_all_employees_list as $employee)
               <option value="{{ $employee->name }}">{{ $employee->name }}</option>
               @endforeach
            </select>
         </div>
      </div>
      <div class="col-sm-6 col-md-3">
         <div class="input-block mb-3 form-focus select-focus">
         <select class="select floating" name="month">
            <option value="">Select Month</option>
            @foreach ($months as $key => $name)
               <option value="{{ $key }}" {{ \Carbon\Carbon::now()->format('m') === $key ? 'selected' : '' }}>
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
<!-- /Search Filter -->
<div class="row">
   <div class="col-lg-12">
      <div class="table-responsive">
         <table class="table table-striped custom-table table-nowrap mb-0">
            <thead>
               <tr>
                  <th>Sr No.</th>
                  <th>Employee ID</th>
                  <th>Image</th>
                  <th>Employee Name</th>
                  @foreach ($days as $day)
                  <th>{{ $day }}</th>
                  @endforeach
               </tr>
            </thead>
            <tbody>
    @php
        $count = 1;
    @endphp
    @forelse ($get_all_employees_list as $employee)
    <tr>
        <td>{{ $count++ }}.</td>
        <td>{{ $employee->unique_employee_id }}</td>
        <td data-th="Image">
            @if($employee->user_pic)
            <div class="user-image"> <img src="{{ url('public/uploads/employees/'. $employee->user_pic) }}" alt=""></div>
            @endif 
        </td>
        <td>{{ $employee->name }}</td>
        @foreach ($days as $day)
        @php
            // Get the current date for the looped day
            $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');

            // Get attendance detail for the specific date
            $attendance = $employee->employees_attendance_detail->first(function ($att) use ($date) {
                return \Carbon\Carbon::parse($att->created_at)->format('Y-m-d') === $date;
            });

            // Get punch-in and punch-out times and duration
            $punchIn = null;
            $punchOut = null;
            $formattedDuration = null;

            // Check if attendance exists
            if ($attendance) {
                $punchIn = \Carbon\Carbon::parse($attendance->punch_in_time);
                $punchOut = $attendance->punch_out_time ? \Carbon\Carbon::parse($attendance->punch_out_time) : null;
          
                if ($punchOut) {
                    // Calculate duration
                    $duration = $punchIn->diff($punchOut);
                    $hours = $duration->h;
                    $minutes = $duration->i;

                    // Format duration
                    $formattedDuration = sprintf('%d:%02d Hours', $hours, $minutes);
                }
            }
        @endphp
        <td>
            @if ($attendance)
            @if ($attendance->attendance_status == 'present')
            <img src="{{ url('public/admin/images/present_icon.svg') }}" alt="">
            <p>{{ $formattedDuration ?? 'N/A' }}</p>
            @elseif ($attendance->attendance_status == 'absent')
            <img src="{{ url('public/admin/images/absent_icon.svg') }}" alt="">
            @elseif ($attendance->attendance_status == 'leave')
            <img src="{{ url('public/admin/images/leave_icon.svg') }}" alt="">
            @elseif ($attendance->attendance_status == 'half_day')
            <img src="{{ url('public/admin/images/half_day_leave.svg') }}" alt="">
            @endif
            @else
            -
            @endif
        </td>
        @endforeach
    </tr>
    @empty
    <tr>
        <td colspan="{{ count($days) + 1 }}" class="text-center">No employees found</td>
    </tr>
    @endforelse
</tbody>

         </table>
      </div>
   </div>
</div>
@endsection