@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="container py-4">
    <!--header-->
    <div class="header-bar d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h5 class="mb-0 fw-semibold text-dark">
                Employees
                <span class="separator mx-2">|</span>
                    <i class="bi bi-house-door-fill"></i>
                <span class="text-muted">
                    – All Trash Employees
                </span>
            </h5>
        </div>
        <a href="javascript:void(0);" class="action-btn trash-btn tooltip-trash btn-trash" data-tooltip="Back" data-link="{{ url('super-admin/all-employees') }}">
            <i class="bi bi-arrow-left-circle-fill text-dark me-1"></i> Back
        </a>
    </div>
    <!--search-->
    <div id="result" class="row mt-3"></div>
    <!--employee cards response-->
    <div id="fullList" class="row g-4">
        <!--Check if employee exist or not-->
        @if($all_customers->count() > 0)
        <!--Get all customers-->
        @foreach($all_customers as $customer)
        <div class="col-md-3 col-sm-6">
            <div class="employee-card">
                @if($customer->user_pic)
                    <img src="{{ url('public/uploads/employees/' . $customer->user_pic) }}" class="profile-img" alt="Thakur Singh">
                @else 
                    <img src="{{ url('public/uploads/users/default_user.png') }}" class="profile-img" alt="Thakur Singh">
                @endif
                <p class="emp-name">{{ $customer->name }}</p>
                <p class="emp-role">{{ $customer->employee_role }}</p>
                <div class="action-icons">
                    <a href="javascript:void(0);" class="action-btn btn-view tooltip-custom" data-title="View Details" data-link="{{ url('super-admin/employee-report', $customer->id) }}">
                        <i class="bi bi-search"></i>
                    </a>
                    <a href="javascript:void(0);" class="action-btn btn-edit tooltip-custom" data-title="Edit" data-link="{{ url('super-admin/edit-employee', $customer->id) }}">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @else 
        <div class="no-trash-message">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            No trash record found.
        </div>
        @endif
    </div>
</div>
<!--top scroll loader-->
<div id="topLoaderBar"></div>
<!--blur background-->
<div id="overlayBlur"></div>
@endsection