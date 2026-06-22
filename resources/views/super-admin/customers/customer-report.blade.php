@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="container py-4">
   <div class="header-bar d-flex justify-content-between align-items-center flex-wrap">
      <div>
         <h5 class="mb-0 fw-semibold text-dark">Employee
            <span class="separator mx-2">|</span>
            <i class="bi bi-house-door-fill"></i>
            <span class="text-muted">– Employee Report</span>
         </h5>
      </div>
   </div>
   <div class="row">
      <!--profile section-->
      <div class="col-md-4">
         <div class="profile-box">
            @if($employee_detail->user_pic)
               <img src="{{ url('public/uploads/employees/' . $employee_detail->user_pic) }}" alt="Profile" class="profile-img">
            @else 
               <img src="{{ url('public/uploads/users/default_user.png') }}" alt="Profile" class="profile-img">
            @endif
            <div class="name">{{ $employee_detail->name ?? '16091997' }}</div>
            <div class="info-group">Registration No<span class="info-label"></span><span class="info-value">{{ $employee_detail->unique_employee_id ?? '16091997' }}</span></div>
            <div class="info-group">Employee Role:<span class="info-label"></span><span class="info-value">{{ $employee_detail->employee_role ?? 'PHP Developer' }}</span></div>
            <div class="info-group">Monthly Salary:<span class="info-label"></span><span class="info-value">{{ $employee_detail->net_salary ?? '10,000' }}</span></div>
            <div class="info-group">Username:<span class="info-label"></span><span class="info-value">{{ $employee_detail->name ?? 'Thakur Singh' }}</span></div>
            <div class="info-group">Password:<span class="info-label"></span><span class="info-value">$2y$10$.ekZVAZQO</span></div>
            <br>

            <div class="info-group">Father/Husband Name:<span class="info-label"></span><span class="info-value">{{ $employee_detail->father_name ?? 'Testing' }}</span></div>
            <div class="info-group">Mobile:<span class="info-label"></span><span class="info-value">{{ $employee_detail->employee_phone_no ?? '82193-73976' }}</span></div>
            <div class="info-group">Email Address:<span class="info-label"></span><span class="info-value">{{ $employee_detail->email ?? 'kapoorthakur906@gmail.com' }}</span></div>
            <div class="info-group">Home Address:<span class="info-label"></span><span class="info-value">{{ $employee_detail->address ?? 'Chamba' }}</span></div>
            <div class="info-group">National ID:<span class="info-label"></span><span class="info-value">{{ $employee_detail->national_id ?? '1234567890' }}</span></div>
            <div class="info-group">Education:<span class="info-label"></span><span class="info-value">{{ $employee_detail->qualification ?? 'B.C.A' }}</span></div>
            <br>

            <div class="info-group">Gender:<span class="info-label"></span><span class="info-value">{{ $employee_detail->gender ?? 'Male' }}</span></div>
            <div class="info-group">Religion:<span class="info-label"></span><span class="info-value">{{ $employee_detail->religion ?? 'Hindu'}}</span></div>
            <div class="info-group">Blood Group:<span class="info-label"></span><span class="info-value">{{ $employee_detail->blood ?? 'B+' }}</span></div>
            <div class="info-group">Date Of Birth:<span class="info-label"></span><span class="info-value">{{ $employee_detail->dob ?? '16 Sep 1998' }}</span></div>
            <div class="info-group">Date of Joinig:<span class="info-label"></span><span class="info-value">{{ $employee_detail->joining_date ?? '10 June 2023' }}</span></div>
            <div class="info-group">Experience:<span class="info-label"></span><span class="info-value">{{ $employee_detail->experince ?? '5 Year' }}</span></div>
         </div>
      </div>
      <!--report sections-->
      <div class="col-md-8">
         <!--attendance report-->
         <div class="d-flex align-items-center mb-3">
            <span class="report-label me-2">1</span>
            <h5 class="mb-0 text-purple">Attendance Report</h5>
         </div>
         <div class="card p-4 mb-4">
            <div class="row text-center mb-4">
               <div class="col-md-6">
                  <div class="circle-box">
                     <div class="circle-box-inner">
                        <div class="circle-text-top">Overall</div>
                        <div class="circle-value">0%</div>
                     </div>
                  </div>
                  <span class="pill-status">Today: NOT MARKED</span>
               </div>
               <div class="col-md-6">
                  <div class="circle-box">
                     <div class="circle-box-inner">
                        <div class="circle-text-top">July 2025</div>
                        <div class="circle-value">0%</div>
                     </div>
                  </div>
                  <span class="pill-status">Yesterday: NOT MARKED</span>
               </div>
            </div>
            <div class="row text-center">
               <div class="col">
                  <div class="status-badge present-badge">
                     <p class="label">PRESENTS</p>
                     <p class="count">0</p>
                     <p class="text-muted small">This Month</p>
                  </div>
               </div>
               <div class="col">
                  <div class="status-badge leave-badge">
                     <p class="label">LEAVES</p>
                     <p class="count">0</p>
                     <p class="text-muted small">This Month</p>
                  </div>
               </div>
               <div class="col">
                  <div class="status-badge absent-badge">
                     <p class="label">ABSENTS</p>
                     <p class="count">1</p>
                     <p class="text-muted small">This Month</p>
                  </div>
               </div>
            </div>
         </div>
         <!--salary report-->
         <div class="d-flex align-items-center mb-3">
            <span class="report-label me-2">2</span>
            <h5 class="mb-0 text-purple">Salary Report</h5>
         </div>
         <div class="card p-4">
            <!--current + monthly-->
            <div class="row text-center mb-4">
               <div class="col">
                  <div class="attached-label-box">
                     <div class="attached-label">Current Salary</div>
                     <div class="attached-circle">
                        <i class="bi bi-currency-dollar me-1"></i> $1,222,323
                     </div>
                  </div>
               </div>
               <div class="col">
                  <div class="attached-label-box">
                     <div class="attached-label success">This Month</div>
                     <div class="attached-circle success">
                        <i class="bi bi-check-circle-fill me-1"></i> ✔ $96 RECEIVED
                     </div>
                  </div>
               </div>
            </div>
            <hr class="my-2">
           <div class="latest-salary-heading">Latest salary record</div>
            <!-- Salary Records -->
          <div class="table-responsive mb-4">
   <table class="table table-bordered align-middle shadow-sm" style="border-radius: 10px; overflow: hidden;">
      <thead class="table-light text-center">
         <tr>
            <th>Month</th>
            <th>Paid Date</th>
            <th>Amount</th>
            <th>Status</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td class="text-primary fw-semibold">June, 2025</td>
            <td class="text-muted">10/07/2025</td>
            <td class="fw-bold">
               ₹ 1500
            </td>
            <td>
               <span class="badge bg-success px-3 py-2 rounded-pill">
                  PAID <i class="bi bi-check-circle-fill ms-1"></i>
               </span>
            </td>
         </tr>
         <!-- Add more records below -->
      </tbody>
   </table>
</div>


         </div>
      </div>
   </div>
</div>
@endsection