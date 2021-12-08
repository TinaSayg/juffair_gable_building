@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
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
      <li class="breadcrumb-item">Utility Bills</li>
    
    </ul> --}}
     <div class="row">
       
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Rent Collection Form</h4>
          </div>
            
            <div class="card-body">
              <form action="">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                          <label for="">Select Tenant</label>
                          <select name="tenant_id" class="form-control" id="">
                            <option value="0">--- Select ---</option>
                            @foreach ($tenant_list as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->tenant_first_name }} {{ $tenant->tenant_last_name }}</option>
                            @endforeach
                          </select>
                        <div>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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