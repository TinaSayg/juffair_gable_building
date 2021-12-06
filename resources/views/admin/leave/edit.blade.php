@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">

<style>
   .custom-file, .custom-file-label, .custom-select, .custom-file-label:after, .form-control[type="color"], select.form-control:not([size]):not([multiple])
    {
      height: calc(1.85rem + 6px) !important;
    }
</style>
@stop
@section('content')

   <div class="section-body">
      <form method="POST" action="{{route('leave.update',$employeeleave->id) }}" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h4>Leave Detail</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-4">
                           <label>Leave Start Date</label>
                           <input type="text" value="{{ isset($employeeleave) ? \Carbon\Carbon::parse($employeeleave->leave_start_date)->format('Y-m-d') : ''}}"  name="leave_start_date" class="form-control datepicker">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Leave End Date</label>
                           <input type="text" value="{{ isset($employeeleave) ? \Carbon\Carbon::parse($employeeleave->leave_end_date)->format('Y-m-d') : ''}}"  name="leave_end_date" class="form-control datepicker">
                        </div>
                        
                           <div class="form-group col-md-4">
                            <label>Leave Type</label>
                            <select class="form-control"  onchange="checkLeaveType(this);" name="leave_type_code">
                                @foreach ($leave_types as $leaveType)
                                <option value="{{ $leaveType->leave_type_code }}" {{ (isset($employeeleave) && ($employeeleave->leave_type_code == $leaveType->leave_type_code)) ? 'selected' :'' }}>{{ $leaveType->leave_type_name }}</option>
                                @endforeach
                            </select>
                           </div>
                        </div>
                        
                        <div class="row">
                           <div class="form-group col-md-4 attachdocument" @if($employeeleave->leave_type_code == 2) style="display:none;" @endif>
                           <label>Attach Medical Certificate</label>
                           <input type="file" name="leave_document"  class="form-control">
                           @if(isset($employeeleave->leave_document) && !empty($employeeleave->leave_document))
                           <a href="{{ url('public/admin/assets/img/documents') }}/{{ isset($employeeleave->leave_document)? $employeeleave->leave_document : '' }}" target="blank">Click here to see old attachment.</a>
                           @endif 
                        </div>
                        </div>
                        
                        <div class="row">
                        <div class="form-group col-md-8">
                           <label>Leave Reason</label>
                           <textarea name="leave_reason" class="form-control">{{ isset($employeeleave->leave_reason) ? $employeeleave->leave_reason : ''}}</textarea>
                        </div>
                     </div>
                     <button  class="btn btn-primary mr-1" type="submit">update</button>
                     <a href="{{ url()->previous() }}"  class="btn btn-primary ml-2">Cancel</a>

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
<script>
   function checkLeaveType(type) {
     if(type.value==1)
     {
         $('.attachdocument').show()
     }
     else
     {
         $('.attachdocument').hide()
     }
    }
 </script>
 

@stop

