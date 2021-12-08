@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">

<style>
   .task_heading
   {
       font-weight: 700;
   }
</style>
@stop
@section('content')


<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
       <li class="breadcrumb-item">
          <h4 class="page-title m-b-0">Create Utility Bill</h4>
       </li>
       <li class="breadcrumb-item">
          <a href="file:///F:/AMS/tenantlist.html">
          <i class="fas fa-home"></i></a>
       </li>
    </ul> --}}
    <div class="section-body">
    <div class="row">
        <div class="col-12" >
            <div class="card">
                <div class="card-header">
                <h4>Task Detail</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <p class="mb-0"><span class="task_heading">Title: </span> {{ isset($task) ? $task->title : '' }}</p>
                            <p class="mb-0">
                            @if($task->location_id == 1)
                            @php
                                $floor_number = \App\Models\FloorDetail::where('id', $task->floor_id)->first()->number;
                                $apartment_number = \App\Models\Unit::where('id', $task->unit_id)->first()->unit_number;
                            @endphp
                            
                            <span class="task_heading">Location: </span> Apartment {{ $apartment_number }}
                            @endif

                            @if($task->location_id == 2)
                            @php
                                $location_area = \App\Models\CommonArea::where('id', $task->common_area_id)->first()->area_name;
                            @endphp
                            
                            <span class="task_heading">Location: </span> {{ $location_area }}

                            @endif

                            @if($task->location_id == 3)
                            @php
                            $floor_number = \App\Models\FloorDetail::where('id', $task->floor_id)->first()->number;
                            @endphp
                            
                            <span class="task_heading">Location: </span> Floor {{ $floor_number }}

                            @endif

                            @if($task->location_id == 4)
                            @php
                                $location_area = \App\Models\ServiceArea::where('id', $task->service_area_id)->first()->service_area_name;
                            @endphp
                            <span class="task_heading">Location: </span> {{ $location_area }}

                            @endif   
                            </p>
                            <p style="text-align: justify;"><span class="task_heading">Description: </span> {{$task->description }}</p>
                            @if($task->task_status_code == 4 )
                            <div style="color: red">
                                <h4>Reason:</h4>
                                <p>{{ $task->comments }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($task->assign_date)
                            <p class="mb-0"><span class="task_heading">Date Assigned: </span> {{ isset($task->assign_date)? \Carbon\Carbon::parse($task->assign_date)->toFormattedDateString(). ' '. \Carbon\Carbon::parse($task->assign_time)->format('g:i A') : '' }}</p>
                            @endif
                            @if($task->deadline_date)
                            <p class="mb-0"><span class="task_heading">Deadline Date: </span> {{ isset($task->deadline_date)? \Carbon\Carbon::parse($task->deadline_date)->toFormattedDateString(). ' '. \Carbon\Carbon::parse($task->deadline_time)->format('g:i A') : '' }}</p>
                            @endif
                            @if($task->complete_date)
                            <p class="mb-0"><span class="task_heading">Completed Date: </span> {{ isset($task->complete_date)? \Carbon\Carbon::parse($task->complete_date)->toFormattedDateString(). ' '. \Carbon\Carbon::parse($task->complete_time)->format('g:i A') : '' }}</p>
                            @endif
                            <p class="mb-0">
                                @php
                                $class = '';
                                switch ($task->task_status_code) {
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
                                
                                <span class="task_heading">Status: </span> <span class="badge {{ $class }}">{{ isset($task->task_status) ? $task->task_status->task_status_name : ''}}</span></p>
                            
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</section>    
@stop
@section('footer_scripts')
<script src="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
     $(".monthPicker").datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });
</script>
@stop
