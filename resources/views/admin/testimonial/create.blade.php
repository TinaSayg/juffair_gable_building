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
            <form method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <h4>Testimonial Details</h4>
                                </div>
                             <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label> Name</label>
                                        <input type="text" maxLength="20" name="name" class="form-control">
                                    </div>

                                <div class="form-group col-md-6">
                                    <label>Attach Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8 attachdocument">
                                    <label>Review</label>
                                    <textarea name="review" class="form-control"></textarea>
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
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
  function checkLeaveType(type) {
    if(type.value==1)
    {
        $('.image').show()
    }
    else
    {
        $('.image').hide()
    }
   }
</script>
@stop