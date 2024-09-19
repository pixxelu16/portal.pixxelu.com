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
   <h2>Search Students List According Fees</h2>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!--start filter student acc status fees-->
         <select name="fees_status" id="search_student_fees_status" class="search-student-list">
            <option value ="" disabled selected>Monthly Fees Status</option>
            <option value="Paid">Paid</option>
            <option value="Pending">Pending</option>
            <option value="Overdue">Overdue</option>
         </select>
         <!--end filter student acc status fees-->
         <!--start filter student acc course-->
         <select name="course_type" id="search_student_list" class="search-student-list">
            <option value ="" disabled selected>Select Course Type</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Web Development">Web Development</option>
            <option value="PHP Development">PHP Development</option>
            <option value="Digital Marketing">Digital Marketing</option>
            <option value="Full Stack Development">Full Stack Development</option>
            <option value="Graphic">Graphic</option>
         </select>
         <!--end filter student acc to course-->
         <!--export students monthly paid fees list -->
         <a href="{{ route('admin.export.paid.fees') }}" class="export"><img src="{{ url('public/admin/images/csv-file.svg') }}">Paid</a>
         <!--export students monthly pending fees list -->
         <a href="{{ route('admin.export.pending.fees') }}" class="export"><img src="{{ url('public/admin/images/csv-file.svg') }}">Pending</a>
         <a href="{{ url('admin/all-students-trash-list') }}" class="export"><img src="{{ url('public/admin/images/trash.svg') }}"></a>
         <a href="{{ url('admin/add-new-student') }}"><img src="{{ url('public/admin/images/pluse.svg') }}">Add New Student</a>
         <!--<a href="{{ url('admin/add-student-previous-fees') }}" class="add-pervious"><img src="{{ url('public/admin/images/pluse.svg') }}">Add Previous Fees</a>-->
      </div>
   </div>
   <div class="scrolling-data-table">
      <div class="card-body">
      <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr class="">
                  <th>S. No</th>
                  <th>Registration ID</th>
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
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @php 
                  $count = 1;
                  use Carbon\Carbon;
                  $currentMonth = Carbon::now()->month;
                  $currentYear = Carbon::now()->year;
               @endphp
               @foreach($get_students_list as $student)
                  @php 
                     $total_fees = $student->total_fees;
                     $pay_fees = 0;
                     @endphp
                     @if(isset($student->student_fees_detail))
                  @foreach($student->student_fees_detail as $fees)
                     @php 
                        $total_fees = $student->total_fees;
                        $pay_fees += $fees['user_fees'];
                        $submissionMonths[] = Carbon::parse($fees['submission_date'])->month;
                     @endphp
                  @endforeach 
               @endif                 
               <tr>
                  <td>{{ $count++ }}</td>
                  <td>{{ $student->id }} </td>
                  <td data-th="Image">
                     @if($student->user_pic)
                     <div class="user-image"> <img src="{{ url('public/uploads/users/' . $student->user_pic)}}" alt="">
                     @else
                     <img src="{{ url('public/uploads/users/default_user.png') }}" alt="">
                     </div>
                     @endif                           
                  </td>
                  <td>
                     <span onclick="openNav()"><a href="#" class="student-link"
                        data-student_id="{{ $student->id }}">{{ $student->name }}</a></span>
                  </td>
                  <td>
                     @if($student->student_phone_no)
                     <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $student->student_phone_no) }}"
                        target="_blank">
                     {{ substr($student->student_phone_no, 0, 5) }}-{{ substr($student->student_phone_no, 5) }}
                     </a>
                     @else
                     -
                     @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($student->course_joining_date)->format('d M Y') }}</td>
                  @if($student->course_type == 'Full Stack Development')
                  <td class="lights-blue-color"><span>Full Stack Development</span></td>
                  @elseif($student->course_type == 'PHP Development')
                  <td class="lights-green-color"><span>PHP Development</span></td>
                  @elseif($student->course_type == 'Web Development')
                  <td class="light-yellow-color"><span>Web Development</span></td>
                  @elseif($student->course_type == 'Digital Marketing')
                  <td class="light-organge-color"><span>Digital Marketing</span></td>
                  @elseif($student->course_type == 'Web Designing')
                  <td class="light-pink-color"><span>Web Designing</span></td>
                  @elseif($student->course_type == 'Graphic Designing')
                  <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  @else
                  <td></td>
                  @endif
                  <td>{{ $student->course_duration }}</td>
                   @if($student->total_fees)
                  <td>
                     Rs {{ number_format($student->total_fees) }} 
                     <div class="box-pay">
                        <button type="button" class="pay-fes-buton student_pay_fees"
                           data-student_id="{{ $student->id }}" data-student_name="{{ $student->name }}" data-toggle="modal" data-target="#myModal">Pay
                        Fee</button>
                     </div>
                  </td>
                  @else
                  <td>N/A</td>
                  @endif
                  <td>
                     @if(isset($student->student_fees_detail))
                     @php      $last_record = $student->student_fees_detail->last(); @endphp
                     @if($last_record)
                     Rs {{ number_format($last_record->user_fees) }}<br>
                     <span class="date-tbl">{{ Carbon::parse($last_record->submission_date)->format('d M Y') }}</span>
                     @else
                     -<br>
                     @endif
                     @endif
                  </td>
                  <td>
                  @if($pay_fees == 0)
                     -
                  @else
                     Rs {{ number_format($total_fees - $pay_fees) }}
                  @endif
               </td>

                  @php
                     $isPaid = false;
                     $isPending = false;
                     $isOverdue = false;
                     $lastPaymentDate = null;
                     $noPayment = true;
                     $payment_completed = false;

                     if (isset($student->student_fees_detail)) {
                     foreach ($student->student_fees_detail as $fees) {
                     $submissionMonth = Carbon::parse($fees['submission_date'])->format('m');
                     $submissionYear = Carbon::parse($fees['submission_date'])->format('Y');
                     $lastPaymentDate = Carbon::parse($fees['submission_date']);

                     //Check if the fees for the current month and year are paid
                     if ($submissionMonth == $currentMonth && $submissionYear == $currentYear && !is_null($fees['user_fees'])) {
                        $isPaid = true;
                        break;
                     }
                     }

                     //Check if the last payment date is more than 45 days ago
                     if ($lastPaymentDate && $lastPaymentDate->diffInDays(Carbon::now()) > 45) {
                         $isOverdue = true;
                        } else {
                         $isPending = !$isPaid;
                        }
                     } 

                     //check user total fees
                     if (!empty($student->total_fees) && $student->total_fees !== 0)  {
                        $noPayment = false;
                     }

                  //check user fees completed or not
                  if (isset($student->total_fees) && $student->total_fees == $pay_fees) {
                     $payment_completed = true;
                  }
                  @endphp
                  @if($noPayment == true)
                  <td>-</td>
                  @elseif($isOverdue)
                  <td class="yellow-color"><span>Overdue</span></td>
                  @elseif($isPending)
                  <td class="red-color"><span>Pending</span></td>
                  @elseif($payment_completed)
                  <td class="ligth-green-color"><span>Fees Complete</span></td>
                  @else
                  <td class="green-colors"><span>Paid</span></td>
                  @endif
                  <td>
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle action-fee-design" type="button"
                           data-bs-toggle="dropdown" aria-expanded="false"> <img
                           src="{{ url('public/admin/images/ellips.svg') }}" alt="ellips" /> </button>
                        <ul class="dropdown-menu pay-fees-submit">
                           <form class="drop-don-list">
                              <li>
                                 <!-- <a href="{{ url('admin/single-student-detail', $student->id) }}"><img src="{{ url('public/admin/images/ico-1.png') }}">View Student Detail</a> -->
                              </li>
                              <li><a href="{{ url('admin/edit-student', $student->id) }}"><img
                                 src="{{ url('public/admin/images/ico-4.png') }}">Edit</a></li>
                              <!-- <li><button type="submit" class="is_trash_student_record" data-id="{{ $student->id }}"><img src="{{ url('public/admin/images/ico-5.png') }}">Trash</button></li> -->
                              <li class="student_trash_record" data-student_id="{{ $student->id }}">
                                 <img src="{{ url('public/admin/images/ico-5.png') }}" alt="Trash Icon"> Trash
                              </li>
                           </form>
                        </ul>
                     </div>
                  </td>
               </tr>
               @endforeach 
            </tbody>
         </table>
      </div>
      <!--start student pay fees model-->
      <div class="modal fade pay-modal" id="myModal" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title"><span class="student_name_pay_fees"></span>Wants to pay fees</h4>
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
   <!--end student pay fees model-->
   <!--start student trash model-->
   <div class="modal" id="modeal_student_id" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modals-header">
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="modal-title">Trash student record</h4>
            </div>
            <div class="modal-body">
               <form action="#" id="trash_student_form" Method="POST">
                  <input id="trash_student_id" type="hidden" value="" name="student_id">                   
                  <p>Please select your student status</p>
                  <input type="radio" id="Leave" name="user_status" value="Leave">
                  <label for="leave">Due to some reason student leave.</label><br>
                  <input type="radio" id="Completed" name="user_status" value="Completed">
                  <label for="completed">Student course are completed.</label><br>
                  <div class="button-saves"><button type="submit" class="disable-submit is_delete_trash_record">Save</button></div>
               </form>
               <div class="loader com_ajax_loader" style="display:none;">
                  <img src="{{ url('public/admin/images/200w.gif') }}" /> 
               </div>
            </div>
            <div class="trash_responce"></div>
         </div>
      </div>
   </div>
  <!--end student trash model-->
</div>
</div>
</div>
</div>
<div id="myNav" class="overlay hide">
   <div class="overlay-content">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loader com_ajax_loaders" style="display: none;">
         <img src="{{ url('public/admin/images/index.svg') }}" />
      </div>
      <div class="student_detail_response"></div>
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


