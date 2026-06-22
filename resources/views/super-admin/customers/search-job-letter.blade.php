@extends('super-admin.layouts.master')
@section('content')
<div class="space-remove"></div>
<div class="container py-4">
   <!--search-->
    <div class="row mb-3">
        <div class="col-md-6 offset-md-3">
            <div class="input-group shadow-sm">
                <input type="text" name="customer_names" id="customer_names" class="form-control border-end-0" placeholder="Search Employee" required>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <!--response-->
            <div id="resultContainer" class="text-danger mt-2"></div>
        </div>
    </div>
</div>
<!--top scroll loader-->
<div id="topLoaderBar"></div>
<!--blur overlay-->
<div id="overlayBlur"></div>
@endsection