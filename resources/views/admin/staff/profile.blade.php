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

   .pwd-input
   {
     border-right: 0 !important;
   }

   .input-group-text
   {
     border-left: 0 !important;
   }
   .form-control, .input-group-text, .custom-select, .custom-file-label
   {
      border-color: #6777ef !important;
   }
  .overlay {
    position: absolute;
    top: 20px;
    bottom: 0;
    left: 122px;
    right: 0;
    opacity: 1;
    transition: .3s ease;
    border-radius: 50%;
    width: 100px;
    box-shadow: 0 4px 25px 0 rgba(0,0,0,0.1);
    height: 100px;
    cursor: pointer;
}

.author-box-center:hover .overlay {
  opacity: 1;
}

.icon {
  color: white;
  font-size: 100px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.fa-user:hover {
  color: #eee;
}

.profile-image
{
  height: 100px;
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
                <img alt="image" src="{{asset('public/admin/assets/img/staff/')}}/{{ $user->image }}"  id="OpenImgUpload" class="rounded-circle profile-image imgupload author-box-picture">
                <form action="{{ route('staff.change_profile_image', $user->id) }}" id="profileImageForm" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="file" name="profile_image" id="imgupload" class="img-input" style="display:none"/>
                </form>
                <div class="overlay">
                  <a href="#" class="icon" title="Edit Profile Image">
                    <i class="fas fa-pen"></i>
                  </a>
                </div> 
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
                    aria-selected="true">Profile Information</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                    aria-selected="false">Change Password</a>
                </li>
              </ul>
              <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                  <form action="{{ route('staff.edit_profile', $user->id) }}" method="post">
                    @csrf
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 col-12">
                          <label>Email</label>
                          <input type="email" class="form-control" readonly value="{{isset($user_details->employee_email_address) ? $user_details->employee_email_address : '' }}">
                          <div class="invalid-feedback">
                            Please fill in the email
                          </div>
                        </div>
                        <div class="form-group col-md-6 col-12">
                          <label>Contact Number (Without Country Code)</label>
                          <input type="tel" name="number" maxlength="8" id="contactNumber" class="form-control" value="{{isset($user_details->employee_mobile_phone) ? $user_details->employee_mobile_phone : '' }}">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label>Present Address</label>
                          <textarea
                            name="present_address" class="form-control">{{isset($user_details->employee_present_address) ? $user_details->employee_present_address : '' }}</textarea>
                        </div>
                        <div class="form-group col-6">
                          <label>Permanent Address</label>
                          <textarea
                            name="permanent_address" class="form-control">{{isset($user_details->employee_permanent_address) ? $user_details->employee_permanent_address : '' }}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                  <form action="{{ route('staff.change_password', $user->id) }}" method="post" autocomplete="off" >
                    @csrf
                    <div class="card-header">
                      <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 col-12">
                          <label>Password</label>
                          <div class="input-group">
                            <input type="password" name="password" autocomplete="off" id="pass_log_id" class="form-control  pwd-input">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-eye-slash toggle-password"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6 col-12">
                          <label>Confirm Password</label>
                          <div class="input-group">
                            <input type="password" name="confirm_password" autocomplete="off" id="confrim_pass_log_id" class="form-control  pwd-input">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-eye-slash toggle-confirm-password"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Change Password</button>
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
<script>
  $("body").on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#pass_log_id");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
});
</script>
<script>
  $("body").on('click', '.toggle-confirm-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#confrim_pass_log_id");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
});
</script>
<script>
  $('.overlay').click(function(){
    $('#imgupload').trigger('click');
  });
</script>
<script>
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.profile-image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".img-input").change(function(){
    readURL(this);
    document.getElementById("profileImageForm").submit();
});
</script>
<script>
  (function($) {
          $.fn.inputFilter = function(inputFilter) {
              return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
              if (inputFilter(this.value)) {
                  this.oldValue = this.value;
                  this.oldSelectionStart = this.selectionStart;
                  this.oldSelectionEnd = this.selectionEnd;
              } else if (this.hasOwnProperty("oldValue")) {
                  this.value = this.oldValue;
                  this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
              } else {
                  this.value = "";
              }
              });
          };
      }(jQuery));
  
     
    $("#contactNumber").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });
</script>
@stop