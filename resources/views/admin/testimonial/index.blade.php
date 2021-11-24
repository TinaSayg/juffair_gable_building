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
           <h4>Testimonial details</h4>
            <div class="card-header-form">
              <a href="{{ route('testimonials.create') }}" type="button"  class="btn btn-primary">Add Testimonial</a>
             </a>
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="mainTable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Review</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($testimonial as $key => $testimonial)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $testimonial->name}}</td>
                        <td>{{ $testimonial->review}}</td>
                        
                        <td>
                          <a href="#" onclick="getTestimonialDetails({{ $testimonial->id }})"><i class="fa fa-eye mr-2"></i> </a>
                          <a href="#" onclick="form_alert('testimonial-{{ $testimonial->id }}','Want to delete this testimonial')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <a href="{{ route('testimonials.edit', $testimonial->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <form action="{{ route('testimonials.delete', $testimonial->id) }}"
                            method="post" id="testimonial-{{ $testimonial->id }}">
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
{{-- visitor modal --}}
<div class="modal" id="testimonialModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
               @include('admin.testimonial.partials.testimonial_view_modal')  
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<script>
  function getTestimonialDetails(id) {
    $.get({
        url: '{{route('testimonials.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#testimonialModal tbody").html(data.html_response)
            $("#testimonialModal").modal("show")
        }
    });
  }
</script>
@stop