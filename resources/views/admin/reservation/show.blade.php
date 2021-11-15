{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')
    <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <h4>Room Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                
                            <div class="form-group col-md-4">
                                <label>Reservation Date</label>
                                <input type="text" name="reservation_date" value="{{ isset($reservation->reservation_date) ? $visitor->reservation_date : '' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Start time</label>
                                <input type="text" name="start_time" value="{{ isset($reservation->start_time) ? $reservation->start_time : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>End time/label>
                                <input type="text" name="end_time" value="{{ isset($reservation->end_time) ? $reservation->end_time : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tenant Name</label>
                                <input type="text" name="tenant_name" value="{{ isset($reservation->tenant_name) ? $reservation-> : 'tenant_name' }}"  class="form-control">
                            </div>

                    </div>
                    <a href="{{ route('reservation.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>




@stop
@section('footer_scripts')
<script>
  
</script>
@stop