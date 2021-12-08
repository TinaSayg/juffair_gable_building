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
        <a href="file:///F:/AMS1/dashboard.html">
          <i class="fas fa-home"></i></a>
      </li>
      <li class="breadcrumb-item">Floors</li>
    
    </ul> --}}
     <div class="row">
      <div class="col-lg-12 col-12">
        @if(request()->user()->can('create-floor'))
            <button type="button" data-toggle="modal" data-target="#floorModal" class="btn btn-primary float-right mb-4" style="padding:7px 35px;">Add Floor
            </button>
        @endif
      </div>
      <div class="col-12">
        <div class="card">
          
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-1" class="table table-export table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Floor No</th>
                      <th>Floor Type</th>
                       {{-- @if(request()->user()->userType == 'Admin') --}}
                       @if(Auth::user()->userType == 'Admin')
                       <th>Action</th>
                       @endif
                       {{-- @endif --}}
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($floors as $key => $floor)
                        <tr>
                          {{-- @dd($floor->floor_type) --}}
                            <td> {{ $floor->from }} - {{ $floor->to }}</td>
                            <td>{{ isset($floor->floor_type) ? $floor->floor_type->floor_type_name : '' }}</td>
                            {{-- @if(request()->user()->userType == 'Admin') --}}
                            @if(Auth::user()->userType == 'Admin')
                              <td>
                                    <a title="delete Floor" href="#" onclick="form_alert('floor-{{ $floor['id'] }}','Want to delete this floor')" class="confirmDelete"><i class="fas fa-trash text-danger"></i></a>
                                    <form action="{{ route('floors.delete', $floor['id']) }}"
                                        method="post" id="floor-{{ $floor['id'] }}">
                                        @csrf @method('delete')
                                    </form>
                              </td>
                            @endif
                          {{-- @endif --}}
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
{{-- Floor Modal --}}
<div class="modal" id="floorModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Add Floors</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('floors.store') }}" class="" method="POST">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>From</label>
            <div class="input-group">
            <div class="input-group-prepend">
            </div>
              <input type="number" min="0" id="from"  name="from" class="form-control">
            </div>
          </div>
          <div class="form-group col-md-6">
            <label>To</label>
            <div class="input-group-prepend">
            </div>
            <input type="number" min="0" id="to" name="to" class="form-control">
          </div>
        </div>
       <div>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label>Floor Type</label>
            <select class="form-control" name="floor_type">
                @foreach ($floor_types as $floor_type)
                    <option value="{{ $floor_type->floor_type_code }}">{{ $floor_type->floor_type_name }}</option>
                @endforeach
            </select>
        </div>
      </div>
        <button type="submit" class="btn btn-primary m-t-15 waves-effect">save</button>
    </form>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal" id="editfloorModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Edit Floor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
       
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')

<!-- JS Libraies -->
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/assets/') }}/js/page/datatables.js"></script>
<script>
  $(document).ready(function(){
    $("#from").keyup(function(){
      let from = parseInt($("#from").val())
      let to = parseInt($("#to").val())
      
      if(from > to)
      {
        
        swal("Error:", "")
        Swal.fire({
            text: "please enter a number less than To range",
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#FC6A57',
            confirmButtonText: 'Okay',
            reverseButtons: true,
            width:300,
            
        })
      }
    });
    $("#to").keyup(function(){
      let from = parseInt($("#from").val())
      let to = parseInt($("#to").val())
      
      if(to < from)
      {
        
        swal("Error:", "")
        Swal.fire({
            text: "please enter a number greater than From range",
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#FC6A57',
            confirmButtonText: 'Okay',
            reverseButtons: true,
            width:300,
        })
      }
    });
  });
  </script>
 

  <script>
    function getfloorDetails(id) {
    
      $.get({
          url: '{{route('floors.edit', '')}}' + "/"+ id,
          dataType: 'json',
          success: function (data) {
              console.log(data)
              $("#editfloorModal .modal-body").html(data.html_response)
              $("#editfloorModal").modal("show")
          }
      });
    }
  </script>

 
@stop