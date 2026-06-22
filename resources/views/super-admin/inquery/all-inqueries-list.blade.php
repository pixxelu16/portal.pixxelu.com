@extends('super-admin.layouts.master')
@section('content')
@php
   $coursePills = [
      'Full Stack Development' => 'portal-pill-blue',
      'PHP Development' => 'portal-pill-green',
      'Web Development' => 'portal-pill-yellow',
      'Digital Marketing' => 'portal-pill-orange',
      'Web Designing' => 'portal-pill-pink',
      'Graphic Designing' => 'portal-pill-purple',
      'Graphic' => 'portal-pill-purple',
   ];
   $visitPills = [
      'Google' => 'portal-pill-blue',
      'Instagram' => 'portal-pill-pink',
      'Facebook' => 'portal-pill-yellow',
      'Office-Visit' => 'portal-pill-green',
      'Website' => 'portal-pill-cyan',
      'YouTube' => 'portal-pill-red',
      'WhatsApp' => 'portal-pill-green',
      'Walk-in' => 'portal-pill-orange',
      'Email' => 'portal-pill-gray',
      'SMS' => 'portal-pill-gray',
      'Other' => 'portal-pill-gray',
   ];
   $priorityPills = ['hot' => 'portal-pill-red', 'warm' => 'portal-pill-orange', 'cold' => 'portal-pill-blue'];
   $statusBadges = [
      'Active' => 'portal-badge-success',
      'Office-Visit' => 'portal-badge-warning',
      'Closed' => 'portal-badge-danger',
      'Converted' => 'portal-badge-muted',
   ];
@endphp
<div class="space-remove"></div>
<div class="title-subheading">
   @include('admin.partials.page-alerts')
   <div class="portal-page-header">
      <div>
         <h2>All Inquiries</h2>
         <p class="portal-page-sub">Track leads, visits & conversion status</p>
      </div>
      <span class="portal-record-count">{{ $all_inqueries_list->count() }} inquiries</span>
   </div>
</div>

<div class="portal-listing">
   <div class="portal-listing-toolbar">
      <div class="portal-listing-toolbar-left">
         <select name="inquery_status" id="search_inquery_status_list" class="portal-select portal-select-sm">
            <option value="" disabled selected>Inquiry Status</option>
            <option value="Active">Active</option>
            <option value="Office_Visited">Office Visited</option>
            <option value="Closed">Closed</option>
            <option value="Converted">Converted</option>
         </select>
         <select name="course_type" id="search_inquery_course_type_list" class="portal-select portal-select-sm">
            <option value="" disabled selected>Course Type</option>
            <option value="PHP Development">PHP Development</option>
            <option value="Web Development">Web Development</option>
            <option value="Digital Marketing">Digital Marketing</option>
            <option value="Web Designing">Web Designing</option>
            <option value="Graphic Designing">Graphic Designing</option>
            <option value="Full Stack Development">Full Stack Development</option>
         </select>
         <form action="{{ url('super-admin/export-inqueries') }}" method="GET" class="portal-inline-form">
            <select name="course_type" id="course_type" class="portal-select portal-select-sm">
               <option value="" disabled selected>Export CSV</option>
               <option value="all">All Inquiries</option>
               <option value="Web Designing">Web Designing</option>
               <option value="Web Development">Web Development</option>
               <option value="PHP Development">PHP Development</option>
               <option value="Digital Marketing">Digital Marketing</option>
               <option value="Full Stack Development">Full Stack Development</option>
               <option value="Graphic">Graphic</option>
            </select>
            <button type="submit" class="portal-btn-outline portal-btn-sm-export" name="submit"><i class="bi bi-download"></i> Export</button>
         </form>
      </div>
      <div class="portal-listing-toolbar-right">
         <a href="{{ url('super-admin/all-converted-inqueries-list') }}" class="portal-btn-outline">Converted</a>
         <a href="{{ url('super-admin/add-new-inquery') }}" class="portal-btn-primary"><i class="bi bi-plus-lg"></i> Add Inquiry</a>
      </div>
   </div>
   <div class="portal-listing-body portal-table-scroll">
      <table id="portalListingTable" class="portal-table portal-table-inquiries">
         <thead>
            <tr>
               <th>#</th>
               <th>Name</th>
               <th>Phone</th>
               <th>Address</th>
               <th>Course</th>
               <th>Visit</th>
               <th>Date</th>
               <th>Priority</th>
               <th>Fees</th>
               <th>Status</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            @php $count = 1; @endphp
            @foreach($all_inqueries_list as $list)
            <tr>
               <td class="col-num">{{ $count++ }}</td>
               <td><span class="portal-person-name" style="cursor:default;">{{ $list->name }}</span></td>
               <td>
                  <a class="portal-phone" href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $list->mobile) }}" target="_blank">
                     <i class="bi bi-whatsapp"></i>{{ substr($list->mobile, 0, 5) . '-' . substr($list->mobile, 5) }}
                  </a>
               </td>
               <td class="portal-cell-muted">{{ $list->address ? (strlen($list->address) > 28 ? substr($list->address, 0, 28) . '…' : $list->address) : '—' }}</td>
               <td>
                  @if($list->course_type && isset($coursePills[$list->course_type]))
                     <span class="portal-pill {{ $coursePills[$list->course_type] }}">{{ $list->course_type }}</span>
                  @else
                     <span class="portal-muted">—</span>
                  @endif
               </td>
               <td>
                  @if($list->visit && isset($visitPills[$list->visit]))
                     <span class="portal-pill {{ $visitPills[$list->visit] }}">{{ $list->visit }}</span>
                  @else
                     <span class="portal-muted">—</span>
                  @endif
               </td>
               <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d M Y') }}</td>
               <td>
                  @if($list->priority && isset($priorityPills[$list->priority]))
                     <span class="portal-pill {{ $priorityPills[$list->priority] }}">{{ ucfirst($list->priority) }}</span>
                  @else
                     <span class="portal-muted">—</span>
                  @endif
               </td>
               <td>{{ $list->total_fees ? '₹' . number_format($list->total_fees) : '—' }}</td>
               <td>
                  @if($list->status && isset($statusBadges[$list->status]))
                     <span class="portal-badge {{ $statusBadges[$list->status] }}">{{ $list->status }}</span>
                  @else
                     <span class="portal-muted">—</span>
                  @endif
               </td>
               <td>
                  <a class="portal-icon-btn portal-icon-edit" href="{{ url('super-admin/edit-inquery', $list->id) }}" title="Edit">
                     <i class="bi bi-pencil"></i>
                  </a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
@endsection
