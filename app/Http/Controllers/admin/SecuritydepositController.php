<?php

namespace App\Http\Controllers\admin;
use App\Models\Unit;
use App\Models\Floor;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\SecurityDeposites;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Session;


class SecuritydepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::where('security_deposite', '>', 0)->where('security_deposit_status', '=', 'unpaid')->get();

        $securitydeposit = SecurityDeposites::orderBy('id','desc')->get();
        return view('admin.securitydeposit.index',compact('securitydeposit','tenants'));
    
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_first_name' => 'required',
            'tenant_last_name' =>  'required' ,
            'tenant_email_address' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required' ,
            'security_deposite_total_amount' => 'required' ,

        ], [
            'tenant_first_name.required' => 'tenant first name is required!',
            'tenant_last_name.required'  => ' tenant last name is required!',
            'tenant_email_address.required' => 'tenant email is required',
            'floor_id.required' => 'floor id is required',
            'unit_id.required' =>  'unit id is required' ,
            'security_deposite_total_amount.required' => 'total amount is required',
        ]);
        $securitydeposit = SecurityDeposites::create([
            'tenant_first_name' => $request['tenant_first_name'],
            'tenant_last_name' => $request['tenant_last_name'],
            'tenant_email_address' => $request['tenant_email_address'],
            'floor_id' => $request['floor_id'],
            'unit_id' => $request['unit_id'],
            'building_id' => $this->building_id,
            'security_deposite_total_amount' =>  $request['security_deposite_total_amount'],
        ]);
        Toastr::success('Security Deposit added successfully!');
        return redirect()->route('securitydeposit.list');
    }
    
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant = Tenant::find($id);
        $html_response = view('admin.securitydeposit.partials.securitydeposit_view_modal', compact('tenant'))->render();
        return response()->json([
            'success' => true,
            'html_response' => $html_response
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenant_first_name' => 'required',
            'tenant_last_name' =>  'required' ,
            'tenant_email_address' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required' ,
            'security_deposite_total_amount' => 'required' ,
        ], [
            'tenant_first_name.required' => 'tenant first name is required!',
            'tenant_last_name.required'  => ' tenant last name is required!',
            'tenant_email_address.required' => 'tenant email is required',
            'floor_id.required' => 'floor id is required',
            'unit_id.required' =>  'unit id is required' ,
            'security_deposite_total_amount.required' => 'total amount is required',
        ]);
       

        $tenant = Tenant::find($id);

        $tenant->security_deposit_status = 'paid';
        

        $tenant->save();
        Toastr::success('Security deposit updated successfully!');
        return redirect()->route('securitydeposit.list');
    }

        

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tenant = Tenant::find($id);
        
        $tenant->security_deposit_status = 'paid';

        $tenant->save();

        Toastr::success('Security deposit deleted successfully!');
        return back();
    }

}