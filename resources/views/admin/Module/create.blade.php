@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<style>
   
</style>
@stop
@section('content')
<section class="section">
    <ul class="breadcrumb breadcrumb-style ">
    <li class="breadcrumb-item">
    </li>
    <li class="breadcrumb-item">
        <a href="file:///F:/AMS/dashboard.html">
        <i class="fas fa-home"></i></a>
    </li>
    <li class="breadcrumb-item">Modules</li>
    <li class="breadcrumb-item">Add Module</li>
    
    </ul>
    <div class="row">
    <div class="col-12">
        <div class="card">
            <form  action="{{ route('module.store') }}" id="formId"
               method="POST"  class="needs-validation" novalidate="">
                @csrf
                <div class="card-header">
                  <h4>Add Module</h4>
                </div>
                <div class="card-body">
                  <div class="form-group row">
                        <div class="form-group col-md-6">
                          <label for="name">Module Name</label>
                          <input type="text" class="form-control " autocomplete="off" required="" name="name" id="slug-input"
                          value="{{ old('name')}}" 

                          placeholder="Module name">
                        </div>
                </div>

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Add</button>
                  <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>

@stop
@section('footer_scripts')

@stop