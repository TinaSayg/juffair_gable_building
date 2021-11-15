@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<style>
</style>
@stop
@section('content')

   <div class="section-body">
      <form method="POST" action="{{route('maintenancecosts.update',$maintenance_costs->id) }}" enctype="multipart/form-data">
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
                           <input type="text" name="maintenance_title" value="@if(isset($maintenance_costs)) {{ $maintenance_costs->maintenance_title }} @endif" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Description</label>
                          
                           <textarea name="maintenance_description" value="" class="form-control">{{ isset($maintenance_costs) ? $maintenance_costs->maintenance_description : ''}}</textarea>
                        </div>
                        <div class="form-group col-md-4">
                           <label>Date</label>
                           <input type="text" value="{{ isset($maintenance_costs) ? \Carbon\Carbon::parse($maintenance_costs->maintenance_date)->format('Y-m-d') : ''}}"  name="maintenance_date" class="form-control datepicker">
                        </div>
                        <div class="form-group col-md-4">
                           <label>Maintenance Cost</label>
                           <input type="text" name="maintenance_cost_total_amount" value="@if(isset($maintenance_costs)) {{ $maintenance_costs->maintenance_cost_total_amount }} @endif" class="form-control">
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
<script></script>
@stop

