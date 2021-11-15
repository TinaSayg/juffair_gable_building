<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Owner;
use App\Models\Building;
use App\Models\BuildingType;
use Illuminate\Http\Request;
use App\Models\BuildingStatus;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $buildings = Building::all();
        $owners = Owner::all();
        // $building_types = BuildingType::all();
        $building_status = BuildingStatus::where('building_status_code','!=', 3)->get();
        return view('dashboard',compact('buildings','building_status','owners'));
    }

    
    /**
     * load create building view.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_new_building()
    {
        return view('admin.buildings.create');
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
            'building_name' => 'required',
            'building_address_line_1' => 'required',
            'owner_id' => 'required',
            'image' => 'required',
            // 'building_status_code' => 'required',
        ], [
            'building_name.required' => 'Building Name is required!',
            'owner_id.required' => 'Please select the building owner first!',
            'building_address_line_1.required' => 'Building Address is required!',
            // 'building_status_code.required' => 'Building Status is required!',
        ]);

        if($request->file('image'))
        {
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $image = Image::make($request->file('image')->getRealPath());
            $image->resize(350,250);
            $image->save(public_path('admin/assets/img/buildings/'). $file_name);
        }

        

        $building = Building::create([
            'building_name' => $request['building_name'],
            'owner_id' => $request['owner_id'],
            'building_address_line_1' => $request['building_address_line_1'],
            'description' => $request['building_description'],
            'image' => $file_name,
            // 'building_status_code' => $request['building_status_code'],
        
        ]);

       

        Toastr::success('Building added successfully!');
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
        $building = Building::find($id);
        $building_types = BuildingType::all();
        $building_status = BuildingStatus::all();

        return view('admin.buildings.show',compact('building','building_types','building_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $building = Building::find($id);
        $owners = Owner::all();
        $building_status = BuildingStatus::where('building_status_code','!=', 3)->get();

        $html_response = view('partials.edit_building_modal', compact('building','owners','building_status'))->render();

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
            'building_name' => 'required',
            'building_address_line_1' => 'required',
            'owner_id' => 'required',
            // 'building_status_code' => 'required',
        ], [
            'building_name.required' => 'Building Name is required!',
            'owner_id.required' => 'Please select the building owner first!',
            'building_address_line_1.required' => 'Building Address is required!',
            // 'building_status_code.required' => 'Building Status is required!',
        ]);

        $building = Building::find($id);
        
        $building->building_name = $request['building_name'];
        $building->owner_id = $request['owner_id'];
        $building->building_address_line_1 = $request['building_address_line_1'];
        $building->description = $request['building_description'];
        // $building->building_status_code = $request['building_status_code'];

        if($request->file('image'))
        {
            unlink(public_path('admin/assets/img/buildings/'). $building->image);

            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $image = Image::make($request->file('image')->getRealPath());
            $image->resize(350,250);
            $image->save(public_path('admin/assets/img/buildings/'). $file_name);
            $building->image = $file_name;
        }

        if($building->save())
        {
            Toastr::success('Building updated successfully!');
            return back();
        }
        else
        {
            Toastr::success('Programatical Error.');
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
        $building = Building::find($id);

        $building->delete();

        Toastr::success('Building deleted successfully!');
        return back();
    }
}
