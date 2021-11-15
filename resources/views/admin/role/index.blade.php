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
    {{-- <ul class="breadcrumb breadcrumb-style ">
    <li class="breadcrumb-item">
    </li>
    <li class="breadcrumb-item">
        <a href="file:///F:/AMS/dashboard.html">
        <i class="fas fa-home"></i></a>
    </li>
    <li class="breadcrumb-item">Roles</li>
    
    </ul> --}}
    <div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h4>All Roles</h4>
            <div class="card-header-form">
                <a href="{{ route('role.create') }}" class="btn btn-icon icon-left btn-primary "><i class="fas fa-plus"></i> Add Role</a>
            </div>
        </div>
            <div class="card-body">
            <div class="table-responsive">
                <table id="tableExport" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td> {{ $role['name'] }}</td>
                            <td>{{ $role['slug'] }}</td>
                        
                            <td>
                              <a title="Assign Permission" href="{{ route('role.assignPermission', $role->id) }}"><i class="fas fa-user-shield"></i></a>&nbsp;&nbsp;

                                <a title="Edit Role"  href="{{ route('role.edit', $role->id) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                <a title="delete Role" href="#" onclick="form_alert('role-{{ $role->id }}','Want to delete this role')" class="confirmDelete"><i class="fas fa-trash text-danger"></i></a>
                                <form action="{{ route('role.delete', $role->id) }}"
                                    method="post" id="role-{{ $role->id }}">
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