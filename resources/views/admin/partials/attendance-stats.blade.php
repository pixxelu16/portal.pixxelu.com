<div class="portal-stats portal-attendance-stats">
   <div class="portal-stat-card portal-stat-featured">
      <div class="portal-stat-top">
         <div class="portal-stat-icon stat-icon-blue"><i class="bi bi-clock-history"></i></div>
      </div>
      <div class="portal-stat-body">
         <p class="portal-stat-value">{{ number_format($total_present_hours, 1) }}</p>
         <h3>Working Hours</h3>
      </div>
   </div>
   <div class="portal-stat-card">
      <div class="portal-stat-top">
         <div class="portal-stat-icon stat-icon-green"><i class="bi bi-check-circle"></i></div>
      </div>
      <div class="portal-stat-body">
         <p class="portal-stat-value">{{ $total_present_days }}</p>
         <h3>Present</h3>
      </div>
   </div>
   <div class="portal-stat-card {{ $total_absent_days == 0 ? 'portal-stat-zero' : '' }}">
      <div class="portal-stat-top">
         <div class="portal-stat-icon stat-icon-orange"><i class="bi bi-x-circle"></i></div>
      </div>
      <div class="portal-stat-body">
         <p class="portal-stat-value">{{ $total_absent_days }}</p>
         <h3>Absent</h3>
      </div>
   </div>
   <div class="portal-stat-card {{ $total_leave_days == 0 ? 'portal-stat-zero' : '' }}">
      <div class="portal-stat-top">
         <div class="portal-stat-icon stat-icon-yellow"><i class="bi bi-calendar-x"></i></div>
      </div>
      <div class="portal-stat-body">
         <p class="portal-stat-value">{{ $total_leave_days }}</p>
         <h3>Leave</h3>
      </div>
   </div>
   <div class="portal-stat-card {{ $total_half_day == 0 ? 'portal-stat-zero' : '' }}">
      <div class="portal-stat-top">
         <div class="portal-stat-icon stat-icon-purple"><i class="bi bi-calendar2-minus"></i></div>
      </div>
      <div class="portal-stat-body">
         <p class="portal-stat-value">{{ $total_half_day }}</p>
         <h3>Half Day</h3>
      </div>
   </div>
   <div class="portal-stat-card">
      <div class="portal-stat-top">
         <div class="portal-stat-icon stat-icon-teal"><i class="bi bi-sun"></i></div>
      </div>
      <div class="portal-stat-body">
         <p class="portal-stat-value">{{ $total_holidays }}</p>
         <h3>Holidays</h3>
      </div>
   </div>
   <div class="portal-stat-card">
      <div class="portal-stat-top">
         <div class="portal-stat-icon stat-icon-pink"><i class="bi bi-calendar3"></i></div>
      </div>
      <div class="portal-stat-body">
         <p class="portal-stat-value">{{ $daysInMonth }}</p>
         <h3>Days in Month</h3>
      </div>
   </div>
</div>
