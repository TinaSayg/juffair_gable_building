@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>

   
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
                      <th>start date</th>
                      <th>end date</th>
                      <th>apply date</th>
                      <th>leaves type</th>
                      <th>leave status</th>
                      <th>Actions</th>
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
                    <tr>
                        <td>{{ $key+1 }}</td>
                        @if(Auth::user()->userType == 'general-manager' || Auth::user()->userType == 'Admin')
                        <td>
                          @php
                            $staff_id = $leave->staff_id;
                            $employee_name = \App\Models\User::where('id', $staff_id)->first()->name;
                          @endphp
                          {{ isset($employee_name)? $employee_name : '' }}
                        </td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($leave->leave_start_date)->toFormattedDateString() }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->leave_end_date)->toFormattedDateString() }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->apply_date)->toFormattedDateString() }}</td>
                        <td>{{ isset($leave->leave_types) ? $leave->leave_types->leave_type_name : '' }}</td>
                        <td>
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
                          <button class="btn btn-info mr-2" onclick="getLeaveDetails({{ $leave->id }})">View</button>
                          @if($leave->leave_status_code ==2)
                          <button class="btn btn-success mr-2 approve_leave" data-leave_id="{{ $leave->id }}" data-approve_leave="1">Approve</button>
                          <button class="btn btn-danger disapprove_leave" data-leave_id="{{ $leave->id }}" data-disapprove_leave="3">Disapprove</button>
                          @endif
                          @endif
                          @if(Auth::user()->userType == 'employee' )
                          <a href="#" onclick="getLeaveDetails({{ $leave->id }})"><i class="fa fa-eye mr-2"></i> </a>
                          @if($leave->leave_status_code ==2)
                          <a href="#" onclick="form_alert('leave-{{ $leave->id }}','Want to delete this leave')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <a href="{{ route('leave.edit', $leave->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <form action="{{ route('leave.delete', $leave->id) }}"
                            method="post" id="leave-{{ $leave->id }}">
                            @csrf @method('delete')
                            @endif
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
    $("#leaveModal .leave_modal_message").html('Do you want to approve ?')
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
    $("#leaveModal .leave_modal_message").html('Do you want to Disapprove ?')
    $("#leaveForm button").removeClass("btn-success")
    $("#leaveForm button").addClass("btn-danger")
    $("#leaveForm button").text("Dispprove")
    $("#leaveModal").modal("show")
  })
</script>
@stop