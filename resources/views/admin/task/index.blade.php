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
        @if(\Auth::user()->userType != 'employee')
        <div class="card">
          <div class="card-header">
           <h4>All Tasks</h4>
            
          @if(request()->user()->can('create-task'))
            <div class="card-header-form">
              <a href="{{ route('tasks.create') }}" class="btn btn-primary" role="button">Add Task</a>
            </div>
          @endif
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped display nowrap"  width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Location</th>
                      <th>Assigned Date</th>
                      <th>Deadline Date</th>
                      <th>Completed Date</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tasks as $key => $item)
                    <tr style="cursor: pointer">
                      <td data-href='{{ route('tasks.show', $item->id) }}'>{{ $key+1 }}</td>
                      <td data-href='{{ route('tasks.show', $item->id) }}'>{{ $item->title }}</td>
                      <td data-href='{{ route('tasks.show', $item->id) }}'>
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
                      <td data-href='{{ route('tasks.show', $item->id) }}'>{{ isset($item->assign_date)? \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString(). ' '. \Carbon\Carbon::parse($item->assign_time)->format('g:i A') : '' }} </td>
                      <td data-href='{{ route('tasks.show', $item->id) }}'>{{ isset($item->deadline_date)? \Carbon\Carbon::parse($item->deadline_date)->toFormattedDateString(). ' '. \Carbon\Carbon::parse($item->deadline_time)->format('g:i A') : '' }} </td>
                      <td data-href='{{ route('tasks.show', $item->id) }}'>{{ isset($item->complete_date)? \Carbon\Carbon::parse($item->complete_date)->toFormattedDateString(). ' '. \Carbon\Carbon::parse($item->complete_time)->format('g:i A') : '' }} </td>
                      {{-- <td>{{ isset($item->complete_date)? \Carbon\Carbon::parse($item->complete_date)->toFormattedDateString(). ' '. \Carbon\Carbon::parse($item->complete_time)->format('g:i A') : '' }}</td> --}}
                      <td data-href='{{ route('tasks.show', $item->id) }}'>
                        @php
                          $class = '';
                          switch ($item->task_status_code) {
                            case 1:
                              $class = 'badge-warning';
                              break;
                            default:
                              $class = 'badge-success';
                              break;
                          }
                        @endphp
                        <span class="badge {{ $class }}">{{ isset($item->task_status) ? $item->task_status->task_status_name : ''}}</span>
                      </td>
                      <td>
                        <div class="dropdown">
                          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Options</a>
                          <div class="dropdown-menu">
                            <a href="{{ route('tasks.show', $item->id) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                            <a href="{{ route('tasks.edit', $item->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                            <a href="#" data-task_id="{{  $item->id }}" class="dropdown-item has-icon assign_task"><i class="fas fa-user-shield"></i> Assign Task</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" onclick="form_alert('task-{{ $item->id }}','Want to delete this task')" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                              Delete</a>
                            <form action="{{ route('tasks.delete', $item->id) }}"
                                method="post" id="task-{{ $item->id }}">
                                @csrf @method('delete')
                            </form>
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
        @else
        <div class="card">
          <div class="card-header">
            <h4>Active Tasks</h4>
            <div class="card-header-form">
              <a href="{{ route('tasks.create') }}" class="btn btn-primary" role="button">Add Task</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="tableExport" class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Date Assigned</th>
                    <th>Deadline Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $tasks = \App\Models\Task::where('assignee_id', Auth::user()->id)->whereIn('task_status_code', [1,2])->orderBy('id','desc')->get();
                  @endphp
                  @foreach($tasks as $key => $item)
                  <tr style="cursor: pointer">
                    <th>{{ $key+1 }}</th>
                    <td>{{ $item->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString() }} {{ \Carbon\Carbon::parse($item->assign_time)->format('g:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->deadling_date)->toFormattedDateString() }} {{ \Carbon\Carbon::parse($item->deadline_time)->format('g:i A') }}</td>
                    <td>
                      <span class="badge badge-warning" style="border-radius: 0px !important">{{ isset($item->task_status) ? $item->task_status->task_status_name : ''}}</span>
                    </td>
                    <td>
                      <a href="{{ route('tasks.show', $item->id) }}" type="button" class="btn btn-primary">View Task</a>
                      @if($item->task_status_code != 2)
                      <a href="#" data-task_id="{{ $item->id }}" data-target="#confirmModal" data-toggle="modal" type="button" class="btn btn-success complete-task-button">Complete Task</a>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </section>
  <div class="modal" id="confirmModal" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Confirm Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="card-body">
          <form action="{{ url('') }}" method="POST" id="completeTaskForm">
            @csrf
            <div>
              <p>Do you want to complete this task?</p>
            </div>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">save</button>
          </form>
        </div>
    </div>
  </div>
  </div>

  <div class="modal" id="requestDetailModal" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">View</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="card-body">
            <table id="mainTable" class="table table-striped">
              <tbody>
                @include('admin.task.partials.request_detail_modal')
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>

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
          <form action="{{ route('tasks.assign_task') }}" method="POST" id="assignTaskForm">
            @csrf
            <div class="row">
              <div class="col-6">
                <input type="hidden" name="task_id" id="assignTaskModalHiddenInput">
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



@stop
@section('footer_scripts')
<!-- JS Libraies -->
<!-- JS Libraies -->
<script src="{{asset('public/admin/assets/bundles/datatables/datatables.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/jszip.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/pdfmake.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/vfs_fonts.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.print.min.js')}}"></script>
<script src="{{asset('public/admin/assets/js/page/datatables.js')}}"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
  $('#tableExport2').DataTable({
    dom: 'Bfrtip',
    "ordering": false,
    buttons: [
      'excel', 'pdf', 'print'
    ]
  })

  $(".complete-task-button").click(function(){
    let task_id = $(this).attr('data-task_id')
   
    let action = $("#completeTaskForm").attr("action") + '/tasks/task/complete/' + task_id
    
    $("#completeTaskForm").attr("action", action)
  })
  
  function get_request_details(id) {
    $.get({
        url: '{{route('request.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            $("#requestDetailModal tbody").html(data.html_response)
            $("#requestDetailModal").modal("show")
        }
    });
  }

</script>
<script>
  $("tr td:not(:last-child)").click(function() {
      window.location = $(this).data("href");
  });

  $(".assign_task").on("click", function(){
    let task_id = $(this).attr('data-task_id')
    $("#assignTaskModalHiddenInput").val(task_id)
    $("#assignTaskModal").modal("show")
  })
</script>
@stop