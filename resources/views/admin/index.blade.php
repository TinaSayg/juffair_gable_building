@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   .card-box
   {
    background-color: #180b57 !important;
    color: #fff;
   }
   .small-box-footer
   {
      color:#fff !important;
   }
   tr:hover {
      background: #a3a3a3 !important;
   }
</style>
@stop
@section('content')
<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style " style="visibility: hidden">
      <li class="breadcrumb-item">
        <h4 class="page-title m-b-0">Dashboard</h4>
      </li>
      <li class="breadcrumb-item">
        <a href="index.html">
          <i class="fas fa-home"></i></a>
      </li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ul> --}}
    <div class="card">
      @php
        $user = Auth::user();
        $email = Auth::user()->email;
        $employee_detail = \App\Models\Employee::where('employee_email_address', $email)->first();
      @endphp
      <div style="padding:20px;font-size: 17px;">
        <p class="mb-0">Welcome <span style="font-size: 17px;font-weight:800">{{ ucwords($user->name) }},</span></p>
        <p class="mb-0"><span style="font-weight: 600">Email</span> : {{ $user->email }}</p>
        <p class="mb-0"><span style="font-weight: 600">Phone Number</span> : {{ $user->number }}</p>
        @if((Auth::user()->userType == 'employee') || (Auth::user()->userType == 'officer'))
          <p class="mb-0"><span style="font-weight: 600">Date Of Joining</span> : {{ \Carbon\Carbon::parse($employee_detail->employee_start_datetime)->toFormattedDateString() }}</p>
        @endif
      </div>
    </div>
    @if(\Auth::user()->userType == 'general-manager' OR \Auth::user()->userType == 'Admin')
      @php
        $total_units = 0;
        $vacant_units = 0;
        $total_tenants = 0;
        $total_employee = 0;
        $total_complaint = 0;
        $total_maintenance_cost  = 0;
        $total_units = \App\Models\Unit::all()->count();
        $total_tenant = \App\Models\Tenant::all()->count();
        
        $total_employees = \App\Models\User::whereIn('userType', ['employee','officer'])->count();
        $total_complains = \App\Models\Complain::where('assigneed_id', Auth::user()->id)->whereIn('complain_status_code' , [1,2])->count();
        
        foreach (\App\Models\MaintenanceCost::pluck('maintenance_cost_total_amount') as $key => $value) {
          $total_maintenance_cost += $value;
        }

        
      @endphp
      <div class="row">
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Total Unit</h6>
                <h4 class="text-right"><i class="fas fa-door-open pull-left bg-cyan c-icon"></i><span>{{ $total_units }}</span>
                </h4>
                <a href="{{ route('units.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Vacant Units</h6>
                <h4 class="text-right"><i
                    class="fas fa-home pull-left bg-deep-orange c-icon"></i><span>{{ $vacant_units }}</span>
                </h4>
                <a href="{{ route('units.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Total Tenant</h6>
                <h4 class="text-right"><i
                    class="fas fa-users pull-left bg-green c-icon"></i><span>{{ $total_tenant }}</span>
                </h4>
                <a href="{{ route('tenants.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Total Employee</h6>
                <h4 class="text-right"><i
                    class="fas fa-user-tie pull-left bg-green c-icon"></i><span>{{ $total_employees }}</span>
                </h4>
                <a href="{{ route('staff.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Total Rent</h6>
                <h4 class="text-right"><i
                    class="fas fa-dollar-sign pull-left bg-green c-icon"></i><span>4514.000 BD</span>
                </h4>
                <a href="" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
                
              </div>
            </div>
          </div>
        </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Total Maintenance</h6>
                <h4 class="text-right"><i
                    class="fas fa-toolbox pull-left bg-green c-icon"></i><span>{{ $total_maintenance_cost }} BD</span>
                </h4>
                <a href="{{ route('maintenancecosts.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Total Complaints</h6>
                <h4 class="text-right">
                <i class="far fa-user pull-left bg-green c-icon"></i><span>{{ $total_complains }}</span>
                </h4>
                <a href="{{ route('complains.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      @if(\Auth::user()->userType == 'employee')
      @php
        $tasks = \App\Models\Task::whereIn('task_status_code', [1,2])->where('assignee_id', Auth::user()->id)->orderBy('id','desc')->get();
        if($average_time)
        {
          $average_time = explode(":", $average_time);
          $hours = $average_time[0];
          $minutes = round($average_time[1]);
        }
      @endphp
      <div class="row">
        
        @php
          $email = Auth::user()->email;
          $employee_detail = \App\Models\Employee::where('employee_email_address', $email)->first();
         
        @endphp
        <div class="col-lg-4 col-sm-6">
          <div class="card card-box" style="height:154px;">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Average time to resolve an assigned tasks</h6>
                <h4 class="text-right"><i class="fas fa-clock pull-left bg-cyan c-icon mt-4"></i><span>{{ isset($hours)? $hours.' '.'hours': '0' }}  {{ isset($minutes) ? $minutes.' '. 'minutes' : ''}} </span>
                </h4>
                <a href="{{ route('tasks.completed_task.list') }}"  class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        @php
            $email = \App\Models\User::where('id', Auth::user()->id)->first()->email;
            $employee_detail = \App\Models\Employee::where('employee_email_address', $email)->first();
      
            $employee_contract_start_date = \Illuminate\Support\Carbon::parse($employee_detail->employee_start_datetime);
            $employee_contract_end_date = Illuminate\Support\Carbon::parse($employee_detail->employee_end_datetime);
            $annual_leaves = $employee_detail->annual_leaves;
           
            //leave taken contract years
            $leave_contract_years = Illuminate\Support\Carbon::parse($employee_contract_start_date)->format('Y'). '-'. Illuminate\Support\Carbon::parse($employee_contract_end_date)->format('Y');
           
            $leaves_taken = 0;
            $leaves = \App\Models\EmployeeLeaves::where('staff_id', Auth::user()->id)->where('leaves_taken_year', $leave_contract_years)->pluck('leaves_taken');
            
            if($leaves->count() > 0)
            {
              $leaves_taken = array_sum($leaves->toArray());
            }
           
        @endphp
        <div class="col-lg-4 col-sm-6">
          <div class="card card-box" style="padding-bottom:19px;height:154px;">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <h6 class="m-b-20">Leaves Taken</h6>
                    <h4 ><span>{{ $leaves_taken }} </span>
                    </h4>
                  </div>
                  <div class="col-md-6 col-12">
                    <h6 class="m-b-20 text-right">Earned Leaves</h6>
                    <h4 class="text-right"><span >{{ $annual_leaves-$leaves_taken }} </span>
                    </h4>
                  </div>
                </div>
                
                <a href="{{ route('leave.list') }}" style="position:relative;top:18px" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
            <h4>Active Task</h4>
            </div>
              
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table-2" class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date Assigned</th>
                        <th>Deadline Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($tasks as $key => $item)
                      <tr style="cursor: pointer;">
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ $key+1 }}</td>
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ $item->title }}</td>
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString() }} {{ $item->assign_time }}</td>
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ \Carbon\Carbon::parse($item->deadline_date)->toFormattedDateString() }} {{ $item->deadline_time }}</td>
                        <td>
                          @php
                            $class = '';
                            switch ( $item->task_status_code) {
                            case 1:
                                $class = 'badge-warning';
                                break;
                            default:
                                $class = 'badge-success';
                                break;
                            }
                          @endphp
                          @if(isset($item->task_status))
                          <button class="btn {{ $class }} task-status-button" data-task_id="{{ $item->id }}" data-task_status_code="{{ $item->task_status_code }}">{{$item->task_status->task_status_name}}</button>
                          @endif
                        </td>
                        <td>
                          
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                            <div class="dropdown-menu">
                              <a href="{{ route('tasks.show', $item->id) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
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
      @endif
  </div>
{{-- Confirm modal --}}
<div class="modal" id="taskConfirmModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Confirm Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="card-body">
        <form action="{{ route('tasks.change_task_status') }}" method="POST" id="completeTaskForm">
          @csrf
          <input type="hidden" name="task_id" id="confirmTaskId">
          <input type="hidden" name="task_status_code" id="confirmTaskStatusCode">
          <div>
            <p class="task-confirm-message">Do you confirm the task has been completed?</p>
          </div>
          <button type="submit" class="btn btn-primary m-t-15 waves-effect">Confirm</button>
        </form>
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
  $("tr td:not(:nth-last-child(2),:nth-last-child(1))").click(function() {
      window.location = $(this).data("href");
  });
</script>
<script>
  $(".task-status-button").click(function(){
    let task_id = $(this).attr('data-task_id')
    let task_status_code = $(this).attr('data-task_status_code')
    
    if(task_status_code == 1)
    {
      $(".task-confirm-message").html("Do you confirm the task has been in progress?")
      $("#confirmTaskId").val(task_id)
      $("#confirmTaskStatusCode").val(2)
    }
    else
    {
      $("#confirmTaskId").val(task_id)
      $("#confirmTaskStatusCode").val(3)
      $(".task-confirm-message").html("Do you confirm the task has been completed?")
    }


    $("#taskConfirmModal").modal("show")

   
  })
</script>
<script>
  $(".complete-task-button").click(function(){
    let task_id = $(this).attr('data-task_id')
   
    let action = $("#completeTaskForm").attr("action") + '/tasks/task/complete/' + task_id
    
    $("#completeTaskForm").attr("action", action)
  })
</script>

@stop