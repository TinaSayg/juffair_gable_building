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
   
    </ul>
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Maintenance Cost list</h4>
            
            
             <div class="card-header-form">
              @if(request()->user()->can('add-maintenance-cost'))
              <a href="{{ route('maintenancecosts.create') }}" type="button"  class="btn btn-primary">Add Maintenance Cost</a>
              @endif
             </a>
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Maintenance Title</th>
                      <th>Description</th>
                      <th>Date</th>
                      <th>Total Amount</th>
                     
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($maintenancecosts as $key => $maintenancecost)
                    <tr style="cursor:pointer;">
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ $key+1 }}</td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ $maintenancecost->maintenance_title }}</td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ $maintenancecost->maintenance_description}}</td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ \Carbon\Carbon::parse($maintenancecost->maintenance_date)->toFormattedDateString() }}</td>
                        <td onclick="getMaintenancecostDetails({{ $maintenancecost->id }})">{{ $maintenancecost->maintenance_cost_total_amount}}</td>
                        <td>
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Options</a>
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