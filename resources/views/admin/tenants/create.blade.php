@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
    Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

<style>
   textarea
   {
       height: 75px !important;
   }

   .bootstrap-tagsinput
   {
       height: auto;
       width: 100% !important;
   }
   .bootstrap-tagsinput input
   {
       margin-top: 5px !important;
   }
</style>
@stop
@section('content')


<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
       <li class="breadcrumb-item">
          <h4 class="page-title m-b-0">Create Tenant</h4>
       </li>
       <li class="breadcrumb-item">
          <a href="file:///F:/AMS/tenantlist.html">
          <i class="fas fa-home"></i></a>
       </li>
    </ul> --}}
    <div class="section-body">
    <div class="row">
    <div class="col-12" >
    <form method="POST" action="{{ route('tenants.store') }}" enctype="multipart/form-data" autocomplete="off">
    <div class="card">
       <div class="card-header">
          <h4>Tenant Information</h4>
       </div>
       <div class="card-body">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Tenant First Name</label>
                        <input type="text" maxLength="20" name="tenant_first_name" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tenant Last Name</label>
                        <input type="text" maxLength="20" name="tenant_last_name" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Contact No (Without Country Code)</label>
                        <input type="text" maxLength="8" name="tenant_mobile_phone" id="contactNo" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tenant Email</label>
                        <input type="email" name="tenant_email_address" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Date of birth</label>
                        <input type="text" name="tenant_date_of_birth" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Image</label>
                        <input type="file" name="tenant_image" accept="image/png,image/jpeg" class="form-control">
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label>Password</label>
                        <input type="text" name="password"  class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Present Address</label>
                        <textarea name="tenant_present_address" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Permanent Address</label>
                        <textarea name="tenant_permanent_address" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Home Country Address</label>
                        <textarea name="home_country_address" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label>CPR</label>
                        <input type="text" maxlength="9" name="tenant_cpr_no" class="form-control" id="cprNumber">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Lease Period Start Date</label>
                        <input type="date" name="lease_period_start_datetime" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Lease Period End Date</label>
                        <input type="date" name="lease_period_end_datetime" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Emergency Contact No.</label>
                        <input type="text" maxLength="12" name="emergancy_contact_number" id="emergencyNumber" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Emergency Email</label>
                        <input type="email" name="emergancy_email" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tenant Type</label>
                        <select class="form-control" name="tenant_type_code">
                            @foreach ($tenant_types as $tenant_type)
                                <option value="{{ $tenant_type->tenant_type_code }}">{{ $tenant_type->tenant_type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label>Tenant Passport Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="tenant_passport_copy" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tenant CPR Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="tenant_cpr_copy" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tenant Contract Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="tenant_contract_copy" class="form-control">
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h4>Apartment Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- <div class="form-group col-md-4">
                        <label for="">Floor Type</label>
                        <select class="form-control" name="floor_type_code" onchange="getFloors(this.value)" id="floor_type_code">
                          <option value="0" selected disabled>---Select---</option>
                          @foreach ($floor_types as $floor_type)
                              <option value="{{ $floor_type->floor_type_code }}">{{ $floor_type->floor_type_name }}</option>
                          @endforeach
                        </select>
                    </div> --}}
          
                    <div class="form-group col-md-3">
                        <label for="">Select Floor</label>
                        <select class="form-control" name="floor_id" style="height: 38px;" onchange="getUnits(this.value)" id="floorSelect">
                            <option value="0" selected disabled>---Select---</option>
                            @foreach ($floor_list as $floor)
                                <option value="{{ $floor->id }}">{{ $floor->number }}</option>
                            @endforeach
                        </select>
    
                    </div>
                    <div class="form-group col-md-3" >
                        <label>Select Apartment</label>
                        <select class="form-control" name="unit_id" id="unitSelect" style="height: 38px;"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label style="display: block;">Add Facilities</label>
                        <input type="text" name="all_facilities" class="form-control inputtags">
                      </div>
                    <div class="form-group col-md-4" >
                        <label>Total Rent</label>
                        <input type="text" name="total_rent" class="form-control" style="height: 38px;">
                    </div>
                </div>
                <button class="btn btn-primary mr-1" type="submit">Save</button>
                <a href="{{ url()->previous() }}" class="btn btn-primary mr-1">Cancel</a>
            </div>
        </form>
        </div>
    </div>
</section>    
@stop
@section('footer_scripts')
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{asset('public/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script>
    $(".inputtags").tagsinput('items');
</script>
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

    
    $("#contactNo").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });

    $("#cprNumber").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });

    $("#emergencyNumber").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });

    
</script>
<script>
    $(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });
    });
</script>
<script>
    // function getFloors(id) {
    //     $.get({
    //         url: '{{route('tenants.fetch_floors', '')}}' + "/"+ id,
    //         dataType: 'json',
    //         success: function (data) {
    //             console.log(data.options)
    //             $('#floorSelect').empty().append(data.options)
    //             $('#unitSelect').empty().append(data.options1)
    //            }
    //     });
    // }
    function getUnits(id) {
       
        $.get({
            url: '{{route('floor.fetch_units','')}}' + "/"+ id,
            dataType: 'json',
            success: function (data) {
                console.log(data.options)
                $('#unitSelect').empty().append(data.options)
               }
        });
    }
</script>
<script>
    function getFloors(id) {
          $.get({
              url: '{{route('floor_type.fetch_floors', '')}}' + "/"+ id,
              dataType: 'json',
              success: function (data) {
                  console.log(data.options)
                  $('#floorSelect').empty().append(data.options)
                  $('#unitSelect').empty().append(data.options1)
              }
          });
      }
</script>
@stop