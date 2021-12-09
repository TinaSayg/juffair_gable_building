<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
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
            'title' => 'required',
            'cost_per_period' =>  'required' ,
            'frequency_of_pay' => 'required',
            'auto_renew' => 'required',
            'image' => 'required',
        ]);

        if($request['frequency_of_pay'] != 'one-time-payment')
        {
            $request->validate([
            'contract_start_date' => 'required',
            'contract_end_date' => 'required', 
            ]);
        }

        $filename ='';
        $store = new ServiceContract();
       
        if($request->file('image'))
        {
          
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            //print_r(public_path('admin/assets/img/servicecontract/').$file_name); exit;
            $request->file('image')->move(public_path('admin/assets/img/servicecontract/'), $file_name);
            $filename= $file_name;  
        }

        $store->title = $request->input("title");
        $store->description = $request->input("contract_description");
        $store->frequency_of_pay = $request->input("frequency_of_pay");
        $store->auto_renewal = $request->input("auto_renew");
        $store->amount = $request->input("cost_per_period");

        if($request['frequency_of_pay'] != 'one-time-payment')
        {
            $store->contract_start_date = $request->input('contract_start_date');
            $store->contract_end_date = $request->input('contract_end_date');
        }
        
        
        $store->image = $filename;
        $store->service_contract_status_code = 1; // opened
        // dd($store);
        if($store->save())
        {
            Toastr::success('This service contract added successfully.');
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
            'title' => 'required',
            'cost_per_period' =>  'required' ,
            'frequency_of_pay' => 'required',
            'auto_renew' => 'required',
        ]);

        if($request['frequency_of_pay'] != 'one-time-payment')
        {
            $request->validate([
            'contract_start_date' => 'required',
            'contract_end_date' => 'required', 
            ]);
        }

        $filename ='';
        $store = ServiceContract::find($id);
       
        if($request->file('image'))
        {
            unlink(public_path('admin/assets/img/servicecontract/'). $store->image);
            
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            //print_r(public_path('admin/assets/img/servicecontract/').$file_name); exit;
            $request->file('image')->move(public_path('admin/assets/img/servicecontract/'), $file_name);
            $filename= $file_name;  
        }
        else
        {
            $filename = $store->image;
        }

        $store->title = $request->input("title");
        $store->description = $request->input("contract_description");
        $store->frequency_of_pay = $request->input("frequency_of_pay");
        $store->auto_renewal = $request->input("auto_renew");
        $store->amount = $request->input("cost_per_period");

        if($request['frequency_of_pay'] != 'one-time-payment')
        {
            $store->contract_start_date = $request->input('contract_start_date');
            $store->contract_end_date = $request->input('contract_end_date');
        }
        
        
        $store->image = $filename;
        $store->service_contract_status_code = 1; // opened
        // dd($store);
        if($store->save())
        {
            Toastr::success('This service contract updated successfully.');
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
