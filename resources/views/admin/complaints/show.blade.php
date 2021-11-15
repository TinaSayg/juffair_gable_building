@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
    AMS - Maintenance Cost List 
@stop
{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')
<section class="section">
    <ul class="breadcrumb breadcrumb-style ">
      <li class="breadcrumb-item">
        <h4 class="page-title m-b-0">Complaints Details</h4>
      </li>
      <li class="breadcrumb-item">
        <a href="file:///F:/AMS/ownerlist.html">
          <i class="fas fa-home"></i></a>
      </li>
      
    </ul>
    <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <h4>Complaints Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Title</label>
                                <input type="text" name="complaint_title" value="{{ isset($complaint->complain_title) ? $complaint->complain_title : '' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Description</label>
                                <input type="text" name="complaint_description" value="{{ isset($complaint->complain_description) ? $maintenancecost->complain_description : '' }}" class="form-control">
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Posted by</label>
                                <input type="text" name="employee_id" value="{{ isset($complaint->employee_id) ? $complaint->employee_id : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Building</label>
                                <input type="text" name="building_id" value="{{ isset($building->building_id) ? $building->building_id : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Status</label>
                                <input type="text" name="complain_status_code" value="{{ isset($complaint->complain_status_code) ? $complaint->complain_status_code : '' }}" class="form-control">
                            </div>
                    </div>
                    <a href="{{ route('complaint.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>
@stop
@section('footer_scripts')
<script>
  
</script>
@stop