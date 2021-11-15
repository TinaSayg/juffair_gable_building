@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
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
        <h4 class="page-title m-b-0">Floors</h4>
      </li>
      <li class="breadcrumb-item">
        <a href="file:///F:/AMS/visitorlist.html">
          <i class="fas fa-home"></i></a>
      </li>
      
    </ul>
    <div class="section-body">
      <div class="row">
        <div class="col-12" >
          <div class="card">
            <div class="card-header">
              <h4>Floor</h4>
            </div>
            <div class="card-body">
              <div class="row">
                  <div class="form-group col-md-6">
                      <label>Floor Number</label>
                      <input type="text" name="floor_number" value="@if(isset($floor)) {{ $floor->floor_number }} @endif" class="form-control">
                  </div>
              </div>
              <div class="row">
              <div class="form-group col-md-6">
                  <label>Floor Description</label>
                  <textarea name="floor_description" class="form-control" id="textAreaExample3" rows="5">@if(isset($floor)) {{ $floor->floor_description }} @endif</textarea>
              </div>
              </div>
              <hr>
              <a href="{{ route('floors.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@stop
@section('footer_scripts')
<script>
  
</script>
@stop