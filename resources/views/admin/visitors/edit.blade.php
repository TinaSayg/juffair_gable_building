@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<style>
</style>
@stop
@section('content')
<section class="section">
   
   <div class="section-body">
      <form method="POST" action="{{route('visitor.update',$visitor->id) }}" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h4>Visitor Details</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-4">
                           <label>Visitors Name</label>
                           <input type="text" name="visitor_full_name" value="@if(isset($visitor)) {{ $visitor->visitor_full_name }} @endif" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Date of visit</label>
                           <input type="text" value="{{ isset($visitor) ? \Carbon\Carbon::parse($visitor->visitor_entry_date)->format('Y-m-d') : ''}}"  name="visitor_entry_date" class="form-control datepicker">
                           
                        </div>
                        <div class="form-group col-md-4">
                           <label>Phone No.</label>
                           <input type="text" name="visitor_phone_number" value="{{ isset($visitor->visitor_phone_number)? $visitor->visitor_phone_number : '' }}" id="contactNo" class="form-control">
                        </div>
                           <div class="form-group col-md-4">
                              <label for="">Floor Type</label>
                              <select class="form-control" name="floor_type_code" onchange="getFloors(this.value)" id="floor_type_code">
                                @foreach ($floor_types as $floor_type)
                                    <option value="{{ $floor_type->floor_type_code }}" {{(isset($tenant) && ($tenant->unit->floor->floor_type_code == $floor_type->floor_type_code)) ? 'selected': '' }}>{{ $floor_type->floor_type_name }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Select Floor</label>
                              <select class="form-control" name="floor_id" onchange="getUnits(this.value)" id="floorSelect">
                                  @foreach ($floors as $floor)
                                      <option value="{{ $floor->id }}" {{ (isset($tenant) && ($tenant->floor_id == $floor->id)) ? 'selected' :'' }}>{{ $floor->number}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group col-md-4" >
                              <label>Unit</label>
                              <select class="form-control" name="unit_id"  id="unitSelect">
                                  @foreach ($units as $unit)
                                      <option value="{{ $unit->id }}" {{ (isset($tenant) && ($tenant->unit_id == $unit->id)) ? 'selected' :'' }}>{{ $unit->unit_number}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                              <label>In</label>
                               <input type="text" name="visitor_in_time" value="@if(isset($visitor)) {{ $visitor->visitor_in_time }} @endif"  class="form-control timepicker">
                           </div>
                           <div class="form-group col-md-4">
                              <label>Out</label>
                              <input type="text" name="visitor_out_time" value="@if(isset($visitor)) {{ $visitor->visitor_out_time }} @endif"  class="form-control timepicker">
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


