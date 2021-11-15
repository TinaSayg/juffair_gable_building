<?php

namespace App\Http\Controllers\admin;

use App\Models\Building;
use App\Models\UtilityBill;
use Illuminate\Http\Request;
use App\Models\UtilityBillType;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Image;
use Session;

class UtilitybillController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utility_bills = UtilityBill::orderBy('id','desc')->get();
        return view('admin.utility_bill.index' , compact('utility_bills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $utility_bill_types = UtilityBillType::all();

        return view('admin.utility_bill.create' , compact('utility_bill_types'));
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
            'utility_bill_type_code' => 'required',
            'utility_bill_date' => 'required',
            'utility_bill_month' => 'required|string',
            'utility_bill_year' => 'required',
            'utility_bill_total_amount' => 'required',
            'utility_bill_description' => 'required',
            'image' => 'required',
        ]);

        $utility_bill = new UtilityBill();
        $utility_bill->utility_bill_type_code = $request['utility_bill_type_code'];
        $utility_bill->utility_bill_date = $request['utility_bill_date'];
        $utility_bill->utility_bill_month = $request['utility_bill_month'];
        $utility_bill->utility_bill_year = $request['utility_bill_year'];
        $utility_bill->utility_bill_total_amount = $request['utility_bill_total_amount'];
        $utility_bill->utility_bill_description = $request['utility_bill_description'];
        

        if($request->file('image'))
        {
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $image = Image::make($request->file('image')->getRealPath());
            // $image->resize(300,200);
            $image->save(public_path('admin/assets/img/utility_bills/'). $file_name);

            $utility_bill->utility_bill_image  = $file_name;
        }
    
        if($utility_bill->save()){
            Toastr::success('Utility bill created successfully.');
            return redirect()->route('utility_bill.list');
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
        
        $utility_bill = UtilityBill::find($id);
        
        $html_response = view('admin.utility_bill.partials.utility_bill_view_modal', compact('utility_bill'))->render();

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
        $utility_bill = UtilityBill::find($id);
        $utility_bill_types = UtilityBillType::all();
        
        return view('admin.utility_bill.edit', compact('utility_bill','utility_bill_types'));
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
            'utility_bill_type_code' => 'required',
            'utility_bill_date' => 'required',
            'utility_bill_month' => 'required|string',
            'utility_bill_year' => 'required',
            'utility_bill_total_amount' => 'required',
            'utility_bill_description' => 'required',
        ]);

        $utility_bill = UtilityBill::find($id);
        $utility_bill->utility_bill_type_code = $request['utility_bill_type_code'];
        $utility_bill->utility_bill_date = $request['utility_bill_date'];
        $utility_bill->utility_bill_month = $request['utility_bill_month'];
        $utility_bill->utility_bill_year = $request['utility_bill_year'];
        $utility_bill->utility_bill_total_amount = $request['utility_bill_total_amount'];
        $utility_bill->utility_bill_description = $request['utility_bill_description'];
    

        if($request->file('image'))
        {
            unlink(public_path('admin/assets/img/utility_bills/'). $utility_bill->utility_bill_image);

            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $image = Image::make($request->file('image')->getRealPath());
            // $image->resize(300,200);
            $image->save(public_path('admin/assets/img/utility_bills/'). $file_name);

            $utility_bill->utility_bill_image  = $file_name;
        }
    
        if($utility_bill->save()){
            Toastr::success('Utility bill updated successfully.');
            return redirect()->route('utility_bill.list');
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
        $utility_bill = UtilityBill::find($id);

        $utility_bill->delete();

        Toastr::success('Utility Bill deleted successfully.');
        return back();
    }
}
