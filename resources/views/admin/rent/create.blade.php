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
            <div class="card" style="padding:15px 15px">
                <form action="" method="get">
                    @csrf
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Select Renter</label>
                        <select name="tenant_id" class="form-control" id="">
                          <option value="">--- Select ---</option>
                          <option value="1">Sam john</option>
                          <option value="2">muhammad kj</option>
                        </select>
                         </div>
                              <div class="form-group col-md-3">
                                <label for="">Floor Type</label>
                                <select class="form-control" name="floor_type_code" onchange="getFloors(this.value)" id="floor_type_code">
                                    <option value="0" selected disabled>---Select---</option>
                                    @foreach ($floor_types as $floor_type)
                                        <option value="{{ $floor_type->floor_type_code }}">{{ $floor_type->floor_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Select Floor</label>
                                <select class="form-control" name="floor_id" id="floorSelect"></select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Select Type</label>
                                <select name="apartment_type" class="form-control" id="">
                                    <option value="0" selected disabled>---Select---</option>
                                    <option value="all">All</option>
                                    <option value="Type 1">Type 1</option>
                                    <option value="Type 2">Type 2</option>
                                    <option value="Type 3">Type 3</option>
                                    <option value="Type 4">Type 4</option>
                                    <option value="Type 5">Type 5</option>
                                </select>
            
                            </div>
                        <div class="form-group col-md-1" style="margin-top: 1.90rem !important;">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
     <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            
            <div class="card-header-form">
             
           </div>
           </div>
             <div class="card-body">
               
          <form method="POST" enctype="multipart/form-data">
            @csrf
            <div >
                <section class="section">
                  <div class="section-body"> 
                    <div class="invoice">
                      <div class="invoice-print">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="invoice-title">
                              <h2>Rent Invoice</h2>
                              <div class="invoice-number">Invoice #1</div>
                              <div class="col-md-24 text-md-right">
                                  Issue Date:30 Nov 2021<br>
                                  Paid Date:30 Nov 2021<br><br>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-md-6">
                                <address>
                                  <strong><b>Muhammad Kj</b></strong><br>
                                  Flat 61,Juffair Gables<br>
                                  Building 1092,Road 4022,<br>
                                  Block 340,Juffair,<br>
                                  Kingdom Of Bahrain
                                </address>
                              </div>
                              <div class="col-md-6 text-md-right">
                                <address>
                                  <strong><b>Juffair Gables<b></strong><br>
                                  Building 1092,Road 4022,<br>
                                  Block 340,Juffair,<br>
                                  Kingdom Of Bahrain<br>
                                  Tel:+973 17255577 <br>
                                  email:mrshaheen@juffairgables.com
                                </address>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-4">
                          <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                              <table class="table table-striped table-hover table-md">
                                <tr>
                                  <th data-width="40">#</th>
                                  <th>Description</th>
                                  <th class="text-center"></th>
                                  <th class="text-center"></th>
                                  <th class="text-right">Amount BHD</th>
                                </tr>
                                <tr>
                                  <td>1</td>
                                  <td>Rent of Apartment 61,Juffair Gables for the month of November</td>
                                  <td class="text-center"></td>
                                  <td class="text-center"></td>
                                  <td class="text-right">650.000</td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>EWA Bill</td>
                                  <td class="text-center"></td>
                                  <td class="text-center"></td>
                                  <td  class="text-right"><input type='text'/></td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>Utility Bill</td>
                                  <td class="text-center"></td>
                                  <td class="text-center"></td>
                                 <td  class="text-right"><input type='text'/></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td class="text-center"></td>
                                  <td class="text-center">VAT(10%)</td>
                                  <td  class="text-right"><input type='text'/></td>
                                </tr>
                              </table>
                            </div>
                            <div class="row mt-4">
                              <div class="col-lg-4">
                               <!--  <div class="section-title">Payment Method:Cash</div> -->
                               <div class="form-group">
                              <label><b>Payment Method</b></label>
                              <select class="form-control">
                                <option>Cash</option>
                                <option>Benefit</option>
                                <option>Card</option>
                              </select>
                            </div>
                              <div class="form-group">
                              <label><b>Notes:</b></label>
                              <textarea class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                              <label class="d-block">Payment Status</label>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                  Paid
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" checked>
                                <label class="form-check-label" for="exampleRadios2">
                                 Unpaid
                                </label>
                              </div>
                            </div>
                             </div>
                                <hr class="mt-3 mb-2">
                                <div class="invoice-detail-item">
                                  <div class="invoice-detail-name">Grand Total</div>
                                  <div class="invoice-detail-value invoice-detail-value-lg">BHD 650.00</div><br><br>
                                  --------------------------<br>
                                  SIGNATURE<br>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div> 
                      <hr>
                      <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                        </div>
                        <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                      </div>
                    </div>
                </section>
        </div>
      </div>
    </div>
  </section>
{{-- visitor modal --}}
<div class="modal" id="rentModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
              @include('admin.rent.partials.rent_view_modal') 
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<script>
  function getRentDetails(id) {
    $.get({
        url: '{{route('rent.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#rentModal tbody").html(data.html_response)
            $("#rentModal").modal("show")
        }
    });
  }
</script>
<script>
  function getFloors(id) {
          $.get({
              url: '{{route('floor_type.fetch_floors', '')}}' + "/"+ id,
              dataType: 'json',
              success: function (data) {
                  console.log(data.options)
                  $('#floorSelect').empty().append(data.options)
              }
          });
      }
  </script>
@stop