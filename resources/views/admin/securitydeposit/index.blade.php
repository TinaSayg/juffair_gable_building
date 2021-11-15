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
           <h4>Security Deposit list</h4>
            <div class="card-header-form">
             
            </div>
          </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="mainTable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tenant Name</th>
                      <th>Tenant Email</th>
                      <th>Tenant Unit</th>
                      <th>Amount</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tenants as $key => $tenant)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $tenant->tenant_first_name }} {{ $tenant->tenant_last_name }}</td>
                        <td>{{ $tenant->tenant_email_address}}</td>
                        <td>{{ isset($tenant->unit) ? $tenant->unit->unit_number : '' }}</td>
                        <td>{{  $tenant->security_deposite }}</td>
                        <td>
                          @if(request()->user()->can('view-security-deposit'))
                          <a href="#" onclick="getSecurityDepositDetails({{ $tenant->id }})"><i class="fa fa-eye mr-2"></i> </a>
                          @endif
                          @if(request()->user()->can('delete-security-deposit'))
                          <a href="#" onclick="form_alert('securitydeposit-{{ $tenant->id }}','Want to delete this security deposit')"><i class="fa fa-trash mr-2" style="font-size: 12px;" data-toggle="modal" data-target="#exampleModal1"></i> </a>
                          @endif
                          <form action="{{ route('securitydeposit.delete', $tenant->id) }}"
                            method="post" id="securitydeposit-{{ $tenant->id }}">
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
{{-- security deposit modal --}}
<div class="modal" id="securitydepositModal" tabindex="-1" role="dialog" aria-labelledby="formModal"  aria-modal="true">
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
              @include('admin.securitydeposit.partials.securitydeposit_view_modal') 
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('footer_scripts')
 <script>
  function getSecurityDepositDetails(id) {
    $.get({
        url: '{{route('securitydeposit.show', '')}}' + "/"+ id,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#securitydepositModal tbody").html(data.html_response)
            $("#securitydepositModal").modal("show")
        }
    });
  }
</script>
@stop