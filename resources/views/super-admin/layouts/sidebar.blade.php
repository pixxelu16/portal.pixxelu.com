<nav>
   <div class="logo-name">
      <div class="logo-image">
         <i class="uil uil-bars sidebar-toggle"><img src="{{ url('public/admin/images/Menu.svg') }}" alt=""></i> 
      </div>
   </div>
   <div class="menu-items">
      <ul class="nav-links">
         <li class="{{ request()->is('super-admin/dashboard') ? 'active' : '' }}">
            <a href="{{ url('super-admin/dashboard') }}">
               <img src="{{ url('public/admin/images/dashboard.svg') }}" alt="dashboard" />
               <span class="link-name">Dashboard</span>
            </a>
         </li>
         @php
            $employeeRoutes = ['super-admin/all-employees','super-admin/add-new-employee','super-admin/edit-employee*','super-admin/search-job','super-admin/job-letter*'];
            $isEmployeeMenuActive = request()->is($employeeRoutes);
         @endphp
         <li class="nav-item dropdown" id="customerMenu">
            <a class="nav-link dropdown-toggle {{ $isEmployeeMenuActive ? 'active show' : '' }}"
               href="#" id="employeeDropdown" role="button"
               data-bs-toggle="dropdown" aria-expanded="true">
                  <img src="{{ url('public/admin/images/student.svg') }}" alt="employee" />
               <span class="link-name">All Employees</span>
            </a>
            <ul class="dropdown-menu {{ $isEmployeeMenuActive ? 'show' : '' }}" aria-labelledby="employeeDropdown">
               <li class="{{ request()->is('super-admin/all-employees') ? 'active' : '' }}">
                  <a class="dropdown-item {{ request()->is('super-admin/all-employees') || request()->is('super-admin/edit-employee/*') ? 'text-dark fw-bold' : '' }}"
                     href="{{ url('super-admin/all-employees') }}">All Employees
                  </a>
               </li>
               <li class="{{ request()->is('super-admin/add-new-employee') ? 'active' : '' }}">
                  <a class="dropdown-item {{ request()->is('super-admin/add-new-employee') ? 'text-dark fw-bold' : '' }}"
                     href="{{ url('super-admin/add-new-employee') }}">Add New
                  </a>
               </li>
               <li class="{{ request()->is('super-admin/search-job') ? 'active' : '' }}">
                  <a class="dropdown-item {{ request()->is('super-admin/search-job') || request()->is('super-admin/job-letter/*') ? 'text-dark fw-bold' : '' }}"
                     href="{{ url('super-admin/search-job') }}">Job Letter
                  </a>
               </li>
            </ul>
         </li>
         <li class="{{ request()->is('super-admin/all-students-list') || request()->is('super-admin/add-new-student') || request()->is('super-admin/edit-student/*') ? 'active' : '' }}">
            <a href="{{ url('super-admin/all-students-list') }}">
               <img src="{{ url('public/admin/images/student.svg') }}" alt="student" />
               <span class="link-name">All Students</span>
            </a>
         </li>
         <li class="{{ request()->is('super-admin/all-internships-list') || request()->is('super-admin/add-new-intern') || request()->is('super-admin/edit-intern/*') ? 'active' : '' }}">
            <a href="{{ url('super-admin/all-internships-list') }}">
               <img src="{{ url('public/admin/images/student.svg') }}" alt="internship" />
               <span class="link-name">Internship</span>
            </a>
         </li>
         <!--<li class="{{ request()->is('super-admin/attendance') ? 'active' : '' }}">
            <a href="aatendance.html">
               <img src="{{ url('public/admin/images/attendance.svg') }}" alt="attendance" />
               <span class="link-name">Attendance</span>
            </a>
         </li>-->
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->is('super-admin/all-employees-attendance-list') || request()->is('super-admin/all-students-attendance-list') ? 'active' : '' }}" 
               href="#" id="attendanceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               <img src="{{ url('public/admin/images/attendance.svg') }}" alt="attendance"/>
               <span class="link-name">Attendances</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="attendanceDropdown">
               <li class="{{ request()->is('super-admin/all-employees-attendance-list') ? 'active' : '' }}">
                  <a class="dropdown-item" href="{{ url('super-admin/all-employees-attendance-list') }}">
                      Employees 
                  </a>
               </li>
               <li class="{{ request()->is('super-admin/all-students-attendance-list') ? 'active' : '' }}">
                  <a class="dropdown-item" href="{{ url('super-admin/all-students-attendance-list') }}">
                     Students
                  </a>
               </li>
            </ul>
         </li>
         <!--<li class="{{ request()->is('super-admin/all-employees-list') ? 'active' : '' }}">
            <a href="{{ url('super-admin/all-employees-list') }}">
               <img src="{{ url('public/admin/images/staff.svg') }}" alt="staff" />
               <span class="link-name">All Employees</span>
            </a>
         </li>-->
         <li class="{{ request()->is('super-admin/all-clients-list') ? 'active' : '' }}">
            <a href="{{ url('super-admin/all-clients-list') }}">
               <img src="{{ url('public/admin/images/all_clients.svg') }}" alt="clients" />
               <span class="link-name">All Clients</span>
            </a>
         </li>
         <li class="{{ request()->is('super-admin/all-inqueries-list') ? 'active' : '' }}">
            <a href="{{ url('super-admin/all-inqueries-list') }}">
               <img src="{{ url('public/admin/images/all_inquries.svg') }}" alt="inqueries" />
               <span class="link-name">All Inqueries</span>
            </a>
         </li>
      </ul>
      <ul class="logout-mode">
         <li>
            <a href="#"><img src="{{ url('public/admin/images/help.svg') }}" alt="leads" />
               <span class="link-name">Help</span>
            </a>
         </li>
         <li>
            <a href="{{ url('super-admin/setting') }}"><img src="{{ url('public/admin/images/setting.svg') }}" alt="leads" />
               <span class="link-name">Settings</span>
            </a>
         </li>
         <li class="nav-item">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <img src="{{ url('public/admin/images/logout.svg') }}" alt="leads" />
               {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
            </form>
         </li>
         <li class="mode">
            <a href="#"><i class="uil uil-moon"></i>
               <span class="link-name">Dark Mode</span>
            </a>
            <div class="mode-toggle">
               <span class="switch"></span>
            </div>
         </li>
      </ul>
   </div>  
</nav>
<script>
document.addEventListener("DOMContentLoaded", function () {
   if (!document.getElementById("overlayBlur")) {
      const overlay = document.createElement("div");
      overlay.id = "overlayBlur";
      overlay.style.cssText = "display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.2); z-index: 9998;";
      document.body.appendChild(overlay);
   }
   if (!document.getElementById("topLoaderBar")) {
      const loader = document.createElement("div");
      loader.id = "topLoaderBar";
      loader.style.cssText = "display: none; height: 4px; background: #4a58ed; width: 0%; position: fixed; top: 0; left: 0; z-index: 9999;";
      document.body.appendChild(loader);
   }
   const overlay = document.getElementById('overlayBlur');
   const topLoaderBar = document.getElementById('topLoaderBar');
   const submenuLinks = document.querySelectorAll('#customerMenu .dropdown-item');
   submenuLinks.forEach(link => {
      link.addEventListener('click', function (e) {
         const targetUrl = this.getAttribute('href');
         //Only apply loader/blur for these 3
         const allowed = [
            '{{ url("super-admin/all-employees") }}',
            '{{ url("super-admin/add-new-employee") }}',
            '{{ url("super-admin/search-job") }}'
         ];
         if (allowed.includes(targetUrl)) {
            e.preventDefault();
            // Show overlay and loader
            overlay.style.display = 'block';
            topLoaderBar.style.display = 'block';
            topLoaderBar.style.width = '0%';

            setTimeout(() => {
               topLoaderBar.style.width = '100%';
            }, 50);
            window.scrollTo({ top: 0, behavior: 'smooth' });
            // Navigate after delay
            setTimeout(() => {
               window.location.href = targetUrl;
            }, 700);
         }
      });
   });
});
</script>

