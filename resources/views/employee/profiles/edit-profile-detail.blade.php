@extends('employee.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="title-subheading">
   <h2>Edit Employee Detail</h2>
</div>
<div class="main-table">
   @if (Session::has('success')) 
   <div class="notification-green">
      <p>{{ Session::get('success') }}</p>
   </div>
   @endif 
   @if (Session::has('unsuccess')) 
   <div class="notification-red">
      <p>{{ Session::get('unsuccess') }}</p>
   </div>
   @endif 
   <div class="login-form">
      <form action="{{ route('employee.update.profile', $employee->id) }}" Method="POST" enctype="multipart/form-data">
         @csrf 
         <div class="small-12 medium-2 large-2 columns">
            <div class="avatar-upload">
               <div class="avatar-edit">
                  <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                  <label for="imageUpload"><i class="fas fa-pencil-alt"></i></label>
               </div>
               <div class="add-new-student-pic">
                  <div class="avatar-preview">
                     @if($employee->user_pic)
                     <img id="imagePreview" src="{{ url('public/uploads/employees/' .$employee->user_pic) }}" >
                     @else
                     <img id="imagePreview" src="{{ url('public/uploads/employees/default_employee.png') }}" >
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design first-name">
               <label for="first-name">First Name</label>
               <input type="text" id="first-name" name="first_name" value="{{$employee->first_name}}" placeholder="Enter First Name">
            </div>
            <div class="form-design last-name">
               <label for="last-name">Last Name</label>
               <input type="text" id="last-name" name="last_name" value="{{$employee->last_name}}" placeholder="Enter Last Name">
            </div>
            <div class="form-design mail">
               <label for="email">Email</label>
               <input type="email" id="email" name="email" value="{{$employee->email}}" class="email-disabled" placeholder="Enter email address">
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design dob">
               <label for="dob">Date of Birth</label>
               <input type="date" id="dob" name="dob" value="{{$employee->dob}}">
            </div>
            <div class="form-design aadhaar-no">
               <label for="aadhaar_no">Aaadhar Number</label>
               <input type="text" id="aadhar_no" name="aadhaar_no" value="{{$employee->aadhaar_no}}" placeholder="Enter Aaadhar Number">
            </div>
            <div class="form-design phone-no">
               <label for="employee_phone_no">Phone Number</label>
               <input type="text" id="phone_no" name="employee_phone_no" value="{{$employee->employee_phone_no}}" placeholder="Enter Phone Number">
            </div>
         </div>
         <div class="form-group display-column radio-btn-design">
            <div class="form-group">
               <label>Gender</label>
               <div class="form-design gender-options">
                  <div class="gender male">
                     <input type="radio" name="gender" value="Male" @if($employee->gender == 'Male') checked @endif>
                     <span>Male</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="gender" value="Female" @if($employee->gender == 'Female') checked @endif>
                     <span>Female</span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label>Marital Status</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Married" @if($employee->marital_status == 'Married') checked @endif>
                     <span>Married</span>
                  </div>
                  <div class="gender male">  
                     <input type="radio" name="marital_status" value="Unmarried" @if($employee->marital_status == 'Unmarried') checked @endif>
                     <span>Unmarried</span>
                  </div>
                  <div class="gender male">
                     <input type="radio" name="marital_status" value="Other" @if($employee->marital_status == 'Other') checked @endif>  
                     <span>Other</span>
                  </div>
               </div>
            </div>
            <div class="form-design category">
               <label for="category">Category</label>
               <div class="form-design marital-status gender-options">
                  <div class="gender male"> 
                     <label class="radio-option">
                     <input type="radio" name="category" value="General" @if($employee->category == 'General') checked @endif>
                     <span>General</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="ST" @if($employee->category == 'ST') checked @endif>
                     <span>ST</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="SC" @if($employee->category == 'SC') checked @endif>
                     <span>SC</span>
                     </label>
                  </div>
                  <div class="gender male">  
                     <label class="radio-option">
                     <input type="radio" name="category" value="OBC" @if($employee->category == 'OBC') checked @endif>
                     <span>OBC</span>
                     </label>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-design qualification">
            @php $qualification = explode(",", $employee['qualification']); @endphp
            <label for="qualification">Qualification</label>
            <div class="qualification-ftp">
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="12th" @if(in_array('12th', $qualification)) checked @endif>
                  <span>12th</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Graduation" @if(in_array('Graduation', $qualification)) checked @endif>
                  <span>Graduation</span>
               </div>
               <div class="checkbox-option">
                  <input type="checkbox" name="qualification[]" value="Other" @if(in_array('Other', $qualification)) checked @endif>
                  <span>Other</span>
               </div>
            </div>
         </div>
         <br>
         <div class="form-group display-column">
            <div class="form-design address">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="{{ $employee->address }}" placeholder="Enter Address">
            </div>
            <div class="form-design state">
               <label for="state">State</label>
               <select name="state" class="form-control" id="state">
                  <option value="" disabled selected>Select State</option>
                  <option value="Andhra Pradesh" @if($employee->state == 'Andhra Pradesh') selected @endif>Andhra Pradesh</option>
                  <option value="Arunachal Pradesh" @if($employee->state == 'Arunachal Pradesh') selected @endif>Arunachal Pradesh</option>
                  <option value="Assam" @if($employee->state == 'Assam') selected @endif>Assam</option>
                  <option value="Bihar" @if($employee->state == 'Bihar') selected @endif>Bihar</option>
                  <option value="Chhattisgarh" @if($employee->state == 'Chhattisgarh') selected @endif>Chhattisgarh</option>
                  <option value="Goa" @if($employee->state == 'Goa') selected @endif>Goa</option>
                  <option value="Gujarat" @if($employee->state == 'Gujarat') selected @endif>Gujarat</option>
                  <option value="Haryana" @if($employee->state == 'Haryana') selected @endif>Haryana</option>
                  <option value="Himachal Pradesh" @if($employee->state == 'Himachal Pradesh') selected @endif>Himachal Pradesh</option>
                  <option value="Jharkhand" @if($employee->state == 'Jharkhand') selected @endif>Jharkhand</option>
                  <option value="Karnataka" @if($employee->state == 'Karnataka') selected @endif>Karnataka</option>
                  <option value="Kerala" @if($employee->state == 'Kerala') selected @endif>Kerala</option>
                  <option value="Madhya Pradesh" @if($employee->state == 'Madhya Pradesh') selected @endif>Madhya Pradesh</option>
                  <option value="Maharashtra" @if($employee->state == 'Maharashtra') selected @endif>Maharashtra</option>
                  <option value="Manipur" @if($employee->state == 'Manipur') selected @endif>Manipur</option>
                  <option value="Meghalaya" @if($employee->state == 'Meghalaya') selected @endif>Meghalaya</option>
                  <option value="Mizoram" @if($employee->state == 'Mizoram') selected @endif>Mizoram</option>
                  <option value="Nagaland" @if($employee->state == 'Nagaland') selected @endif>Nagaland</option>
                  <option value="Odisha" @if($employee->state == 'Odisha') selected @endif>Odisha</option>
                  <option value="Punjab" @if($employee->state == 'Punjab') selected @endif>Punjab</option>
                  <option value="Rajasthan" @if($employee->state == 'Rajasthan') selected @endif>Rajasthan</option>
                  <option value="Sikkim" @if($employee->state == 'Sikkim') selected @endif>Sikkim</option>
                  <option value="Tamil Nadu" @if($employee->state == 'Tamil Nadu') selected @endif>Tamil Nadu</option>
                  <option value="Telangana" @if($employee->state == 'Telangana') selected @endif>Telangana</option>
                  <option value="Tripura" @if($employee->state == 'Tripura') selected @endif>Tripura</option>
                  <option value="Uttar Pradesh" @if($employee->state == 'Uttar Pradesh') selected @endif>Uttar Pradesh</option>
                  <option value="Uttarakhand" @if($employee->state == 'Uttarakhand') selected @endif>Uttarakhand</option>
                  <option value="West Bengal" @if($employee->state == 'West Bengal') selected @endif>West Bengal</option>
                  <option value="Andaman and Nicobar Islands" @if($employee->state == 'Andaman and Nicobar Islands') selected @endif>Andaman and Nicobar Islands</option>
                  <option value="Chandigarh" @if($employee->state == 'Chandigarh') selected @endif>Chandigarh</option>
                  <option value="Dadra and Nagar Haveli and Daman and Diu" @if($employee->state == 'Dadra and Nagar Haveli and Daman and Diu') selected @endif>Dadra and Nagar Haveli and Daman and Diu</option>
                  <option value="Lakshadweep" @if($employee->state == 'Lakshadweep') selected @endif>Lakshadweep</option>
                  <option value="Delhi" @if($employee->state == 'Delhi') selected @endif>Delhi</option>
                  <option value="Puducherry" @if($employee->state == 'Puducherry') selected @endif>Puducherry</option>
                  <option value="Ladakh" @if($employee->state == 'Ladakh') selected @endif>Ladakh</option>
                  <option value="Jammu and Kashmir" @if($employee->state == 'Jammu and Kashmir') selected @endif>Jammu and Kashmir</option>
               </select>
            </div>
            <div class="form-design district">
               <label for="district">District</label>
               <select name="district" class="form-control" id="district">
                  <option value="" disabled selected>Select District</option>
                  <option value="Bilaspur" @if($employee->district == 'Bilaspur') selected @endif>Bilaspur</option>
                  <option value="Chamba" @if($employee->district == 'Chamba') selected @endif>Chamba</option>
                  <option value="Hamirpur" @if($employee->district == 'Hamirpur') selected @endif>Hamirpur</option>
                  <option value="Kangra" @if($employee->district == 'Kangra') selected @endif>Kangra</option>
                  <option value="Kinnaur" @if($employee->district == 'Kinnaur') selected @endif>Kinnaur</option>
                  <option value="Kullu" @if($employee->district == 'Kullu') selected @endif>Kullu</option>
                  <option value="Lahaul and Spiti" @if($employee->district == 'Lahaul and Spiti') selected @endif>Lahaul and Spiti</option>
                  <option value="Mandi" @if($employee->district == 'Mandi') selected @endif>Mandi</option>
                  <option value="Shimla" @if($employee->district == 'Shimla') selected @endif>Shimla</option>
                  <option value="Sirmaur" @if($employee->district == 'Sirmaur') selected @endif>Sirmaur</option>
                  <option value="Solan" @if($employee->district == 'Solan') selected @endif>Solan</option>
                  <option value="Una" @if($employee->district == 'Una') selected @endif>Una</option>
               </select>
            </div>
         </div>
         <div class="form-group display-column">
            <div class="form-design pin_code">
               <label for="pin_code">Pin Code</label>
               <input type="text" id="pin_code" name="pin_code" value="{{$employee->pin_code}}" placeholder="Enter Pin Code">
            </div>
            <div class="form-design joining_date">
               <label for="joining_date">Joining Date</label>
               <input type="date" id="joining_date" name="joining_date" value="{{$employee->joining_date}}">
            </div>
            <div class="form-design experince">
               <label for="experince">Experince</label>
               <select name="experince" class="form-control" id="experince">
                  <option value="" disabled selected>Select Experince</option>
                  <option value="Fresher" @if($employee->experince == 'Fresher') selected @endif>Fresher</option>
                  <option value="6 Month" @if($employee->experince == '6 Month') selected @endif>6 Month</option>
                  <option value="1 Year" @if($employee->experince == '1 Year') selected @endif>1 Year</option>
                  <option value="2 Year" @if($employee->experince == '2 Year') selected @endif>2 Year</option>
                  <option value="3 Year" @if($employee->experince == '3 Year') selected @endif>3 Year</option>
                  <option value="4 Year" @if($employee->experince == '4 Year') selected @endif>4 Year</option>
                  <option value="5 Year" @if($employee->experince == '5 Year') selected @endif>5 Year</option>
                  <option value="6 Year" @if($employee->experince == '6 Year') selected @endif>6 Year</option>
                  <option value="7 Year" @if($employee->experince == '7 Year') selected @endif>7 Year</option>
                  <option value="8 Year" @if($employee->experince == '8 Year') selected @endif>8 Year</option>
                  <option value="9 Year" @if($employee->experince == '9 Year') selected @endif>9 Year</option>
                  <option value="10 Year" @if($employee->experince == '10 Year') selected @endif>10 Year</option>
                  <option value="11 Year" @if($employee->experince == '11 Year') selected @endif>11 Year</option>
                  <option value="12 Year" @if($employee->experince == '12 Year') selected @endif>12 Year</option>
                  <option value="13 Year" @if($employee->experince == '13 Year') selected @endif>13 Year</option>
                  <option value="14 Year" @if($employee->experince == '14 Year') selected @endif>14 Year</option>
                  <option value="15 Year" @if($employee->experince == '15 Year') selected @endif>15 Year</option>
               </select>
            </div>
         </div>
         <div class="form-button">
            <div class="back-button">
               <input type="submit" class="btn btn-success" name="submit" value="Update">
            </div>
         </div>
      </form>
   </div>
</div>
@endsection