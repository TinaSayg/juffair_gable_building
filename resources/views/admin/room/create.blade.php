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
            <form method="POST" action="{{ route('room.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <h4> Add Room Details</h4>
                                </div>
                             <div class="card-body">
                                <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Name</label>
                                    <input type="text" autocomplete="off" maxlength="50" name="name" class="form-control">
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