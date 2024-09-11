@extends('employee.layouts.master')
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Personal Details</h2>
</div>
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
            <img src="{{ url('public/uploads/users/default_user.png')}}" alt="">
            @endif
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
         <p><em>Registration No: </em><span>{{ $get_employee_detail->unique_employee_id }}</span></p>
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
                  <td colspan="4">No accessories assigned to this employee.</td>
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
                  <td colspan="4">No damaged accessories recorded for this employee.</td>
               </tr>
               @endif
            </tbody>
         </table>
      </div>
      <!--end employee damage accessoriese-->
   </div>
   <!--end all employees table-->
</div>
@endsection