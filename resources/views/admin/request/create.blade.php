@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">

<style>
   
</style>
@stop
@section('content')


<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
       <li class="breadcrumb-item">
          <h4 class="page-title m-b-0">Create Utility Bill</h4>
       </li>
       <li class="breadcrumb-item">
          <a href="file:///F:/AMS/tenantlist.html">
          <i class="fas fa-home"></i></a>
       </li>
    </ul> --}}
    <div class="section-body">
    <div class="row">
    <div class="col-12" >
        <div class="card">
            <div class="card-header">
              <h4>Add Request</h4>
            </div>
            <div class="card-body">
            <form method="POSt" action="{{ route('request.store') }}" enctype="multipart/form-data">
              @csrf
                <div class="row">
                    <div class="form-group col-md-4" id="locationDropdown">
                        <label>Select Location</label>
                        <select class="form-control" onchange="get_locations(this)" name="location_id" id="">
                            <option value="">--- Select ---</option>
                            @foreach (\App\Models\Location::all() as $location)
                                <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description"  class="form-control"></textarea>
                        </div>
                    </div>
                </div>
               
                
                <button class="btn btn-primary mr-1" type="submit">Submit</button>
                <a href="{{ url()->previous() }}"  class="btn btn-primary ml-2">Cancel</a>

            </div>
            </from>
          </div>
</section>    
@stop
@section('footer_scripts')
<script src="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
     $(".monthPicker").datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });
</script>
<script>
    function get_locations(location)
    {
        let id = location.value
        
        if(id == 2 || id == 3 || id == 4)
        {
            $(".floor-dropdown").remove()
            $(".unit-dropdown").remove()
        }

        if(id == 1 || id == 3 || id == 4)
        {
            $(".common_area_select").remove()
        }

        if(id == 1 || id == 2 || id == 4)
        {
            $(".parking_floor_select").remove()
        }

        if(id == 1 || id == 2 || id == 3)
        {
            $(".service_area_select").remove()
        }

        $.get({
            url: '{{route('tasks.get_task_location', '')}}' + "/"+ id,
            dataType: 'json',
            success: function (data) {
                console.log(data.options)

                if(id == 1)
                {
                    $('#locationDropdown').after(data.floor_select)
                    $('.floor-dropdown').after(data.unit_select)
                }

                if(id == 2)
                {
                    
                    $('#locationDropdown').after(data.common_area_select)
                } 

                if(id == 3)
                {
                    
                    $('#locationDropdown').after(data.parking_floors)
                } 

                if(id == 4)
                {
                    
                    $('#locationDropdown').after(data.service_areas_select)
                } 

            }
        });
    }
</script>
<script>
    // function getFloors(id) {
    //     $.get({
    //         url: '{{route('tenants.fetch_floors', '')}}' + "/"+ id,
    //         dataType: 'json',
    //         success: function (data) {
    //             console.log(data.options)
    //             $('#floorSelect').empty().append(data.options)
    //             $('#unitSelect').empty().append(data.options1)
    //            }
    //     });
    // }
    function getUnits(id) {
       
        $.get({
            url: '{{route('floor_type.fetch_all_units','')}}' + "/"+ id,
            dataType: 'json',
            success: function (data) {
                console.log(data.options)
                $('#unitSelect').empty().append(data.options)
               }
        });
    }
</script>
@stop
