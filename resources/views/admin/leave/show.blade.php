@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
    
@stop
{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')
<section class="section">
    
    <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <h4>Leave Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Leave start date</label>
                                <input type="text" name="leave_start_date" value="{{ isset($leave->leave_start_date) ? $leave->leave_start_date : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Leave end date</label>
                                <input type="text" name="leave_end_date" value="{{ isset($employeeleave->leave_end_date) ? $employeeleave->leave_end_date : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Apply date</label>
                                <input type="text" name="apply_date" value="{{ isset($employeeleave->apply_date) ? $employeeleave->apply_date : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Leave reason</label>
                                <input type="text" name="leave_reason" value="{{ isset($employeeleave->leave_reason) ? $employeeleave-> : 'leave_reason' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>leave type</label>
                                <input type="text" name="leave_type_code" value="{{ isset($employeeleave->leave_type_code) ? $employeeleave->leave_type_name : '' }}" class="form-control">
                            </div>
                            <div class="section-title">Attach Medical Certificate</div>
                            <ul>
                              <li><a href="{{ url('public/admin/assets/img/documents').'/'. $employeeleave->leave_document }}" target="blank">Passport Copy</a></li>
                             
                            </ul>
                        </div>
                    </div>
                    <a href="{{ route('leave.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>
@stop
@section('footer_scripts')
<script>
  
</script>
@stop