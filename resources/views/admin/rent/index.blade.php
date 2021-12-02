@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<style>
</style>
@stop
@section('content')
<section class="section">
   <div class="row">
        <div class="col-12">
            <div class="card" style="padding:15px 15px">
                <form action="" method="get">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                                <label>Month</label>
                                <input type="month" name="" class="form-control">
                                </div>
                        <div class="form-group col-md-4">
                                <label>Date</label>
                                <input type="date" class="form-control">
                                </div>
                        </div>
                        <div class="form-group col-md-1" style="margin-top: 1.90rem !important;">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Rent details</h4>
           <div class="card-header-form">
            <a href="{{ route('rent.create') }}" type="button"  class="btn btn-primary">Add rent</a>
           </a>
          </div>
          </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="mainTable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Renter Name</th>
                      <th>Rent Apartment No</th>
                      <th>Invoice</th>
                      <th>Rent</th>
                      <th>EWA Bill</th>
                      <th>Utility Bill</th>
                      <th>Rent Date</th>
                      <th>Rent Month</th>
                      <th>Rent Year</th>
                      <th>Rent Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tenants as $key => $tenant)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td data-href=''>{{ $tenant->tenant_first_name }} {{ $tenant->tenant_last_name }}</td>
                        <td data-href=''>{{ isset($tenant->unit) ? $tenant->unit->unit_number : '' }}</td>
                        <td>{{ $tenant->rent_year}}</td>
                        <td data-href=''>{{ isset($tenant->unit) ? $tenant->unit->unit_rent : '' }}</td>
                        <td>{{ $tenant->ewa_bill}}</td>
                        <td>{{ $tenant->utility_bill}}</td>
                        <td>{{ $tenant->paid_date}}</td>
                        <td>{{ $tenant->rent_month}}</td>
                        <td>{{ $tenant->rent_year}}</td>
                        <td>{{ $tenant->rent_paid_status_code}}</td><td>
                            <div class="dropdown">
                              <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                              <div class="dropdown-menu">
                                <a href="" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                {{-- <a href="{{ route('invoice.create',$tenant->id) }}?month=12&year=2021" class="dropdown-item has-icon"><i class="fas fa-eye"></i> Add Invoice</a> --}}
                                @if(request()->user()->can('edit-tenant'))
                                <a href="" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                @endif
                                @if(request()->user()->can('delete-tenant'))
                                <div class="dropdown-divider"></div>
                                <a href="#" onclick="form_alert('tenant-{{ $tenant->id }}','Want to delete this tenant')" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                                  Delete</a>
                                @endif
                              </div>
                            </div>
                            @if(request()->user()->can('delete-tenant'))
                              <form action=""
                                method="post" id="tenant-{{ $tenant->id }}">
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
{{-- visitor modal --}}
<div class="modal" id="rentModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="card-body">
        <form class="table-responsive">
          <table id="mainTable" class="table table-striped">
            <tbody>
              @include('admin.rent.partials.rent_view_modal') 
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<script>
  function getRentDetails(id) {
    $.get({
        url: '{{route('rent.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#rentModal tbody").html(data.html_response)
            $("#rentModal").modal("show")
        }
    });
  }
</script>
<script>
  function getFloors(id) {
          $.get({
              url: '{{route('floor_type.fetch_floors', '')}}' + "/"+ id,
              dataType: 'json',
              success: function (data) {
                  console.log(data.options)
                  $('#floorSelect').empty().append(data.options)
              }
          });
      }
  </script>
@stop