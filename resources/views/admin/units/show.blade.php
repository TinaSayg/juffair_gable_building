@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/components.css">
<style>
   .sup
   {
     vertical-align: super;
     font-size: 18px;
   }
</style>
@stop
@section('content')
@php
  $tenant = $unit->tenant;
@endphp
<section class="section">
    
    <div class="section-body">
      <div class="row">
        <div class="col-12" >
          <div class="col-12 col-sm-6 col-lg-12">
            <div class="card">
              
              <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                      aria-controls="home" aria-selected="true">Apartment Information</a>
                  </li>
                  @if($unit->tenant)
                  <li class="nav-item">
                    <a class="nav-link" id="tenant-tab" data-toggle="tab" href="#tenant" role="tab"
                      aria-controls="profile" aria-selected="false">Tenant Information</a>
                  </li>
                  @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                      <div class="col-md-3 col-6 b-r">
                        <strong>Floor</strong>
                        <br>
                        <p class="text-muted">{{ isset($unit->floor)? $unit->floor->number : '' }}</p>
                      </div>
                      <div class="col-md-3 col-6 b-r">
                        <strong>Apartment No.</strong>
                        <br>
                        <p class="text-muted">{{isset($unit) ? $unit->unit_number : ''}}</p>
                      </div>
                      <div class="col-md-3 col-6 b-r">
                        <strong>Apartment Type</strong>
                        <br>
                        <p class="text-muted">{{ isset($unit->apartment_type )? $unit->apartment_type  : '' }}</p>
                      </div>
                      
                      <div class="col-md-3 col-6">
                        <strong>No of bedrooms</strong>
                        <br>
                        <p class="text-muted">{{isset($unit) ? $unit->no_of_bed_rooms : '' }}</p>
                      </div>
                      <div class="col-md-3 col-6">
                        <strong>Apartment Area</strong>
                        <br>
                        <p class="text-muted">{{isset($unit) ? $unit->unit_area : '' }} m<sup>2</sup></p>
                      </div>
                      <div class="col-md-3 col-6">
                        <strong>Apartment Color</strong>
                        <br>
                        <span style="padding:5px 25px;background-color: {{ isset($unit)? $unit->color_code: ''}};box-shadow: 0 1px 2px;"></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <strong>Status</strong>
                        <br>
                        @php
                            $class = '';
                            switch ( $unit->unit_status_code) {
                            case 1:
                                $class = 'badge-success';
                                break;
                            default:
                                $class = 'badge-warning';
                                break;
                            }
                        @endphp
                        <span class="badge {{ $class }}">{{ isset($unit->unit_status) ? $unit->unit_status->unit_status_name : '' }}</span>
                      </div>
                      
                    </div>
                  </div>
                  @if($unit->tenant)
                  <div class="tab-pane fade" id="tenant" role="tabpanel" aria-labelledby="tenant-tab">
                    <div class="row mt-sm-5">
                      <div class="col-12 col-md-12 col-lg-4">
                        <div class="card author-box">
                          <div class="card-body">
                            <div class="author-box-center">
                              <img alt="image" src="{{ asset('public/admin/assets/img/staff')}}/{{ isset($tenant->tenant_image) ? $tenant->tenant_image:'' }}" class="rounded-circle author-box-picture">
                              <div class="clearfix"></div>
                              <div class="author-box-name">
                                <a href="#">{{isset($tenant) ? $tenant->tenant_first_name. ' '.$tenant->tenant_last_name : ''}}</a>
                              </div>
                              <div class="author-box-job">Apartment:{{isset($tenant->unit) ? $tenant->unit->unit_number : '' }}(floor {{isset($tenant->unit->floor)? $tenant->unit->floor->number : ''}})</div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header">
                            <h4>Personal Details</h4>
                          </div>
                          <div class="card-body">
                            <div class="py-1">
                              <p class="clearfix">
                                <span class="float-left">
                                  Date of Birth
                                </span>
                                <span class="float-right text-muted">
                                  {{ isset($tenant->tenant_date_of_birth) ? \Carbon\Carbon::parse($tenant->tenant_date_of_birth)->format('d-m-Y') : '' }}
                                </span>
                              </p>
                              <p class="clearfix">
                                <span class="float-left">
                                  Phone
                                </span>
                                <span class="float-right text-muted">
                                  {{ isset($tenant->tenant_mobile_phone)? $tenant->tenant_mobile_phone : '' }}
                                </span>
                              </p>
                              <p class="clearfix">
                                <span class="float-left">
                                  Email
                                </span>
                                <span class="float-right text-muted">
                                  {{ isset($tenant->tenant_email_address )? $tenant->tenant_email_address  : '' }}
                                </span>
                              </p>
                            </div>
                          </div>
                        </div>
                      
                      </div>
                      <div class="col-12 col-md-12 col-lg-8">
                        <div class="card">
                          <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                  aria-selected="true">About</a>
                              </li>
                             
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                              <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                                <div class="row">
                                  <div class="col-md-3 col-6 b-r">
                                    <strong>Full Name</strong>
                                    <br>
                                    <p class="text-muted">{{isset($tenant) ? $tenant->tenant_first_name. ' '.$tenant->tenant_last_name : ''}}</p>
                                  </div>
                                  <div class="col-md-3 col-6 b-r">
                                    <strong>Mobile</strong>
                                    <br>
                                    <p class="text-muted">{{ isset($tenant->tenant_mobile_phone)? $tenant->tenant_mobile_phone : '' }}</p>
                                  </div>
                                  <div class="col-md-3 col-6 b-r">
                                    <strong>Emergency Email</strong>
                                    <br>
                                    <p class="text-muted">{{ isset($tenant->emergancy_email )? $tenant->emergancy_email  : '' }}</p>
                                  </div>
                                  <div class="col-md-3 col-6">
                                    <strong>Rent Unit No.</strong>
                                    <br>
                                    <p class="text-muted">{{isset($tenant->unit) ? $tenant->unit->unit_number : '' }}</p>
                                  </div>
                                  <div class="col-md-3 col-6">
                                    <strong>Security Deposit</strong>
                                    <br>
                                    <p class="text-muted">{{isset($tenant) ? $tenant->security_deposit : '' }} BD</p>
                                  </div>
                                  
                                </div>
                                 
                                <div class="section-title">Contract Details</div>
                                <ul>
                                  <li>Lease Period Start Date: from {{ isset($tenant->lease_period_start_datetime) ? \Carbon\Carbon::parse($tenant->lease_period_start_datetime)->toFormattedDateString() : '' }} to {{ isset($tenant->lease_period_end_datetime) ? \Carbon\Carbon::parse($tenant->lease_period_end_datetime)->toFormattedDateString() : '' }}</li>
                                  </li></ul>
                                   <div class="section-title">Address</div>
                                  <ul>
                                    <li>Present Address:{{ isset($tenant->tenant_present_address )? $tenant->tenant_present_address  : '' }}</li>
                                    <li>Permenant Address:{{ isset($tenant->tenant_permanent_address )? $tenant->tenant_permanent_address  : '' }}
                                    </li></ul>
                                  </ul>
                                  <div class="section-title">Documents</div>
                                  <ul>
                                    <li><a href="{{ url('public/admin/assets/img/documents')}} .'/'. {{ isset($tenant)? $tenant->tenant_passport_copy : '' }}" target="blank">Passport Copy</a></li>
                                    <li><a href="{{ url('public/admin/assets/img/documents')}} .'/'. {{ isset($tenant)? $tenant->tenant_cpr_copy: ''}}" target="blank">CPR Copy</a></li>
                                    <li><a href="{{ url('public/admin/assets/img/documents') }} .'/'. {{ isset($tenant)? $tenant->tenant_contract_copy : '' }}" target="blank">Employee Contract</a></li>
                                  </ul>
                              </div>
                              </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>



@stop
@section('footer_scripts')
<script>
  
</script>
@stop