@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/admin/assets') }}/css/components.css">
<style>
     table.dataTable td img
    {
        box-shadow: 0 5px 15px 0 rgba(105,103,103,0.5);
        border: 2px solid #ffffff;
        border-radius: 10px;
    }

    table.dataTable td, table.dataTable th {
        vertical-align: middle;
    }
    tr:hover {
    background: #a3a3a3 !important;
   }
</style>
@stop
@section('content')
<section class="section">
    <div class="section-body">
      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-4">
            @php
                $user = Auth::user();
            @endphp
          <div class="card author-box">
            <div class="card-body">
              <div class="author-box-center">
                <img alt="image" src="{{asset('public/admin/assets/img/staff/')}}/{{ $user->image }}" class="rounded-circle author-box-picture">
                <div class="clearfix"></div>
                <div class="author-box-name mt-1">
                  <a href="#">{{ $user->name }}</a>
                </div>
                <div class="author-box-job">{{ $user->userType }}</div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4>Personal Details</h4>
            </div>
            <div class="card-body">
                @php
                    $user_details = \App\Models\Employee::where('employee_email_address', $user->email)->first();
                @endphp
              <div class="py-4">
                <p class="clearfix">
                  <span class="float-left">
                    Birthday
                  </span>
                  <span class="float-right text-muted">
                    {{ isset($user_details) ? \Carbon\Carbon::parse($user_details->date_of_birth)->format('d-m-Y'): '' }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    Phone
                  </span>
                  <span class="float-right text-muted">
                    {{ isset($user_details) ? $user_details->employee_mobile_phone : '' }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    Email
                  </span>
                  <span class="float-right text-muted">
                    {{ isset($user_details) ? $user_details->employee_email_address : '' }}

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
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                    aria-selected="false">Setting</a>
                </li>
              </ul>
              <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                  <div class="row">
                    <div class="col-md-3 col-6 b-r">
                      <strong>Full Name</strong>
                      <br>
                      <p class="text-muted">Emily Smith</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                      <strong>Mobile</strong>
                      <br>
                      <p class="text-muted">(123) 456 7890</p>
                    </div>
                    <div class="col-md-3 col-6 b-r">
                      <strong>Email</strong>
                      <br>
                      <p class="text-muted">johndeo@example.com</p>
                    </div>
                    <div class="col-md-3 col-6">
                      <strong>Location</strong>
                      <br>
                      <p class="text-muted">India</p>
                    </div>
                  </div>
                  <p class="m-t-30">Completed my graduation in Arts from the well known and
                    renowned institution
                    of India – SARDAR PATEL ARTS COLLEGE, BARODA in 2000-01, which was
                    affiliated
                    to M.S. University. I ranker in University exams from the same
                    university
                    from 1996-01.</p>
                  <p>Worked as Professor and Head of the department at Sarda Collage, Rajkot,
                    Gujarat
                    from 2003-2015 </p>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem
                    Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when
                    an unknown printer took a galley of type and scrambled it to make a
                    type
                    specimen book. It has survived not only five centuries, but also the
                    leap
                    into electronic typesetting, remaining essentially unchanged.</p>
                  <div class="section-title">Education</div>
                  <ul>
                    <li>B.A.,Gujarat University, Ahmedabad,India.</li>
                    <li>M.A.,Gujarat University, Ahmedabad, India.</li>
                    <li>P.H.D., Shaurashtra University, Rajkot</li>
                  </ul>
                  <div class="section-title">Experience</div>
                  <ul>
                    <li>One year experience as Jr. Professor from April-2009 to march-2010
                      at B.
                      J. Arts College, Ahmedabad.</li>
                    <li>Three year experience as Jr. Professor at V.S. Arts &amp; Commerse
                      Collage
                      from April - 2008 to April - 2011.</li>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting
                      industry.
                    </li>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting
                      industry.
                    </li>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting
                      industry.
                    </li>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting
                      industry.
                    </li>
                  </ul>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                  <form method="post" class="needs-validation">
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 col-12">
                          <label>First Name</label>
                          <input type="text" class="form-control" value="John">
                          <div class="invalid-feedback">
                            Please fill in the first name
                          </div>
                        </div>
                        <div class="form-group col-md-6 col-12">
                          <label>Last Name</label>
                          <input type="text" class="form-control" value="Deo">
                          <div class="invalid-feedback">
                            Please fill in the last name
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-7 col-12">
                          <label>Email</label>
                          <input type="email" class="form-control" value="test@example.com">
                          <div class="invalid-feedback">
                            Please fill in the email
                          </div>
                        </div>
                        <div class="form-group col-md-5 col-12">
                          <label>Phone</label>
                          <input type="tel" class="form-control" value="">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>Bio</label>
                          <textarea
                            class="form-control summernote-simple">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur voluptatum alias molestias minus quod dignissimos.</textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group mb-0 col-12">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                            <label class="custom-control-label" for="newsletter">Subscribe to newsletter</label>
                            <div class="text-muted form-text">
                              You will get new information about products, offers and promotions
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Save Changes</button>
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
<!-- JS Libraies -->
<script src="{{asset('public/admin/assets/bundles/datatables/datatables.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/jszip.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/pdfmake.min.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/vfs_fonts.js')}}"></script>
<script src="{{asset('public/admin/assets/bundles/datatables/export-tables/buttons.print.min.js')}}"></script>
<script src="{{asset('public/admin/assets/js/page/datatables.js')}}"></script>

@stop