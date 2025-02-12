<nav>
   <div class="logo-name">
      <div class="logo-image">
         <i class="uil uil-bars sidebar-toggle"><img src="{{ url('public/admin/images/Menu.svg') }}" alt=""></i> 
      </div>
   </div>
   <div class="menu-items">
      <ul class="nav-links">
         <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ url('admin/dashboard') }}">
            <img src="{{ url('public/admin/images/dashboard.svg') }}" alt="dashboard" />
            <span class="link-name">Dashboard</span>
            </a>
         </li>
         <li class="{{ request()->is('admin/all-students-list') || Request::is('admin/edit-student/*') ? 'active' : '' }}">
            <a href="{{ url('admin/all-students-list') }}">
            <img src="{{ url('public/admin/images/student.svg') }}" alt="student" />
            <span class="link-name">All Students</span>
            </a>
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->is('admin/all-employees-attendance-list') || request()->is('admin/all-students-attendance-list') ? 'active' : '' }}" 
               href="#" id="attendanceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ url('public/admin/images/attendance.svg') }}" alt="attendance"/>
            <span class="link-name">Attendances</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="attendanceDropdown">
               <li class="{{ request()->is('admin/all-employees-attendance-list') ? 'active' : '' }}">
                  <a class="dropdown-item" href="{{ url('admin/all-employees-attendance-list') }}">
                  Employees 
                  </a>
               </li>
               <li class="{{ request()->is('admin/all-students-attendance-list') ? 'active' : '' }}">
                  <a class="dropdown-item" href="{{ url('admin/all-students-attendance-list') }}">
                  Students
                  </a>
               </li>
            </ul>
         </li>
         <li class="{{ request()->is('admin/all-employees-list') ? 'active' : '' }}">
            <a href="{{ url('admin/all-employees-list') }}">
            <img src="{{ url('public/admin/images/staff.svg') }}" alt="staff" />
            <span class="link-name">All Employees</span>
            </a>
         </li>
         <li class="{{ request()->is('admin/all-inqueries-list') || Request::is('admin/edit-inquery/*') ? 'active' : '' }}">
            <a href="{{ url('admin/all-inqueries-list') }}">
            <img src="{{ url('public/admin/images/all_inquries.svg') }}" alt="inqueries" />
            <span class="link-name">All Inqueries</span>
            </a>
         </li>
      </ul>
      <ul class="logout-mode">
         <li class="{{ request()->is('admin/help') ? 'active' : '' }}">
            <a href="#">
            <img src="{{ url('public/admin/images/help.svg') }}" alt="leads" />
            <span class="link-name">Help</span>
            </a>
         </li>
         <li class="{{ request()->is('admin/setting') ? 'active' : '' }}">
            <a href="{{ url('admin/setting') }}">
            <img src="{{ url('public/admin/images/setting.svg') }}" alt="leads" />
            <span class="link-name">Settings</span>
            </a>
         </li>
         <li class="nav-item">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
            <img src="{{ url('public/admin/images/logout.svg') }}" alt="leads" />
            {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
            </form>
         </li>
         <li class="mode">
            <a href="#">
            <i class="uil uil-moon"></i>
            <span class="link-name">Dark Mode</span>
            </a>
            <div class="mode-toggle">
               <span class="switch"></span>
            </div>
         </li>
      </ul>
   </div>
</nav>