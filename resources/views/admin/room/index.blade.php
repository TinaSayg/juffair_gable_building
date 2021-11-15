@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   
</style>
@stop
@section('content')
<section class="section">
   
    </ul>
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Room list</h4>
            
            
             <div class="card-header-form">
              <a href="{{ route('room.create') }}" type="button"  class="btn btn-primary">Add room</a>
             </a>
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                     
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($room as $key => $room)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $room->name }}</td>
                       
                        <td>
                          <a href="#" onclick="getRoomDetails({{ $room->id }})"><i class="fa fa-eye mr-2"></i> </a>
                       
                          <a href="#" onclick="form_alert('room-{{ $room->id }}','Want to delete this maintenance cost')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <a href="{{ route('room.edit', $room->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <form action="{{ route('room.delete', $room->id) }}"
                            method="post" id="room-{{ $room->id }}">
                            @csrf @method('delete')
                        </form> 
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
{{-- maintenance cost modal --}}
<div class="modal" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
              @include('admin.room.partials.addroom_view_modal')
            </tbody>
          </table>
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
  function getRoomDetails(id) {
    $.get({
        url: '{{route('room.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#roomModal tbody").html(data.html_response)
            $("#roomModal").modal("show")
        }
    });
  }
</script>
@stop