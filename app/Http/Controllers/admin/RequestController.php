<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Complain;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\RequestStatus;
use App\Models\ComplainStatus;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maintenancerequest = MaintenanceRequest::all();
        $employee_list = User::where('userType', 'employee')->get();
        return view('admin.request.index', compact('maintenancerequest','employee_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $request_statuses = RequestStatus::all();
        $manager_list = User::where('userType', 'general-manager')->get();
        return view('admin.request.create', compact('request_statuses','manager_list'));
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
        ]);

        $complaint = new Complain();
        $complaint->complain_title = $request->input('title');
        $complaint->complain_description = $request->input('description');
        $complaint->complain_person_id = Auth::user()->id;
        $complaint->complain_status_code = 1;

        if($complaint->save() )
        {
            Toastr::success('Your request submit successfully.');
            return redirect()->route('request.list', ['tab' => '1']);
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('tasks.create');
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
        $request = \App\Models\Request::find($id);
        
        $html_response = view('admin.task.partials.request_detail_modal', compact('request'))->render();

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
        $maintenancerequest = MaintenanceRequest::find($id);
       
        return view('admin.request.edit', compact('maintenancerequest'));
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
            'description' => 'required',
            'location_id' =>  'required',
        ]);
       
        $location_id = $request->input('location_id');
        $floor_id = $request->input('floor_id',null);
        $unit_id = $request->input('unit_id',null);
        $common_area_id = $request->input('common_area_id',null);
        $service_area_id = $request->input('service_area_id',null);
       

        $maintenancerequest = MaintenanceRequest::find($id);
        $maintenancerequest->title = $request->input('title');
        $maintenancerequest->description = $request->input('description');
        $maintenancerequest->location_id= $request->input('location_id');
        $maintenancerequest->floor_id = $floor_id;
        $maintenancerequest->unit_id = $unit_id;
        $maintenancerequest->common_area_id = $common_area_id;
        $maintenancerequest->service_area_id = $service_area_id;
        $maintenancerequest->maintenance_request_status_code = 1;

        if(Auth::user()->userType == 'employee')
        {
            $maintenancerequest->user_id = Auth::user()->id;
        }
        

        if($maintenancerequest->save()){
            Toastr::success('Maintenance Request updated successfully.');
            
            if(Auth::user()->userType == 'employee')
            {
                return redirect()->route('request.list');
            }
            
            return redirect()->route('dashboard');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('request.create');
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
        $maintenancerequest = MaintenanceRequest::find($id);
        
        if($maintenancerequest->delete())
        {
            Toastr::success('This request is deleted.');
            return redirect()->back();
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->back();
        }
    }

    public function request_action(Request $request, $id)
    {
       $action_id = $request->input('action_id');

       $request = \App\Models\Request::find($id);
       
       if($action_id == 2)
       {
            $request->request_status_code = 2;  // accepted
            $request->save();
            Toastr::success('Employee Request is accepted.');
            return back();

       }
       {
            $request->request_status_code = 3;  // rejected
            $request->save();
            Toastr::success('Employee Request is rejected.');
            return back();
       }

       Toastr::success('Something went wrong.');
       return back();
    }
}
