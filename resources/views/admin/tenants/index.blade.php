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
   tr:hover {
    background: #a3a3a3 !important;
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
      <li class="breadcrumb-item">Tenants</li>
    </ul> --}}
     <div class="row">
       <div class="col-12">
         @if(request()->user()->can('add-tenant') OR \Auth::user()->userType == 'officer')
           <a href="{{ route('tenants.create') }}" style="padding:7px 35px;" class="btn btn-primary mb-4 float-right" role="button">Add tenant</a>
         @endif
       </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Active Tenant list</h4>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-1" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tenant Name</th>
                      <th>Contact No.</th>
                      <th>Tenant Email</th>
                      <th>Rent Apartment No</th>
                      @if(request()->user()->userType != 'employee')
                      <th>Action</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tenants->where('is_passed','!=', 1) as $key => $tenant)
                    <tr style="cursor:pointer;">
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $key+1 }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $tenant->tenant_first_name }} {{ $tenant->tenant_last_name }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $tenant->tenant_mobile_phone }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $tenant->tenant_email_address  }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ isset($tenant->unit) ? $tenant->unit->unit_number : '' }}</td>
                        <td>
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                            <div class="dropdown-menu">
                              <a href="{{ route('tenants.show',$tenant->id) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                              @if(request()->user()->can('edit-tenant'))
                              <a href="{{ route('tenants.edit',$tenant->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                              @endif
                             
                              <div class="dropdown-divider"></div>
                              <a href="{{ route('tenants.passed', $tenant->id) }}"  class="dropdown-item has-icon"><i class="far fa-user"></i>
                                Passed</a>
                             
                            </div>
                          </div>
                          
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="card">
          <div class="card-header">
           <h4>Passed Tenant list</h4>
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
                      <th>Rent Apartment No</th>
                      @if(request()->user()->userType != 'employee')
                      <th>Action</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tenants->where('is_passed', 1) as $key => $tenant)
                    <tr style="cursor:pointer;">
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $key+1 }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $tenant->tenant_first_name }} {{ $tenant->tenant_last_name }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $tenant->tenant_mobile_phone }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ $tenant->tenant_email_address  }}</td>
                        <td data-href='{{ route('tenants.show',$tenant->id) }}'>{{ isset($tenant->unit) ? $tenant->unit->unit_number : '' }}</td>
                        <td>
                          <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                            <div class="dropdown-menu">
                              <a href="{{ route('tenants.show',$tenant->id) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                              @if(request()->user()->can('edit-tenant'))
                              <a href="{{ route('tenants.edit',$tenant->id) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                              @endif
                            </div>
                          </div>
                          
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
    $("tr td:not(:last-child)").click(function() {
        window.location = $(this).data("href");
    });

    
</script>
@stop