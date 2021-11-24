@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
tr:hover {
    background: #a3a3a3 !important;
}
   
</style>
@stop
@section('content')
<section class="section">
   
    </ul>
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>
              @if(Auth::user()->userType == 'general-manager' || Auth::user()->userType == 'Admin')
              Approve Leaves
              @else
              Apply Leave
              @endif
            </h4>
             <div class="card-header-form">
              @if(Auth::user()->userType == 'employee' )
              <a href="{{ route('leave.create') }}" type="button"  class="btn btn-primary">Apply leave request</a>
             
              @endif
            </a>
            </div>
          </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped display nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      @if(Auth::user()->userType == 'general-manager' || Auth::user()->userType == 'Admin')
                      <th>Employee Name
                      @endif
                    </th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Apply Date</th>
                      <th>Leaves Type</th>
                      <th>Leave Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      if(Auth::user()->userType == 'employee')
                      {
                        $employeeleave = $employeeleave->where('staff_id', Auth::user()->id);
                      }

                    @endphp
                    @foreach($employeeleave as $key => $leave)
                    <tr style="cursor: pointer" >
                        <td onclick="getLeaveDetails({{ $leave->id }})">{{ $key+1 }}</td>
                        @if(Auth::user()->userType == 'general-manager' || Auth::user()->userType == 'Admin')
                        <td onclick="getLeaveDetails({{ $leave->id }})">
                          @php
                            $staff_id = $leave->staff_id;
                            $employee_name = \App\Models\User::where('id', $staff_id)->first()->name;
                          @endphp
                          {{ isset($employee_name)? $employee_name : '' }}
                        </td>
                        @endif
                        <td onclick="getLeaveDetails({{ $leave->id }})">{{ \Carbon\Carbon::parse($leave->leave_start_date)->toFormattedDateString() }}</td>
                        <td onclick="getLeaveDetails({{ $leave->id }})">{{ \Carbon\Carbon::parse($leave->leave_end_date)->toFormattedDateString() }}</td>
                        <td onclick="getLeaveDetails({{ $leave->id }})">{{ \Carbon\Carbon::parse($leave->apply_date)->toFormattedDateString() }}</td>
                        <td onclick="getLeaveDetails({{ $leave->id }})">{{ isset($leave->leave_types) ? $leave->leave_types->leave_type_name : '' }}</td>
                        <td onclick="getLeaveDetails({{ $leave->id }})">
                          @php
                            $class = '';
                            switch ($leave->leave_status_code) {
                              case 1:
                                $class = 'badge-success';
                                break;
                              case 2:
                                $class = 'badge-warning';
                                break;
                              default:
                                $class = 'badge-danger';
                                break;
                            }
                          @endphp
                          <span class="badge {{ $class }}">{{ isset($leave->leaveStatus) ? $leave->leaveStatus->leave_status_name : '' }}</span>
                        </td>
                        <td class="d-flex">
                          
                          @if(Auth::user()->userType == 'Admin' OR Auth::user()->userType == 'general-manager' )
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                            <div class="dropdown-menu">
                              <a href="#" class="dropdown-item has-icon" onclick="getLeaveDetails({{ $leave->id }})"><i class="fas fa-eye"></i> View</a>
                              @if($leave->leave_status_code ==2)
                              <a href="{{ route('leave.edit', $leave->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                              @endif
                              @if($leave->leave_status_code ==2)
                              <div class="dropdown-divider"></div>
                              <a href="#" class="dropdown-item has-icon approve_leave" data-leave_id="{{ $leave->id }}" data-approve_leave="1"><i style="color:green" class="fas fa-check-circle"></i>
                                Approve</a>
                              <a href="#" class="dropdown-item has-icon disapprove_leave" data-leave_id="{{ $leave->id }}" data-disapprove_leave="3"><i style="color:red" class="fas fa-times-circle"></i>
                                Disapprove</a>
                              @endif
                              @endif
                            </div>
                            
                          </div>
                          
                          @if(Auth::user()->userType == 'employee' )
                          {{-- <a href="#" onclick="getLeaveDetails({{ $leave->id }})"><i class="fa fa-eye mr-2"></i> </a> --}}
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                            <div class="dropdown-menu">
                              <a href="#" class="dropdown-item has-icon" onclick="getLeaveDetails({{ $leave->id }})"><i class="fas fa-eye"></i> View</a>
                              @if($leave->leave_status_code ==2)
                              <a href="{{ route('leave.edit', $leave->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                              <div class="dropdown-divider"></div>
                              <a href="#" onclick="form_alert('leave-{{ $leave->id }}','Want to delete this leave')" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                                Delete</a>
                              @endif
                            </div>
                            <form action="{{ route('leave.delete', $leave->id) }}"
                              method="post" id="leave-{{ $leave->id }}">
                              @csrf @method('delete')
                              @endif
                            </form> 
                          </div>
                          {{-- @if($leave->leave_status_code ==2)
                          <a href="#" onclick="form_alert('leave-{{ $leave->id }}','Want to delete this leave')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <a href="{{ route('leave.edit', $leave->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          
                          @endif --}}
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
  <div class="modal" id="leaveModal" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="card-body">
          <form action="{{ route('approveleave.save_leave_status') }}" method="POST" id="leaveForm">
            @csrf
            <input type="hidden" name="leave_status_code" id="leaveStatusInputField">
            <input type="hidden" name="leave_id" id="leaveIdInputField">
            <div>
              <p class="leave_modal_message"></p>
            </div>
            <button type="submit" class="btn  m-t-15 waves-effect">save</button>
          </form>
        </div>
    </div>
  </div>
  </div>

{{-- leave detail modal --}}
<div class="modal" id="leaveDetailModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script>
  function getLeaveDetails(id) {
    $.get({
        url: '{{route('leave.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#leaveDetailModal tbody").html(data.html_response)
            $("#leaveDetailModal").modal("show")
        }
    });
  }

  $(".approve_leave").click(function(){
    let leave_status_code = $(this).attr('data-approve_leave')
    let leave_id = $(this).attr('data-leave_id')

    $("#leaveModal .modal-title").text("Approve Leave")
    $("#leaveStatusInputField").val(leave_status_code)
    $("#leaveIdInputField").val(leave_id)
    $("#leaveModal .leave_modal_message").html('Do you want to approve the leave request ?')
    $("#leaveForm button").removeClass("btn-danger")
    $("#leaveForm button").addClass("btn-success")
    $("#leaveForm button").text("Approve")
    $("#leaveModal").modal("show")
  })

  $(".disapprove_leave").click(function(){
    let leave_status_code = $(this).attr('data-disapprove_leave')
    let leave_id = $(this).attr('data-leave_id')

    $("#leaveModal .modal-title").text("Disapprove Leave")
    $("#leaveStatusInputField").val(leave_status_code)
    $("#leaveIdInputField").val(leave_id)
    $("#leaveModal .leave_modal_message").html('Are you sure you want to disapprove the leave request?')
    $("#leaveForm button").removeClass("btn-success")
    $("#leaveForm button").addClass("btn-danger")
    $("#leaveForm button").text("Dispprove")
    $("#leaveModal").modal("show")
  })
</script>
@stop