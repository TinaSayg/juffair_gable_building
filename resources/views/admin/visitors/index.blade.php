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
           <h4>Visitors list</h4>
            <div class="card-header-form">
              @if(request()->user()->can('add-visitor'))
              <a href="{{ route('visitor.create') }}" type="button"  class="btn btn-primary">Add Visitor</a>
              </a>
              @endif
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="mainTable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Visitors Name</th>
                      <th>Date</th>
                      <th>Phone No</th>
                      <th>Unit</th>
                      <th>In</th>
                      <th>Out</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($visitor as $key => $visitor)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $visitor->visitor_full_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($visitor->visitor_entry_date)->toFormattedDateString() }}</td>
                        <td>{{ $visitor->visitor_phone_number}}</td>
                        <td>{{ isset($visitor->unit) ? $visitor->unit->unit_number : '' }}</td>
                        <td>{{ $visitor->visitor_in_time}}</td>
                        <td>{{ $visitor->visitor_out_time}}</td>
                        

                        <td>
                          @if(request()->user()->can('view-visitor'))
                          <a href="#" onclick="getVisitorDetails({{ $visitor->id }})"><i class="fa fa-eye mr-2"></i> </a>
                          @endif
                          @if(request()->user()->can('delete-visitor'))
                          <a href="#" onclick="form_alert('visitor-{{ $visitor->id }}','Want to delete this visitor')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          @endif
                          @if(request()->user()->can('edit-visitor'))
                          <a href="{{ route('visitor.edit', $visitor->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          @endif
                          <form action="{{ route('visitor.delete', $visitor->id) }}"
                            method="post" id="visitor-{{ $visitor->id }}">
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
<div class="modal" id="visitorModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
              @include('admin.visitors.partials.visitors_view_modal') 
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<script>
  function getVisitorDetails(id) {
    $.get({
        url: '{{route('visitor.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#visitorModal tbody").html(data.html_response)
            $("#visitorModal").modal("show")
        }
    });
  }
</script>
@stop