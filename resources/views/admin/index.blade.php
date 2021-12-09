@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
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
   .card .card-statistic-4 .c-icon
   {
     width: 36px !important;
     height: 36px !important;
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
        $leaves_request = \App\Models\EmployeeLeaves::where('leave_status_code', 2)->count();
        
        foreach (\App\Models\MaintenanceCost::pluck('maintenance_cost_total_amount') as $key => $value) {
          $total_maintenance_cost += $value;
        }

        
      @endphp
      <div class="row">
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Total Apartment</h6>
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
                <h6 class="m-b-20 text-right">Vacant Apartment</h6>
                <h4 class="text-right"><i
                    class="fas fa-home pull-left bg-deep-orange c-icon"></i><span>{{ $total_units - $total_tenant }}</span>
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
                <h6 class="m-b-20 text-right">Rented Apartment</h6>
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
                <h6 class="m-b-20 text-right">Total Rent Per Year</h6>
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
                <h6 class="m-b-20 text-right">Maintenance Cost Per Year</h6>
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
                <h6 class="m-b-20 text-right">Leaves Request</h6>
                <h4 class="text-right">
                <i class="far fa-user pull-left bg-green c-icon"></i><span>{{ $leaves_request }}</span>
                </h4>
                <a href="{{ route('leave.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>
             @if(Auth::user()->userType == 'general-manager' OR Auth::user()->userType == 'Admin')
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
                      
                      $maintenancerequest = \App\Models\MaintenanceRequest::where('maintenance_request_status_code', 1)->get();
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
                            <a href="{{ route('request.edit', $item->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i>Edit</a>
                            {{-- <a href="" class="dropdown-item has-icon"><i class="
                              fas fa-book"></i>Resubmit</a> --}}
                              @if((Auth::user()->userType == 'general-manager' OR Auth::user()->userType == 'Admin')  &&  $item->maintenance_request_status_code != 3)
                              {{-- @if($item->maintenance_request_status_code ==1)
                              <a href="#" data-request_id="{{ $item->id }}" class="dropdown-item has-icon under-review" ><i class="
                                fas fa-pen-square" style="color:green;"></i>Under Review</a>
                              @endif --}}
                              <a href="#" data-request_id="{{ $item->id }}" data-task-assignee_id="{{ $item->user_id }}" class="dropdown-item has-icon assign_task"><i class="fas fa-user-shield"></i>Assign Task</a>
                              <div class="dropdown-divider"></div>
                              <a href="{{ route('dashboard.task.closed',$item->id) }}" data-task_id="{{  $item->id }}" class="dropdown-item has-icon" style="color:green"><i class="
                                fas fa-check-circle"></i> Close</a>
                            @endif
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
      
      @endif
      @if(\Auth::user()->userType == 'employee')
      @php
        $tasks = \App\Models\Task::whereIn('task_status_code', [1,2,3,4])->where('assignee_id', Auth::user()->id)->orderBy('id','desc')->get();
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
                <h6 class="text-right  m-b-20">Average time to resolve an assigned tasks</h6>
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
                        <th>Location</th>
                        <th>Date Assigned</th>
                        <th>Deadline Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($tasks as $key => $item)
                      <tr class="active-task-table" style="cursor: pointer;">
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ $key+1 }}</td>
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ $item->title }}</td>
                        <td data-href='{{ route('tasks.show', $item->id) }}'>
                          @if($item->location_id == 1)
                          @php
                            $floor_number = \App\Models\FloorDetail::where('id', $item->floor_id)->first()->number;
                            $apartment_number = \App\Models\Unit::where('id', $item->unit_id)->first()->unit_number;
                          @endphp
                            Apartment {{ $apartment_number }}
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
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString() }} {{ $item->assign_time }}</td>
                        <td data-href='{{ route('tasks.show', $item->id) }}'>{{ \Carbon\Carbon::parse($item->deadline_date)->toFormattedDateString() }} {{ $item->deadline_time }}</td>
                        <td>
                          @php
                            $class = '';
                            switch ( $item->task_status_code) {
                            case 1:
                                $class = 'badge-warning';
                                break;
                            case 4:
                                $class = 'badge-warning';
                                break;
                            default:
                                $class = 'badge-success';
                                break;
                            }
                          @endphp
                          @if(isset($item->task_status))
                          <span class="badge {{ $class }}">{{$item->task_status->task_status_name}}</span>
                          @endif
                        </td>
                        <td>
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                            <div class="dropdown-menu">
                              <a href="{{ route('tasks.show', $item->id) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                              @if(in_array($item->task_status_code,[1,2,4]))
                              <div class="dropdown-divider"></div>
                              <a href="#" data-task_id="{{ $item->id }}" data-task_status_code="{{ $item->task_status_code }}" class="dropdown-item has-icon task-status-button">
                                @if($item->task_status_code == 1)
                                <i class="
                                fas fa-check-circle" style="color:green"></i><span style="color: green"> In Progress
                                @endif
                                @if($item->task_status_code == 2 || $item->task_status_code == 4)
                                <i class="
                                fas fa-check-circle" style="color:green"></i><span style="color: green"> Completed
                                @endif
                                </span>
                              </a>
                              @endif
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
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" name="now_cb" checked type="checkbox">
                  <label class="form-check-label" style="margin-top:1px !important">
                    Now
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row assign_schedule" style="display: none">
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
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Deadline Date</label>
                <input type="text" name="deadline_date" class="form-control datepicker1">
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
            {{-- <div class="col-12">
              <div class="form-group">
                <label>Comment</label>
                <textarea name="comment" id="" class="form-control" cols="30" rows="10"></textarea>
              </div>
            </div> --}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $("tr.active-task-table td:not(:nth-last-child(2),:nth-last-child(1))").click(function() {
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

  $('input[type=checkbox]').change(function() {
     
    if (this.checked) {
        $(".assign_schedule").hide() 
    } else {
      $(".assign_schedule").show()
    }
  });


  $(".datepicker1").daterangepicker({
        locale: { format: "YYYY-MM-DD" },
        singleDatePicker: true,
        minDate : moment(new Date(),"YYYY-MM-DD").add('days', 1),
  });
</script>

@stop