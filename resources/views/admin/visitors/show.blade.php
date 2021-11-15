@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
    AMS - Visitor List 
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
                            <h4>Visitor Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Visitors Name</label>
                                <input type="text" name="visitor_full_name" value="{{ isset($visitor->visitor_full_name) ? $visitor->visitor_full_name : '' }}"  class="form-control">
                            </div>
                             <div class="form-group col-md-4">
                                <label>Date of visit</label>
                                <input type="text" name="visitor_entry_date" value="{{ isset($visitor->visitor_entry_date) ? $visitor->visitor_entry_date : '' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Phone No.</label>
                                <input type="text" name="visitor_phone_number" value="{{ isset($visitor->visitor_phone_number) ? $visitor->visitor_phone_number : '' }}" class="form-control">
                            </div>
                            
                             <div class="form-group col-md-4">
                                <label>Floor</label>
                                <input type="text" name="floor_id" value="{{ isset($complaint->employee_id) ? $complaint->employee_id : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>unit</label>
                                <input type="text" name="unit_id" {{ isset($visitor->unit) ? $visitor->unit->unit_number : '' }} class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>IN</label>
                                <input type="text" name="visitor_in_time" value="{{ isset($visitor->visitor_in_time) ? $visitor->visitor_in_time : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Out</label>
                                <input type="text" name="visitor_out_time" value="{{ isset($visitor->visitor_out_time) ? $visitor->visitor_out_time : '' }}" class="form-control">
                            </div>
                    </div>
                    <a href="{{ route('visitor.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>
@stop
@section('footer_scripts')
<script>
  
</script>
@stop