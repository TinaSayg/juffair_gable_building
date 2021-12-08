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
   tr:hover {
    background: #a3a3a3 !important;
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
        <div class="col-lg-12">
            @if(Auth::user()->userType == 'Admin')
                <a href="{{ route('units.create') }}" style="padding:7px 35px;" type="button" class="btn btn-primary float-right mb-4">Add Apartment
                </a>
            @endif
        </div>
        <div class="col-12">
            <div class="card" style="padding:15px 15px">
                <form action="{{ route('units.search_filter') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- <div class="form-group col-md-3">
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
                            <select class="form-control" name="floor_id"  id="floorSelect">
                                <option value="0" selected disabled>---Select---</option>
                                @foreach ($floor_list as $floor)
                                    <option value="{{ $floor->id }}">{{ $floor->number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Select Type</label>
                            <select name="apartment_type" class="form-control" id="">
                                <option value="0" selected disabled>---Select---</option>
                                <option value="all">All</option>
                                <option value="Type 1">Type 1</option>
                                <option value="Type 2">Type 2</option>
                                <option value="Type 3">Type 3</option>
                                <option value="Type 4">Type 4</option>
                                <option value="Type 5">Type 5</option>
                            </select>
        
                        </div>
                        <div class="form-group col-md-3">
                            <label for="number">Status</label>
                            <select name="unit_status_code" class="form-control" id="unitStatus">
                                <option value="0" selected disabled>---Select---</option>
                                <option value="all">All</option>
                                @foreach ($unit_status as $unit_status)
                                    <option value="{{ $unit_status->unit_status_code }}">{{ $unit_status->unit_status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="number">Select Color</label>
                            <select name="color_code" class="form-control" id="">
                                <option value="">--- Select ---</option>
                                <option value="all">All</option>
                                @foreach ($color_codes_list as $key => $color_code_name)
                                    <option value="{{ $key }}" style="padding:5px 25px;background-color: {{ $key }}">{{ $color_code_name }}</option>
                                @endforeach
                            </select>
                           
                        </div>
                        <div class="form-group col-md-1" style="margin-top: 1.90rem !important;">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-12">
            <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-2" class="table table-striped display nowrap"  width="100%" style="">
                    <thead>
                        <tr>
                            <th>Floor</th>
                            <th>Apartment No.</th>
                            <th>Apartment Type</th>
                            <th>No. of bedrooms</th>
                            <th>Area</th>
                            <th>Status</th>
                            <th>Colour</th>
                            @if(request()->user()->userType == 'general-manager' OR request()->user()->userType == 'Admin')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $user_type = Auth::user()->userType;
                        @endphp
                        @foreach($units as $unit)
                            
                            <tr style="cursor: pointer">
                                <td data-href='{{route('units.full_apartment.show', $unit->id)}}'>{{ isset($unit->floor) ? $unit->floor->number : '' }}</td>
                                <td data-href='{{route('units.full_apartment.show', $unit->id)}}'>{{ $unit->unit_number }}</td>
                                <td data-href='{{route('units.full_apartment.show', $unit->id)}}'>{{ isset($unit->apartment_type) ? $unit->apartment_type : '' }}</td>
                                <td data-href='{{route('units.full_apartment.show', $unit->id)}}'>{{ $unit->no_of_bed_rooms }}</td>
                                <td data-href='{{route('units.full_apartment.show', $unit->id)}}'>{{ $unit->unit_area }} m<sup>2</sup></td>
                                <td data-href='{{route('units.full_apartment.show', $unit->id)}}'>
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
                                    <span  class="badge {{ $class }}">{{ isset($unit->unit_status) ? $unit->unit_status->unit_status_name : '' }}</span>
                                </td>
                                <td data-href='{{route('units.full_apartment.show', $unit->id)}}'><span style="padding:5px 25px;background-color: {{$unit->color_code}};box-shadow: 0 1px 2px;"></span></td>
                                @if(request()->user()->userType == 'general-manager' OR request()->user()->userType == 'Admin')
                                <td>
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('units.show',$unit->id) }}" class="dropdown-item has-icon" ><i class="fas fa-eye"></i> View</a>
                                        @if(Auth::user()->userType == 'Admin')
                                            <div class="dropdown-divider"></div>
                                          <a href="{{ route('units.edit',$unit->id) }}" class="dropdown-item has-icon"><i class="fa fa-pencil-alt"></i> Edit</a>
                                          <a href="#" class="dropdown-item has-icon text-danger" onclick="form_alert('unit-{{ $unit->id }}','Want to delete this apartment')"><i class="far fa-trash-alt"></i>
                                            Delete</a>
                                          @endif
                                        </div>
                                    </div>
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
    $("tr td:not(:last-child)").click(function() {
        window.location = $(this).data("href");
    });
</script>
@stop