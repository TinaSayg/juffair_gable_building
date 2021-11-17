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
           <h4>Completed Task</h4>
            
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
                      <th>Assign to</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tasks as $key => $item)
                    
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $item->title }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString() }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->assign_time)->format('g:i A') }}</td>
                      <td>
                        
                        {{ \App\Models\User::where('id' , $item->assignee_id)->first()->name }}
                        
                      </td>
                      <td>
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