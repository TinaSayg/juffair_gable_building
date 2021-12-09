<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class MaintenanceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'title' => 'required',
            'description' => 'required',
            'location_id' =>  'required',
        ]);
       
        $location_id = $request->input('location_id');
        $floor_id = $request->input('floor_id',null);
        $unit_id = $request->input('unit_id',null);
        $common_area_id = $request->input('common_area_id',null);
        $service_area_id = $request->input('service_area_id',null);
       

        $maintenancerequest = new MaintenanceRequest();
        $maintenancerequest->title = $request->input('title');
        $maintenancerequest->description = $request->input('description');
        $maintenancerequest->location_id= $request->input('location_id');
        $maintenancerequest->floor_id = $floor_id;
        $maintenancerequest->unit_id = $unit_id;
        $maintenancerequest->common_area_id = $common_area_id;
        $maintenancerequest->service_area_id = $service_area_id;
        $maintenancerequest->maintenance_request_status_code = 1;
        $maintenancerequest->user_id = Auth::user()->id;
        

        if($maintenancerequest->save()){
            Toastr::success('Maintenance Request added successfully.');
            return redirect()->route('request.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('request.create');
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
        $maintenance_request = MaintenanceRequest::find($id);
        
        $html_response = view('admin.request.partials.maintenance_request_view_modal', compact('maintenance_request'))->render();

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function maintenance_request_under_review($id)
    {
        $maintenance_request = MaintenanceRequest::find($id);

        $maintenance_request->maintenance_request_status_code = 2;

        if($maintenance_request->save()){
            return response()->json([
                'success' => true,
            ]);
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('request.create');
        }
    }
}
