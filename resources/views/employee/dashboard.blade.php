@extends('employee.layouts.master')
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="space-remove"></div>
<!-- <div class="title-subheading">
   <h2>Personal Details</h2>
</div> -->
<div class="main-single-student">
   <div class="name-user">
      <div class="student-name">
         <div class="edit-student-detail">
            <li><a href="{{ url('employee/profile') }}"><i class="fa-solid fa-pencil"></i></a></li>
         </div>
         <div class="profile-user-popup">
            @if(isset($get_employee_detail->user_pic))
            <img src="{{ url('public/uploads/employees/'. $get_employee_detail->user_pic)}}" alt="">
            @else
            <img src="{{ url('public/uploads/employees/default_user.png')}}" alt="">
            @endif
         </div>
         <div class="student-attendance">
            <div class="box-pay">
               <button type="button" class="student-punch-in-buton employeet_punch_in_attendances" data-employee_id="{{ $get_employee_detail->id }}" data-employee_name="{{ $get_employee_detail->name }}" data-toggle="modal" data-target="#punchInModel">Punch in
            </div>
            <div class="box-pay">
               <button type="button" class="student-punch-out-buton employee_punch_out_attendance" data-employee_id="{{ $get_employee_detail->id }}" data-employee_name="{{ $get_employee_detail->name }}" data-toggle="modal" data-target="#punchOutModel">Punch Out
            </div>
         </div>
         <h3>{{ $get_employee_detail->name ?? '-' }}</h3>
         <p>{{ $get_employee_detail->employee_role ?? '-'}}</p>
         <p>{{ $get_employee_detail->email ?? '-' }}</p>
         <p>{{ substr($get_employee_detail->employee_phone_no, 0, 5) . '-' . substr($get_employee_detail->employee_phone_no, 5) }}</p>
         @if(isset($get_employee_detail->joining_date))
         <p><em>Joining Date:</em> {{ ($get_employee_detail->joining_date) ? Carbon::parse($get_employee_detail->joining_date)->format('d M Y') : '-' }}</p>
         @else
         -
         @endif
      </div>
      <div class="info-student">
         <h4>Information</h4>
      </div>
      <div class="detail-info">
         <p><em>Employee ID: </em><span>{{ $get_employee_detail->unique_employee_id }}</span></p>
         <p><em>Date of Birth:</em><span>{{ ($get_employee_detail->dob) ? Carbon::parse($get_employee_detail->dob)->format('d M Y') : '-' }}</span></p>
         <p><em>Sex: </em><span>{{ $get_employee_detail->gender ?? '-' }}</span></p>
         <p><em>Category: </em><span>{{ $get_employee_detail->category ?? '-' }}</span></p>
         <p><em>Aadhar Card No: </em><span>{{ $get_employee_detail->aadhaar_no ?? '-' }}</span></p>
         <p><em>Current Address: </em><span>{{ $get_employee_detail->address . ', ' . $get_employee_detail->district . ', ' . $get_employee_detail->state . ', ' . $get_employee_detail->pin_code }}</span></p>
      </div>
   </div>
   <!--start all employees table-->
   <div class="table-all">
      <!--start employee monthly salary table-->
      <div class="table-qualification">
         <label>Employee Monthly Salary Details</label>
         <div id="table-scroll" class="table-scroll first-table">
            <table id="main-table" class="main-table">
               <thead>
                  <tr>
                     <th>Sr. No.</th>
                     <th>Month</th>
                     <th>Increment Amount</th>
                     <th>Paid Amount</th>
                  </tr>
               </thead>
               <tbody class="scroll">
                  @php
                  $count = 1;
                  $total_paid_salary = 0;
                  $total_increment = 0;
                  @endphp
                  @foreach ($baseSalaries as $month => $baseSalary)
                  @php
                  $incrementAmount = $incrementsForMonth[$month] ?? 0;
                  $total_paid_salary += $baseSalary;
                  $total_increment += $incrementAmount;
                  @endphp
                  <tr>
                     <td>{{ $count++ }}.</td>
                     <td>{{ $month }}</td>
                     <td>{{ $incrementAmount > 0 ? number_format($incrementAmount) : '-' }}</td>
                     <td>{{ $baseSalary > 0 ? number_format($baseSalary) : '-' }}</td>
                  </tr>
                  @endforeach
               </tbody>
               <tfoot>
                  <tr class="tfooter">
                     <td class="space" colspan="3">
                        <span style="color: green;">
                        Total Paid Salary for the Year: {{ now()->year }}
                        </span>
                     </td>
                     <td><strong style="color: black;">{{ number_format($total_paid_salary) }}</strong></td>
                  </tr>
                  <tr class="tfooter">
                     <td class="space" colspan="3">
                        <span style="color: black;">
                        Total Net Salary:
                        </span>
                     </td>
                     <td><strong style="color: black;">{{ $get_employee_detail->net_salary > 0 ? number_format(base64_decode($get_employee_detail->net_salary)) : '-' }}</strong></td>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
      <!--end employee monthly salary table-->
      <!--start employee assign accessoriese-->
      <div class="table-qualification">
         <label>Assign Accessories Details</label>
         <table>
            <thead>
               <tr>
                  <th>Sr. No.</th>
                  <th>Keyboard</th>
                  <th>Mouse</th>
                  <th>Assign Accessories Date</th>
               </tr>
            </thead>
            <tbody>
               @if ($get_employee_assign_accessories->isNotEmpty())
               @php  $count = 1; @endphp
               @foreach ($get_employee_assign_accessories as $accessory)
               <tr>
                  <td>{{ $count++ }}.</td>
                  <td>{{ $accessory->keyboard_assigned }}</td>
                  <td>{{ $accessory->mouse_assigned }}</td>
                  <td>{{ Carbon::parse($accessory->created_at)->format('d M Y') }}</td>
               </tr>
               @endforeach
               @else
               <tr>
                  <td colspan="4">No accessories assigned.</td>
               </tr>
               @endif
            </tbody>
         </table>
      </div>
      <!--end employee assign accessoriese-->
      <!--start employee damage accessoriese-->
      <div class="table-qualification">
         <label>Damage Accessories Details</label>
         <table>
            <thead>
               <tr>
                  <th>Sr. No.</th>
                  <th>Keyboard</th>
                  <th>Mouse</th>
                  <th>Damage Accessories Date</th>
               </tr>
            </thead>
            <tbody>
               @if ($get_employee_damage_accessories->isNotEmpty())
               @php  $count = 1; @endphp
               @foreach ($get_employee_damage_accessories as $damage_accessory)
               <tr>
                  <td>{{ $count++ }}.</td>
                  <td>{{ $damage_accessory->keyboard_damaged }}</td>
                  <td>{{ $damage_accessory->mouse_damaged }}</td>
                  <td>{{ Carbon::parse($damage_accessory->created_at)->format('d M Y') }}</td>
               </tr>
               @endforeach
               @else
               <tr>
                  <td colspan="4">No damaged accessories.</td>
               </tr>
               @endif
            </tbody>
         </table>
      </div>
      <!--end employee damage accessoriese-->
        <!--start employee punch in attendance modal-->
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
                        <input type="hidden" id="model_employee_id" name="employee_id" value="" />
                        <div class="form-group">
                           <label for="attendanceStatus">Attendance Status <span class="text-danger">*</span></label>
                           <select class="form-control" name="attendance_status" id="attendanceStatus">
                              <option value ="" disabled selected>Select Status</option>
                              <option value="present">Present</option>
                              <option value="half_day">Half Day</option>
                              <option value="absent">Absent</option>
                              <option value="leave">Leave</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="sift">Shift<span class="text-danger">*</span></label>
                           <select class="form-control" name="sift" id="sift">
                              <option value ="" disabled selected>Select Batch</option>
                              <option value="Morning">Morning</option>
                              <option value="Evening">Evening</option>
                              <option value="Night">Night</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="shiftType">Shift Type <span class="text-danger">*</span></label>
                           <select class="form-control" name="sift_type" id="sift_type">
                              <option value ="" disabled selected>Select type</option>
                              <option value="full_day">Full Day</option>
                              <option value="half_day">Half Day</option>
                              <option value="quarter_day">Quarter Day</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="punch_in_time">Punch In Time <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="punch_in_time" id="punch_in_time">
                        </div>
                        <!-- <div class="form-group">
                           <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="punch_out_time" id="punchOutTime">
                        </div> -->
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary is_create_employee_punch_in_attendance">Submit</button>
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
         <!--end employee punch in attendance modal-->
         <!--start employee punch out attendance modal-->
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
                        <input type="hidden" id="model_punch_out_employee_id" name="employee_id" value="" />
                        <div class="form-group">
                           <label for="punchOutTime">Punch Out Time <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="punch_out_time" id="punch_out_time">
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary is_update_employee_punch_out_attendance">Submit</button>
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
         <!--end employee punch out attendance modal-->
   </div>
   <!--end all employees table-->
</div>
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