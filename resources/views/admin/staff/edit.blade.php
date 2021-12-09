

@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
   textarea
   {
   height: 64px !important;
   }
</style>
@stop
@section('content')
<section class="section">
   {{-- 
   <ul class="breadcrumb breadcrumb-style ">
      <li class="breadcrumb-item">
         <a href="index.html">
         <i class="fas fa-home"></i></a>
      </li>
      <li class="breadcrumb-item">Staff Details</li>
      <li class="breadcrumb-item">Edit Staff</li>
   </ul>
   --}}
   <div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         @if ($errors->any())
         <div class="alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
         @if(Session::has('success_message'))
         <div class="alert alert-success alert-success fade show" style="margin-top:10px" role="alert">
            {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         @endif
         @if(Session::has('error_message'))
         <div class="alert alert-danger alert-success fade show" style="margin-top:10px" role="alert">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         @endif
         <div class="card">
            <form 
               action="{{ route('staff.update', $staffData['id']) }}" 
               method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
               @csrf
               <div class="card-header">
                  <h4>Edit Staff</h4>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="form-group col-md-4">
                        <label for="name">Name</label>
                        <input type="text" class="form-control"  name="name" id="name"
                        @if (!empty($staffData['employee_name'])) value="{{$staffData['employee_name']}}" @else value="{{ old('employee_name')}}" @endif
                        placeholder="Staff name">
                        <div class="invalid-feedback">
                           Staff Name is required?
                        </div>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="number">Contact Number (Without Country Code)</label>
                        <input type="text" class="form-control" maxlength="8"  name="number" id="number"
                        @if (!empty($staffData['employee_mobile_phone'])) value="{{$staffData['employee_mobile_phone']}}" @else value="{{ old('employee_mobile_phone')}}" @endif
                        placeholder="Staff number">
                        <div class="invalid-feedback">
                           Staff number is required?
                        </div>
                     </div>
                     <div class="form-group col-md-3">
                        <label for="email">Email </label>
                        <input type="email" class="form-control"  name="email" id="email"
                        @if (!empty($staffData['employee_email_address'])) value="{{$staffData['employee_email_address']}}" @else value="{{ old('employee_email_address')}}" @endif
                        placeholder="Staff email">
                        <div class="invalid-feedback">
                           Please add an email
                        </div>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Date of birth</label>
                        <input type="text" value="{{ isset($staffData['employee_date_of_birth']) ? $staffData['employee_date_of_birth'] : '' }}" name="staff_date_of_birth" class="form-control datepicker">
                     </div>
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                           <label for="staff_image">Staff Image</label>
                           <div class="input-group">
                              <div class="custom-file">
                                 <input type="file" class="custom-file-input" name="staff_image" id="staff_image">
                                 <label class="custom-file-label" for="staff_image">Choose file</label>
                              </div>
                           </div>
                           @if(!empty($staffData['employee_image']))
                           <img src="{{asset('public/admin/assets/img/staff/'.$staffData['employee_image'])}}" height="150" width="150">
                           @endif  
                        </div>
                     </div>
                     
                     <div class="form-group col-md-4">
                        <label>Annual Leaves</label>
                        <input type="text" value="{{ isset($staffData['annual_leaves']) ? $staffData['annual_leaves'] : '' }}" name="annual_leaves" class="form-control" id="annual_leaves"></input>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Total Salary (BD)</label>
                        <input type="text" value="{{ isset($staffData['employee_sallery']) ? $staffData['employee_sallery'] : '' }}" name="sallery" class="form-control" id="sallery"></input>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Present Address</label>
                        <textarea name="staff_present_address" class="form-control">{{ isset($staffData['employee_present_address']) ? $staffData['employee_present_address'] : '' }}</textarea>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Permanent Address</label>
                        <textarea name="staff_permanent_address" class="form-control">{{ isset($staffData['employee_permanent_address']) ? $staffData['employee_permanent_address'] : '' }}</textarea>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Cpr Number</label>
                        <input type="text" value="{{ isset($staffData['employee_cpr_no']) ? $staffData['employee_cpr_no'] : '' }}" maxlength="9" name="staff_cpr_no" class="form-control" id="cprNumber">
                     </div>
                     <div class="form-group col-md-4">
                        <label>Passport Number</label>
                        <input type="text" value="{{ isset($staffData['passport_number']) ? $staffData['passport_number'] : '' }}" maxlength="9" name="passport_number" class="form-control" id="cprNumber">
                     </div>
                     <div class="form-group col-md-4">
                        <label>LeasePeriodStartDate</label>
                        <input type="text" value="{{ isset($staffData['employee_start_datetime']) ? $staffData['employee_start_datetime'] : '' }}" name="lease_period_start_datetime" class="form-control datepicker">
                     </div>
                     <div class="form-group col-md-4">
                        <label>LeasePeriodEndDate</label>
                        <input type="text" value="{{ isset($staffData['employee_end_datetime']) ? $staffData['employee_end_datetime'] : '' }}" name="lease_period_end_datetime" class="form-control datepicker">
                     </div>
                     <div class="form-group col-md-4">
                        <label>Staff Passport Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="staff_passport_copy" class="form-control">
                     </div>
                     <div class="form-group col-md-4">
                        <label>Staff CPR Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="staff_cpr_copy" class="form-control">
                     </div>
                     <div class="form-group col-md-4">
                        <label>Staff Contract Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="staff_contract_copy" class="form-control">
                     </div>
                  </div>
                  <div class="form-group row">
                     <div class="form-group col-md-5" style="margin-right: 10px">
                        <label>Assign Role to Staff</label> <br>
                        @foreach($roles as $key=>$role )
                        <input type="radio"  {{$role['id']==$selectedRole->role_id ? 'checked' : ''}} name="staffType"  value="{{$role['slug']}}">{{$role['name']}} <br>
                        @endforeach
                        <div class="invalid-feedback">
                           Please select role for the staff
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-right">
                     <button type="submit" class="btn btn-primary">Edit Staff</button>
                  </div>
            </form>
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
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
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
   
      
       $("#number").inputFilter(function(value) {
       return /^-?\d*$/.test(value); });
   
       $("#cprNumber").inputFilter(function(value) {
       return /^-?\d*$/.test(value); });
   
       $("#sallery").inputFilter(function(value) {
       return /^-?\d*$/.test(value); });
   
</script>
<script>
   $('#staff_image').change(function() {
     var i = $(this).next('label').clone();
     var file = $('#staff_image')[0].files[0].name;
     $(this).next('label').text(file);
   });
</script>
@stop

