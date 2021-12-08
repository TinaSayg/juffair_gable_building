<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Models\Rent;
use App\Models\Unit;
use App\Models\Floor;
use App\Models\Tenant;
use App\Models\Building;
use App\Models\RentType;
use App\Models\FloorType;
use App\Models\UnitStatus;
use Illuminate\Http\Request;
use App\Models\RentPaidStatus;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $units = Unit::orderBy('id','desc')->get();
        $rent_paid_status = RentPaidStatus::all();
        $rent_details = Rent::orderBy('id','desc')->get();
    
        return view('admin.rent.index', compact('rent_details','rent_paid_status'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $rent_types = RentType::all();
        $units = Unit::orderBy('id','desc')->get();
        $floor_types = FloorType::where('floor_type_code', '!=', 1)->get();
        $unit_status = UnitStatus::all();
        $rent_paid_status = RentPaidStatus::all();
        $tenant_list = Tenant::where('is_passed', null)->get();
        
        return view('admin.rent.create', compact('rent_types','units','floor_types','unit_status','rent_paid_status','tenant_list'));
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
        $rent=Rent::find($id);
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
   
    public function search_filter(Request $request)
    {
        $rent_month = $request->input('rent_month',null);
        $rent_year = $request->input('rent_year',null);
        $query = Rent::query();

        if($tenant_id)
        {
            $query->where('tenant_id', $tenant_id);
        }

        if($apartment_type){
            
            if($apartment_type != "all")
            {
                $query->where('apartment_type', $apartment_type);
            }

        }

        if($unit_status_code){
            
            if($unit_status_code != "all")
            {
                $query->where('unit_status_code', $unit_status_code);
            }

        }
        if($color_code)
        {
            if($color_code != "all")
            {
                $query->where('color_code', $color_code);
            }
            
        }
       
        $units = $query->get();
        
        $floor_types = FloorType::where('floor_type_code', '!=', 1)->get();

        $unit_status = UnitStatus::all();
        $color_codes_list = Unit::pluck('color_code');
        // dd($color_codes_list);
        $instance = new ColorInterpreter();

        $color_names_list = [];

        if($color_codes_list->isNotEmpty())
        {
            foreach($color_codes_list as $color_code)
            {

                $result = $instance->name($color_code);
                array_push($color_names_list,$result['name']);    
            }

            $color_codes_list = $color_codes_list->combine($color_names_list);
        }
        return view('admin.units.index',compact('units','floor_types','unit_status','color_codes_list'));
    }
}
