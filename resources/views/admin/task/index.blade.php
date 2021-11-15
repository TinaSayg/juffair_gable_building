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
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Date</th>
                      <th>time</th>
                      <th>Assign by</th>
                      <th>Assign to</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tasks as $key => $item)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $item->title }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString() }}</td>
                      <td>{{ $item->assign_time }}</td>
                      <td>{{ \App\Models\User::where('id' , $item->assignor_id)->first()->name }}</td>
                      <td>{{ \App\Models\User::where('id' , $item->assignee_id)->first()->name }}</td>
                      <td>{{ isset($item->task_status) ? $item->task_status->task_status_name : ''}}</td>
                      <td>
                        @if(request()->user()->can('view-task'))
                        <a href="{{ route('tasks.show', $item->id) }}"><i class="fa fa-eye mr-2"></i> </a>
                        @endif
                        @if(request()->user()->can('delete-task'))
                        <a href="#" onclick="form_alert('task-{{ $item->id }}','Want to delete this task')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                        @endif
                        @if(request()->user()->can('edit-task'))
                        <a href="{{ route('tasks.edit', $item->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                        @endif
                        <form action="{{ route('tasks.delete', $item->id) }}"
                            method="post" id="task-{{ $item->id }}">
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
        @else
        <div class="card">
          <div class="card-header">
            <h4>My Task</h4>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link @if(!request()->has('tab')) active @endif" id="assigned-work-tab" data-toggle="tab" href="#assignedWork" role="tab"
                  aria-controls="home" aria-selected="true">Assigned Work</a>
              </li>
              <li class="nav-item">
                <a class="nav-link @if(request()->has('tab')) active @endif" id="raise-request-tab" data-toggle="tab" href="#raiseRequest" role="tab"
                  aria-controls="profile" aria-selected="false">Raise Request</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane @if(!request()->has('tab')) active @else fade @endif" id="assignedWork" role="tabpanel" aria-labelledby="assigned-work-tab">
                <div class="my-2 mr-3" style="text-align: right;">
                  <a href="{{ route('tasks.create') }}" class="btn btn-primary" role="button">Add Task</a>
                </div>
                <div class="table-responsive">
                  <table id="tableExport" class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>time</th>
                        <th>Assign by</th>
                        <th>Assign to</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $tasks = \App\Models\Task::where('assignee_id', Auth::user()->id)->orderBy('id','desc')->get();
                      @endphp
                      @foreach($tasks as $key => $item)
                      <tr>
                        <th>{{ $key+1 }}</th>
                        <td>{{ $item->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString() }}</td>
                        <td>{{ $item->assign_time }}</td>
                        <td>{{ \App\Models\User::where('id' , $item->assignor_id)->first()->name }}</td>
                        <td>{{ \App\Models\User::where('id' , $item->assignee_id)->first()->name }}</td>
                        <td>
                         
                          <span class="badge" style="border-radius: 0px !important">{{ isset($item->task_status) ? $item->task_status->task_status_name : ''}}</span>
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
              <div class="tab-pane @if(request()->has('tab')) active @else fade @endif" id="raiseRequest" role="tabpanel" aria-labelledby="raise-request-tab">
                <div class="my-2 mr-3" style="text-align: right;">
                  <a href="{{ route('request.create') }}" class="btn btn-primary" role="button">Add Request</a>
                </div>
                <div class="table-responsive">
                  <table id="tableExport2" class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Assigned to</th>
                        <th>Designation</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $all_requests = \App\Models\Request::where('posted_by', Auth::user()->id)->get();
                      @endphp
                      @foreach($all_requests as $key => $item)
                      @php
                        $user = \App\Models\User::with('roles')->where('id' , $item->assigned_id)->first();
                        $name = $user->name;
                        $designation = $user->roles()->first()->name;
                      @endphp
                      <tr>
                        <th>{{ $key+1 }}</th>
                        <td>{{ $item->title }}</td>
                        <td>{{ $name }}</td>
                        <td>{{ $designation }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->toFormattedDateString() }}</td>
                        <td>
                          @php
                          $class = '';
                          switch ($item->request_status_code) {
                            case 1:
                              $class = 'badge-warning';
                              break;
                            case 2:
                              $class = 'badge-success';
                              break;
                            default:
                              $class = 'badge-danger';
                              break;
                          }
                          @endphp
                          <span class="badge {{ $class }}" style="border-radius:0px !important">
                            {{ isset($item->request_status) ? $item->request_status->request_status_name : ''}}
                          </span>
                        </td>
                        <td>
                          <a href="#" onclick="get_request_details({{ $item->id }})"><i class="fa fa-eye mr-2"></i> </a>
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
@stop