<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\ServiceContract;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services_contract_list = ServiceContract::orderBy('id', 'desc')->get();
        
        return view('admin.service_contract.index', compact('services_contract_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service_contract.create');
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
            'contract_description' => 'required',
            'contract_cost' =>  'required' ,
            'frequency_of_pay' => 'required',
            'renew_date' => 'required',  
        ]);

        $store = new ServiceContract();
        $store->description = $request->input("contract_description");
        $store->amount = $request->input("contract_cost");
        $store->frequency_of_pay = $request->input("frequency_of_pay");
        $store->contract_renew_date = $request->input("renew_date");

        if($store->save())
        {
            Toastr::success('This service contract details added successfully.');
            return  redirect()->route('service_contract.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service_contract = ServiceContract::find($id);
        return view("admin.service_contract.edit", compact('service_contract'));
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
            'contract_description' => 'required',
            'contract_cost' =>  'required' ,
            'frequency_of_pay' => 'required',
            'renew_date' => 'required',  
        ]);

        $update = ServiceContract::find($id);
        $update->description = $request->input("contract_description");
        $update->amount = $request->input("contract_cost");
        $update->frequency_of_pay = $request->input("frequency_of_pay");
        $update->contract_renew_date = $request->input("renew_date");

        if($update->save())
        {
            Toastr::success('This service contract details updated successfully.');
            return  redirect()->route('service_contract.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service_contract = ServiceContract::find($id);
        
        if($service_contract->delete())
        {
            Toastr::success('This service contract deleted successfully!');
            return back();
        }
    }
}
