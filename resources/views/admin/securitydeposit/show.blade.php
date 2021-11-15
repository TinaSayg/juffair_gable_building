@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
    AMS - Security Deposit List 
@stop
{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')
<section class="section">
    <ul class="breadcrumb breadcrumb-style ">
      <li class="breadcrumb-item">
        <h4 class="page-title m-b-0">Security Deposit Details</h4>
      </li>
      <li class="breadcrumb-item">
        <a href="file:///F:/AMS/ownerlist.html">
          <i class="fas fa-home"></i></a>
      </li>
      
    </ul>
    <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <h4>Security Deposit Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Tenant First Name</label>
                                <input type="text" name="tenant_first_name" value="{{ isset($securitydeposit->tenant_first_name) ? $securitydeposit->tenant_first_name : '' }}"  class="form-control">
                            </div>
                             <div class="form-group col-md-4">
                                <label>Tenant last Name</label>
                                <input type="text" name="tenant_last_name" value="{{ isset($securitydeposit->tenant_last_name) ? $securitydeposit->tenant_last_name : '' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Email</label>
                                <input type="text" name="tenant_email_address" value="{{ isset($securitydeposit->tenant_email_address) ? $securitydeposit->tenant_email_address : '' }}" class="form-control">
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Floor</label>
                                <input type="text" name="floor_id" value="{{ isset($complaint->employee_id) ? $complaint->employee_id : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>unit</label>
                                <input type="text" name="unit_id" {{ isset($securitydeposit->unit) ? $securitydeposit->unit->unit_number : '' }} class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Amount</label>
                                <input type="text" name="security_deposite_total_amount" value="{{ isset($securitydeposit->security_deposite_total_amount) ? $securitydeposit->security_deposite_total_amount : '' }}" class="form-control">
                            </div>
                    </div>
                    <a href="{{ route('securitydeposit.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>
@stop
@section('footer_scripts')
<script>
  
</script>
@stop