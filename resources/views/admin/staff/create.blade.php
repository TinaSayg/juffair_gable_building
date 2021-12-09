

@extends('layouts.admin.app')
{{-- Page title --}}
@section('title')
Juffair Gable
@stop
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
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
      <li class="breadcrumb-item">Add Staff</li>
   </ul>
   --}}
   <div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <form 
               action="{{route('staff.store') }}" 
               method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
               @csrf
               <div class="card-header">
                  <h4>Add Staff</h4>
               </div>
               <div class="card-body">
                  <div class="form-group row">
                     <div class="form-group col-md-4">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" autocomplete="off" required="" name="name" id="name"
                           value="{{ old('name')}}" 
                           placeholder="Staff name">
                        <div class="invalid-feedback">
                           Staff Name is required?
                        </div>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="number">Contact Number (Without Country Code)</label>
                        <input type="tel" maxlength="8" class="form-control" autocomplete="off" name="number" id="number" required="" 
                           value="{{ old('number')}}" 
                           placeholder="Staff contact number">
                        <div class="invalid-feedback">
                           Staff number is required?
                        </div>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="email">Email </label>
                        <input type="email" class="form-control" autocomplete="off" required="" name="email" id="email" placeholder="Enter Staff email"
                           value="{{ old('email')}}">
                        <div class="invalid-feedback">
                           Please add an email
                        </div>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Date of birth</label>
                        <input type="date" name="staff_date_of_birth" class="form-control">
                     </div>
                     <div class="form-group col-md-4">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" autocomplete="off" required="" name="password" id="password" placeholder="Enter password">
                        <div class="invalid-feedback">
                           Please add password
                        </div>
                     </div>
                     <div class="col-md-4 col-12">
                        <div class="form-group">
                           <label for="staff_image">Staff Image</label>
                           <div class="input-group">
                              <div class="custom-file">
                                 <input type="file"
                                    id="staff_image" name="staff_image"
                                    accept="image/jpeg,image/png">
                              </div>
                           </div>
                        </div>
                     </div>
                     
                     <div class="form-group col-md-4">
                        <label>Annual Leaves</label>
                        <input type="text" name="annual_leaves" class="form-control" id="annual_leaves"></input>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Total Salary (BD)</label>
                        <input type="text" name="sallery" class="form-control" id="sallery"></input>
                     </div>

                     <div class="form-group col-md-4">
                        <label>Present Address</label>
                        <textarea name="staff_present_address" class="form-control"></textarea>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Permanent Address</label>
                        <textarea name="staff_permanent_address" class="form-control"></textarea>
                     </div>
                     <div class="form-group col-md-4">
                        <label>Cpr Number</label>
                        <input type="text" maxlength="9" name="staff_cpr_no" class="form-control" id="cprNumber">
                     </div>
                     <div class="form-group col-md-4">
                        <label>Passport Number</label>
                        <input type="text" maxlength="9" name="passport_number" class="form-control" id="cprNumber">
                     </div>
                     <div class="form-group col-md-4">
                        <label>LeasePeriodStartDate</label>
                        <input type="date" name="lease_period_start_datetime" class="form-control">
                     </div>
                     <div class="form-group col-md-4">
                        <label>LeasePeriodEndDate</label>
                        <input type="date" name="lease_period_end_datetime" class="form-control">
                     </div>
                     <div class="form-group col-md-4">
                        <label>Passport Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="staff_passport_copy" class="form-control">
                     </div>
                     <div class="form-group col-md-4">
                        <label>CPR Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="staff_cpr_copy" class="form-control">
                     </div>
                     <div class="form-group col-md-4">
                        <label>Contract Copy</label>
                        <input type="file" accept="image/png, image/jpeg" name="staff_contract_copy" class="form-control">
                     </div>
                     <div class="form-group col-md-12" style="margin-right: 10px">
                        <label>Assign Role to Staff</label> <br>
                        @foreach($roles as $key=>$role )
                        <input type="radio" name="staffType" value="{{$role['slug']}}"> {{$role['name']}} <br>
                        @endforeach
                        <div class="invalid-feedback">
                           Please select role for the staff
                        </div>
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
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
@stop

