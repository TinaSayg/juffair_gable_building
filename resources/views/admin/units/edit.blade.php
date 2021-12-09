@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<style>
   .bootstrap-tagsinput
   {
       width: 100%;
       padding: 9px 6px;
   }
   .sup
   {
     vertical-align: super;
     font-size: 18px;
   }
</style>
@stop
@section('content')
<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
      <li class="breadcrumb-item">
        <a href="index.html">
          <i class="fas fa-home"></i></a>
      </li>
      <li class="breadcrumb-item">Units</li>
      <li class="breadcrumb-item">Add Unit</li>
    </ul> --}}
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <form 
            action="{{ isset($unit) ? route('units.update', $unit->id) : '' }}" 
             method="POST"  enctype="multipart/form-data">
              @csrf
              <div class="card-header">
                <h4>Edit Apartment</h4>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  {{-- <div class="form-group col-md-6">
                    <label for="">Floor Type</label>
                    <select class="form-control" name="floor_type_code" onchange="getFloors(this.value)" id="floor_type_code">
                      @foreach ($floor_types as $floor_type)
                          <option value="{{ $floor_type->floor_type_code }}" {{(isset($unit->floor->floor_type) && ($floor_type->floor_type_code == $unit->floor->floor_type->floor_type_code)) ? 'selected' : ''}}>{{ $floor_type->floor_type_name }}</option>
                      @endforeach
                    </select>
                  </div> --}}

                  
                  <div class="form-group col-md-6">
                    <select class="form-control" name="floor_id"  id="floorSelect">
                      <option value="0" selected disabled>---Select---</option>
                      @foreach ($floor_list as $floor)
                          <option value="{{ $floor->id }}" @if($unit->floor_id == $floor->id) selected @endif>{{ $floor->number }}</option>
                      @endforeach
                    </select>
                    
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Apartment Number</label>
                    <input type="text" value="{{ $unit->unit_number }}" name="unit_number" class="form-control" maxlength="4" id="unitNumber">
                  </div>
                </div>
                <div class="form-group row">
                    
                    <div class="form-group col-md-3">
                      <label for="name">Apartment Type</label>
                      <select name="apartment_type" class="form-control" id="">
                        <option value="Type 1" @if($unit->apartment_type == 'Type 1') selected @endif>Type 1</option>
                        <option value="Type 2" @if($unit->apartment_type == 'Type 2') selected @endif>Type 2</option>
                        <option value="Type 3" @if($unit->apartment_type == 'Type 3') selected @endif>Type 3</option>
                        <option value="Type 4" @if($unit->apartment_type == 'Type 4') selected @endif>Type 4</option>
                        <option value="Type 5" @if($unit->apartment_type == 'Type 5') selected @endif>Type 5</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="">Pick Color</label>
                      <input type="text" value="{{ $unit->color_code }}" name="color_code" class="form-control colorpickerinput">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="name">No of bed rooms</label>
                      <select class="form-control" name="no_of_bed_rooms" id="">
                        @for($i= 1; $i<=10; $i++)
                        <option value="{{ $i }}" {{ (isset($unit) && ($unit->no_of_bed_rooms == $i)) ? 'selected': '' }}>{{ $i }}</option>
                        @endfor
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="number">Apartment Area (m<sup>2</sup>)</label>
                      <input type="text" value="{{ $unit->unit_area }}" maxlength="3" name="unit_area" placeholder="" class="form-control" id="unitArea">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="number">Apartment Status</label>
                      <select name="unit_status_code" class="form-control" id="unitStatus">
                        @foreach ($unit_status as $unit_status)
                            <option value="{{ $unit_status->unit_status_code }}" {{ (isset($unit) && ($unit->unit_status_code == $unit_status->unit_status_code)) ? 'selected': '' }}>{{ $unit_status->unit_status_name }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
                  
                  
                 
      </div>

      
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ url()->previous() }}"  class="btn btn-primary ml-2">Cancel</a>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script src="{{asset('public/admin/assets/bundles/datatables/datatables.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/jszip.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/pdfmake.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/vfs_fonts.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.print.min.js')}}"></script>
<script src="{{asset('public/admin/assets/js/page/datatables.js')}}"></script>
<!-- Page Specific JS File -->
<script src="{{asset('public/admin/assets/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
{{-- <script src="{{asset('public/admin/assets/js/page/forms-advanced-forms.js') }}"></script> --}}
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

   
    $("#unitNumber").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });

    $("#noOFBeds").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });

    $("#unitArea").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });

    
</script>
<script>
  $(".colorpickerinput").colorpicker({
      format: 'hex',
      component: '.input-group-append',
  });
</script>
<script>
function getFloors(id) {
      $.get({
          url: '{{route('floor_type.fetch_floors', '')}}' + "/"+ id,
          dataType: 'json',
          success: function (data) {
              console.log(data.options)
              $('#floorSelect').empty().append(data.options)
          }
      });
  }
</script>
@stop