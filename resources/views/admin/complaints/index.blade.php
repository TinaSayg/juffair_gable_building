@extends('layouts.admin.app')
{{-- Page title --}}
{{-- @section('title')
    AMS
@stop --}}
{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<style>
   
</style>
@stop
@section('content')
<section class="section">
    {{-- <ul class="breadcrumb breadcrumb-style ">
      <li class="breadcrumb-item">
      </li>
      <li class="breadcrumb-item">
        <a href="file:///F:/AMS/dashboard.html">
          <i class="fas fa-home"></i></a>
      </li>
      <li class="breadcrumb-item">Utility Bills</li>
    
    </ul> --}}
     <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
           <h4>All Requests</h4>
            
            
            {{-- <div class="card-header-form">
              <a href="{{ route('complains.create') }}" class="btn btn-primary" role="button">Add Complaint</a>
             
            </div> --}}
          </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="table-2" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Date</th>
                      <th>Reported</th>
                      <th>Status</th>
                      <th>Assigned Request</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach($complaints as $key => $complain)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $complain->complain_title }}</td>
                      <td>{{ \Carbon\Carbon::parse($complain->compaint_date)->toFormattedDateString() }}</td>
                      <td>
                        @php
                          $user = \App\Models\User::where('id', $complain->complain_person_id)->first();
                        @endphp
                        <span class="badge-outline col-indigo">{{ $user->name }} ({{ $user->userType }})</span>
                      </td>
                      <td>
                        @php
                        $class = '';
                        switch ($complain->complain_status_code) {
                          case 1:
                            $class = 'badge-warning';
                            break;
                          case 2:
                            $class = 'badge-success';
                            break;
                          case 3:
                            $class = 'badge-warning';
                            break;
                          default:
                            $class = 'badge-success';
                            break;
                        }
                      @endphp
                      <span class="badge {{ $class }}">
                        {{ isset($complain->complain_status) ? $complain->complain_status->complain_status_name : '' }}
                      </span>
                      </td>
                      <td>
                        @php
                          $user = \App\Models\User::where('id', $complain->assigneed_id)->first();
                          
                        @endphp
                        <span class="badge-outline col-indigo">{{ $user->name }} ({{ $user->userType }})</span>
                      </td>
                     
                      <td>
                        
                        @if($complain->complain_status->complain_status_code == '1')
                        <a href="#" data-toggle="tooltip"  data-placement="top" data-complain_id="{{ $complain->id }}" title="Assigned Request"><i  class="fas fa-user-shield mr-2"></i> </a>
                        @endif
                        <a href="#" data-toggle="tooltip" data-placement="top" title="View Detail" onclick="getComplainDetails({{ $complain->id }})"><i class="fa fa-eye mr-2"></i> </a>
                        @if(Auth::user()->userType != 'employee' && Auth::user()->userType != 'tenant')
                          <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="form_alert('complain-{{ $complain->id }}','Want to delete this request')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                        @endif
                        <a href="#" data-toggle="tooltip" data-complain_id="{{ $complain->id }}" data-placement="top" title="Add Solution"><i class="
                          fas fa-thumbs-up mr-2"></i> </a>
                        {{-- <a data-toggle="tooltip" data-placement="top" title="Edit" href="{{ route('complains.edit', $complain->id) }}"><i class="fa fa-pencil-alt" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a> --}}
                        
                        @if(Auth::user()->userType != 'employee' && Auth::user()->userType != 'tenant')
                        <form action="{{ route('complains.delete', $complain->id) }}"
                            method="post" id="complain-{{ $complain->id }}">
                            @csrf @method('delete')
                        </form> 
                        @endif
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
  <div class="modal" id="assignRequestModal" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Assign Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="card-body">
          <form action="{{ route('complains.assign_request') }}" method="POST" id="assignRequestForm">
            @csrf
            <div class="row">
              <div class="col-12">
                <input type="hidden" name="complain_id" id="complainHiddenField">
                <div class="section-title">Assign To</div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" value="0" checked onclick="handleClick(this);" id="customRadioInline1" name="customRadioInline1"
                    class="custom-control-input">
                  <label class="custom-control-label" for="customRadioInline1">Employee</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" value="1" onclick="handleClick(this);" id="customRadioInline2" name="customRadioInline1"
                    class="custom-control-input">
                  <label class="custom-control-label" for="customRadioInline2">Officer</label>
                </div>
              </div>
              <div class="col-6 mt-3 employee-select">
                <div class="form-group">
                  <label for="">Select Employee</label>
                  <select name="employee_id" class="form-control" id="">
                    <option value="0">--- Select ---</option>
                    @foreach ($employee_list as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6 mt-3 officer-select" style="display: none;">
                <div class="form-group">
                  <label for="">Select Officer</label>
                  <select name="officer_id" class="form-control" id="">
                    <option value="0">--- Select ---</option>
                    @foreach ($officer_list as $officer)
                      <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">save</button>
          </form>
        </div>
    </div>
  </div>
</div>


{{-- Add Solution Modal --}}
<div class="modal" id="solutionModal" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Add Solution</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="card-body">
        <form action="{{ route('complains.add_solution') }}" method="POST" id="addSolutionForm">
          @csrf
          <div class="row">
            <div class="col-6 mt-3">
              <input type="hidden" name="complain_id" id="solutionComplainInputField">
              <div class="form-group">
                <label for="">Select Status</label>
                <select name="complain_status_code" class="form-control" id="">
                  <option value="">--- Select ---</option>
                  @foreach ($complaint_status_list as $item)
                      <option value="{{ $item->complain_status_code }}">{{  $item->complain_status_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12 mt-3 officer-select" >
              <div class="form-group">
                <label for="">Add Solution</label>
                <textarea name="solution" id="" class="form-control" cols="30" rows="10"></textarea>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary m-t-15 waves-effect">save</button>
        </form>
      </div>
  </div>
</div>
</div>
{{-- complain modal --}}
<div class="modal" id="complainModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
             
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
<!-- JS Libraies -->
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/datatables.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin/assets/') }}/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/admin/assets/') }}/js/page/datatables.js"></script>
<script>
  $(".fa-user-shield").on("click", function(){
    let complain_id = $(this).parent().attr("data-complain_id")
    $("#complainHiddenField").val(complain_id)
    $("#assignRequestModal").modal("show")
  })

  $(".fa-thumbs-up").on("click", function(){
    let complain_id = $(this).parent().attr("data-complain_id")
    $("#solutionComplainInputField").val(complain_id)
    $("#solutionModal").modal("show")
  })

  function handleClick(myRadio) {
    var select_value = myRadio.value;
    if(select_value == 1)
    {
        $(".employee-select").hide()
        $(".officer-select").show()
    }
    else
    {
        $(".employee-select").show()
        $(".officer-select").hide()
    }

  }
</script>
<script>
  function getComplainDetails(id) {
    
    $.get({
        url: '{{route('complains.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data.options)
            $("#complainModal tbody").html(data.html_response)
            $("#complainModal").modal("show")
        }
    });
  }
</script>
@stop