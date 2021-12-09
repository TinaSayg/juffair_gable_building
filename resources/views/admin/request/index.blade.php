@extends('layouts.admin.app')
{{-- Page title --}}
{{-- @section('title')
    AMS
@stop --}}
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<style>
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
      <li class="breadcrumb-item">Utility Bills</li>
    
    </ul> --}}
      <div class="row">
        <div class="col-12">
          <a href="{{ route('request.create') }}" class="btn btn-primary float-right mb-4" style="padding:7px 35px;" role="button">Add Request</a>

        </div>
        <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>
             @if(Auth::user()->userType == 'general-manager')
             Incoming Request
             @else
             Maintenance Requests You Reported
             @endif
            </h4>
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
                    @php
                      if(Auth::user()->userType == 'employee')
                      {
                        $maintenancerequest = \App\Models\MaintenanceRequest::where('user_id', Auth::user()->id)->get();
                      }
                    @endphp
                    @foreach($maintenancerequest as $key => $item)
                    <tr style="cursor: pointer">
                      <th onclick="getRequestMentenanceDetails({{ $item->id }})">{{ $key+1 }}</th>
                      <td onclick="getRequestMentenanceDetails({{ $item->id }})">{{ $item->title }}</td>
                      <td onclick="getRequestMentenanceDetails({{ $item->id }})">
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
                      <td onclick="getRequestMentenanceDetails({{ $item->id }})">
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
                            <a href="#" class="dropdown-item has-icon" onclick="getRequestMentenanceDetails({{ $item->id }})"><i class="fas fa-eye"></i> View</a>
                            @if($item->maintenance_request_status_code == 1)
                            <a href="{{ route('request.edit', $item->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i>Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item has-icon" onclick="form_alert('maintenance-request-{{ $item->id }}','Want to delete this request')"><i class="fas fa-trash"></i>Delete</a>
                            @endif
                            {{-- <a href="" class="dropdown-item has-icon"><i class="
                              fas fa-book"></i>Resubmit</a> --}}
                              @if(Auth::user()->userType == 'general-manager' &&  $item->maintenance_request_status_code != 3)
                                @if($item->maintenance_request_status_code ==1)
                                <a href="#" data-request_id="{{ $item->id }}" class="dropdown-item has-icon under-review" ><i class="
                                  fas fa-pen-square" style="color:green;"></i>Under Review</a>
                                @endif
                                @if($item->maintenance_request_status_code ==1 || $item->maintenance_request_status_code ==2)
                                  <a href="#" data-request_id="{{ $item->id }}" class="dropdown-item has-icon assign_task"><i class="fas fa-user-shield"></i>Assign Task</a>
                                @endif
                              @endif
                          </div>
                          <form action="{{ route('request.delete', $item->id) }}"
                            method="post" id="maintenance-request-{{ $item->id }}">
                            @csrf @method('delete')
                          </form>
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
  <div class="modal" id="assignTaskModal" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Assign Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="card-body">
          <form action="{{ route('tasks.assign_task_for_maintenance') }}" method="POST" id="assignTaskForm">
            @csrf
            <div class="row">
              <div class="col-6">
                <input type="hidden" name="maintenance_request_id" id="assignTaskModalHiddenInput">
                <div class="form-group">
                  <label for="">Select Employee</label>
                  <select name="employee_id" class="form-control" id="">
                    <option value="">--- Select ---</option>
                    @foreach ($employee_list as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Assign Date</label>
                  <input type="text" name="assign_date" class="form-control datepicker">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Assign Time</label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="fas fa-clock"></i>
                          </div>
                      </div>
                      <input type="text"  name="assign_time" class="form-control timepicker">
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Deadline Date</label>
                  <input type="text" name="deadline_date" class="form-control datepicker">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Deadline Time</label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="fas fa-clock"></i>
                          </div>
                      </div>
                      <input type="text" name="deadline_time" class="form-control timepicker">
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Comment</label>
                  <textarea name="comment" id="" class="form-control" cols="30" rows="10"></textarea>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Assign</button>
          </form>
        </div>
    </div>
  </div>
  </div>
{{-- request modal --}}
<div class="modal" id="maintenanceRequestModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
<script src="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script>

  $(".assign_task").on("click", function(){
    
    let request_id = $(this).attr("data-request_id")
    $("#assignTaskModalHiddenInput").val(request_id)
    $("#assignTaskModal").modal("show")
  })
  
  $(".under-review").on("click", function(){
    
    let request_id = $(this).attr("data-request_id")

    $.get({
        url: '{{route('request.under_review', '')}}' + "/"+ request_id,
        dataType: 'json',
        success: function (data) {
          setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
          }, 1000); 
        }
    });

  })
 

function getRequestMentenanceDetails(id) {
    
    $.get({
        url: '{{route('request.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#maintenanceRequestModal tbody").html(data.html_response)
            $("#maintenanceRequestModal").modal("show")
        }
    });
  }
</script>
@stop