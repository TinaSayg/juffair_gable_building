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
         <h4 class="page-title m-b-0">Security Deposit Form</h4>
      </li>
      <li class="breadcrumb-item">
         <a href="file:///F:/AMS/ownerlist.html">
         <i class="fas fa-home"></i></a>
      </li>
   </ul>
   <div class="section-body">
      <form method="POST" action="{{route('securitydeposit.update',$securitydeposit->id) }}" enctype="multipart/form-data">
         @csrf
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
                           <input type="text" name="tenant_first_name" value="@if(isset($securitydeposit)) {{ $securitydeposit->tenant_first_name }} @endif" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Tenant Last Name</label>
                           <input type="text" name="tenant_last_name"  value="@if(isset($securitydeposit)) {{ $securitydeposit->tenant_last_name}} @endif" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Email</label>
                           <input type="text" name="tenant_email_address" value="@if(isset($securitydeposit)) {{ $securitydeposit->tenant_email_address}} @endif" class="form-control">
                        </div>
                          <div class="form-group col-md-4" >
                        <label>Floor</label>
                        <select class="form-control" name="floor_id" onchange="getUnits(this.value)" id="floorSelect">
                            <option value="">---Select---</option>
                            @if(isset($floors_list) && $floors_list->isNotEmpty())
                                @foreach ($floors_list as $floor)
                                    <option value="{{ $floor->id }}" >{{ $floor->floor_number }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-4" >
                        <label>Unit</label>
                        <select class="form-control" name="unit_id" id="unitSelect"></select>
                    </div>
                                <div class="form-group col-md-4">
                               <label>Amount</label>
                             <input type="text" name="security_deposite_total_amount" value="@if(isset($securitydeposit)) {{ $securitydeposit->security_deposite_total_amount }} @endif" class="form-control">
                        </div>
                     </div>
                     <button  class="btn btn-primary mr-1" type="submit">update</a>
                  </div>
               </div>
            </div>
         </div>
   </div>
   </div>
   </form>
   </div>
   </div>
</section>
@stop
@section('footer_scripts')
<script>
    function getUnits(id) {
        $.get({
            url: '{{route('tenants.fetch_units','')}}' + "/"+ id,
            dataType: 'json',
            success: function (data) {
                console.log(data.options)
                $('#unitSelect').empty().append(data.options)
               }
        });
    }
</script>
@stop

