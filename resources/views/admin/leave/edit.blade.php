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
      <form method="POST" action="{{route('leave.update',$employeeleave->id) }}" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h4>Leave Details</h4>
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
                           <label>Apply Date</label>
                           <input type="text" value="{{ isset($employeeleave) ? \Carbon\Carbon::parse($employeeleave->apply_date)->format('Y-m-d') : ''}}"  name="apply_date" class="form-control datepicker">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Leave reason</label>
                           <textarea name="leave_reason" class="form-control">{{ isset($employeeleave->leave_reason) ? $employeeleave->leave_reason : ''}}</textarea>
                          
                        </div>
                           <div class="form-group col-md-4">
                            <label>Leave Type</label>
                            <select class="form-control" name="leave_type_code">
                                @foreach ($leave_types as $leaveType)
                                <option value="{{ $leaveType->leave_type_code }}" {{ (isset($employeeleave) && ($employeeleave->leave_type_code == $leaveType->leave_type_code)) ? 'selected' :'' }}>{{ $leaveType->leave_type_name }}</option>
                                @endforeach
                            </select>
                           </div>
                        <div class="form-group col-md-4">
                           <label>Attach document</label>
                           <input type="file" name="leave_document"  class="form-control">
                           @if(isset($employeeleave->leave_document) && !empty($employeeleave->leave_document))
                               <img src="{{asset('public/admin/assets/img/documents/'.$employeeleave->leave_document)}}" height="150" width="150">
                           @endif 
                        </div>
                        </div>
                    
                     <button  class="btn btn-primary mr-1" type="submit">update</a>
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

