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
    
    </ul>
    <div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h4>All Modules</h4>
            <div class="card-header-form">
                <a href="{{ route('module.create') }}" class="btn btn-icon icon-left btn-primary "><i class="fas fa-plus"></i> Add Module</a>
            </div>
        </div>
            <div class="card-body">
            <div class="table-responsive">
                <table id="tableExport" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module['name'] }} </td>
        
                            <td>
                                <a title="Edit Module"  href="{{ route('module.edit', $module->id) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                <a title="delete Module" href="#" onclick="form_alert('module-{{ $module->id }}','Want to delete this module')" class="confirmDelete"><i class="fas fa-trash text-danger"></i></a>
                                <form action="{{ route('module.delete', $module->id) }}"
                                    method="post" id="module-{{ $module->id }}">
                                    @csrf @method('delete')
                                </form>
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
</section>

@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script src="{{asset('public/admin/assets/bundles/datatables/datatables.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/jszip.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/pdfmake.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/vfs_fonts.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.print.min.js')}}"></script>
<script src="{{asset('public/admin/assets/js/page/datatables.js')}}"></script>
@stop