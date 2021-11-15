@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<style>
   
</style>
@stop
@section('content')

    <section class="section">
       
        <div class="section-body">
            <form method="POST" action="{{ route('visitor.store') }}" enctype="multipart/form-data">
                @csrf
                   
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <h4>Visitor Details</h4>
                                </div>
                             <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Visitors Name</label>
                                        <input type="text" name="visitor_full_name" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Date of visit</label>
                                        <input type="date" name="visitor_entry_date" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                    <label>Phone No.</label>
                                    <input type="text" maxLength="12" name="visitor_phone_number" id="contactNo" class="form-control">
                                    
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Floor Type</label>
                                    <select class="form-control" name="floor_type_code" onchange="getFloors(this.value)" id="floor_type_code">
                                      <option value="0" selected disabled>---Select---</option>
                                      @foreach ($floor_types as $floor_type)
                                          <option value="{{ $floor_type->floor_type_code }}">{{ $floor_type->floor_type_name }}</option>
                                      @endforeach
                                    </select>
                                </div>
                      
                                <div class="form-group col-md-4">
                                    <label for="">Select Floor</label>
                                    <select class="form-control" name="floor_id" onchange="getUnits(this.value)" id="floorSelect"></select>
                
                                </div>
                                <div class="form-group col-md-4" >
                                    <label>Unit</label>
                                    <select class="form-control" name="unit_id" id="unitSelect"></select>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>IN</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <div class="input-group-text">
                                              <i class="fas fa-clock"></i>
                                            </div>
                                          </div>
                                          <input type="text"  name="visitor_in_time" class="form-control timepicker">
                                        </div>
                                     </div>
                                    <div class="form-group col-md-4">
                                        <label>Out</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <div class="input-group-text">
                                              <i class="fas fa-clock"></i>
                                            </div>
                                          </div>
                                          <input type="text"  name="visitor_out_time" class="form-control timepicker">
                                        </div>
                                      </div>
                                    </div>
                                 </div>
                                    <button class="btn btn-primary mr-1" type="submit">Save</button>
                                
                        </div>
                    </form>
                    </div>
        </div>
    </section>
@stop
@section('footer_scripts')
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
    
       
    
        
    </script>
<script src="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script>
    function getFloors(id) {
        $.get({
            url: '{{route('floor_type.fetch_all_units_and_floors_list', '')}}' + "/"+ id,
            dataType: 'json',
            success: function (data) {
                console.log(data.options)
                $('#floorSelect').empty().append(data.options)
                $('#unitSelect').empty().append(data.options1)
               }
        });
    }
    function getUnits(id) {
       
        $.get({
            url: '{{route('floor_type.fetch_all_units','')}}' + "/"+ id,
            dataType: 'json',
            success: function (data) {
                console.log(data.options)
                $('#unitSelect').empty().append(data.options)
               }
        });
    }
</script>
@stop