<nav class="sidebar-modern">
   <div class="sidebar-brand">
      <a href="{{ url('admin/dashboard') }}" class="logo-link">
         <img src="{{ url('public/admin/images/pixelu_icon.png') }}" alt="Pixxelu Logo">
      </a>
   </div>
   <div class="menu-items">
      <ul class="nav-links">
         <li class="{{ request()->is('admin/dashboard') || Request::is('admin/all-stocks-list') || Request::is('admin/add-new-stock') || Request::is('admin/add-new-inquery') ? 'active' : '' }}">
            <a href="{{ url('admin/dashboard') }}">
               <img src="{{ url('public/admin/images/dashboard.svg') }}" alt="dashboard" />
               <span class="link-name">
                  Overview
               </span>
            </a>
         </li>
         <li class="{{ request()->is('admin/all-employees-list') || Request::is('admin/search-employees-list/*') ? 'active' : '' }}">
            <a href="{{ url('admin/all-employees-list') }}">
               <img src="{{ url('public/admin/images/staff.svg') }}" alt="staff" />
               <span class="link-name">
                  All Employees
               </span>
            </a>
         </li>
         <li class="{{ request()->is('admin/all-students-list') || Request::is('admin/search-students-fees-list/*') || Request::is('admin/search-students-list/*') || Request::is('admin/add-new-student') || Request::is('admin/all-students-trash-list') || Request::is('admin/edit-student/*') ? 'active' : '' }}">
            <a href="{{ url('admin/all-students-list') }}">
               <img src="{{ url('public/admin/images/student.svg') }}" alt="student" />
               <span class="link-name">
                  All Students
               </span>
            </a>
         </li>
         <li class="{{ request()->is('admin/all-internships-list') || Request::is('admin/add-new-intern') || Request::is('admin/edit-intern/*') ? 'active' : '' }}">
            <a href="{{ url('admin/all-internships-list') }}">
               <img src="{{ url('public/admin/images/student.svg') }}" alt="internship" />
               <span class="link-name">
                  Internship
               </span>
            </a>
         </li>
         <li class="sidebar-submenu-wrap {{ request()->is('admin/all-employees-attendance-list') || request()->is('admin/search-employee-attendance') || request()->is('admin/all-students-attendance-list') || request()->is('admin/search-student-attendance') ? 'open active' : '' }}">
            <a href="#" class="sidebar-submenu-toggle" aria-expanded="{{ request()->is('admin/all-employees-attendance-list') || request()->is('admin/search-employee-attendance') || request()->is('admin/all-students-attendance-list') || request()->is('admin/search-student-attendance') ? 'true' : 'false' }}">
               <img src="{{ url('public/admin/images/attendance.svg') }}" alt="attendance"/>
               <span class="link-name">Attendances</span>
               <i class="bi bi-chevron-down submenu-arrow"></i>
            </a>
            <ul class="sidebar-submenu">
               <li class="{{ request()->is('admin/all-employees-attendance-list') || request()->is('admin/search-employee-attendance') ? 'active' : '' }}">
                  <a href="{{ url('admin/all-employees-attendance-list') }}">Employees</a>
               </li>
               <li class="{{ request()->is('admin/all-students-attendance-list') || request()->is('admin/search-student-attendance') ? 'active' : '' }}">
                  <a href="{{ url('admin/all-students-attendance-list') }}">Students</a>
               </li>
            </ul>
         </li>
         <li class="{{ request()->is('admin/all-inqueries-list') || Request::is('admin/search-inquery/*') || Request::is('admin/search-inquery-course-type/*') || Request::is('admin/all-converted-inqueries-list') || Request::is('admin/edit-inquery/*') ? 'active' : '' }}">
            <a href="{{ url('admin/all-inqueries-list') }}">
               <img src="{{ url('public/admin/images/all_inquries.svg') }}" alt="inqueries" />
               <span class="link-name">
                  All Inqueries
               </span>
            </a>
         </li>
      </ul>
      <ul class="logout-mode">
         <li class="{{ request()->is('admin/help') ? 'active' : '' }}">
            <a href="#">
               <img src="{{ url('public/admin/images/help.svg') }}" alt="leads" />
               <span class="link-name">
                  Help
               </span>
            </a>
         </li>
         <li class="{{ request()->is('admin/setting') || Request::is('admin/profile') || Request::is('admin/change-password') ? 'active' : '' }}">
            <a href="{{ url('admin/setting') }}">
               <img src="{{ url('public/admin/images/setting.svg') }}" alt="leads" />
               <span class="link-name">
                  Settings
               </span>
            </a>
         </li>
         <li class="nav-item logout-item">
            <a class="logout-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
               <img src="{{ url('public/admin/images/logout.svg') }}" alt="logout" />
               {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
            </form>
         </li>
         <li class="mode">
            <a href="#">
               <i class="uil uil-moon"></i>
               <span class="link-name">
                  Dark Mode
               </span>
            </a>
            <div class="mode-toggle">
               <span class="switch"></span>
            </div>
         </li>
      </ul>
   </div>
</nav>
<script>
document.querySelectorAll('.sidebar-submenu-toggle').forEach(function(toggle) {
   toggle.addEventListener('click', function(e) {
      e.preventDefault();
      var wrap = this.closest('.sidebar-submenu-wrap');
      var isOpen = wrap.classList.contains('open');
      document.querySelectorAll('.sidebar-submenu-wrap.open').forEach(function(el) {
         if (el !== wrap) {
            el.classList.remove('open');
            el.querySelector('.sidebar-submenu-toggle').setAttribute('aria-expanded', 'false');
         }
      });
      wrap.classList.toggle('open', !isOpen);
      this.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
   });
});
</script>