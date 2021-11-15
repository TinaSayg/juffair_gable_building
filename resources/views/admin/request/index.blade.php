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
           <h4>Employees Request</h4>
            
          {{-- @if(request()->user()->can('create-task'))
            <div class="card-header-form">
              <a href="{{ route('tasks.create') }}" class="btn btn-primary" role="button">Add Task</a>
            </div>
          @endif --}}
          </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableExport" class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Designation</th>
                          <th>Title</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          if(Auth::user()->userType == 'Admin'){
                              $all_requests = \App\Models\Request::all();
                          }
                          else {
                           
                            $all_requests = \App\Models\Request::where('assigned_id', Auth::user()->id)->get();
                          }
                        @endphp
                        @foreach($all_requests as $key => $item)
                        @php
                          $user = \App\Models\User::with('roles')->where('id' , $item->posted_by)->first();
                          $name = $user->name;
                          $designation = $user->roles()->first()->name;
                        @endphp
                        <tr>
                          <th>{{ $key+1 }}</th>
                          <td>{{ $name }}</td>
                          <td>{{ $designation }}</td>
                          <td>{{ $item->title }}</td>
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
                            <button class="btn btn-primary" onclick="get_request_details({{ $item->id }})">View</button>
                            @if($item->request_status_code == 1)
                            <button class="btn btn-success request-button" data-request_id="{{ $item->id }}" data-action_id="2">Accept</button>
                            <button class="btn btn-danger request-button" data-request_id="{{ $item->id }}" data-action_id="3">Reject</button>
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
</section>
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

<div class="modal" id="confirmModal" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Confirm Employee Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="card-body">
        <form action="{{url('')}}" method="POST" id="requestActionForm">
          @csrf
          <div>
            <p id="confirmMesssage" class="ml-2"></p>
          </div>
          <input type="hidden" class="form-control" name="action_id" id="requestAction">
          <button type="submit" class="btn m-t-15 waves-effect">save</button>
        </form>
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

  $(".request-button").click(function(){
    let id = $(this).attr('data-request_id')
    let action = $(this).attr('data-action_id')
    
    if(action == 3)
    {
      $("#confirmMesssage").html("Do you want to reject this request?")
      $(".waves-effect").addClass('btn-danger')
      $(".waves-effect").text('Reject')
      $("#requestAction").val(action)
    }
    else
    {
      $("#confirmMesssage").html("Do you want to accept this request?")
      $(".waves-effect").addClass('btn-success')
      $(".waves-effect").text('Accept')
      $("#requestAction").val(action)
    }

    let act = {!! json_encode(url('/')) !!} + '/request/request/action/' + id
   
    $("#requestActionForm").attr("action", act)

    $("#confirmModal").modal("show")
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