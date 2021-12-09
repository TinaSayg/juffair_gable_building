@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')

    <section class="section">
      
        <div class="section-body">
            <form method="POST" action="{{ route('maintenancecosts.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <h4>Maintenance Details</h4>
                                </div>
                             <div class="card-body">
                                <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Maintenance Title</label>
                                    <input type="text" maxlength="50" name="maintenance_title" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Date</label>
                                    <input type="date" name="maintenance_date" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Maintenance Cost</label>
                                    <input type="text" name="maintenance_cost_total_amount" class="form-control">
                                </div>
                                <div class="form-group col-md-4" id="locationDropdown">
                                    <label>Select Location</label>
                                    <select class="form-control" onchange="get_locations(this)" name="location_id" id="">
                                        <option value="">--- Select ---</option>
                                        @foreach (\App\Models\Location::all() as $location)
                                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea name="maintenance_description" class="form-control"></textarea>
                                    
                                </div>
                                
                        </div>
                        <button  class="btn btn-primary mr-1" type="submit">save</button>
                        <a href="{{ url()->previous() }}"  class="btn btn-primary ml-2">Cancel</a>
                    </div>
                </form>
                </div>
        </div>
    </section>
    


@stop
@section('footer_scripts')
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