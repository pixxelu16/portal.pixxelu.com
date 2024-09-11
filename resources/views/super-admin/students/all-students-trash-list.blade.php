@extends('super-admin.layouts.master')
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
   <h2>All Trash Students List</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-trash-back">
         <a href="{{ url('admin/all-students-list') }}">
         <span class="login-arrow">
         <i class="fa fa-arrow-left" style="margin-right: 5px;" aria-hidden="true"></i>Back
         </span>
         </a>
      </div>
   </div>
   <div class="scrolling-data-table" style="margin-inline: 10px;">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr  class="sticky">
                  <th>S. No</th>
                  <th>Student ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Course</th>
                  <th>Course Duration</th>
                  <th>Total Fees</th>
                  <th>Last Paid Fees</th>
                  <th>Pending Fees</th>
                  <th>Status</th>
                  <!-- <th>Action</th> -->
               </tr>
            </thead>
            <tbody>
               @php 
               $count = 1;
               use Carbon\Carbon;
               $currentMonth = Carbon::now()->month;
               $currentYear = Carbon::now()->year;
               @endphp

               @foreach($get_students_detail as $student)
               @php 
               $total_fees = $student->total_fees;
               $pay_fees = 0;
               @endphp
               
               @if(isset($student->student_fees_detail)) 
               @foreach($student->student_fees_detail as $fees)
               @php 
               $total_fees = $student->total_fees;
               $pay_fees  += $fees['user_fees'];
               $submissionMonths[] = Carbon::parse($fees['submission_date'])->month;
               @endphp
               @endforeach 
               @endif     
               <tr>
                  <td>{{ $count++ }}</td>
                  <td>{{ $student->id }} </td>
                  <td data-th="Image">
                     @if($student->user_pic)
                     <div class="user-image"> <img src = "{{ url('public/uploads/users/'. $student->user_pic)}}" alt=""></div>
                     @endif 
                  </td>
                  <td>{{ $student->name }}</td>
                  <td><a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $student->student_phone_no) }}" target="_blank">{{ substr($student->student_phone_no, 0, 5) }}-{{ substr($student->student_phone_no, 5) }}</a></td>
                  <td>{{ \Carbon\Carbon::parse($student->course_joining_date)->format('d M Y') }}</td>
                  @if($student->course_type == 'Full Stack Development') 
                    <td class="lights-blue-color"><span>Full Stack Development</span></td>
                  @elseif($student->course_type == 'PHP Development')
                    <td class="lights-green-color"><span>PHP Development</span></td>
                  @elseif($student->course_type == 'Web Development')
                    <td class="light-yellow-color"><span>Web Development</span></td>
                  @elseif($student->course_type == 'Web Designing')
                    <td class="light-pink-color"><span>Web Designing</span></td>
                  @elseif($student->course_type == 'Graphic Designing')
                    <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  @else
                    <td></td>
                  @endif
                  <td>{{ $student->course_duration }}</td>
                  <td>
                     Rs {{ number_format($student->total_fees) }}
                     <!-- <div class="box-pay">
                        <button type="button" class="pay-fes-buton student_pay_fees" data-student_id="{{ $student->id }}" data-toggle="modal" data-target="#myModal">Pay Fee</button>
                        </div> -->
                  </td>
                  <td>
                     @if(isset($student->student_fees_detail))
                     @php
                     $get_last_submit_fees = collect($student->student_fees_detail)->sortByDesc(function ($fee) {
                     });
                     //Get the last paid fee
                     $lastPaidFee = $get_last_submit_fees->first();
                     @endphp
                     @if($lastPaidFee)
                     Rs {{ number_format($lastPaidFee['user_fees']) }}<br>
                     <span class="date-tbl">{{ Carbon::parse($lastPaidFee['submission_date'])->format('d M Y') }}</span>
                     @endif
                     @endif
                  </td>
                  <td>Rs {{ number_format($total_fees - $pay_fees) }}</td>
                  @if($student->user_status == 'Active') 
                  <td class="green-color"><span>Active</span></td>
                  @elseif($student->user_status == 'Pending')
                  <td class="red-color"><span>Pending</span></td>
                  @elseif($student->user_status == 'Suspend')
                  <td class="purple-color"><span>Suspend</span></td>
                  @elseif($student->user_status == 'Completed')
                  <td class="green-color"><span>Complete</span></td>
                  @elseif($student->user_status == 'Leave')
                  <td class="red-color"><span>Leave</span></td>
                  @else
                  <td></td>
                  @endif
                  <!-- @php
                     $isPending = false;
                     if (isset($student->student_fees_detail)) {
                        foreach ($student->student_fees_detail as $fees) {
                              $submissionMonth = Carbon::parse($fees['submission_date'])->format('m');
                              $submissionYear = Carbon::parse($fees['submission_date'])->format('Y');                          
                              if ($submissionMonth == $currentMonth && $submissionYear == $currentYear && !is_null($fees['user_fees'])) {
                                 $isPending = true;
                                 break;
                              }
                        }
                     }
                     @endphp
                     @if(!$isPending)
                     <td class="red-color"><span>Pending</span></td>
                     @else
                     <td class="green-color"><span>Paid</span></td>
                     @endif -->
                  <!-- <td>
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <img src="{{ url('public/admin/images/ellips.svg') }}" alt="ellips" /> </button>
                        <ul class="dropdown-menu pay-fees-submit">
                           <form class="drop-don-list">
                               <li> 
                                 <a href="{{ url('admin/single-student-detail', $student->id) }}"><img src="{{ url('public/admin/images/ico-1.png') }}">View Student Detail</a>
                                 </li> -->
                              <!-- <li><a href="{{ url('super-admin/edit-student', $student->id) }}"><img src="{{ url('public/admin/images/ico-4.png') }}">Edit</a></li>  -->
                              <!-- <li><button type="submit" class="is_delete_student_record" data-id="{{ $student->id }}"><img src="{{ url('public/admin/images/ico-5.png') }}">Delete</button></li>
                           </form>
                        </ul>
                     </div>
                  </td> -->
               </tr>
               @endforeach 
            </tbody>
         </table>
      </div>
      <div class="modal fade pay-modal" id="myModal" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Pay Fees</h4>
               </div>
               <div class="modal-body">
                  <form action="#" id="is_create_student_fee" Method="POST">
                     <input id="model_student_id" type="hidden" value="" name="student_id">
                     <input type="text" id="fees_amount" name="fees_amount" placeholder="Amount"/>                     
                     <select name="payment_type" id="payment_type">
                        <option value="">Payment Type</option>
                        <option value="online">Online</option>
                        <option value="cash">Cash</option>
                     </select>
                     <select name="first_payment_type" id="first_payment_type">
                        <option value="">First Payment Type</option>
                        <option value="down_payment">Down Payment</option>
                        <option value="monthly">Monthly</option>
                     </select>
                     <div class="button-save"><button type="submit" class="disable-submit">Save</button></div>
                  </form>
                  <div class="loader com_ajax_loader" style="display:none;">
                     <img src="{{ url('public/admin/images/200w.gif') }}" /> 
                  </div>
               </div>
               <div class="student_fee_responce"></div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection