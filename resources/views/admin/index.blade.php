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
      <p class="mb-0" style="padding:20px;font-size: 17px;">Hello <span style="font-size: 17px;font-weight:600">{{ Auth::user()->name }},</span></p>
    </div>
    @if(\Auth::user()->userType == 'general-manager')
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
        $tasks = \App\Models\Task::where('task_status_code', 1)->where('assignee_id', Auth::user()->id)->get();
        $average_time = explode(":", $average_time);
        $hours = $average_time[0];
        $minutes = round($average_time[1]);
      @endphp
      <div class="row">
        
        @php
          $email = Auth::user()->email;
          $employee_detail = \App\Models\Employee::where('employee_email_address', $email)->first();
        @endphp
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Passport number</h6>
                <h4 class="text-right"><i class="material-icons  pull-left bg-cyan c-icon">phone_in_talk</i><span>{{ $employee_detail->passport_number }}</span>
                </h4>
                <a href="{{ route('tasks.completed_task.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Phone number</h6>
                <h4 class="text-right"><i class="material-icons  pull-left bg-cyan c-icon">phone_in_talk</i><span>{{ $employee_detail->employee_mobile_phone }}</span>
                </h4>
                <a href="{{ route('tasks.completed_task.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Start date of work at this building</h6>
                <h4 class="text-right"><i class="fas fas fa-calendar-alt pull-left bg-cyan c-icon mt-4"></i><span>{{ \Carbon\Carbon::parse($employee_detail->employee_start_datetime)->toFormattedDateString() }}</span>
                </h4>
                <a href="{{ route('tasks.completed_task.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">End date of work at this building</h6>
                <h4 class="text-right"><i class="fas fas fa-calendar-alt pull-left bg-cyan c-icon mt-4"></i><span>{{ \Carbon\Carbon::parse($employee_detail->employee_end_datetime)->toFormattedDateString() }}</span>
                </h4>
                <a href="{{ route('tasks.completed_task.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card card-box">
            <div class="card-statistic-4">
              <div class="info-box7-block">
                <h6 class="m-b-20 text-right">Average time to resolve an assigned task</h6>
                <h4 class="text-right"><i class="fas fa-clock pull-left bg-cyan c-icon mt-4"></i><span>{{ isset($hours)? $hours: '' }} hours {{ isset($minutes) ? $minutes : ''}} minutes</span>
                </h4>
                <a href="{{ route('tasks.completed_task.list') }}" class="small-box-footer text-center d-block pt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
            <h4>Pending Tasks</h4>
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
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->assign_date)->toFormattedDateString() }}</td>
                        <td>{{ $item->assign_time }}</td>
                        <td>{{ \App\Models\User::where('id' , $item->assignor_id)->first()->name }}</td>
                        <td>{{ \App\Models\User::where('id' , $item->assignee_id)->first()->name }}</td>
                        <td>{{ isset($item->task_status) ? $item->task_status->task_status_name : ''}}</td>
                        <td>
                          <a href="{{ route('tasks.show', $item->id) }}" type="button" class="btn btn-primary">View Task</a>
                          <a href="#" data-task_id="{{ $item->id }}" data-target="#confirmModal" data-toggle="modal" type="button" class="btn btn-success complete-task-button">Complete Task</a>
                          {{-- <a href="#" onclick="form_alert('task-{{ $item->id }}','Want to delete this task')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <a href="{{ route('tasks.edit', $item->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <form action="{{ route('tasks.delete', $item->id) }}"
                              method="post" id="task-{{ $item->id }}">
                              @csrf @method('delete')
                          </form>  --}}
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
<div class="modal" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/assets/') }}/js/page/datatables.js"></script>
<script>
  $(".complete-task-button").click(function(){
    let task_id = $(this).attr('data-task_id')
   
    let action = $("#completeTaskForm").attr("action") + '/tasks/task/complete/' + task_id
    
    $("#completeTaskForm").attr("action", action)
  })
</script>
@stop