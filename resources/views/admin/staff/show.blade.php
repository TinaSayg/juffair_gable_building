@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<!-- Template CSS -->
<link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/components.css">
<style>
   
</style>
@stop
@section('content')
<section class="section">
    
    <div class="section-body">
      <div class="row mt-sm-5">
        <div class="col-12 col-md-12 col-lg-4">
          <div class="card author-box">
            <div class="card-body">
              <div class="author-box-center">
                <img alt="image" src="{{ asset('public/admin/assets/img/staff')}}/{{ isset($employee->employee_image) ? $employee->employee_image:'' }}" class="rounded-circle author-box-picture">
                <div class="clearfix"></div>
                <div class="author-box-name">
                  <a href="#">{{isset($employee) ? $employee->employee_name : ''}}</a>
                </div>
                
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
                    {{ isset($employee->employee_date_of_birth) ? \Carbon\Carbon::parse($employee->employee_date_of_birth)->format('d-m-Y') : '' }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    Phone
                  </span>
                  <span class="float-right text-muted">
                    {{ isset($employee->employee_mobile_phone)? $employee->employee_mobile_phone : '' }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    Email
                  </span>
                  <span class="float-right text-muted">
                    {{ isset($employee->employee_email_address )? $employee->employee_email_address  : '' }}
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
                      <p class="text-muted">{{isset($employee) ? $employee->employee_name : ''}}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                      <strong>Email</strong>
                      <br>
                      <p class="text-muted">{{ isset($employee->employee_email_address )? $employee->employee_email_address  : '' }}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                      <strong>CPR</strong>
                      <br>
                      <p class="text-muted">{{isset($employee) ? $employee->employee_cpr_no : ''}}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                      <strong>Passport Number</strong>
                      <br>
                      <p class="text-muted">{{isset($employee) ? $employee->passport_number : ''}}</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                      <strong>Salary Per Month</strong>
                      <br>
                      <p class="text-muted">BD{{ isset($employee->employee_sallery )? round($employee->employee_sallery,0)  : '' }}</p>
                    </div>
                  </div>
                  
                   
                  <div class="section-title">Employee Details</div>

                  <ul>
                    <li>Joining Date:({{isset($employee->employee_start_datetime) ? \Carbon\Carbon::parse($employee->employee_start_datetime)->toFormattedDateString() : '' }})</li>
                    <li>Contract end date:({{isset($employee->employee_end_datetime) ? \Carbon\Carbon::parse($employee->employee_end_datetime)->toFormattedDateString() : '' }})</li>
                  </ul>

                  <div class="section-title">Leave Details</div>

                  <ul>
                    <li>Leave Per Month: {{isset($employee) ? round($employee->annual_leaves/12,1) : '' }}</li>
                    <li>Annual Leaves: {{isset($employee) ? $employee->annual_leaves : '' }}</li>
                  </ul>
                  <div class="section-title">Documents</div>
                  
                  <ul>
                    <li><a href="{{ url('public/admin/assets/img/documents').'/'. $employee->employee_passport_copy }}" target="blank">Passport Copy</a></li>
                    <li><a href="{{ url('public/admin/assets/img/documents').'/'. $employee->employee_cpr_copy }}" target="blank">CPR Copy</a></li>
                    <li><a href="{{ url('public/admin/assets/img/documents').'/'. $employee->employee_contract_copy }}" target="blank">Employee Contract</a></li>
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
</section>



@stop
@section('footer_scripts')
<script>
  
</script>
@stop