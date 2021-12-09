@extends('layouts.admin.app')
{{-- Page title --}}
{{-- @section('title')
    AMS
@stop --}}
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   .card a
   {
       text-decoration: underline;
   }

   ul li
   {
     line-height: 35px;
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
      <li class="breadcrumb-item">Utility Bills</li>
    
    </ul> --}}
     <div class="row">
       
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>All Reports</h4>
          </div>
            
            <div class="card-body">
              <ul>
                <li><a href="{{ route('reports.generate_rented_apartment_list') }}">Click here to generate rented apartment list</a></li>
                <li><a href="{{ route('reports.generate_vacant_apartment_list') }}">Click here to generate vacant apartment list</a></li>
                <li><a href="{{ route('reports.generate_full_apartment_list') }}">Click here to generate full apartment list</a></li>
                <li><a href="{{ route('reports.generate_active_tenant_list') }}">Click here to generate active tenant list</a></li>
                <li><a href="{{ route('reports.generate_passed_tenant_list') }}">Click here to generate passed tenant list</a></li>
              </ul>
              
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
@stop