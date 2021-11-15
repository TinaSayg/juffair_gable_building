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
            <a href="{{url('/dashboard')}}">
                <i class="fas fa-home"></i></a>
            <a href="{{route('role.list')}}">Roles</a>
        </li>
        <li class="breadcrumb-item active">Assign Permission</li>
    </ul> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                   <div class="col">
                       <h4>All Permissions </h4>
                   </div>
                </div>
                <div class="card-body assign-permission">
                            @foreach($modules as $module)
                                @if (!empty($module['permission'] ))
                                <div class="row assign-permission-section m-1">
                                    <div class="col-12">
                                        <h4>{{$module['module']['name']}}</h4>
                                    </div>
                                    @foreach($module['permission'] as $permission)
                                        <div class="col-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" value="{{$permission->id}}" {{ $permission->permission_id == $permission->id ? 'checked' : '' }} id="{{$permission->id}}Id" class="custom-control-input permissionClass">
                                                <label for="{{$permission->id}}Id" class="custom-control-label">{{$permission->name}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                       
                            @endforeach

                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script>
    var slug = function(str) {
    var $slug = '';
    var trimmed = $.trim(str);
    $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
    replace(/-+/g, '-').
    replace(/^-|-$/g, '');
    return $slug.toLowerCase();
}

$( "#slug-input" ).keyup(function() {
    $('#slug').val(slug($('#slug-input').val()));
});

</script>
<script>
    $(function() {
        $('.permissionClass').click(function () {
           
            var val = $(this).val();
            var checked = 'No';
            if($(this).is(":checked")) {
                checked = 'Yes';
            }
            
            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: "{{ url()->current() }}",
                data: { "_token": "{{ csrf_token() }}",'checked' : checked, 'value' : val},
                success:function (response)  {
                    console.log(response)
                    // requestTable.ajax.reload();
                    // $('#createRole').trigger("reset");
                    // $('#createRoleModal').modal('hide');
                },
                error: (response) => {
                    // if(response.status === 422) {
                    //     let errors = response.responseJSON.errors;
                    //     Object.keys(errors).forEach(function (key) {
                    //         console.log(key);
                    //         $("#" + key + "Input").addClass("is-invalid");
                    //         $("#" + key + "Error").children("strong").text(errors[key][0]);
                    //     });
                    // } else {
                       
                    // }
                }
            })
        });
    });
</script>
@stop