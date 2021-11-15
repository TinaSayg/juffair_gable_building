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
     input {
    border:none;
    border-bottom: 1px solid #1890ff;
    padding: 20px 10px !important;
    outline: none;
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
    </li>
    <li class="breadcrumb-item">
        <a href="file:///F:/AMS/dashboard.html">
        <i class="fas fa-home"></i></a>
    </li>
    <li class="breadcrumb-item">Units</li>
    
    </ul> --}}
    <div class="row">
        <div class="col-12">
            <div class="card" style="padding:15px 15px">
                <form action="{{ route('units.search_filter') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6" style="margin-top: 1.90rem !important;">
                            <input type="text" autocomplete="off" name="search" placeholder="Search by apartment no" class="form-control">
                        </div>
                        
                        <div class="form-group col-md-1" style="margin-top: 2.0rem !important;">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h4>Apartment List</h4>
            <div class="card-header-form">
                @if(request()->user()->can('create-unit'))
                    <a href="{{ route('units.create') }}" type="button" class="btn btn-primary">Add apartment
                    </a>
                @endif
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-2" class="table table-striped display nowrap"  width="100%" style="">
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Contract Start Date</th>
                        <th>Contract End Date</th>
                        <th>Cpr Copy</th>
                        <th>Apartment No.</th>
                        <th>Apartment Rent</th>
                        <th>Security Deposit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                        <tr style="cursor: pointer" class='clickable-row' data-href='{{route('units.search_by_apartment.show', $unit->id)}}'>
                            <td>{{ isset($unit->tenant) ?  $unit->tenant->tenant_first_name. ' '. $unit->tenant->tenant_last_name : '' }}</td>
                            <td>{{ isset($unit->tenant) ?  \Carbon\Carbon::parse($unit->tenant->lease_period_start_datetime)->toFormattedDateString() : '' }}</td>
                            <td>{{ isset($unit->tenant) ?   \Carbon\Carbon::parse($unit->tenant->lease_period_end_datetime)->toFormattedDateString()  : '' }}</td>
                            <td><a href="{{ url('public/admin/assets/img/documents'). '/' . (isset($unit->tenant)? $unit->tenant->tenant_cpr_copy : '') }}" target="_blank">Click here to view</a></td>
                            
                            <td>{{ $unit->unit_number }}</td>
                            <td>{{ $unit->unit_rent }} BD</td>
                            <td>{{ isset($unit->tenant) ?  $unit->tenant->security_deposit : '' }} BD</td>
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