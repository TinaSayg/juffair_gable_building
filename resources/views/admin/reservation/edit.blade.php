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
      <form method="POST" action="{{route('reservation.update',$reservation->id) }}" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h4>Reservation Details</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        
                        <div class="form-group col-md-4">
                            <label>Reservation Date</label>
                            <input type="text" value="{{ isset($reservation->reservation_date)? \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') : '' }}" name="reservation_date" class="form-control datepicker">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Start Time</label>
                             <input type="text" name="start_time" value="@if(isset($reservation)) {{ $reservation->start_time }} @endif"  class="form-control timepicker">
                        </div>
                         <div class="form-group col-md-4">
                            <label>End Time</label>
                            <input type="text" name="end_time" value="@if(isset($reservation)) {{ $reservation->end_time }} @endif"  class="form-control timepicker">
                         </div>
                         <div class="form-group col-md-4">
                            <label>Tenant Name</label>
                            <input type="text" name="tenant_name" value="@if(isset($reservation)) {{ $reservation->tenant_name }} @endif" class="form-control">
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

