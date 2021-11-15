@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
</style>
@stop
@section('content')

   <div class="section-body">
      <form method="POST" action="{{route('notice.update',$noticeboard->id) }}" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h4>Notice Edit</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-4">
                           <label>Notice</label>
                           <input type="text" name="notice_text" value="@if(isset($noticeboard)) {{ $noticeboard->notice_text}} @endif" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Date</label>
                           <input type="text" value="{{ isset($noticeboard) ? \Carbon\Carbon::parse($noticeboard->notice_date)->format('Y-m-d') : ''}}"  name="notice_date" class="form-control datepicker">
                        </div>
                        

                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select class="form-control" name="notice_board_status_code">
                                @foreach ($noticeStatus as $noticeStatus)
                                <option value="{{ $noticeStatus->notice_boardstatus_code }}" {{ (isset($noticeboard) && ($noticeboard->notice_board_status_code == $noticeStatus->notice_boardstatus_code)) ? 'selected' :'' }}>{{ $noticeStatus->notice_boardstatus_name }}</option>
                                @endforeach
                            </select>
                        </div>
                     
                     </div>
                     <button  class="btn btn-primary mr-1" type="submit">update</a>
                  </div>
               </div>
            </div>
         </div>
   </div>
   </div>
   </form>
   </div>
   </div>
</section>
@stop
@section('footer_scripts')
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script></script>
@stop

