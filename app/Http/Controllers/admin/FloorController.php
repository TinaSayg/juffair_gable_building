<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Models\Unit;
use App\Models\Floor;
use App\Models\Building;
use App\Models\FloorType;
use App\Models\FloorDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::all();
        $floor_types = FloorType::all();
        return view('admin.Floors.index',compact('floors','floor_types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'from' => 'required|integer|lte:to',
            'to'  =>  'required|integer|gte:from',
            'floor_type' => 'required',
        ]);

        $from = $request['from'];
        $to = $request['to'];
        $floor_type_code = $request['floor_type'];
        
       
        $all_floors = FloorDetail::pluck('number')->toArray();
        for($i=$from; $i <= $to; $i++)
        {
            if(in_array($from,$all_floors))
            {
                Toastr::error('Floor '. $from.' is already added.');
                return back();
            }
            else
            {
                FloorDetail::create([
                    'number' => $i,
                    'floor_type_code' => $floor_type_code, 
                ]);
                
            }
            
        }

        Floor::create([
            'from' => $from,
            'to' => $to,
            'floor_type_code' => $floor_type_code, 
        ]);


        
       
        Toastr::success('Floors added successfully!');
        return back();
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
        $floor = Floor::find($id);
        $floor_types= FloorType::all();

        $html_response = view('admin.Floors.partials.floors_edit_modal', compact('floor','floor_types'))->render();
        return response()->json([
            'success' => true,
            'html_response' => $html_response
        ]);
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
            'floor_number' => 'required',
            'floor_type' => 'required',
        ], [
            'floor_number.required' => 'Floor Number is required!',
            'floor_type' => 'Floor Type is required!',
        ]);

        $floor = Floor::find($id);

        
        $floor->number = $request['floor_number'];
       
        $floor->floor_type_code = $request['floor_type'];

        $floor->save();

        Toastr::success('Floor updated successfully!');
        return redirect()->route('floors.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        $floor = Floor::find($id);

        $start = $floor->from;
        $to = $floor->to;
        $floor_type_code = $floor->floor_type_code;
        
        $floor_numbers= [];
        for($i = $start; $i<= $to; $i++)
        {
            array_push($floor_numbers,$i);
        }

        $ids = FloorDetail::whereIn('number', $floor_numbers)->pluck('id')->toArray();
        
        $floor_list = Unit::whereIn('floor_id' , $ids)->get();
       

        if($floor_list->count() > 0)
        {
            Toastr::error("You cann't delete the floors.");
            return back();
        }
        
        
        FloorDetail::destroy($ids);
        $floor->delete();



        Toastr::success('Floor deleted successfully!');
        return back();
    }
}
