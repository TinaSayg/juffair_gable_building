@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   tr:hover {
    background: #a3a3a3 !important;
   }
</style>
@stop
@section('content')
<section class="section">
     <div class="row">
       <div class="col-12">
        @if(request()->user()->can('add-maintenance-cost'))
        <a href="{{ route('maintenancecosts.create') }}" type="button"  class="btn btn-primary float-right mb-4" style="padding:7px 35px;">Add Maintenance Cost</a>
        @endif
       </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Maintenance Cost list</h4>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Maintenance Title</th>
                      <th>Location</th>
                      <th>Date</th>
                      <th>Total Amount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($maintenancecosts as $key => $maintenancecost)
                    <tr style="cursor:pointer;">
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ $key+1 }}</td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ $maintenancecost->maintenance_title }}</td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">
                          @if($maintenancecost->location_id == 1)
                          @php
                            $floor_number = \App\Models\FloorDetail::where('id', $maintenancecost->floor_id)->first()->number;
                            $apartment_number = \App\Models\Unit::where('id', $maintenancecost->unit_id)->first()->unit_number;
                          @endphp
                          Apartment {{ $apartment_number }}
                          @endif
  
                          @if($maintenancecost->location_id == 2)
                          @php
                            $location_area = \App\Models\CommonArea::where('id', $maintenancecost->common_area_id)->first()->area_name;
                          @endphp
                          {{ $location_area }}
                          @endif
    
                          @if($maintenancecost->location_id == 3)
                          @php
                            $floor_number = \App\Models\FloorDetail::where('id', $maintenancecost->floor_id)->first()->number;
                          @endphp
                          Floor {{ $floor_number }}
                          @endif
    
                          @if($maintenancecost->location_id == 4)
                            @php
                              $location_area = \App\Models\ServiceArea::where('id', $maintenancecost->service_area_id)->first()->service_area_name;
                            @endphp
                            {{ $location_area }} Area
                          @endif
                        </td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ \Carbon\Carbon::parse($maintenancecost->maintenance_date)->toFormattedDateString() }}</td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ $maintenancecost->maintenance_cost_total_amount}} BD</td>
                        <td>
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                            <div class="dropdown-menu">
                              @if(request()->user()->can('view-maintenance-cost'))
                              <a href="#" onclick="getMaintenancecostDetails({{ $maintenancecost->id }})" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                              @endif
                              @if(request()->user()->can('edit-maintenance-cost'))
                              <a href="{{ route('maintenancecosts.edit', $maintenancecost->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                              @endif
                              @if(request()->user()->can('delete-maintenance-cost'))
                              <div class="dropdown-divider"></div>
                              <a href="#" onclick="form_alert('maintenancecosts-{{ $maintenancecost->id }}','Want to delete this maintenance cost')" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                                Delete</a>
                              @endif
                            </div>
                          </div>
                          @if(request()->user()->can('delete-maintenance-cost'))
                          <form action="{{ route('maintenancecosts.delete', $maintenancecost->id) }}"
                              method="post" id="maintenancecosts-{{ $maintenancecost->id }}">
                              @csrf @method('delete')
                          </form>
                          @endif
                      </td>
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
{{-- maintenance cost modal --}}
<div class="modal" id="maintenancecostModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="card-body">
        <form class="table-responsive">
          <table id="mainTable" class="table table-striped">
            <tbody>
              @include('admin.maintenance.partials.maintenancecost_view_modal')
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/assets/') }}/js/page/datatables.js"></script>
<script>
  function getMaintenancecostDetails(id) {
    $.get({
        url: '{{route('maintenancecosts.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#maintenancecostModal tbody").html(data.html_response)
            $("#maintenancecostModal").modal("show")
        }
    });
  }
</script>
@stop