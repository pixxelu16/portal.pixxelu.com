<div class="top">
   <!-- <div class="logo-bar"><img src="{{ url('public/admin/images/black-pixxelu.svg') }}"></div> -->
   <div class="dropdown-admin-panel">
      <!-- <div class="btn-pixxeluss">
         <a href="{{ url('admin/add-new-inquery') }}"><img src="{{ url('public/admin/images/pluse.svg') }}">Add New Inquery</a>
         </div> -->
      <div class="dropdown-content-panel">
         <div class="img-admin-panel"></div>
         <div class="custom-user-dropdown d-flex align-items-center justify-content-end me-3">
            <a class="d-flex align-items-center text-decoration-none dropdown-toggle custom-dropdown-toggle" 
               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               <img src="{{ url('public/uploads/users/'.auth()->user()->user_pic) }}" 
                  alt="user" class="rounded-circle me-2 custom-user-img">
               <div class="custom-user-info">
                  <span class="fw-semibold">{{ auth()->user()->name }}</span>
                  <small class="custom-user-role">Admin</small>
               </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow custom-dropdown-menu">
               <li>
                  <a class="dropdown-item" href="{{ url('admin/profile') }}">
                     <i class="bi bi-person me-2"></i> Profile
                  </a>
               </li>
               <li>
                  <a class="dropdown-item" href="{{ url('admin/change-password') }}">
                  <i class="bi bi-key me-2"></i> Change Password
                  </a>
               </li>
               <li>
                  <hr class="dropdown-divider">
               </li>
               <li>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <i class="bi bi-box-arrow-right me-2"></i> Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                  </form>
               </li>
            </ul>
         </div>
      </div>
   </div>
</div>
</div>
