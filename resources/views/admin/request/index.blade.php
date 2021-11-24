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
           <h4> Maintenance Requests You Reported</h4>
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
                      <th>Location</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Action</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach($maintenancerequest as $key => $item)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $item->title }}</td>
                      <td>
                        @if($item->location_id == 1)
                        @php
                          $floor_number = \App\Models\FloorDetail::where('id', $item->floor_id)->first()->number;
                          $apartment_number = \App\Models\Unit::where('id', $item->unit_id)->first()->unit_number;
                        @endphp
                        Floor {{ $floor_number }}, Apartment {{ $apartment_number }}
                      @endif

                      @if($item->location_id == 2)
                        @php
                          $location_area = \App\Models\CommonArea::where('id', $item->common_area_id)->first()->area_name;
                        @endphp
                        {{ $location_area }}
                      @endif

                      @if($item->location_id == 3)
                      @php
                        $floor_number = \App\Models\FloorDetail::where('id', $item->floor_id)->first()->number;
                      @endphp
                      Floor {{ $floor_number }}
                      @endif

                      @if($item->location_id == 4)
                        @php
                          $location_area = \App\Models\ServiceArea::where('id', $item->service_area_id)->first()->service_area_name;
                        @endphp
                        {{ $location_area }} Area
                      @endif
                      </td>

                      <td>{{ \Carbon\Carbon::parse($item->date)->toFormattedDateString() }}</td>
                      <td>
                      @php
                        $class = '';
                        switch ($item->maintenance_request_status_code) {
                          case 1:
                            $class = 'badge-warning';
                            break;
                          case 2:
                            $class = 'badge-success';
                            break;
                          case 3:
                            $class = 'badge-warning';
                            break;
                          default:
                            $class = 'badge-success';
                            break;
                        }
                      @endphp
                      <span class="badge {{ $class }}">
                        {{ isset($item->maintenance_request_status) ? $item->maintenance_request_status->maintenance_request_status_name : '' }}
                      </span>
                      </td>
                      <td>
                        <div class="dropdown">
                          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                          <div class="dropdown-menu">
                            <a href="{{ route('tasks.show', $item->id) }}" class="dropdown-item has-icon"><i class="
                              fas fa-book"></i>Resubmit</a>
                          </div>
                        </div>
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
{{-- Add Solution Modal --}}
<div class="modal" id="solutionModal" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Add Solution</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="card-body">
        <form action="{{ route('complains.add_solution') }}" method="POST" id="addSolutionForm">
          @csrf
          <div class="row">
            <div class="col-6 mt-3">
              <input type="hidden" name="complain_id" id="solutionComplainInputField">
              <div class="form-group">
                <label for="">Select Status</label>
                <select name="complain_status_code" class="form-control" id="">
                  <option value="">--- Select ---</option>
                  @foreach ($complaint_status_list as $item)
                      <option value="{{ $item->complain_status_code }}">{{  $item->complain_status_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12 mt-3 officer-select" >
              <div class="form-group">
                <label for="">Add Solution</label>
                <textarea name="solution" id="" class="form-control" cols="30" rows="10"></textarea>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary m-t-15 waves-effect">save</button>
        </form>
      </div>
  </div>
</div>
</div>
{{-- request modal --}}
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
{{-- complain modal --}}
<div class="modal" id="complainModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
  $(".add-solution").on("click", function(){
    let complain_id = $(this).parent().attr("data-complain_id")
    $("#solutionComplainInputField").val(complain_id)
    $("#solutionModal").modal("show")
  })

function getComplainDetails(id) {
    
    $.get({
        url: '{{route('complains.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#complainModal tbody").html(data.html_response)
            $("#complainModal").modal("show")
        }
    });
  }
</script>
@stop