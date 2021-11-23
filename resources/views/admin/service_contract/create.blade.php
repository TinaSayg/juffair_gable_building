@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
   
</style>
@stop
@section('content')


<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
       <li class="breadcrumb-item">
          <h4 class="page-title m-b-0">Create Utility Bill</h4>
       </li>
       <li class="breadcrumb-item">
          <a href="file:///F:/AMS/tenantlist.html">
          <i class="fas fa-home"></i></a>
       </li>
    </ul> --}}
    <div class="section-body">
    <div class="row">
    <div class="col-12" >
        <div class="card">
            <div class="card-header">
              <h4>Service Contract Form</h4>
            </div>
            <div class="card-body">
            <form method="POSt" action="{{ route('service_contract.store') }}" enctype="multipart/form-data">
              @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Contract description</label>
                        <textarea name="contract_description" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Contract cost</label>
                        <input type="text" name="contract_cost" id="contractCost" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Frequency of pay</label>
                        <input type="text" name="frequency_of_pay" id="frequencyOFPay" class="form-control">
                    </div>
                    <div class="form-group col-md-4 attachdocument">
                        <label>Upload File</label>
                        <input type="file" name="image" accept="application/pdf" class="form-control">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-4">
                        <label>Renew date</label>
                        <input type="text" name="renew_date" class="form-control datepicker">
                    </div>
                </div>
               
                <button class="btn btn-primary mr-1" type="submit">Save</button>
                </div>
            </from>
          </div>
</section>    
@stop
@section('footer_scripts')
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
    (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
                });
            };
        }(jQuery));
    
        
        $("#contractCost").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });
    
        $("#frequencyOFPay").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });
    
    
        
    </script>
@stop