@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
</style>
@stop
@section('content')

   <div class="section-body">
      <form method="POST" action="{{route('testimonials.update',$testimonial->id) }}" enctype="multipart/form-data">
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
                            <label>Name</label>
                            <input type="text" name="name" value="@if(isset($testimonial)) {{ $testimonial->name }} @endif" class="form-control">
                         </div>
                         <div class="form-group col-md-6">
                           <label>Image</label>
                           <input type="file" name="image"  class="form-control">
                           @if(isset($testimonial->image) && !empty($testimonial->image))
                               <img src="{{asset('public/admin/assets/img/testimonial/'.$testimonial->image)}}" height="150" width="150">
                           @endif 
                            
                        </div>

                        <div class="form-group col-md-8">
                           <label>Review</label>
                           <textarea name="review"  class="form-control">{{ isset($testimonial->review)? $testimonial->review : '' }}</textarea>
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
<script src="{{ asset('public/admin/assets/') }}/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>

</script>
@stop

