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
           <h4>All Requests</h4>
            
            
            <div class="card-header-form">
              <a href="{{ route('request.create') }}" class="btn btn-primary" role="button">Add Request</a>
             
            </div>
          </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Assigned Request</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach($complaints as $key => $complain)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $complain->complain_title }}</td>
                      <td>{{ \Carbon\Carbon::parse($complain->compaint_date)->toFormattedDateString() }}</td>
                      <td>
                      @php
                        $class = '';
                        switch ($complain->complain_status_code) {
                          case 1:
                            $class = 'badge-warning';
                            break;
                          case 2:
                            $class = 'badge-success';
                            break;
                          case 3:
                            $class = 'badge-success';
                            break;
                          default:
                            $class = 'badge-danger';
                            break;
                        }
                      @endphp
                      <span class="badge {{ $class }}">
                        {{ isset($complain->complain_status) ? $complain->complain_status->complain_status_name : '' }}
                      </span>
                      </td>
                      <td>
                        @php
                          $user = \App\Models\User::where('id', $complain->assigneed_id)->first();
                        @endphp
                        <span class="badge-outline col-indigo">{{ $user->name }} ({{ $user->userType }})</span>
                      </td>
                     
                      <td>
                        
                        <a href="#" data-toggle="tooltip" data-placement="top" title="View Detail"><i class="fa fa-eye mr-2"></i> </a>
                        @if(Auth::user()->userType != 'employee' && Auth::user()->userType != 'tenant')
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="form_alert('complain-{{ $complain->id }}','Want to delete this Complaint')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                        @endif
                        
                        {{-- <a data-toggle="tooltip" data-placement="top" title="Edit" href="{{ route('complains.edit', $complain->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a> --}}
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Add Solution"><i class="
                          fas fa-thumbs-up mr-2"></i> </a>
                        
                        @if(Auth::user()->userType != 'employee' && Auth::user()->userType != 'tenant')
                        <form action="{{ route('complains.delete', $complain->id) }}"
                            method="post" id="complain-{{ $complain->id }}">
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
              @include('admin.utility_bill.partials.utility_bill_view_modal')
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
        url: '{{route('complains.show', '')}}' + "/"+ id,
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