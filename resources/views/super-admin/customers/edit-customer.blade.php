@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
@include('notification')
<div class="container py-4">
   <div class="header-bar d-flex justify-content-between align-items-center flex-wrap">
      <div>
         <h5 class="mb-0 fw-semibold text-dark">
            Employees
            <span class="separator mx-2">|</span>
            <i class="bi bi-house-door-fill"></i>
            <span class="text-muted">– Edit Employee</span>
         </h5>
      </div>
   </div>
   <div class="form-header">
      <h2 class="form-title">Edit Employee</h2>
      <div class="form-status-legend">
         <div class="legend-item required">
            <span class="arrow-icon">➤</span>
            <span class="label-text">Required</span>
         </div>
         <div class="legend-item optional">
            <span class="arrow-icon">➤</span>
            <span class="label-text">Optional</span>
         </div>
      </div>
   </div>
   <form id="customerForm" action="{{ route('update.employee', $customer_detail->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="section-title">
         <span class="section-number">1</span> Basic Information
      </div>
      <div class="underline"></div>
      <div class="row">
         <div class="col-md-4 form-group">
            <div class="chip-label">Picture – Optional</div>
            <div class="image-box">
               @if($customer_detail->user_pic)
               <img id="previewImage" src="{{ url('public/uploads/employees/' . $customer_detail->user_pic) }}"  alt="Preview Image">
               @else
               <img id="previewImage" src="{{ url('public/uploads/users/default_user.png') }}"  alt="Preview Image">
               @endif  
               <label for="imageInput" class="choose-image-btn">📷 Choose Image</label>
               <input type="file" name="image" id="imageInput" hidden>
            </div>
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label label-colored">Employee Name*</div>
            <input type="text" name="name" value="{{ old('name', $customer_detail->name) }}" class="form-control @error('name') custom-invalid @enderror" placeholder="Name of Employee">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label label-colored">Employee Role*</div>
            <select name="employee_role" class="form-select @error('employee_role') custom-invalid @enderror">
               <option value="" selected disabled>Select</option>
               <option value="Backend Developer" @if(old('employee_role', $customer_detail->employee_role) == 'Backend Developer') selected @endif>Backend Developer</option>
               <option value="Frontend Developer" @if(old('employee_role', $customer_detail->employee_role) == 'Frontend Developer') selected @endif>Frontend Developer</option>
               <option value="Full Stack Developer" @if(old('employee_role', $customer_detail->employee_role) == 'Full Stack Developer') selected @endif>Full Stack Developer</option>
               <option value="UI/UX Designer" @if(old('employee_role', $customer_detail->employee_role) == 'UI/UX Designer') selected @endif>UI/UX Designer</option>
               <option value="DevOps Engineer" @if(old('employee_role', $customer_detail->employee_role) == 'DevOps Engineer') selected @endif>DevOps Engineer</option>
               <option value="Mobile App Developer" @if(old('employee_role', $customer_detail->employee_role) == 'Mobile App Developer') selected @endif>Mobile App Developer</option>
               <option value="Software Engineer" @if(old('employee_role', $customer_detail->employee_role) == 'Software Engineer') selected @endif>Software Engineer</option>
               <option value="Project Manager" @if(old('employee_role', $customer_detail->employee_role) == 'Project Manager') selected @endif>Project Manager</option>
               <option value="Business Analyst" @if(old('employee_role', $customer_detail->employee_role) == 'Business Analyst') selected @endif>Business Analyst</option>
               <option value="IT Support" @if(old('employee_role', $customer_detail->employee_role) == 'IT Support') selected @endif>Digital Marketing</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Mobile No for SMS/WhatsApp</div>
            <input type="text" name="employee_phone_no" value="{{ old('employee_phone_no', $customer_detail->employee_phone_no) }}" id="mobile_no" class="form-control @error('employee_phone_no') custom-invalid @enderror" placeholder="e.g +91xxxxxxxxxx" maxlength="11">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label label-colored">Monthly Salary*</div>
            <input type="text" name="net_salary" id="monthly_salary" value="{{ old('net_salary', $customer_detail->net_salary) }}" class="form-control @error('net_salary') custom-invalid @enderror" placeholder="Monthly Salary" maxlength="10">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label label-colored">Date of Joining*</div>
            <input type="date" name="joining_date" class="form-control @error('joining_date') custom-invalid @enderror" value="{{ old('joining_date', $customer_detail->joining_date)}}">
         </div>
      </div>
      <div class="section-title">
         <span class="section-number">2</span> Other Information
      </div>
      <div class="underline"></div>
      <div class="row">
         <div class="col-md-4 form-group">
            <div class="chip-label">Father / Husband Name</div>
            <input type="text" name="father_name" value="{{ old('father_name', $customer_detail->father_name) }}" class="form-control @error('father_name') custom-invalid @enderror" placeholder="Father /Husband Name">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Gender</div>
            <select name="gender" class="form-select @error('gender') custom-invalid @enderror">
               <option value="" selected disabled>Select</option>
               <option value="Male" @if(old('gender', $customer_detail->gender) == 'Male') selected @endif>Male</option>
               <option value="Female" @if(old('gender', $customer_detail->gender) == 'Female') selected @endif>Female</option>
               <option value="Other" @if(old('gender', $customer_detail->gender) == 'Other') selected @endif>Other</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Experience</div>
            <select name="experince" class="form-select @error('experince') custom-invalid @enderror">
               <option value="">Select Experience</option>
               <option value="1 Year" @if(old('experince', $customer_detail->experince) == '1 Year') selected @endif>1 Year</option>
               <option value="2 Year" @if(old('experince', $customer_detail->experince) == '2 Year') selected @endif>2 Year</option>
               <option value="3 Year" @if(old('experince', $customer_detail->experince) == '3 Year') selected @endif>3 Year</option>
               <option value="4 Year" @if(old('experince', $customer_detail->experince) == '4 Year') selected @endif>4 Year</option>
               <option value="5 Year" @if(old('experince', $customer_detail->experince) == '5 Year') selected @endif>5 Year</option>
               <option value="6 Year" @if(old('experince', $customer_detail->experince) == '6 Year') selected @endif>6 Year</option>
               <option value="7 Year" @if(old('experince', $customer_detail->experince) == '7 Year') selected @endif>7 Year</option>
               <option value="8 Year" @if(old('experince', $customer_detail->experince) == '8 Year') selected @endif>8 Year</option>
               <option value="9 Year" @if(old('experince', $customer_detail->experince) == '9 Year') selected @endif>9 Year</option>
               <option value="10 Year" @if(old('experince', $customer_detail->experince) == '10 Year') selected @endif>10 Year</option>
               <option value="11 Year" @if(old('experince', $customer_detail->experince) == '11 Year') selected @endif>11 Year</option>
               <option value="12 Year" @if(old('experince', $customer_detail->experince) == '12 Year') selected @endif>12 Year</option>
               <option value="13 Year" @if(old('experince', $customer_detail->experince) == '13 Year') selected @endif>13 Year</option>
               <option value="14 Year" @if(old('experince', $customer_detail->experince) == '14 Year') selected @endif>14 Year</option>
               <option value="15 Year" @if(old('experince', $customer_detail->experince) == '15 Year') selected @endif>15 Year</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">National ID</div>
            <input type="text" name="national_id" value="{{ old('national_id', $customer_detail->national_id) }}" class="form-control @error('national_id') custom-invalid @enderror" placeholder="National ID">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Religion</div>
            <select name="religion" class="form-select @error('religion') custom-invalid @enderror">
               <option value="" selected disabled>Select</option>
               <option value="Hindu" @if(old('religion', $customer_detail->religion) == 'Hindu') selected @endif>Hindu</option>
               <option value="Muslim" @if(old('religion', $customer_detail->religion) == 'Muslim') selected @endif>Muslim</option>
               <option value="Christian" @if(old('religion', $customer_detail->religion) == 'Christian') selected @endif>Christian</option>
               <option value="Sikh" @if(old('religion', $customer_detail->religion) == 'Sikh') selected @endif>Sikh</option>
               <option value="Buddhist" @if(old('religion', $customer_detail->religion) == 'Buddhist') selected @endif>Buddhist</option>
               <option value="Jain" @if(old('religion', $customer_detail->religion) == 'Jain') selected @endif>Jain</option>
               <option value="Parsi" @if(old('religion', $customer_detail->religion) == 'Parsi') selected @endif>Parsi</option>
               <option value="Jewish" @if(old('religion', $customer_detail->religion) == 'Jewish') selected @endif>Jewish</option>
               <option value="Other" @if(old('religion', $customer_detail->religion) == 'Other') selected @endif>Other</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Email Address</div>
            <input type="email" name="email" value="{{ old('email', $customer_detail->email) }}" class="form-control @error('email') custom-invalid @enderror" placeholder="Email Address" disabled="selected">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Education</div>
            <input type="text" name="qualification" value="{{ old('qualification', $customer_detail->qualification) }}" class="form-control @error('qualification') custom-invalid @enderror" placeholder="Education">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Blood Group</div>
            <select  name="blood" class="form-select @error('blood') custom-invalid @enderror">
               <option value="" selected disabled>Select</option>
               <option value="A+" @if(old('blood', $customer_detail->blood) == 'A+') selected @endif>A+</option>
               <option value="A−" @if(old('blood', $customer_detail->blood) == 'A-') selected @endif>A−</option>
               <option value="B+" @if(old('blood', $customer_detail->blood) == 'B+') selected @endif>B+</option>
               <option value="B−" @if(old('blood', $customer_detail->blood) == 'B−') selected @endif>B−</option>
               <option value="AB+" @if(old('blood', $customer_detail->blood) == 'AB+') selected @endif>AB+</option>
               <option value="AB−" @if(old('blood', $customer_detail->blood) == 'AB−') selected @endif>AB−</option>
               <option value="O+" @if(old('blood', $customer_detail->blood) == 'O+') selected @endif>O+</option>
               <option value="O−" @if(old('blood', $customer_detail->blood) == 'O−') selected @endif>O−</option>
            </select>
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Date of Birth</div>
            <input type="date" name="dob" value="{{ old('dob',$customer_detail->dob) }}" class="form-control @error('dob') custom-invalid @enderror">
         </div>
         <div class="col-md-8 form-group">
            <div class="chip-label">Home Address</div>
            <input type="text" name="address" value="{{ old('address',$customer_detail->address) }}" class="form-control @error('address') custom-invalid @enderror" placeholder="Home Address">
         </div>
         <div class="col-md-4 form-group">
            <div class="chip-label">Status</div>
            <select name="user_status" class="form-select">
               <option value="" selected disabled>Select</option>
               <option value="Active" @if(old('user_status', $customer_detail->user_status) == 'Active') selected @endif>Active</option>
               <option value="Pending" @if(old('user_status', $customer_detail->user_status) == 'Pending') selected @endif>Pending</option>
               <option value="Suspend" @if(old('user_status', $customer_detail->user_status) == 'Suspend') selected @endif>Suspend</option>
               <option value="Approved" @if(old('user_status', $customer_detail->user_status) == 'Approved') selected @endif>Approved</option>
            </select>
         </div>
      </div>
      <div class="underline"></div>
      <div class="text-center mt-4">
         <button type="reset" class="btn btn-reset me-2">
         <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
         </button>
         <button type="submit" class="btn btn-submit">
         <i class="bi bi-check-lg me-1"></i> Update
         </button>
      </div>
   </form>
   <!--top scroll loader-->
   <div id="topLoaderBar"></div>
   <!--blur background-->
   <div id="overlayBlur"></div>
</div>
<script>
   document.getElementById('imageInput').addEventListener('change', function (event) {
      const file = event.target.files[0];
      if (file) {
         const reader = new FileReader();
         reader.onload = function (e) {
            document.getElementById('previewImage').src = e.target.result;
         };
         reader.readAsDataURL(file);
      }
   });
</script>
@endsection