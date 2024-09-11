<div class="top">
   <div class="logo-bar"><img src="{{ url('public/admin/images/black-pixxelu.svg') }}"></div>
   <div class="dropdown-admin-panel">
      <div class="dropdown-content-panel">
         <div class="img-admin-panel">          
         </div>
         <div class="dropdown">
            <div class="user-info dropbtn">
               <img src="{{ url('public/uploads/employees/'.auth()->user()->user_pic) }}" alt="{{ auth()->user()->user_pic }}" class="user-pic">
               <p class="user-name">{{ auth()->user()->name }}</p>
            </div>
            <div class="dropdown-content">
               <a href="{{ url('employee/profile') }}">Profile</a>
               <a href="{{ url('employee/change-password') }}">Change Password</a>
               <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
               {{ __('Logout') }}
               </a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
               </form>
            </div>
         </div>
      </div>
   </div>
</div>