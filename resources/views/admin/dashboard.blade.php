@extends('admin.layouts.master')
@section('content')
<style>
   element {
   width: 229.883px;
   text-align: ;
   }
</style>
<div class="space-remove"></div>
<div class="title-subheading">
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
   <!--start four boxes studens fees-->
   <div class="boxes-wrapper">
      <div class="box">
         <h3>Total Fees</h3>
         <p>Rs {{ number_format($all_students_total_fees) }}</p>
      </div>
      <div class="box">
         <h3><span style="color: green;">Paid Fees</span></h3>
         <p>Rs {{ number_format($all_students_paid_fees) }}</p>
      </div>
      <div class="box">
         <h3><span style="color: red;">Pending Fees</span></h3>
         <!--calculate pending fees-->
         @php
         $all_students_pending_fees = $all_students_total_fees - $all_students_paid_fees;
         @endphp 
         <p>Rs {{ number_format($all_students_pending_fees,  0, '.', ',') }}</p>
      </div>
      <div class="box">
         <!--paid monthly fees-->
         <h3><span style="color: green;">Paid Fees This Month</span></h3>
         <p>Rs {{  number_format($current_month_paid_fees,  0, '.', ',') }}</p>
         <div class="p-flex">
            <p><strong style="color: green;">Online:-</strong> Rs {{ number_format($payment_type_online,  0, '.', ',') }}</p>
            <p><strong style="color: green;">Cash:-</strong> Rs {{ number_format($payment_type_cash,  0, '.', ',') }}</p>
         </div>
      </div>
   </div>
   <!--end four boxes studens fees-->
   <!--start six boxes students information-->
   <div class="boxes-wrapperers">
      <div class="box">
         <h3>Total Students</h3>
         <p>{{ $is_total_students }}</p>
      </div>
      <div class="box">
         <h3>Web Designing</h3>
         <p>{{ $is_web_designing_students }}</p>
      </div>
      <div class="box">
         <h3>Web Development</h3>
         <p>{{ $is_web_development_students }}</p>
      </div>
      <div class="box">
         <h3>Php Development</h3>
         <p>{{ $is_php }}</p>
      </div>
      <div class="box">
         <h3>Full Stack Development</h3>
         <p>{{ $is_full_stack_development }}</p>
      </div>
      <div class="box">
         <h3>Graphic</h3>
         <p>{{ $is_graphic }}</p>
      </div>
   </div>
   <!--end six boxes students information-->
   <div class="chart-design">
      <figure class=".highcharts-figure">
         <div id="students_monthly_fees_detail"></div>
         <!--<button id="plain">Plain</button>
            <button id="inverted">Inverted</button>
            <button id="polar">Polar</button>-->
      </figure>
      <figure class=".highcharts-figure">
         <div id="total_students_detail"></div>
   </div>
   </figure>
   <?php
      use Carbon\Carbon as MyCarbon;
      ?>
</div>
<div class="student-header">
   <h6>All Students Monthly Fees List:- <?php echo MyCarbon::now()->format('F Y'); ?></h6>
</div>
<div class="main-table">
   <div class="data-table-listing">
      <div class="btn-pixxelu">
         <!--stokes list-->
         <a href="{{ url('admin/all-stocks-list') }}" class="export">Stock List</a>
         <!--end stokes list-->
         <!--export students monthly paid fees list -->
         <a href="{{ route('admin.export.paid.fees') }}" class="export">
         <img src="{{ url('public/admin/images/csv-file.svg') }}">Paid
         </a>
         <!--export students monthly pending fees list -->
         <a href="{{ route('admin.export.pending.fees') }}" class="export">
         <img src="{{ url('public/admin/images/csv-file.svg') }}">Pending  
         </a>
      </div>
   </div>
   <!--start students monthly table-->
   <div class="scrolling-data-table">
      <div class="card-body">
         <table id="example1" class="rwd-table cloud-path">
            <thead>
               <tr class="sticky">
                  <th>S. No</th>
                  <th>Student ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Joining Date</th>
                  <th>Course</th>
                  <th>Monthly Fees</th>
               </tr>
            </thead>
            <tbody>
               @php
               $count = 1;
               use Carbon\Carbon;
               @endphp
               @foreach($get_student_list as $student)    
               <tr>
                  <td>{{ $count++ }}</td>
                  <td>{{ $student->id }} </td>
                  <td data-th="Image">
                     <div class="user-image">
                        @if($student->user_pic)
                        <img src="{{ url('public/uploads/users/' . $student->user_pic) }}" alt="User Image">
                        @else
                        <img src="{{ url('public/uploads/users/default_user.png') }}" alt="Default User Image">
                        @endif
                     </div>
                  </td>
                  <td>
                     <span onclick="openNav()"><a href="#" class="student-link" data-student_id="{{ $student->id }}">{{ $student->name }}</a></span>
                  </td>
                  <td>
                     @if($student->student_phone_no)
                     <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $student->student_phone_no) }}" target="_blank">
                     {{ substr($student->student_phone_no, 0, 5) }}-{{ substr($student->student_phone_no, 5) }}
                     </a>
                     @else
                     No phone number available
                     @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($student->course_joining_date)->format('d M Y') }}</td>
                  @if($student->course_type == 'Full Stack Development') 
                  <td class="lights-blue-color"><span>Full Stack Development</span></td>
                  @elseif($student->course_type == 'PHP Development')
                  <td class="lights-green-color"><span>PHP Development</span></td>
                  @elseif($student->course_type == 'Web Development')
                  <td class="light-yellow-color"><span>Web Development</span></td>
                  @elseif($student->course_type == 'Web Designing')
                  <td class="light-pink-color"><span>Web Designing</span></td>
                  @elseif($student->course_type == 'Graphic Designing')
                  <td class="light-cyan-color"><span>Graphic Designing</span></td>
                  @else
                  <td></td>
                  @endif
                  <td style="text-align:left;">
                  @php
                     $total_fees = 0;
                  @endphp  

                  @foreach($student->student_fees_detail as $fees_detail)
                     @php
                           $total_fees += $fees_detail->user_fees;
                     @endphp
                     <span class="date-tbl">
                           {{ Carbon::parse($fees_detail->submission_date)->format('d M Y') }}
                           <em>({{ $fees_detail->user_fees }} / {{ $fees_detail->payment_type }})</em>
                     </span><br>
                  @endforeach
                  <!-- Display total fees after the loop -->
                  <strong>Paid Fees: {{ $total_fees }}</strong>
               </td>

               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
   <!--end students monthly table-->
</div>
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
</script>
@endsection
<script>
   var currentYear = new Date().getFullYear();
   document.addEventListener('DOMContentLoaded', function () {
       const chartOptions = {
           chart: {
               renderTo: 'students_monthly_fees_detail'
           },
           title: {
               text: 'Students Monthly Fees Detail, ' + currentYear,
               align: 'center'
           },
           credits: {
               enabled: false 
           },
           colors: [
               '#4caefe', '#3fbdf3', '#35c3e8', '#2bc9dc', '#20cfe1',
               '#16d4e6', '#0dd9db', '#03dfd0', '#00e4c5', '#00e9ba',
               '#00eeaf', '#23e274'
           ],
           xAxis: {
               categories: [
                   'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                   'Oct', 'Nov', 'Dec'
               ]
           },
           series: [{
               type: 'column',
               name: 'This Month Total Students Fees Rs',
               borderRadius: 5,
               colorByPoint: true,
               data: [
                  {{$jan_month_fees_detail}}, 
                  {{$feb_month_fees_detail}}, 
                  {{$march_month_fees_detail}}, 
                  {{$april_month_fees_detail}}, 
                  {{$may_month_fees_detail}}, 
                  {{$june_month_fees_detail}}, 
                  {{$july_month_fees_detail}}, 
                  {{$august_month_fees_detail}},
                  {{$sept_month_fees_detail}}, 
                  {{$oct_month_fees_detail}}, 
                  {{$nov_month_fees_detail}}, 
                  {{$dec_month_fees_detail}}
               ],
               showInLegend: false
           }]
       };
       
       var chart = new Highcharts.Chart(chartOptions);
   
       document.getElementById('plain').addEventListener('click', () => {
           chart.update({
               chart: {
                   inverted: false,
                   polar: false
               }
           });
       });
   
       document.getElementById('inverted').addEventListener('click', () => {
           chart.update({
               chart: {
                   inverted: true,
                   polar: false
               }
           });
       });
   
       document.getElementById('polar').addEventListener('click', () => {
           chart.update({
               chart: {
                   inverted: false,
                   polar: true
               }
           });
       });
   });
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
       Highcharts.chart('total_students_detail', {
           chart: {
               type: 'spline'
           },
           title: {
               text: 'Students Enrollments per Month - 2023 & 2024'
           },
           xAxis: {
               categories: [
                   'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                   'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
               ],
               accessibility: {
                   description: 'Months of the year'
               }
           },
           yAxis: {
               title: {
                   text: 'Number of Students'
               },
               labels: {
                   format: '{value}'
               }
           },
           tooltip: {
               crosshairs: true,
               shared: true,
               valueSuffix: ' students'
           },
           plotOptions: {
               spline: {
                   marker: {
                       radius: 4,
                       lineColor: '#666666',
                       lineWidth: 1
                   }
               }
           },
           credits: {
               enabled: false  
           },
           series: [{
               name: 'Enrollments 2023',
               marker: {
                   symbol: 'circle'
               },
               data: [
                   {{$jan_month_student_detail_2023}},
                   {{$feb_month_student_detail_2023}},
                   {{$march_month_student_detail_2023}},
                   {{$april_month_student_detail_2023}},
                   {{$may_month_student_detail_2023}},
                   {{$june_month_student_detail_2023}},
                   {{$july_month_student_detail_2023}},
                   {{$august_month_student_detail_2023}},
                   {{$sep_month_student_detail_2023}},
                   {{$oct_month_student_detail_2023}},
                   {{$nov_month_student_detail_2023}},
                   {{$dec_month_student_detail_2023}}
               ]
           }, {
               name: 'Enrollments 2024',
               marker: {
                   symbol: 'square'
               },
               data: [
                   {{$jan_month_student_detail_2024}},
                   {{$feb_month_student_detail_2024}},
                   {{$march_month_student_detail_2024}},
                   {{$april_month_student_detail_2024}},
                   {{$may_month_student_detail_2024}},
                   {{$june_month_student_detail_2024}},
                   {{$july_month_student_detail_2024}},
                   {{$august_month_student_detail_2024}},
                   {{$sep_month_student_detail_2024}},
                   {{$oct_month_student_detail_2024}},
                   {{$nov_month_student_detail_2024}},
                   {{$dec_month_student_detail_2024}}
               ]
           }]
       });
   });
</script>