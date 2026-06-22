@extends('admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
@if (Session::has('success'))
<div class="notification-green"><p>{{ Session::get('success') }}</p></div>
@endif
@if (Session::has('unsuccess'))
<div class="notification-red"><p>{{ Session::get('unsuccess') }}</p></div>
@endif

{{-- Header --}}
<div class="dash-header">
   <div class="dash-header-left">
      <h2>Overview</h2>
      <span class="dash-period-badge" id="periodBadge">{{ $periodLabel }}</span>
   </div>
   <div class="btn-pixxeluss">
      <a href="{{ url('admin/add-new-inquery') }}">
         <img src="{{ url('public/admin/images/pluse.svg') }}" alt="Add"> Add New Inquery
      </a>
   </div>
</div>

{{-- Filter Bar --}}
<div class="dash-filter-bar">
   <form id="dashboardFilterForm" method="GET" action="{{ url('admin/dashboard') }}" class="dash-filter-form">
      <div class="filter-tabs">
         <button type="button" class="filter-tab {{ $filterType === 'year' ? 'active' : '' }}" data-filter="year">
            <i class="bi bi-calendar3"></i> Year
         </button>
         <button type="button" class="filter-tab {{ $filterType === 'month' ? 'active' : '' }}" data-filter="month">
            <i class="bi bi-calendar-month"></i> Month
         </button>
         <button type="button" class="filter-tab {{ $filterType === 'week' ? 'active' : '' }}" data-filter="week">
            <i class="bi bi-calendar-week"></i> Week
         </button>
      </div>
      <input type="hidden" name="filter_type" id="filterTypeInput" value="{{ $filterType }}">

      <div class="filter-selects">
         <div class="filter-group">
            <label for="yearSelect">Year</label>
            <select name="year" id="yearSelect" class="dash-select">
               @foreach($availableYears as $yr)
                  <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
               @endforeach
            </select>
         </div>

         <div class="filter-group filter-month-group {{ $filterType !== 'month' ? 'hidden' : '' }}">
            <label for="monthSelect">Month</label>
            <select name="month" id="monthSelect" class="dash-select">
               @foreach($availableMonths as $num => $name)
                  <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
               @endforeach
            </select>
         </div>

         <div class="filter-group filter-week-group {{ $filterType !== 'week' ? 'hidden' : '' }}">
            <label for="weekSelect">Week</label>
            <select name="week" id="weekSelect" class="dash-select">
               @foreach($availableWeeks as $num => $label)
                  <option value="{{ $num }}" {{ $selectedWeek == $num ? 'selected' : '' }}>{{ $label }}</option>
               @endforeach
            </select>
         </div>

         <button type="submit" class="dash-apply-btn">
            <i class="bi bi-funnel"></i> Apply Filter
         </button>
      </div>
   </form>
</div>

{{-- Stats Section --}}
<div class="overview-section">
   <div class="overview-cards">
      <div class="stat-card stat-card-hover">
         <div class="stat-header">
            <span class="stat-title">
               <span class="icon-box icon-blue"><img src="{{ url('public/admin/images/Vector (1).png') }}" alt=""></span>
               Overall Total Fees
            </span>
            <span class="stat-value" id="statTotalFees">₹ {{ number_format($all_students_total_fees) }}</span>
         </div>
         <div class="stat-footer stat-footer-muted">All active students</div>
      </div>

      <div class="stat-card stat-card-hover">
         <div class="stat-header">
            <span class="stat-title">
               <span class="icon-box icon-green"><img src="{{ url('public/admin/images/paid_fees.png') }}" alt=""></span>
               Overall Paid Fees
            </span>
            <span class="stat-value">₹ {{ number_format($all_students_paid_fees) }}</span>
         </div>
         <div class="stat-footer">
            <span class="{{ $paidFeesChange >= 0 ? 'trend-up' : 'trend-down' }}">
               {{ number_format(abs($paidFeesChange), 1) }}% {{ $paidFeesChange >= 0 ? '↑' : '↓' }}
            </span> vs last week
         </div>
      </div>

      <div class="stat-card stat-card-hover">
         <div class="stat-header">
            <span class="stat-title">
               <span class="icon-box icon-red"><img src="{{ url('public/admin/images/pending.png') }}" alt=""></span>
               Overall Pending Fees
            </span>
            @php $pending = $all_students_total_fees - $all_students_paid_fees; @endphp
            <span class="stat-value">₹ {{ number_format($pending) }}</span>
         </div>
         <div class="stat-footer stat-footer-muted">Outstanding balance</div>
      </div>

      <div class="stat-card stat-card-hover stat-card-accent">
         <div class="stat-header">
            <span class="stat-title">
               <span class="icon-box icon-purple"><img src="{{ url('public/admin/images/fi_2567567.png') }}" alt=""></span>
               <span id="periodPaidLabel">Paid Fees ({{ $periodLabel }})</span>
            </span>
            <span class="stat-value" id="statPeriodPaid">₹ {{ number_format($periodPaidFees) }}</span>
         </div>
         <div class="stat-footer" id="statPaymentBreakdown">
            <span class="pay-tag pay-online"><i class="bi bi-credit-card"></i> Online: ₹ {{ number_format($payment_type_online) }}</span>
            <span class="pay-tag pay-cash"><i class="bi bi-cash"></i> Cash: ₹ {{ number_format($payment_type_cash) }}</span>
         </div>
      </div>
   </div>

   <div class="students-box">
      <h3 class="students-header">
         <span class="icon-box icon-gray"><img src="{{ url('public/admin/images/students.png') }}" alt=""></span>
         Total Students
         <span class="students-total">{{ $is_total_students }}</span>
      </h3>
      <div class="students-list">
         <p><span>Web Designing</span><span class="course-count">{{ $is_web_designing_students }}</span></p>
         <p><span>Web Development</span><span class="course-count">{{ $is_web_development_students }}</span></p>
         <p><span>Php Development</span><span class="course-count">{{ $is_php }}</span></p>
         <p><span>Full Stack Development</span><span class="course-count">{{ $is_full_stack_development }}</span></p>
         <p><span>Digital Marketing</span><span class="course-count">{{ $digital_marketing }}</span></p>
         <p><span>Graphic</span><span class="course-count">{{ $is_graphic }}</span></p>
      </div>
      <div class="period-enrollment">
         <i class="bi bi-person-plus"></i>
         <span>New enrollments in period: <strong id="statEnrollments">{{ $periodEnrollments }}</strong></span>
      </div>
   </div>
</div>

{{-- Charts --}}
<div class="chart-section">
   <div class="chart-card">
      <div class="chart-card-header">
         <h4>Fee Summary</h4>
         <span class="chart-subtitle" id="chartFeeSubtitle">{{ $periodLabel }}</span>
      </div>
      <div id="students_monthly_fees_detail"></div>
   </div>
   <div class="chart-card">
      <div class="chart-card-header">
         <h4>Enrollments</h4>
         <span class="chart-subtitle">{{ $selectedYear }}</span>
      </div>
      <div id="total_students_detail"></div>
   </div>
</div>

{{-- Table --}}
<div class="main-table dash-table-wrap">
   <div class="dash-table-top">
      <div class="dash-table-title">
         <h6>Students Fees List</h6>
         <span class="table-period" id="tablePeriodLabel">{{ $periodLabel }}</span>
         <span class="table-count">{{ $get_student_list->count() }} records</span>
      </div>
      <div class="dash-table-actions">
         <a href="{{ url('admin/all-stocks-list') }}" class="dash-action-btn"><i class="bi bi-box-seam"></i> Stock</a>
         <a href="{{ url('students-fees-paid') }}" class="dash-action-btn"><i class="bi bi-check-circle"></i> Paid</a>
         <a href="{{ url('students-pending-fees') }}" class="dash-action-btn"><i class="bi bi-clock"></i> Pending</a>
         <a href="{{ url('students-overdue-fees') }}" class="dash-action-btn dash-action-warn"><i class="bi bi-exclamation-circle"></i> Overdue</a>
      </div>
   </div>

   <div class="dash-table-body">
      <table id="dashboardStudentsTable" class="dash-student-table">
         <thead>
            <tr>
               <th>#</th>
               <th>Student</th>
               <th>Phone</th>
               <th>Joined</th>
               <th>Course</th>
               <th>Paid Fees</th>
               <th>Receipt</th>
            </tr>
         </thead>
         <tbody>
            @php $count = 1; @endphp
            @forelse($get_student_list as $student)
            @php
               $courseClass = match($student->course_type) {
                  'Full Stack Development' => 'course-blue',
                  'PHP Development' => 'course-green',
                  'Web Development' => 'course-yellow',
                  'Web Designing' => 'course-pink',
                  'Digital Marketing' => 'course-orange',
                  'Graphic Designing' => 'course-cyan',
                  default => 'course-default',
               };
               $total_fees = $student->student_fees_detail->sum('user_fees');
            @endphp
            <tr>
               <td class="col-num">{{ $count++ }}</td>
               <td class="col-student">
                  <div class="student-cell">
                     <div class="student-avatar">
                        @if($student->user_pic)
                           <img src="{{ url('public/uploads/users/' . $student->user_pic) }}" alt="">
                        @else
                           <img src="{{ url('public/uploads/users/default_user.png') }}" alt="">
                        @endif
                     </div>
                     <div class="student-info">
                        <a href="#" class="student-link" data-student_id="{{ $student->id }}" onclick="openNav(); return false;">{{ $student->name }}</a>
                        <span class="student-id">ID: {{ $student->id }}</span>
                     </div>
                  </div>
               </td>
               <td class="col-phone">
                  @if($student->student_phone_no)
                     <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $student->student_phone_no) }}" target="_blank" class="phone-link">
                        {{ substr($student->student_phone_no, 0, 5) }}-{{ substr($student->student_phone_no, 5) }}
                     </a>
                  @else
                     <span class="text-muted-dash">—</span>
                  @endif
               </td>
               <td class="col-date">{{ \Carbon\Carbon::parse($student->course_joining_date)->format('d M Y') }}</td>
               <td class="col-course"><span class="course-pill {{ $courseClass }}">{{ $student->course_type ?: '—' }}</span></td>
               <td class="col-fees">
                  <span class="fee-amount">₹ {{ number_format($total_fees) }}</span>
                  @if($student->student_fees_detail->first())
                     <span class="fee-date">{{ \Carbon\Carbon::parse($student->student_fees_detail->first()->submission_date)->format('d M, Y') }}</span>
                  @endif
               </td>
               <td class="col-receipt">
                  <a href="{{ url('admin/download-receipt/' . $student->id) }}" target="_blank" class="receipt-btn" title="Download Receipt">
                     <i class="fas fa-download"></i>
                  </a>
               </td>
            </tr>
            @empty
            <tr><td colspan="7" class="no-data">No fee records found for this period.</td></tr>
            @endforelse
         </tbody>
      </table>
   </div>
</div>

{{-- Student Detail Overlay --}}
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

const FILTER_TYPE = @json($filterType);
const MONTHLY_FEES = @json($monthlyFees);
const WEEK_CHART = @json($weekChartData);
const MONTH_CHART = @json($monthChartData);
const ENROLLMENT_DATA = @json($enrollmentData);
const ENROLLMENT_YEARS = @json(array_values($enrollmentYears));

const MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const SELECTED_YEAR = @json($selectedYear);

const simpleChartTheme = {
   chart: { backgroundColor: 'transparent', style: { fontFamily: 'Overpass, sans-serif' } },
   credits: { enabled: false },
   title: { text: null },
   legend: { enabled: false },
   xAxis: { lineColor: '#e8e8e8', tickColor: '#e8e8e8', labels: { style: { color: '#888', fontSize: '11px' } } },
   yAxis: { gridLineColor: '#f0f0f0', title: { text: null }, labels: { style: { color: '#888', fontSize: '11px' } } },
   tooltip: { backgroundColor: '#191919', borderWidth: 0, borderRadius: 8, style: { color: '#fff', fontSize: '12px' } }
};

document.addEventListener('DOMContentLoaded', function () {
   document.querySelectorAll('.filter-tab').forEach(tab => {
      tab.addEventListener('click', function () {
         document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
         this.classList.add('active');
         const type = this.dataset.filter;
         document.getElementById('filterTypeInput').value = type;
         document.querySelector('.filter-month-group').classList.toggle('hidden', type !== 'month');
         document.querySelector('.filter-week-group').classList.toggle('hidden', type !== 'week');
      });
   });

   let feeCategories, feeData;
   if (FILTER_TYPE === 'week' && WEEK_CHART.length) {
      feeCategories = WEEK_CHART.map(d => d.label);
      feeData = WEEK_CHART.map(d => d.amount);
   } else if (FILTER_TYPE === 'month' && MONTH_CHART.length) {
      feeCategories = MONTH_CHART.map(d => d.label);
      feeData = MONTH_CHART.map(d => d.amount);
   } else {
      feeCategories = MONTHS;
      feeData = MONTHLY_FEES;
   }

   window.feeChart = Highcharts.chart('students_monthly_fees_detail', {
      ...simpleChartTheme,
      chart: { ...simpleChartTheme.chart, type: 'column', height: 280 },
      xAxis: { ...simpleChartTheme.xAxis, categories: feeCategories },
      yAxis: { ...simpleChartTheme.yAxis, min: 0 },
      tooltip: { ...simpleChartTheme.tooltip, valuePrefix: '₹ ' },
      plotOptions: { column: { borderRadius: 4, borderWidth: 0, color: '#DC4A26', pointPadding: 0.15 } },
      series: [{ name: 'Fees', data: feeData }]
   });

   const yearEnrollments = ENROLLMENT_DATA[SELECTED_YEAR] || [];
   Highcharts.chart('total_students_detail', {
      ...simpleChartTheme,
      chart: { ...simpleChartTheme.chart, type: 'areaspline', height: 280 },
      xAxis: { ...simpleChartTheme.xAxis, categories: MONTHS },
      yAxis: { ...simpleChartTheme.yAxis, min: 0, allowDecimals: false },
      tooltip: { ...simpleChartTheme.tooltip, valueSuffix: ' students' },
      plotOptions: {
         areaspline: {
            fillColor: { linearGradient: { x1:0,y1:0,x2:0,y2:1 }, stops: [[0,'rgba(220,74,38,0.25)'],[1,'rgba(220,74,38,0.02)']] },
            lineWidth: 2, color: '#DC4A26', marker: { enabled: false }
         }
      },
      series: [{ name: 'Enrollments ' + SELECTED_YEAR, data: yearEnrollments }]
   });

   if ($.fn.DataTable && $('#dashboardStudentsTable').length) {
      $('#dashboardStudentsTable').DataTable({
         pageLength: 10,
         lengthChange: false,
         order: [],
         language: { search: '', searchPlaceholder: 'Search students...' },
         dom: '<"dash-dt-toolbar"f>rt<"dash-dt-footer"ip>'
      });
   }
});
</script>
@endsection
