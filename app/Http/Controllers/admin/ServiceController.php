<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\ServiceContract;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;

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
            'image' => 'required|max:20480|mimes:pdf',
        ]);
        $filename ='';
        if($request->file('image'))
        {
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $request->file('image')->move(public_path('admin/assets/img/invoices/'). $file_name);
            $filename= $file_name;  
        }

        $store = new ServiceContract();
        $store->description = $request->input("contract_description");
        $store->amount = $request->input("contract_cost");
        $store->frequency_of_pay = $request->input("frequency_of_pay");
        $store->contract_renew_date = $request->input("renew_date");
        $store->image = $filename;

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
        $service_contract = ServiceContract::find($id);
        
        $html_response = view('admin.service_contract.partials.service_contract_view_modal', compact('service_contract'))->render();

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

        if($request->file('image'))
        {
            unlink(public_path('admin/assets/img/servicecontract/'). $update->image);
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
             $image = Image::make($request->file('image')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/servicecontract/'). $file_name);
            $filename= $file_name;  
            $update->image = $filename;
        }

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
