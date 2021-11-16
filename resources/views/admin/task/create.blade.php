@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">

<style>
   
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
              <h4>Add Task</h4>
            </div>
            <div class="card-body">
            <form method="POSt" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
              @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Date</label>
                        <input type="text" name="assign_date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Time</label>
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
                <div class="row">
                    @if(Auth::user()->userType != 'employee')
                    <div class="form-group col-md-4">
                        <label>Assign to</label>
                        <select class="form-control" name="assignee_id" >
                            <option value="">--- select ---</option>
                            @foreach ($employee_list as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
               
                
                <button class="btn btn-primary mr-1" type="submit">Save</button>
                </div>
            </from>
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
