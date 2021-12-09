<?php

namespace App\Http\Controllers\admin;
use App\Models\Unit;
use App\Models\User;
use App\Models\Building;
use App\Models\Complain;
use App\Models\FloorType;
use App\Models\FloorDetail;
use Illuminate\Http\Request;
use App\Models\ComplainStatus;
use App\Models\ComplainSolution;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaints = Complain::orderBy('id','desc')->get();
        $employee_list = User::where('userType', 'employee')->get();
        $officer_list = User::where('userType', 'officer')->get();
        $complaint_status_list = ComplainStatus::all();
        
        return view('admin.complaints.index',compact('complaints','employee_list','officer_list','complaint_status_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $complaints = Complain::all();
        $complainStatus = ComplainStatus::all();
        $floor_types = FloorType::all();
        $employees = User::where('userType', 'employee')->get();
        return view('admin.complaints.create',compact('complaints','complainStatus','employees','floor_types'));
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
            'complaint_title' => 'required',
            'complaint_date' =>  'required' ,
            
            'complaint_description' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required'

        ], [
            'floor_id.required' => 'Select the foor first',
            'unit_id.required' => 'Select the unit first',
        ]);



        $complaint = new Complain();
        $complaint->complain_title = $request['complaint_title'];
        $complaint->complain_date = $request['complaint_date'];
        
        $complaint->complain_description = $request['complaint_description'];
        $complaint->posted_id = Auth::user()->id;

        $complaint->floor_id = $request['floor_id'];
        $complaint->unit_id = $request['unit_id'];

        $user_type = Auth::user()->userType;

        
        if($user_type == 'general-manager' OR $user_type == 'Admin')
        {
            $request->validate([
                'assignee_id' => 'required',
                'complain_status_code' => 'required',
    
            ], [
                'assignee_id.required' => 'Select the assign to value',
                'complain_status_code.required' => 'Select the complain status',
            ]);

            $complaint->assignee_id = $request['assignee_id'];
            $complaint->complain_status_code = $request['complain_status_code'];
        }
        else
        {
           
            $complaint->assignee_id = Auth::user()->id;
            $complaint->complain_status_code = '1'; //pending
        }
          

        if($complaint->save())
        {
            Toastr::success('Complaint created successfully!');
            return redirect()->route('complains.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('complains.create');
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
        $complaint = Complain::find($id);
        
        $html_response = view('admin.complaints.partials.complaint_view_modal', compact('complaint'))->render();

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
        $complaint = Complain::find($id);
        $complainStatus = ComplainStatus::all();
        $floor_types = FloorType::all();
        $employees = User::where('userType', 'employee')->get();
        $floors = FloorDetail::where('floor_type_code' , $complaint->unit->floor->floor_type_code)->get();
        $units = Unit::where('floor_id' , $complaint->floor_id)->get();
        return view('admin.complaints.edit',compact('complaint','complainStatus','employees','floor_types','floors','units'));
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
            'complaint_title' => 'required',
            'complaint_date' =>  'required' ,
            
            'complaint_description' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required'

        ], [
            'floor_id.required' => 'Select the foor first',
            'unit_id.required' => 'Select the unit first',
        ]);

        $complaint = Complain::find($id);
        $complaint->complain_title = $request['complaint_title'];
        $complaint->complain_date = $request['complaint_date'];
       
        $complaint->complain_description = $request['complaint_description'];
        $complaint->posted_id = Auth::user()->id;
        $complaint->floor_id = $request['floor_id'];
        $complaint->unit_id = $request['unit_id'];
        $user_type = Auth::user()->userType;

        
        if($user_type == 'general-manager' OR $user_type == 'Admin')
        {
            $request->validate([
                'assignee_id' => 'required',
                'complain_status_code' => 'required',
    
            ], [
                'assignee_id.required' => 'Select the assign to value',
                'complain_status_code.required' => 'Select the complain status',
            ]);

            $complaint->assignee_id = $request['assignee_id'];
            $complaint->complain_status_code = $request['complain_status_code'];
        }
        else
        {
           
            $complaint->assignee_id = Auth::user()->id;
            $complaint->complain_status_code = '1'; //pending
        }
        if($complaint->save())
        {
            Toastr::success('Complaint updated successfully!');
            return redirect()->route('complains.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('complains.create');
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
        $complaint = Complain::find($id);
        $complain_solution_id = $complaint->complain_solution_id;
        $solution = ComplainSolution::find($complain_solution_id);
        
        if($complaint->delete())
        {
            $solution->delete();
        }        

        Toastr::success('Complaint deleted successfully!');
        return back();
    }

    public function assign_request(Request $request)
    {
        
        $complain_id = $request->input("complain_id");
        $employee_id = $request->input("employee_id");
        $officer_id = $request->input("officer_id");

        $complaint = Complain::find($complain_id);
        
        if($employee_id)
        {
            $complaint->assigneed_id = $employee_id;
            $complaint->save();
            Toastr::success('This request assigned to employee successfully!');
            return back();
        }
        elseif($officer_id)
        {
            $complaint->assigneed_id = $officer_id;
            $complaint->save();
            Toastr::success('This request assigned to officer successfully!');
            return back();
        }
        else
        {
            Toastr::error('Please select the employee or officer to assign request.');
            return back();
        }
     }

     public function add_solution(Request $request)
     {
        $request->validate([
            'complain_status_code' => 'required',
            'solution' => 'required',
        ],
        [
            'complain_status_code.required' => 'Select the status',
        ]);

        $complain_id = $request->input("complain_id");
        $complain_status_code = $request->input("complain_status_code");
        $solution = $request->input("solution");
       
        $store = new ComplainSolution();

        $store->solution = $solution;

        if($store->save()){

            Complain::where('id', $complain_id)->update(array('complain_status_code' => $complain_status_code, 'complain_solution_id' => $store->id));
            Toastr::success('Complain solution added successfully.');
            return back();
        }
        else
        {
            Toastr::error('Something went wrong.');
            return back();
        }

     }
}
