@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
   
</style>
@stop
@section('content')
    <section class="section">
        <div class="section-body">
            <form method="POST" action="{{ route('leave.store') }}" enctype="multipart/form-data">
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
                                    <input type="text" name="leave_start_date" class="form-control" id="datepicker1">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Leave End Date</label>
                                    <input type="text" name="leave_end_date" class="form-control " id="datepicker2">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Leave Type</label>
                                    <select class="form-control" onchange="checkLeaveType(this);" name="leave_type_code">
                                        @foreach ($leave_types as $leaveType)
                                        <option value="{{ $leaveType->leave_type_code }}" >{{ $leaveType->leave_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 attachdocument">
                                    <label>Attach Medical Certificate</label>
                                    <input type="file" name="leave_document" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label>Reason</label>
                                    <textarea name="leave_reason" class="form-control"></textarea>
                                </div>
                        </div>
                        <button  class="btn btn-primary mr-1" type="submit">Submit</button>
                        <a href="{{ url()->previous() }}"  class="btn btn-primary ml-2">Cancel</a>
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
<script>
    $("#datepicker1").daterangepicker({
        locale: { format: "YYYY-MM-DD" },
        singleDatePicker: true,
        minDate: new Date(),
    });

    $("#datepicker2").daterangepicker({
            locale: { format: "YYYY-MM-DD" },
            singleDatePicker: true,
    });

    $("#datepicker1").change(function(){
        let start = $("#datepicker1").val()
        $("#datepicker2").daterangepicker({
            locale: { format: "YYYY-MM-DD" },
            singleDatePicker: true,
            minDate: start,
        });
    })

    $("#datepicker2").change(function(){
        let max = $("#datepicker2").val()
        
        $("#datepicker1").daterangepicker({
            locale: { format: "YYYY-MM-DD" },
            singleDatePicker: true,
            minDate: new Date(),
            maxDate: max,
        });
    })
</script>
@stop