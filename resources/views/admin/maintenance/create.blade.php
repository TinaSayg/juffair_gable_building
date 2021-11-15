@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<style>
   
</style>
@stop
@section('content')

    <section class="section">
      
        <div class="section-body">
            <form method="POST" action="{{ route('maintenancecosts.store') }}" enctype="multipart/form-data">
                @csrf
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
                                    <input type="text" maxlength="50" name="maintenance_title" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Description</label>
                                    <textarea name="maintenance_description" class="form-control"></textarea>
                                    
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label>Date</label>
                                    <input type="date" name="maintenance_date" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Maintenance Cost</label>
                                    <input type="text" name="maintenance_cost_total_amount" class="form-control">
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
<script>
  
</script>
@stop