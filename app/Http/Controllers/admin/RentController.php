<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Models\Rent;
use App\Models\Unit;
use App\Models\Floor;
use App\Models\Tenant;
use App\Models\Building;
use App\Models\RentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class RentController extends Controller
{
    public $building_id;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->building_id = Session::get('building_id');
    
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenant_rent_details = Tenant::where('building_id', $this->building_id)->orderBy('floor_id','asc')->get();
        // dd($units_rent_details->first()->tenant);
        // dd($tenant_rent_details);
        return view('admin.rents.index', compact('tenant_rent_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rent_types = RentType::all();
        $floors_list = Floor::where('building_id', $this->building_id)->get();
        return view('admin.rents.create', compact('floors_list','rent_types'));
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
            'floor_id' => 'required',
            'unit_id' => 'required',
            'renter_name' => 'required',
            'rent_type_code' => 'required',
            'rent' => 'required',
            'ewa_bill' => 'required',
            'utility_bill' => 'required',
            'paid_date' => 'required',
            'rent_month' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $rent = new Rent();
        $rent->building_id = $this->building_id;
        $rent->floor_id = $request['floor_id'];
        $rent->unit_id = $request['unit_id'];
        $rent->renter_name = $request['renter_name'];
        $rent->rent_type_code = $request['rent_type_code'];
        $rent->rent = $request['rent'];
        $rent->ewa_bill = $request['ewa_bill'];
        $rent->utility_bill = $request['utility_bill'];
        $rent->paid_date = $request['paid_date'];
        $rent->rent_month = $request['rent_month'];
        $rent->payment_method = $request['payment_method'];
        
        if($rent->save()){
            Toastr::success('Rent created successfully.');
            return redirect()->route('rent.list');
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
        $tenant_rent_detail = Tenant::where('id', $id)->where('building_id', $this->building_id)->orderBy('floor_id','asc')->first();
        return view('admin.rents.view_invoice', compact('tenant_rent_detail'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rent = Rent::find($id);
        $rent_types = RentType::all();
        $floors_list = Floor::where('building_id', $this->building_id)->get();

        return view('admin.rents.edit', compact('rent','floors_list','rent_types'));
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
            'floor_id' => 'required',
            'unit_id' => 'required',
            'renter_name' => 'required',
            'rent_type_code' => 'required',
            'rent' => 'required',
            'ewa_bill' => 'required',
            'utility_bill' => 'required',
            'paid_date' => 'required',
            'rent_month' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $rent = Rent::find($id);
        $rent->building_id = $this->building_id;
        $rent->floor_id = $request['floor_id'];
        $rent->unit_id = $request['unit_id'];
        $rent->renter_name = $request['renter_name'];
        $rent->rent_type_code = $request['rent_type_code'];
        $rent->rent = $request['rent'];
        $rent->ewa_bill = $request['ewa_bill'];
        $rent->utility_bill = $request['utility_bill'];
        $rent->paid_date = $request['paid_date'];
        $rent->rent_month = $request['rent_month'];
        $rent->payment_method = $request['payment_method'];
        
        if($rent->save()){
            Toastr::success('Rent updated successfully.');
            return redirect()->route('rent.list');
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
        $rent = Rent::find($id);

        $rent->delete();

        Toastr::success('This Rent details deleted successfully!');
        return back();
    }
}
