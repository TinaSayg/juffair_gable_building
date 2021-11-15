<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use App\Models\FloorType;
use App\Models\FloorDetail;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        
        return view('dashboard' , compact('buildings'));
    }

    public function fetch_all_units_and_floors_list($floor_type_code)
    {
       
        $floors = FloorDetail::where('floor_type_code', $floor_type_code)->get();
       
        
        
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        foreach ($floors as $floor) {
            $res .= '<option value="' . $floor->id . '"  >' . $floor->number . '</option>';
        }
        
        $res1 = '<option value="' . 0 . '" disabled >---Select---</option>';

        if($floors->isNotEmpty())
        {
            
            $first_floor_id = $floors->first()->id;
           
            $units = Unit::where('floor_id' , $first_floor_id)->get();
            
            foreach ($units as $unit) {
                $res1 .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
            }
        }
        return response()->json([
            'options' => $res,
            'options1' => $res1,
        ]);
    }

    public function fetch_floors($floor_type_code)
    {
        $floors = FloorDetail::where('floor_type_code', $floor_type_code)->get();
       
        
        
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        foreach ($floors as $floor) {
            $res .= '<option value="' . $floor->id . '"  >' . $floor->number . '</option>';
        }
        
        $res1 = '<option value="' . 0 . '" disabled >---Select---</option>';

        if($floors->isNotEmpty())
        {
            
            $first_floor_id = $floors->first()->id;
            
            $units = Unit::where('unit_status_code' , 2)->where('floor_id' , $first_floor_id)->get();
            
            foreach ($units as $unit) {
                $res1 .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
            }
        }
        return response()->json([
            'options' => $res,
            'options1' => $res1,
        ]);
    }

    public function fetch_units($floor_id)
    {
        
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        $units = Unit::where('unit_status_code' , 2)->where('floor_id' , $floor_id)->get();
        
        foreach ($units as $unit) {
            $res .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
        }

        return response()->json([
            'options' => $res,
        ]);
    }

    public function fetch_all_units($floor_id)
    {
       
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        $units = Unit::where('floor_id' , $floor_id)->get();
        
        foreach ($units as $unit) {
            $res .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
        }

        return response()->json([
            'options' => $res,
        ]);
    }
}
