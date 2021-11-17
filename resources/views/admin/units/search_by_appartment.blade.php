@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   .sup
   {
     vertical-align: super;
     font-size: 18px;
   }
   input {
    border:none;
    border-bottom: 1px solid #1890ff;
    padding: 20px 10px !important;
    outline: none;
     }
</style>
@stop
@section('content')
<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
    <li class="breadcrumb-item">
    </li>
    <li class="breadcrumb-item">
        <a href="file:///F:/AMS/dashboard.html">
        <i class="fas fa-home"></i></a>
    </li>
    <li class="breadcrumb-item">Units</li>
    
    </ul> --}}
    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <div class="card" style="padding:15px 15px">
                    <form action="{{ route('units.search_by_apartment_list') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-top: 1.90rem !important;">
                                <label for="">Apartment No.</label>
                                <input type="text" autocomplete="off" name="apartment_number" placeholder="e.g 10" class="form-control">
                            </div>
                            
                            <div class="form-group col-md-1" style="margin-top: 3.8rem !important;">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @if(\Auth::user()->userType == 'general-manager')
            <div class="card" style="padding:15px 15px">
                <form action="{{ route('units.search_filter') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="">Floor Type</label>
                            <select class="form-control" name="floor_type_code" onchange="getFloors(this.value)" id="floor_type_code">
                                <option value="0" selected disabled>---Select---</option>
                                @foreach ($floor_types as $floor_type)
                                    <option value="{{ $floor_type->floor_type_code }}">{{ $floor_type->floor_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Select Floor</label>
                            <select class="form-control" name="floor_id" id="floorSelect"></select>
        
                        </div>
                        <div class="form-group col-md-2">
                            <label for="number">Status</label>
                            <select name="unit_status_code" class="form-control" id="unitStatus">
                                <option value="0" selected disabled>---Select---</option>
                                
                                @foreach ($unit_status as $unit_status)
                                    <option value="{{ $unit_status->unit_status_code }}">{{ $unit_status->unit_status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="number">Color Code</label>
                            <input type="text" value="{{ old('color_code') }}" name="color_code" class="form-control">
                        </div>
                        <div class="form-group col-md-1" style="margin-top: 1.90rem !important;">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h4>Apartment List</h4>
                <div class="card-header-form">
                    @if(request()->user()->can('create-unit'))
                        <a href="{{ route('units.create') }}" type="button" class="btn btn-primary">Add appartment
                        </a>
                    @endif
                </div>
                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-2" class="table table-striped display nowrap"  width="100%" style="">
                    <thead>
                        <tr>
                            <th>Floor</th>
                            <th>Apartment No.</th>
                            <th>Apartment Rent</th>
                            <th>Apartment Type</th>
                            <th>No. of bedrooms</th>
                            <th>Apartment Area</th>
                            <th>Status</th>
                            <th>Colour Code</th>
                            @if(request()->user()->userType == 'general-manager')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $user_type = Auth::user()->userType;
                        @endphp
                        @foreach($units as $unit)
                            
                            <tr @if($user_type == 'officer') style="cursor: pointer" class='clickable-row' data-href='{{route('units.search_by_apartment.show', $unit->id)}}' @endif>
                                <td>{{ isset($unit->floor) ? $unit->floor->number : '' }}</td>
                                <td>{{ $unit->unit_number }}</td>
                                <td>{{ $unit->unit_rent }} BD</td>
                                <td>{{ isset($unit->floor->floor_type) ? $unit->floor->floor_type->floor_type_name : '' }}</td>
                                <td>{{ $unit->no_of_bed_rooms }}</td>
                                <td>{{ $unit->unit_area }} m<sup>2</sup></td>
                                <td>
                                    @php
                                        $class = '';
                                        switch ( $unit->unit_status_code) {
                                        case 1:
                                            $class = 'badge-success';
                                            break;
                                        default:
                                            $class = 'badge-warning';
                                            break;
                                        }
                                    @endphp
                                    <span class="badge {{ $class }}">{{ isset($unit->unit_status) ? $unit->unit_status->unit_status_name : '' }}</span>
                                </td>
                                <td>{{ $unit->color_code }}</td>
                                @if(request()->user()->userType == 'general-manager')
                                <td>
                                    <a href="{{ route('units.show',$unit->id) }}"><i class="fa fa-eye mr-2" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                                    @if(request()->user()->can('delete-unit'))
                                        <a href="#" onclick="form_alert('unit-{{ $unit->id }}','Want to delete this unit')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                                    @endif
                                    @if(request()->user()->can('edit-unit'))
                                        <a href="{{ route('units.edit',$unit->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                                    @endif
                                    <form action="{{route('units.delete',[$unit->id])}}"
                                    method="post" id="unit-{{ $unit->id }}">
                                        @csrf @method('delete')
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/assets/') }}/js/page/datatables.js"></script>
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
<script>
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
</script>
@stop