@extends('layouts.admin.app')
{{-- Page title --}}

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
<style>
   
</style>
@stop
@section('content')


<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
       <li class="breadcrumb-item">
          <h4 class="page-title m-b-0">Create Utility Bill</h4>
       </li>
       <li class="breadcrumb-item">
          <a href="file:///F:/AMS/tenantlist.html">
          <i class="fas fa-home"></i></a>
       </li>
    </ul> --}}
    <div class="section-body">
    <div class="row">
    <div class="col-12" >
        <div class="card">
            <div class="card-header">
              <h4>Service Contract Form</h4>
            </div>
            <div class="card-body">
            <form method="POSt" action="{{ route('service_contract.update', $service_contract->id) }}" enctype="multipart/form-data">
              @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Title</label>
                        <input type="text" value="{{ isset($service_contract->Title) ? $service_contract->Title: '' }}" name="title"  class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Cost Per Period (BD)</label>
                        <input type="text" name="cost_per_period" value="{{ isset($service_contract->amount) ? $service_contract->amount: '' }}" id="contractCost" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Frequency of Pay</label>
                        <select name="frequency_of_pay" id="" class="form-control">
                            <option value="monthly" @if($service_contract->frequency_of_pay == 'monthly') selected @endif>Monthly</option>
                            <option value="quarterly" @if($service_contract->frequency_of_pay == 'quarterly') selected @endif>Quarterly</option>
                            <option value="yearly" @if($service_contract->frequency_of_pay == 'yearly') selected @endif>Yearly</option>
                            <option value="bi-yearly" @if($service_contract->frequency_of_pay == 'bi-yearly') selected @endif>Bi-yearly</option>
                            <option value="one-time-payment" @if($service_contract->frequency_of_pay == 'one-time-payment') selected @endif>One time Payment</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 renew_date" >
                        <label>Contract Start Date</label>
                        <input type="text" value="{{ isset($service_contract->contract_start_date) ? $service_contract->contract_start_date: '' }}" name="contract_start_date" class="form-control datepicker1">
                    </div>
                    <div class="form-group col-md-4 renew_date" >
                        <label>Contract End Date</label>
                        <input type="text" name="contract_end_date" value="{{ isset($service_contract->contract_end_date) ? $service_contract->contract_end_date: '' }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-4 attachdocument">
                        <label>Upload Invoice/Receipt</label>
                        <input type="file" name="image"  accept="application/pdf, image/jpeg" class="form-control">
                        
                    </div>
                    <div class="form-group col-md-4">
                        <label>Auto Renewal</label>
                        <div class="form-control">
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" value="1" @if($service_contract->auto_renewal == '1') checked @endif name="auto_renew"
                                class="custom-control-input" checked>
                            <label class="custom-control-label" for="customRadioInline1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" value="0" @if($service_contract->auto_renewal == '0') checked @endif name="auto_renew"
                                class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline2">No</label>
                        </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea name="contract_description"  class="form-control" id="" cols="30" rows="10">{{ isset($service_contract->description) ? $service_contract->description: '' }}</textarea>
                    </div>
                    </div>
                    <button class="btn btn-primary mr-1" type="submit">Save</button>
                    <a href="{{ url()->previous() }}" class="btn btn-primary mr-1">Cancel</a> 
                </div>
            </from>
          </div>
</section>    
@stop
@section('footer_scripts')
<script src="{{asset('public/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    
        
        $("#contractCost").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });
    
        $("#frequencyOFPay").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });
    
    
        
    </script>
    <script>
        $("select[name=frequency_of_pay]").change(function(){
            let frequency_of_pay = $("select[name=frequency_of_pay]").val()
            let contract_start_date = moment($("input[name=contract_start_date]").val())

            if(frequency_of_pay == 'monthly')
            {
                let contract_end_date = moment(contract_start_date).add(30, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'quarterly')
            {
                let contract_end_date = moment(contract_start_date).add(90, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'yearly')
            {
                let contract_end_date = moment(contract_start_date).add(365, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'bi-yearly')
            {
                let contract_end_date = moment(contract_start_date).add(730, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'one-time-payment')
            {
                $("input[name=contract_start_date]").parent().hide()
                $("input[name=contract_end_date]").parent().hide()
            }
            else
            {
                $("input[name=contract_start_date]").parent().show()
                $("input[name=contract_end_date]").parent().show()
            }

        })

        $("input[name=contract_start_date]").change(function(){
            let frequency_of_pay = $("select[name=frequency_of_pay]").val()
            let contract_start_date = moment($("input[name=contract_start_date]").val())
            
            if(frequency_of_pay == 'monthly')
            {
                let contract_end_date = moment(contract_start_date).add(30, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'quarterly')
            {
                let contract_end_date = moment(contract_start_date).add(90, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'yearly')
            {
                let contract_end_date = moment(contract_start_date).add(365, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'bi-yearly')
            {
                let contract_end_date = moment(contract_start_date).add(730, 'days');
                
                $("input[name=contract_end_date]").val(contract_end_date.format('YYYY-MM-DD'))
            }

            if(frequency_of_pay == 'one-time-payment')
            {
                $("input[name=contract_start_date]").parent().hide()
                $("input[name=contract_end_date]").parent().hide()
            }
            
        })


    </script>
    <script>
        $(".datepicker1").daterangepicker({
        locale: { format: "YYYY-MM-DD" },
        singleDatePicker: true,
        
        });

        $(".datepicker2").daterangepicker({
        locale: { format: "YYYY-MM-DD" },
        singleDatePicker: true,
        
        });
    </script>
    {{-- <script>
        $('input[type=radio][name=auto_renew]').change(function() {
           
            if (this.value == '0') {
                $('.renew_date').show()
            }
            else if (this.value == '1') {
                $('.renew_date').hide()

            }
        });
    </script> --}}
@stop