<?php
namespace App\Http\Controllers\admin;

use App\Models\Building;
use Illuminate\Http\Request;
use App\Models\MaintenanceCost;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Session;

class MaintenanceCostController extends Controller
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
    public function index()
    {
        $maintenancecosts = Maintenancecost::orderBy('id','desc')->get();
        return view('admin.maintenance.index',compact('maintenancecosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maintenancecosts = Maintenancecost::all();
        return view('admin.maintenance.create' ,compact('maintenancecosts'));
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
            'maintenance_title' => 'required',
            'maintenance_description' =>  'required' ,
            'maintenance_date' => 'required',
            'maintenance_cost_total_amount' => 'required',
            'location_id' =>  'required',

        ], [
            'maintenance_title.required' => 'Maintenance title is required!',
            'maintenance_description.required'  => 'Maintenance description is required!',
            'maintenance_date.required' => 'Maintenance date is required!',
            'maintenance_cost_total_amount.required' => 'Maintenance cost is required!',
            'location_id.required' => 'Please select the location!',
        ]);

        $location_id = $request->input('location_id');
        $floor_id = $request->input('floor_id',null);
        $unit_id = $request->input('unit_id',null);
        $common_area_id = $request->input('common_area_id',null);
        $service_area_id = $request->input('service_area_id',null);

        
        $maintenancecost = MaintenanceCost::create([
            'maintenance_title' => $request['maintenance_title'],
            'maintenance_description' => $request['maintenance_description'],
            'maintenance_date' => $request['maintenance_date'],
            'maintenance_cost_total_amount' => $request['maintenance_cost_total_amount'],
            'location_id' => $request['location_id'],
            'floor_id' => $request['floor_id'],
            'unit_id' => $request['unit_id'],
            'common_area_id' => $request['common_area_id'],
            'service_area_id' => $request['service_area_id'],
        ]);

        Toastr::success('Maintenance Cost added successfully!');
        return redirect()->route('maintenancecosts.list');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $maintenancecost = Maintenancecost::find($id);
        
        $html_response = view('admin.maintenance.partials.maintenancecost_view_modal', compact('maintenancecost'))->render();

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
    
        $maintenance_costs = Maintenancecost::find($id);
        return view('admin.maintenance.edit' ,compact('maintenance_costs'));
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
            'maintenance_title' => 'required',
            'maintenance_description' =>  'required' ,
            'maintenance_date' => 'required',
            'maintenance_cost_total_amount' => 'required',
            'location_id' =>  'required',
        ], [
            'maintenance_title.required' => 'Maintenance title is required!',
            'maintenance_description.required'  => 'Maintenance description is required!',
            'maintenance_date.required' => 'Maintenance date is required!',
            'maintenance_cost_total_amount.required' => 'Maintenance cost is required!',
            'location_id.required' => 'Please select the location!',
        ]);

        $location_id = $request->input('location_id');
        $floor_id = $request->input('floor_id',null);
        $unit_id = $request->input('unit_id',null);
        $common_area_id = $request->input('common_area_id',null);
        $service_area_id = $request->input('service_area_id',null);

        $maintenancecost = Maintenancecost::find($id);

        $maintenancecost->maintenance_title = $request['maintenance_title'];
        $maintenancecost->maintenance_description = $request['maintenance_description'];
        $maintenancecost->maintenance_date = $request['maintenance_date'];
        $maintenancecost->maintenance_cost_total_amount = $request['maintenance_cost_total_amount'];
        $maintenancecost->location_id = $location_id;
        $maintenancecost->floor_id = $floor_id;
        $maintenancecost->unit_id = $unit_id;
        $maintenancecost->common_area_id = $common_area_id;
        $maintenancecost->service_area_id = $service_area_id;
      
        $maintenancecost->save();

        Toastr::success('Maintenance updated successfully!');
        return redirect()->route('maintenancecosts.list');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $maintenancecost =Maintenancecost::find($id);

        $maintenancecost->delete();

        Toastr::success('Maintenance cost deleted successfully!');
        return back();
    }
}
