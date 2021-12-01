@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')
<section class="section">
  
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>Notice list</h4>
            <div class="card-header-form">
              <a href="{{ route('notice.create') }}" type="button"  class="btn btn-primary">Add notice</a>
             </a>
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="mainTable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Notice</th>
                      <th>Date</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($noticeboard as $key => $noticeboard)
                    
                    <tr>
                        <td>{{ $key+1}}</td>
                        <td>{{ $noticeboard->notice_text}}</td>
                        <td>{{ \Carbon\Carbon::parse($noticeboard->notice_date)->toFormattedDateString() }}</td>
                        <td>{{ isset($noticeboard->role) ? $noticeboard->role->name : '' }}</td>
                        <td>{{ isset($noticeboard->notice_status) ? $noticeboard->notice_status->notice_boardstatus_name : '' }}</td>
                        <td>
                            <a href="#" onclick="getNoticeDetails({{ $noticeboard->id }})"><i class="fa fa-eye mr-2"></i> </a>
                          <a href="#" onclick="form_alert('noticeboard-{{ $noticeboard->id }}','Want to delete this noticeboard')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <a href="{{ route('notice.edit', $noticeboard->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <form action="{{ route('notice.delete', $noticeboard->id) }}"
                           method="post" id="noticeboard-{{ $noticeboard->id }}">
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
{{-- Notice modal --}}
<div class="modal" id="noticeboardModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
              @include('admin.notice.partials.noticeboard_view_modal') 
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<script>
  function getNoticeDetails(id) {
    $.get({
        url: '{{route('notice.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#noticeboardModal tbody").html(data.html_response)
            $("#noticeboardModal").modal("show")
        }
    });
  }
</script>
@stop