@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/summernote/summernote-bs4.css') }}">
<style>

tr:hover {
background: #a3a3a3 !important;
}
</style>
@stop
@section('content')
<section class="section">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>All Messages</h4>
        </div>
          
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-2" class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Sender Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($message_list as $key => $message)
                  <tr style="cursor:pointer;">
                      <td data-href='{{ route('messages.show', $message->id) }}'>{{ $key+1 }}</td>
                      <td data-href='{{ route('messages.show', $message->id) }}'>{{ $message->subject }}</td>
                      
                      <td data-href='{{ route('messages.show', $message->id) }}'>
                        @php
                          $name = \App\Models\User::where('id', $message->sender_id)->first()->name;
                        @endphp

                        {{ $name }}
                      </td>
                      <td>
                        <div class="dropdown">
                          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action</a>
                          <div class="dropdown-menu">
                            <a href="{{ route('messages.show', $message->id) }}" onclick="" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" onclick="form_alert('message-{{ $message->id }}','Want to delete this message')" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                              Delete</a>
                          </div>
                        </div>
                        <form action="{{ route('messages.delete', $message->id) }}"
                            method="post" id="message-{{ $message->id }}">
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
</section>
@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script src="{{asset('public/admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>

<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/assets/') }}/js/page/datatables.js"></script>
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- JS Libraies -->
<script src="{{asset('public/admin/assets/bundles/ckeditor/ckeditor.js') }}"></script>
<script>
  $("tr td:not(:last-child)").click(function() {
      window.location = $(this).data("href");
  });
</script>
@stop