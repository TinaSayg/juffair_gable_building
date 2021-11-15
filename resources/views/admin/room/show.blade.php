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
                                <label>Name</label>
                                <input type="text" name="name" value="{{ isset($room->name) ? $room-> : 'name' }}"  class="form-control">
                            </div>
                        
                           
                    </div>
                    <a href="{{ route('room.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>




@stop
@section('footer_scripts')
<script>
  
</script>
@stop