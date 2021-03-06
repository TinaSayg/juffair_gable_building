<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Models\Unit;
use App\Models\Floor;
use App\Models\Building;
use App\Models\RentType;
use App\Models\UnitType;
use App\Models\FloorType;
use App\Models\UnitStatus;
use App\Models\FloorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class UnitController extends Controller
{

    public function index()
    {
        $units = Unit::orderBy('id','desc')->get();
        $floor_types = FloorType::where('floor_type_code', '!=', 1)->get();
        $unit_status = UnitStatus::all();
        return view('admin.units.index',compact('units','floor_types','unit_status'));
    }

    public function apartment_by_floor(Request $request)
    {
        $search = $request->input('search');
        if($search)
        {
            $floor = FloorDetail::where('number', $search)->first();
            if(isset($floor))
            {
                $floor_id = $floor->id;
                $units = Unit::where('floor_id', $floor_id)->orderBy('id','desc')->get();

            }
            else
            {
                $units = collect([]);
            }

        }
        else
        {
            $units = Unit::orderBy('id','desc')->get();

        }
        return view('admin.units.apartment_by_floor',compact('units'));
    }

    public function apartment_by_type(Request $request)
    {
        $apartment_type = $request->input('apartment_type');
        
        $apartment_types = FloorType::where('floor_type_code', '!=' , 1)->get();
        
        if($apartment_type)
        {
            $ids = FloorDetail::where('floor_type_code', $apartment_type)->pluck('id');
            
            if($ids->isNotEmpty())
            {
                $units = Unit::whereIn('floor_id', $ids)->orderBy('id','desc')->get();
            }
            else
            {
                $units = collect([]);
            }

        }
        else
        {
            $units = Unit::orderBy('id','desc')->get();

        }

        return view('admin.units.apartment_by_type',compact('units','apartment_types'));
    }

    public function apartment_by_color(Request $request)
    {
        $apartment_color = $request->input('apartment_color');
        
        $apartment_colors = Unit::pluck('color_code');
        
        
        if($apartment_color)
        {
            
            if($apartment_color)
            {
                $units = Unit::where('color_code', $apartment_color)->orderBy('id','desc')->get();
            }
            else
            {
                $units = collect([]);
            }

        }
        else
        {
            $units = Unit::orderBy('id','desc')->get();

        }

        return view('admin.units.apartment_by_color',compact('units','apartment_colors'));
    }

    public function search_by_appartment()
    {
        $units = Unit::orderBy('id','desc')->get();
        
        $floor_types = FloorType::where('floor_type_code', '!=', 1)->get();
        $unit_status = UnitStatus::all();
        return view('admin.units.search_by_appartment',compact('units','floor_types','unit_status'));
    }

    public function rented_apartment(){
        $units = Unit::where('unit_status_code' , 1)->get();
        $floor_types = FloorType::where('floor_type_code', '!=', 1)->get();
        $unit_status = UnitStatus::all();
        return view('admin.units.rented_apartment',compact('units','floor_types','unit_status'));
    }
    public function leave(){
        
        return view('admin.units.leave');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $floor_types = FloorType::where('floor_type_code', '!=', 1)->get();

        $unit_status = UnitStatus::all();
        return view('admin.units.create', compact('floor_types','unit_status'));
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
            'unit_number' => 'required',
            'unit_rent' => 'required',
            'color_code' => 'required',
            'no_of_bed_rooms' => 'required',
            'unit_area' => 'required',
            'floor_id' => 'required',
            'unit_status_code' => 'required',
        ], [
            'unit_number.required' => 'Unit mumber field is required!',
            'color_code.required' => 'Pick color field is required!',
            'floor_id.required' => 'Select the floor!',
            'unit_statufloor_ids_code.required' => 'Select unit status!',
        ]);

        $count = Unit::where('unit_number' , $request['unit_number'])->where('floor_id', $request['floor_id'])->get()->count();
        
        if($count > 0)
        {
            
            Toastr::error('This Unit already added.');
            return back();
        }
        else
        {
            $floor_number = FloorDetail::where('id', $request['floor_id'])->first()->number;

            $unit = Unit::create([
                'unit_number' => $floor_number.$request['unit_number'],
                'unit_rent' => $request['unit_rent'],
                'color_code' => $request['color_code'],
                'no_of_bed_rooms' => $request['no_of_bed_rooms'],
                'unit_area' => $request['unit_area'],
                'floor_id' => $request['floor_id'],
                'unit_status_code' => $request['unit_status_code'],
            ]);

            Toastr::success('Unit added successfully.');
            return redirect()->route('units.list');
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
        $unit = Unit::find($id);
        $unit_types = UnitType::all();
        $unit_status = UnitStatus::all();
        $rent_types = RentType::all();
        return view('admin.units.show',compact('unit','rent_types','unit_types','unit_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $unit = Unit::find($id);
        
        $floor_types = FloorType::all();
        $unit_status = UnitStatus::all();

        return view('admin.units.edit',compact('unit','floor_types','unit_status'));
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
            // 'unit_number' => 'required',
            'unit_rent' => 'required',
            'color_code' => 'required',
            'no_of_bed_rooms' => 'required',
            'unit_area' => 'required',
            // 'floor_id' => 'required',
            'unit_status_code' => 'required',
        ], [
            // 'unit_number.required' => 'Unit mumber field is required!',
            'color_code.required' => 'Pick color field is required!',
            // 'floor_id.required' => 'Select the floor!',
            'unit_statufloor_ids_code.required' => 'Select unit status!',
        ]);

        // update units
        $unit = Unit::find($id);
        // $unit->unit_number = $request['unit_number'];
        $unit->unit_rent = $request['unit_rent'];
        $unit->color_code = $request['color_code'];
        $unit->no_of_bed_rooms = $request['no_of_bed_rooms'];
        $unit->unit_area = $request['unit_area'];
        // $unit->floor_id = $request['floor_id'];
        $unit->unit_status_code = $request['unit_status_code'];

        if($unit->save())
        {
            Toastr::success('Unit updated successfully!');
            return redirect()->route('units.list');

        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('units.list');
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
        $unit = Unit::find($id);

        $unit->delete();

        Toastr::success('unit deleted successfully!');
        return back();
    }

    public function search_filter(Request $request)
    {
        $floor_type_code = $request->input('floor_type_code',null);
        $floor_id = $request->input('floor_id',null);
        $unit_status_code = $request->input('unit_status_code',null);
        $color_code = $request->input('color_code',null);

        $query = Unit::query();

        if($floor_id)
        {
            $query->where('floor_id', $floor_id);
        }
        if($unit_status_code){
            
            $query->where('unit_status_code', $unit_status_code);

        }
        if($color_code)
        {
            $query->where('color_code', $color_code);
            
        }
        
        $units = $query->get();
        
        $floor_types = FloorType::all();
        $unit_status = UnitStatus::all();
        return view('admin.units.index',compact('units','floor_types','unit_status'));
    }
}
