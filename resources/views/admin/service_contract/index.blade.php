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
   tr:hover {
    background: #a3a3a3 !important;
   }
   .finished-contract
   {
     background:#c17676 !important;
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
      <li class="breadcrumb-item">Utility Bills</li>
    
    </ul> --}}
     <div class="row">
       <div class="col-12">
        <a href="{{ route('service_contract.create') }}" class="btn btn-primary float-right mb-4" style="padding: 7px 35px;" role="button">Add New Contract</a>
       </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Service Contract list</h4>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped display nowrap"  width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Cost Per Period</th>
                      <th>Frequency of Pay</th>
                      <th>Contract Start Date</th>
                      <th>Contract End Date</th>
                      <th>Auto Renewal</th>
                      {{-- <th>Status</th> --}}
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($services_contract_list as $key => $item)
                    @php
                      $current_date = \Carbon\Carbon::now()->format('Y-m-d');
                      $contract_end_date = \Carbon\Carbon::parse($item->contract_end_date)->format('Y-m-d');
                      
                      $class = '';
                      if(\Carbon\Carbon::parse($current_date)->gt(\Carbon\Carbon::parse($contract_end_date)))
                      {
                        $class = 'finished-contract';
                      }
                    @endphp
                    <tr style="cursor:pointer" class="@if($class) {{$class}} @endif">
                      <td onclick="getServiceContractDetails({{ $item->id }})">{{ $key+1 }}</td>
                      <td onclick="getServiceContractDetails({{ $item->id }})">{{ $item->Title }}</td>
                      <td onclick="getServiceContractDetails({{ $item->id }})">{{ $item->amount }} BD</td>
                      <td onclick="getServiceContractDetails({{ $item->id }})">{{ $item->frequency_of_pay }}</td>
                      <td onclick="getServiceContractDetails({{ $item->id }})">{{ \Carbon\Carbon::parse($item->contract_start_date)->toFormattedDateString() }}</td>
                      <td onclick="getServiceContractDetails({{ $item->id }})">{{ \Carbon\Carbon::parse($item->contract_end_date)->toFormattedDateString() }}</td>
                      <td>
                        <span class="badge btn-warning">
                          @if($item->auto_renewal == '1')
                          Yes
                          @else
                          No
                          @endif
                        </span>
                      </td>
                      {{-- <td>
                        @php
                          $class = '';
                          switch ($item->service_contract_status_code) {
                            case 1:
                              $class = 'badge-success';
                              break;
                            default:
                              $class = 'badge-danger';
                              break;
                          }
                        @endphp
                        <span class="badge {{ $class }}">{{ isset($item->service_contract_status_code) ? $item->service_contract_status->service_contract_status_name : ''}}</span>
                      </td> --}}
                      <td>
                        <div class="dropdown">
                          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                          <div class="dropdown-menu">
                            <a href="#" onclick="getServiceContractDetails({{ $item->id }})" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                            <a href="{{ route('service_contract.edit', $item->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" onclick="form_alert('service_contract-{{ $item->id }}','Want to delete this Service Contract')" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                              Delete</a>
                          </div>
                        </div>
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
{{-- Service Contract modal --}}
<div class="modal" id="serviceContractModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
  function getServiceContractDetails(id) {
    $.get({
        url: '{{route('service_contract.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#serviceContractModal tbody").html(data.html_response)
            $("#serviceContractModal").modal("show")
        }
    });
  }
</script>
@stop