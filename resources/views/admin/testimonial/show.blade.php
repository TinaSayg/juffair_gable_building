@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
    
@stop
{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')
<section class="section">
    
    <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <h4>Testimonial Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ isset($testimonial->name) ? $testimonial-> : 'name' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Review</label>
                                <input type="text" name="review" value="{{ isset($testimonial->review) ? $testimonial-> : 'review' }}"  class="form-control">
                            </div>
                            <div class="section-title">File</div>
                            <ul>
                              <li><a href="{{ url('public/admin/assets/img/documents').'/'. $testimonial->image }}" target="blank">File</a></li>
                             
                            </ul>
                        </div>
                    </div>
                    <a href="{{ route('testimonial.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>
@stop
@section('footer_scripts')
<script>
  
</script>
@stop