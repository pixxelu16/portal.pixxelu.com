@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   @include('admin.partials.page-alerts')

   <div class="portal-stats portal-stats-compact">
      <div class="portal-stat-card portal-stat-featured">
         <div class="portal-stat-top">
            <div class="portal-stat-icon stat-icon-teal"><i class="bi bi-briefcase-fill"></i></div>
            <span class="portal-stat-tag">Internship</span>
         </div>
         <div class="portal-stat-body">
            <p class="portal-stat-value">{{ $is_total_interns }}</p>
            <h3>Total Interns</h3>
         </div>
      </div>
   </div>

   <div class="portal-page-header">
      <div>
         <h2>Internships</h2>
         <p class="portal-page-sub">Manage internship enrollments & records</p>
      </div>
      <span class="portal-record-count">{{ $get_interns_detail->count() }} active</span>
   </div>
</div>

<div class="portal-listing">
   <div class="portal-listing-toolbar">
      <div class="portal-listing-toolbar-left"></div>
      <div class="portal-listing-toolbar-right">
         <a href="{{ url('super-admin/add-new-intern') }}" class="portal-btn-primary"><i class="bi bi-plus-lg"></i> Add Intern</a>
      </div>
   </div>

   <div class="portal-listing-body portal-table-scroll">
      <table id="portalListingTable" class="portal-table portal-table-students">
         <thead>
            <tr>
               <th>#</th>
               <th>Intern</th>
               <th>Contact</th>
               <th>Course</th>
               <th>Fees Summary</th>
               <th>This Month</th>
               <th>Status</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            @php
               $count = 1;
               use Carbon\Carbon;
               $currentMonth = Carbon::now()->month;
               $currentYear = Carbon::now()->year;
            @endphp
            @foreach($get_interns_detail as $student)
            @php
               $pay_fees = 0;
               if (isset($student->student_fees_detail)) {
                  foreach ($student->student_fees_detail as $fees) {
                     $pay_fees += $fees['user_fees'];
                  }
               }
               $total_fees = $student->total_fees ?? 0;
               $pending_fees = $total_fees - $pay_fees;

               $coursePill = match($student->course_type) {
                  'Full Stack Development' => 'portal-pill-blue',
                  'PHP Development'        => 'portal-pill-green',
                  'Web Development'        => 'portal-pill-yellow',
                  'Web Designing'          => 'portal-pill-pink',
                  'Digital Marketing'      => 'portal-pill-orange',
                  'Graphic Designing'      => 'portal-pill-cyan',
                  'Graphic'                => 'portal-pill-cyan',
                  default                  => 'portal-pill-gray',
               };

               $monthPaid = 0;
               $monthPaidDate = null;
               if (isset($student->student_fees_detail) && $student->student_fees_detail->isNotEmpty()) {
                  $currentMonthPayments = $student->student_fees_detail->filter(function ($record) use ($currentMonth, $currentYear) {
                     $d = Carbon::parse($record->submission_date);
                     return $d->month == $currentMonth && $d->year == $currentYear
                        && in_array($record->payment_type, ['cash', 'online']);
                  });
                  foreach ($currentMonthPayments as $payment) {
                     $monthPaid += $payment->user_fees;
                     $monthPaidDate = $payment->submission_date;
                  }
               }

               $isPaid = false;
               $isPending = false;
               $isOverdue = false;
               $lastPaymentDate = null;
               $noPayment = empty($total_fees) || $total_fees == 0;
               $payment_completed = false;

               if (isset($student->student_fees_detail)) {
                  foreach ($student->student_fees_detail as $fees) {
                     $submissionMonth = Carbon::parse($fees['submission_date'])->format('m');
                     $submissionYear = Carbon::parse($fees['submission_date'])->format('Y');
                     $lastPaymentDate = Carbon::parse($fees['submission_date']);
                     if ($submissionMonth == $currentMonth && $submissionYear == $currentYear && !is_null($fees['user_fees'])) {
                        $isPaid = true;
                        break;
                     }
                  }
                  if ($total_fees == $pay_fees) {
                     $payment_completed = true;
                  } elseif ($lastPaymentDate && $lastPaymentDate->diffInDays(Carbon::now()) > 45 && $total_fees !== $pay_fees) {
                     $isOverdue = true;
                  } else {
                     $isPending = !$isPaid;
                  }
               }

               if ($noPayment) {
                  $statusBadge = 'portal-badge-muted'; $statusLabel = 'N/A';
               } elseif ($isOverdue) {
                  $statusBadge = 'portal-badge-warning'; $statusLabel = 'Overdue';
               } elseif ($isPending) {
                  $statusBadge = 'portal-badge-danger'; $statusLabel = 'Pending';
               } elseif ($payment_completed) {
                  $statusBadge = 'portal-badge-success'; $statusLabel = 'Complete';
               } else {
                  $statusBadge = 'portal-badge-success'; $statusLabel = 'Paid';
               }
            @endphp
            <tr>
               <td class="col-num">{{ $count++ }}</td>
               <td>
                  <div class="portal-person">
                     <div class="portal-avatar">
                        @if($student->user_pic)
                           <img src="{{ url('public/uploads/users/' . $student->user_pic) }}" alt="">
                        @else
                           <img src="{{ url('public/uploads/users/default_user.png') }}" alt="">
                        @endif
                     </div>
                     <div class="portal-person-info">
                        <a href="#" class="portal-person-name student-link" data-student_id="{{ $student->id }}" onclick="openNav(); return false;">{{ $student->name }}</a>
                        <span class="portal-person-meta">Reg #{{ $student->id }} · Intern · Joined {{ Carbon::parse($student->course_joining_date)->format('d M Y') }}</span>
                     </div>
                  </div>
               </td>
               <td>
                  @if($student->student_phone_no)
                     <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $student->student_phone_no) }}" target="_blank" class="portal-phone">
                        <i class="bi bi-whatsapp"></i>
                        {{ substr($student->student_phone_no, 0, 5) }}-{{ substr($student->student_phone_no, 5) }}
                     </a>
                  @else
                     <span class="portal-muted">—</span>
                  @endif
               </td>
               <td>
                  <span class="portal-pill {{ $coursePill }}">{{ $student->course_type ?: '—' }}</span>
                  @if($student->course_duration)
                     <span class="portal-duration">{{ $student->course_duration }}</span>
                  @endif
               </td>
               <td>
                  <div class="portal-fees-stack">
                     @if($total_fees)
                        <div class="portal-fees-row">
                           <span class="portal-fees-label">Total</span>
                           <span class="portal-fee-amount">₹ {{ number_format($total_fees) }}</span>
                        </div>
                        <div class="portal-fees-row">
                           <span class="portal-fees-label">Pending</span>
                           <span class="portal-fees-pending">₹ {{ number_format(max(0, $pending_fees)) }}</span>
                        </div>
                        <button type="button" class="portal-btn-sm portal-btn-sm-pay student_pay_fees pay-fes-buton"
                           data-student_id="{{ $student->id }}" data-student_name="{{ $student->name }}"
                           data-toggle="modal" data-target="#myModal">
                           <i class="bi bi-cash-coin"></i> Pay Fee
                        </button>
                     @else
                        <span class="portal-muted">N/A</span>
                     @endif
                  </div>
               </td>
               <td>
                  @if($monthPaid > 0)
                     <span class="portal-fee-amount">₹ {{ number_format($monthPaid) }}</span>
                     <span class="portal-fee-date">{{ Carbon::parse($monthPaidDate)->format('d M Y') }}</span>
                  @else
                     <span class="portal-muted">—</span>
                  @endif
               </td>
               <td><span class="portal-badge {{ $statusBadge }}">{{ $statusLabel }}</span></td>
               <td>
                  <div class="portal-row-actions">
                     <a href="{{ url('super-admin/download-receipt/' . $student->id) }}" target="_blank" class="portal-icon-btn portal-icon-download" title="Download Receipt">
                        <i class="bi bi-download"></i>
                     </a>
                     <a href="{{ url('super-admin/edit-intern', $student->id) }}" class="portal-icon-btn portal-icon-edit" title="Edit">
                        <i class="bi bi-pencil"></i>
                     </a>
                     <button type="button" class="portal-icon-btn portal-icon-danger student_trash_record" data-student_id="{{ $student->id }}" title="Move to Trash">
                        <i class="bi bi-trash3"></i>
                     </button>
                  </div>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>

{{-- Pay Fees Modal --}}
<div class="modal fade pay-modal" id="myModal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span class="student_name_pay_fees"></span> — Pay Fees</h4>
         </div>
         <div class="modal-body">
            <form action="{{ url('super-admin/submit-student-fees') }}" id="is_create_student_fee" method="POST" novalidate>
               @csrf
               <input id="model_student_id" type="hidden" value="" name="student_id">
               <input type="text" id="fees_amount" name="fees_amount" placeholder="Amount" class="form-control mb-2" />
               <select name="payment_type" id="payment_type" class="form-control mb-2">
                  <option value="">Payment Type</option>
                  <option value="online">Online</option>
                  <option value="cash">Cash</option>
               </select>
               <select name="first_payment_type" id="first_payment_type" class="form-control mb-2">
                  <option value="">First Payment Type (Optional)</option>
                  <option value="down_payment">Down Payment</option>
                  <option value="monthly">Monthly</option>
               </select>
               <div class="button-save"><button type="button" class="disable-submit portal-btn-primary is_submit_student_fee">Save Payment</button></div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;"><img src="{{ url('public/admin/images/200w.gif') }}" /></div>
         </div>
         <div class="student_fee_responce"></div>
      </div>
   </div>
</div>

{{-- Trash Modal --}}
<div class="modal" id="modeal_student_id" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header-trash">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Move to Trash</h4>
         </div>
         <div class="modal-body">
            <form action="#" id="trash_student_form" Method="POST">
               <input id="trash_student_id" type="hidden" value="" name="student_id">
               <p>Select reason:</p>
               <div class="portal-radio-group">
                  <label><input type="radio" name="user_status" value="Leave"> Student left the course</label>
                  <label><input type="radio" name="user_status" value="Completed"> Course completed</label>
               </div>
               <div class="button-saves mt-3"><button type="submit" class="disable-submit is_delete_trash_record portal-btn-primary">Confirm</button></div>
            </form>
            <div class="loader com_ajax_loader" style="display:none;"><img src="{{ url('public/admin/images/200w.gif') }}" /></div>
         </div>
         <div class="trash_responce"></div>
      </div>
   </div>
</div>

<div id="myNav" class="overlay hide">
   <div class="overlay-content">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loader com_ajax_loaders" style="display: none;"><img src="{{ url('public/admin/images/index.svg') }}" /></div>
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
