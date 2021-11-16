@extends('layouts.admin.app')
{{-- Page title --}}
{{-- @section('title')
    AMS
@stop --}}
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   
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
      <li class="breadcrumb-item">Utility Bills</li>
    
    </ul> --}}
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Service Contract list</h4>
            
            
             <div class="card-header-form">
            <a href="{{ route('service_contract.create') }}" class="btn btn-primary" role="button">Add new contract</a>
             
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Contract Description</th>
                      <th>Contract Cost</th>
                      <th>Frequency of pay</th>
                      <th>Renew Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($services_contract_list as $key => $item)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $item->description }}</td>
                      <td>{{ $item->amount }} BD</td>
                      <td>{{ $item->frequency_of_pay }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->contract_renew_date)->toFormattedDateString() }}</td>
                      <td>
                        @if(request()->user()->can('view-utility-bill'))
                        <a href="#" onclick="getUtilityBillDetails({{ $item->id }})"><i class="fa fa-eye mr-2"></i> </a>
                        @endif
                        
                        <a href="#" onclick="form_alert('service_contract-{{ $item->id }}','Want to delete this Service Contract')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                       
                        <a href="{{ route('service_contract.edit', $item->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                        
                        <form action="{{ route('service_contract.delete', $item->id) }}"
                            method="post" id="service_contract-{{ $item->id }}">
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
{{-- Utility Bill modal --}}
<div class="modal" id="utilityBillModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
              @include('admin.task.partials.request_detail_modal')
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
  function getUtilityBillDetails(id) {
    
    $.get({
        url: '{{route('utility_bill.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#utilityBillModal tbody").html(data.html_response)
            $("#utilityBillModal").modal("show")
        }
    });
  }
</script>
@stop