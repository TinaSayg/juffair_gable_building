@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   
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
                      <th>date</th>
                      <th>Total Amount</th>
                     
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($maintenancecosts as $key => $maintenancecost)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $maintenancecost->maintenance_title }}</td>
                        <td>{{ $maintenancecost->maintenance_description}}</td>
                        <td>{{ \Carbon\Carbon::parse($maintenancecost->maintenance_date)->toFormattedDateString() }}</td>
                        <td>{{ $maintenancecost->maintenance_cost_total_amount}}</td>
                        <td>
                          view-maintenance-cost
                          @if(request()->user()->can('view-maintenance-cost'))
                          <a href="#" onclick="getMaintenancecostDetails({{ $maintenancecost->id }})"><i class="fa fa-eye mr-2"></i> </a>
                          @endif
                          @if(request()->user()->can('delete-maintenance-cost'))
                          <a href="#" onclick="form_alert('maintenancecosts-{{ $maintenancecost->id }}','Want to delete this maintenance cost')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          @endif
                          @if(request()->user()->can('edit-maintenance-cost'))
                          <a href="{{ route('maintenancecosts.edit', $maintenancecost->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          @endif
                          <form action="{{ route('maintenancecosts.delete', $maintenancecost->id) }}"
                            method="post" id="maintenancecosts-{{ $maintenancecost->id }}">
                            @csrf @method('delete')
                        </form> 
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