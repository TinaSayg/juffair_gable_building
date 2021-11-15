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
     table.dataTable td img
    {
        box-shadow: 0 5px 15px 0 rgba(105,103,103,0.5);
        border: 2px solid #ffffff;
        border-radius: 10px;
    }

    table.dataTable td, table.dataTable th {
        vertical-align: middle;
    }
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
    <li class="breadcrumb-item">Staffs</li>
    
    </ul> --}}
    <div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h4>All Staffs</h4>
            <div class="card-header-form">
                @if(request()->user()->can('create-staff'))
                    <a href="{{ route('staff.create') }}" class="btn btn-icon icon-left btn-primary "><i class="fas fa-plus"></i> Add Staffs</a>
                @endif
            </div>
        </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Conctact No</th>
                        <th>image</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($staffs as $staff)
                    <tr>
                        <td> {{ $staff['name'] }}</td>
                        <td>{{ $staff['number'] }}</td>
                        <td>
                            @if(!empty($staff['image']))
                            <img src="{{ asset('public/admin/assets/img/staff')}}/{{ $staff['image'] }}" alt="" width="100" height="100">
                            @else
                            <img src="{{asset('public/admin/assets/img/staff/no-image.png')}}" alt="" width="100" height="100">
                            @endif
                      </td>
                      <td>{{ $staff['email']}}</td>
                      <td>{{ $staff['userType'] }}</td>
                       
                        {{-- <td>
                            @if($staff['status'] ==1)
                            <a  class="updateStaffStatus" id="staff-{{$staff['id']}}" staff_id="{{$staff['id']}}" href="javascript:void(0)"><i style="font-size:20px" class="fas fa-toggle-on text-success" status="Active" aria-hidden="true"></i></a>
                            @else
                            <a class="updateStaffStatus" id="staff-{{$staff['id']}}" staff_id="{{$staff['id']}}" href="javascript:void(0)"><i style="font-size:20px" class="fas fa-toggle-off text-danger" status="Inactive" aria-hidden="true"></i></a>
                            @endif
                        </td> --}}
                        <td>
                            <a href="{{ route('staff.show',$staff['id']) }}"><i class="fa fa-eye mr-2" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                            @if(request()->user()->can('edit-staff'))
                                <a title="Edit Staff"  href="{{ route('staff.edit', $staff['id']) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                            @endif
                            @if(request()->user()->can('delete-staff'))
                                <a title="delete Staff" href="#" onclick="form_alert('staff-{{ $staff['id'] }}','Want to delete this staff')" class="confirmDelete"><i class="fas fa-trash text-danger"></i></a>
                                <form action="{{ route('staff.delete', $staff['id']) }}"
                                    method="post" id="staff-{{ $staff['id'] }}">
                                    @csrf @method('delete')
                                </form>
                            @endif
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