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
            <form method="POST" action="{{ route('notice.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">Notice Details</h4>
                                </div>
                             <div class="card-body">
                                <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Notice</label>
                                    <input type="text" maxlength="50" name="notice_text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Date</label>
                                    <input type="date" name="notice_date" class="form-control">
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label>Role</label>
                                    <select class="form-control" name="role_id">
                                        @foreach ($role as $role)
                                        <option value="{{ $role->id }}" >{{ $role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                                <div class="form-group col-md-4">
                                    <label>Status</label>
                                    <select class="form-control" name="notice_board_status_code">
                                        @foreach ($noticeStatus as $noticeStatus)
                                        <option value="{{ $noticeStatus->notice_boardstatus_code }}" >{{ $noticeStatus->notice_boardstatus_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <button  class="btn btn-primary mr-1" type="submit">save</a>
                  
                    </div>
                </form>
                </div>
        </div>
    </section>
    


@stop
@section('footer_scripts')
<script>
  
</script>
@stop