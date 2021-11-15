@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
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
      <li class="breadcrumb-item">Tenants</li>
    </ul> --}}
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Tenant list</h4>
            
            
            <div class="card-header-form">
              @if(request()->user()->can('add-tenant') OR \Auth::user()->userType == 'officer')
                <a href="{{ route('tenants.create') }}" class="btn btn-primary" role="button">Add tenant</a>
              @endif
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tenant Name</th>
                      <th>Contact No.</th>
                      <th>Tenant Email</th>
                      <th>RentAppartmentNo</th>
                      @if(request()->user()->userType != 'employee')
                      <th>Actions</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tenants as $key => $tenant)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $tenant->tenant_first_name }} {{ $tenant->tenant_last_name }}</td>
                        <td>{{ $tenant->tenant_mobile_phone }}</td>
                        <td>{{ $tenant->tenant_email_address  }}</td>
                        <td>{{ isset($tenant->unit) ? $tenant->unit->unit_number : '' }}</td>
                        <td>
                          <a href="{{ route('tenants.show',$tenant->id) }}"><i class="fa fa-eye mr-2" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          @if(request()->user()->userType != 'employee')
                            @if(request()->user()->can('delete-tenant') OR \Auth::user()->userType == 'officer')
                            <a href="#" onclick="form_alert('tenant-{{ $tenant->id }}','Want to delete this tenant')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                            @endif
                            @if(request()->user()->can('edit-tenant') OR \Auth::user()->userType == 'officer')
                              <a href="{{ route('tenants.edit',$tenant->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                            @endif
                            @if(request()->user()->can('delete-tenant') OR \Auth::user()->userType == 'officer')
                            <form action="{{route('tenants.delete',[$tenant->id])}}"
                              method="post" id="tenant-{{ $tenant->id }}">
                                @csrf @method('delete')
                            </form>
                            @endif
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
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/assets/') }}/js/page/datatables.js"></script>
<script>
    
</script>
@stop