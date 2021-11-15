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
          <h4 class="page-title m-b-0">Update Utility Bill</h4>
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
              <h4>Update Utility Bill Form</h4>
            </div>
            <div class="card-body">
            <form method="POSt" action="{{ route('utility_bill.update' , $utility_bill->id) }}" enctype="multipart/form-data">
              @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Bill Type</label>
                        <select class="form-control" name="utility_bill_type_code" >
                            @foreach ($utility_bill_types as $item)
                                <option value="{{ $item->utility_bill_type_code }}" {{ isset($utility_bill) && ($item->utility_bill_type_code == $utility_bill->utility_bill_type_code) ? 'selected' : '' }}>{{ $item->utility_bill_type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Bill Date</label>
                        <input type="text" value="{{ isset($utility_bill) ? \Carbon\Carbon::parse($utility_bill->utility_bill_date)->format('Y-m-d') : ''}}"  name="utility_bill_date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Bill Month</label>
                        <input type="text" value="{{ isset($utility_bill) ? $utility_bill->utility_bill_month : ''}}" name="utility_bill_month" class="form-control">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-4">
                        <label>Bill Year</label>
                        <input type="text" value="{{ isset($utility_bill) ? $utility_bill->utility_bill_year : ''}}" name="utility_bill_year" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total Amount</label>
                        <input type="text" value="{{ isset($utility_bill) ? $utility_bill->utility_bill_total_amount : ''}}" name="utility_bill_total_amount" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>details</label>
                        <textarea name="utility_bill_description" value="" class="form-control">{{ isset($utility_bill) ? $utility_bill->utility_bill_description : ''}}</textarea>
                    </div>
                    </div>
                    <div class="row">
                    
                    <div class="form-group col-md-4">
                        <label>Upload Bill</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <hr>
                <button class="btn btn-primary mr-1" type="submit">update</button>
                </div>
            </from>
          </div>
</section>    
@stop
@section('footer_scripts')
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

@stop