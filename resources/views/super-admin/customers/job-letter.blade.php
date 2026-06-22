@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
@include('notification')
<div class="container my-4">
   <!--header-->
   <div class="header-bar d-flex justify-content-between align-items-center flex-wrap">
      <div>
         <h5 class="mb-0 fw-semibold text-dark">
            Employee
            <span class="separator mx-2">|</span>
               <i class="bi bi-house-door-fill"></i>
            <span class="text-muted">– Job Letter</span>
         </h5>
      </div>
   </div>
   <!--job card-->
   <div class="job-card mt-4">
      <!--print button(top right)-->
      <div class="print-btn-wrapper">
         <a href="{{ url('super-admin/job-letter-print/' . $employee_detail->id) }}" target="_blank" class="btn btn-job-letter">
            <i class="bi bi-printer-fill me-1"></i> Print Job Letter
         </a>
      </div>
      <!--profile-->
      <div class="job-card-section job-profile">
         @if($employee_detail->user_pic)
            <img src="{{ url('public/uploads/employees/' . $employee_detail->user_pic) }}" alt="Employee">
         @else
            <img src="{{ url('public/uploads/users/default_user.png') }}" alt="Employee">
         @endif
         <div class="employee-name">{{ $employee_detail->name ?? 'Kapoor' }}</div>
      </div>
      <!--left info-->
      <div class="job-card-section">
         <div class="job-info">
            <span class="label">Registration/ID</span>
            <div class="arrow-row">
               <i class="bi bi-arrow-return-right"></i>
               <div class="value">{{ $employee_detail->unique_employee_id ??'177213' }}</div>
            </div>
         </div>
         <div class="job-info">
            <span class="label">Employee Role</span>
            <div class="arrow-row">
               <i class="bi bi-arrow-return-right"></i>
               <div class="value">{{ $employee_detail->employee_role ?? 'Accountant' }}</div>
            </div>
         </div>
         <div class="job-info">
            <span class="label">Date of Joining</span>
            <div class="arrow-row">
               <i class="bi bi-arrow-return-right"></i>
               <div class="value">{{ \Carbon\Carbon::parse($employee_detail->joining_date ?? '2025-07-07')->format('d F, Y') }}</div>
            </div>
         </div>
         <div class="job-info">
            <span class="label">Account Status</span>
            <div class="arrow-row">
               <i class="bi bi-arrow-return-right"></i>
               <span class="status-active">✔ {{ $employee_detail->user_status ?? 'Active' }}</span>
            </div>
         </div>
      </div>
      <!--right info-->
      <div class="job-card-section">
         <div class="job-info">
            <span class="label">Portal URL</span>
            <div class="arrow-row">
               <i class="bi bi-arrow-return-right"></i>
               <div class="value">pixxelu/signin</div>
            </div>
         </div>
         <div class="job-info">
            <span class="label">Username</span>
            <div class="arrow-row">
               <i class="bi bi-arrow-return-right"></i>
               <div class="value">{{ $employee_detail->name ?? '125764ogj93177210' }}</div>
            </div>
         </div>
         <div class="job-info">
            <span class="label">Password</span>
            <div class="arrow-row">
               <i class="bi bi-arrow-return-right"></i>
               <div class="value">$2y$10$.ekZVAZQO</div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection