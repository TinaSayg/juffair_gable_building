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
           <h4>Reservation details</h4>
            <div class="card-header-form">
              <a href="{{ route('reservation.create') }}" type="button"  class="btn btn-primary">Add reservation</a>
             </a>
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="mainTable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Reservation ID</th>
                      <th>Reservation Date</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Tenant Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($reservation as $key => $reservation)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $reservation->reservation_id}}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->toFormattedDateString() }}</td>
                        <td>{{ $reservation->start_time}}</td>
                        <td>{{ $reservation->end_time}}</td>
                        <td>{{ $reservation->tenant_name}}</td>
                        <td>
                          <a href="#" onclick="getReservationDetails({{ $reservation->id }})"><i class="fa fa-eye mr-2"></i> </a>
                          <a href="#" onclick="form_alert('reservation-{{ $reservation->id }}','Want to delete this visitor')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <a href="{{ route('reservation.edit', $reservation->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          <form action="{{ route('reservation.delete', $reservation->id) }}"
                            method="post" id="reservation-{{ $reservation->id }}">
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
<div class="modal" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
              @include('admin.reservation.partials.reservationdetails_view_modal') 
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<script>
  function getReservationDetails(id) {
    $.get({
        url: '{{route('reservation.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#reservationModal tbody").html(data.html_response)
            $("#reservationModal").modal("show")
        }
    });
  }
</script>
@stop