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
        <a href="index.html">
          <i class="fas fa-home"></i></a>
      </li>
      <li class="breadcrumb-item">Permission</li>
      <li class="breadcrumb-item">Edut Permission</li>
    </ul> --}}
    <div class="section-body">
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif
          @if(Session::has('success_message'))
          <div class="alert alert-success alert-success fade show" style="margin-top:10px" role="alert">
              {{ Session::get('success_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
          @if(Session::has('error_message'))
          <div class="alert alert-danger alert-success fade show" style="margin-top:10px" role="alert">
              {{ Session::get('error_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">

          <div class="card">
              <form name="AddOnForm" method="post" id="AddOnForm" action="{{route('permission.update', $permission->id)}}">
                  @csrf
              <div class="card-header">
                <h4>Edit Permission</h4>
              </div>
              <div class="card-body">
                <div class="row form-group">
                  <div class="form-group col-md-5" style="margin-right: 10px">
                    
                    <label>Select Module</label> <br>
                    <select name="module" id="select2" class="select2 form-control" >
                      <option value="" selected>Select Module</option>
                      @foreach($modules as $key=>$module )
                          <option name="{{$module['id']}}"  value="{{$module['id']}}" {{ (isset($permission) && ($permission->module->id == $module->id)) ? 'selected': '' }}>{{$module['name']}}</option>
                      @endforeach
                  </select>
                </div>
                </div>

                <div class="row form-group">
                  <div class="col-lg-12">
                      <div class="form-group">
                          <label for="Permission_name" class="col-form-label text-md-right">
                              Add Permission 
                          </label>
                          <table width="100%">
                              <tbody class="data-repeater">
                                  <tr class="kolom">
                                      <td width=32%>
                                          <div class="form-group">
                                              <input id="Permission_name"  placeholder="Permission Name"
                                                  type="text"
                                                  class="form-control slug-input form-input @error('Permission_name') is-invalid @enderror"
                                                  name="Permission_name"
                                                  value="{{ isset($permission)? $permission->name : '' }}"
                                                  autocomplete="Permission_name" autofocus>
                                              @error('Permission_name')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                              @enderror
                                          </div>
                                      </td>
                                      <td width=32%>
                                        <div class="form-group">
                                            <input id="Permission_slug" placeholder="Permission Slug"
                                                type="text"
                                                class="form-control form-input @error('Permission_slug') is-invalid @enderror"
                                                name="Permission_slug"
                                                value="{{ isset($permission)? $permission->slug : '' }}"
                                                
                                                autocomplete="Permission_slug" autofocus>
                                            @error('Permission_slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </td>
                               
                                  </tr>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
    

              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Add</button>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@stop
@section('footer_scripts')
<!-- JS Libraies -->
{{-- <script>
    var slug = function(str) {
    
    var $slug = '';
    var trimmed = $.trim(str);
    $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
    replace(/-+/g, '-').
    replace(/^-|-$/g, '');
    return $slug.toLowerCase();
}

$("#Permission_name" ).keyup(function() {
    $('#Permission_slug').val(slug($('#Permission_name').val()));
});

</script> --}}
@stop