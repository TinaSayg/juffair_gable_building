@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/summernote/summernote-bs4.css') }}">
<style>
.card .card-header
{
    display: block !important;
}
.note-editable
{
    margin-top: 20px;
}
.note-editor.note-frame
{
    border:unset !important;
}
.note-table
{
    display:none;
}
.note-insert
{
    display:none;
}
.note-view
{
    display:none;
}
</style>
@stop
@section('content')
<section class="section">
    <div class="col-12 col-lg-8 offset-lg-2">
        <div class="card" style="padding:25px;">
          <div class="boxs mail_listing">
            <div class="inbox-body no-pad">
              <section class="mail-list">
                <div class="mail-sender">
                  <div class="mail-heading">
                    <h4 class="vew-mail-header">
                      <b>{{ $message->subject }}</b>
                    </h4>
                  </div>
                  <hr>
                  <div class="media">
                      @php
                          $user = \App\Models\User::where('id', $message->sender_id)->first();
                      @endphp
                    <a href="#" class="table-img m-r-15">
                      <img alt="image" src="{{asset('public/admin/assets/img/staff/')}}/{{ $user->image }}" class="rounded-circle" width="60"
                        data-toggle="tooltip" title="{{ $user->name }}">
                    </a>
                    <div class="media-body">
                      <span class="date pull-right">{{ \Carbon\Carbon::parse($message->created_at)->format("g:i A") }} {{ \Carbon\Carbon::parse($message->created_at)->format('d M Y') }}</span>
                      <h5 class="col-black">{{ $user->name }}</h5>
                      <small class="text-muted">From: {{ $user->email }}</small>
                    </div>
                  </div>
                </div>
                <div class="view-mail p-t-20">
                  <p>
                      {!! $message->description !!}
                  </p>
                </div>
                
              </section>
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
  
</script>
@stop