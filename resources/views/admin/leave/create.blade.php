@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
   
</style>
@stop
@section('content')

    <section class="section">
      
        <div class="section-body">
            <form method="POST" action="{{ route('leave.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <h4>Leave Details</h4>
                                </div>
                             <div class="card-body">
                                <div class="row">
                                <div class="form-group col-md-4">
                                    <label>leave start date</label>
                                    <input type="date" name="leave_start_date" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>leave end date</label>
                                    <input type="date" name="leave_end_date" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Apply Date</label>
                                    <input type="date" name="apply_date" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Reason</label>
                                    <textarea name="leave_reason" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Leave Type</label>
                                    <select class="form-control" name="leave_type_code">
                                        @foreach ($leave_types as $leaveType)
                                        <option value="{{ $leaveType->leave_type_code }}" >{{ $leaveType->leave_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Attach Document</label>
                                    <input type="file" name="leave_document" class="form-control">
                                </div>
                        </div>
                        <button  class="btn btn-primary mr-1" type="submit">save</a>
                  
                    </div>
                </form>
                </div>
        </div>
    </section>
    


@stop
@section('footer_scripts')
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
  
</script>
@stop