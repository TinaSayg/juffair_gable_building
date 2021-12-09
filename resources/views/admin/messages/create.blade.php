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
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="boxs mail_listing">
                  <div class="inbox-center table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th colspan="1">
                            <div class="inbox-header">
                              Send Message To General Manager
                            </div>
                          </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <form class="composeForm" action="{{ route('email.send') }}" method="POST" style="padding:25px;">
                  <div class="row">
                    <div class="col-lg-12">
                        @csrf
                        {{-- <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="email_address" class="form-control" placeholder="TO">
                          </div>
                        </div> --}}
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                          </div>
                        </div>
                        <textarea class="summernote" name="message"></textarea>
                        {{-- <div class="compose-editor m-t-20">
                          <div id="summernote"></div>
                          <input type="file"  class="default mb-3" name="attachments[]" multiple>
                        </div> --}}
                      
                    </div>
                    <div class="col-lg-12">
                      <div class="m-b-20">
                        <button type="submit" class="btn btn-primary btn-border-radius waves-effect">Send</button>
                        {{-- <a href="{{ url()->previous() }}" type="button" class="btn btn-danger btn-border-radius waves-effect">Cancel</a> --}}
                      </div>
                    </div>
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