
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
                            <h4>Maintenance Details</h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Maintenance Title</label>
                                <input type="text" name="maintenance_title" value="{{ isset($maintenancecost->maintenance_title) ? $maintenancecost-> : 'maintenance_title' }}"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Description</label>
                                <input type="text" name="maintenance_description" value="{{ isset($maintenancecost->maintenance_description) ? $maintenancecost->maintenance_description : '' }}" class="form-control">
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Date</label>
                                <input type="text" name="maintenance_date" value="{{ isset($maintenancecost->maintenance_date) ? $maintenancecost->maintenance_date : '' }}" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Maintenance Cost</label>
                                <input type="text" name="maintenance_cost_total_amount" value="{{ isset($maintenancecost->maintenance_cost_total_amount) ? $maintenancecost->maintenance_cost_total_amount : '' }}" class="form-control">
                            </div>
                           
                    </div>
                    <a href="{{ route('maintenancecosts.list') }}" class="btn btn-primary mr-1" type="button">Back</a>
              
                </div>
            </div>
    </div>
</section>




@stop
@section('footer_scripts')
<script>
  
</script>
@stop