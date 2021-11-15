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
           <h4>Utility Bill list</h4>
            
            
             <div class="card-header-form">
            <a href="{{ route('utility_bill.create') }}" class="btn btn-primary" role="button">create new</a>
             
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Bill Type</th>
                      <th>Bill Date</th>
                      <th>Total Amount</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($utility_bills as $key => $item)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ isset($item->utility_bill_type)? $item->utility_bill_type->utility_bill_type_name : '' }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->utility_bill_date)->toFormattedDateString() }}</td>
                      <td>{{ $item->utility_bill_total_amount }}</td>
                      <td>
                        @if(request()->user()->can('view-utility-bill'))
                        <a href="#" onclick="getUtilityBillDetails({{ $item->id }})"><i class="fa fa-eye mr-2"></i> </a>
                        @endif
                        @if(request()->user()->can('delete-utility-bill'))
                        <a href="#" onclick="form_alert('utility_bill-{{ $item->id }}','Want to delete this Utility Bill')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                        @endif
                        @if(request()->user()->can('edit-untility-bill'))
                        <a href="{{ route('utility_bill.edit', $item->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                        @endif
                        <form action="{{ route('utility_bill.delete', $item->id) }}"
                            method="post" id="utility_bill-{{ $item->id }}">
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