<?php
namespace App\Http\Controllers\admin;
use Session;
use Hash;
use Image;
use App\Models\LeaveType;
use App\Models\LeaveStatus;
use Illuminate\Http\Request;
use App\Models\EmployeeLeaves;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;


class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employeeleave = EmployeeLeaves::orderBy('id','desc')->get();
        return view('admin.leave.index',compact('employeeleave'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeleave = EmployeeLeaves::all();
        $leaveStatus = LeaveStatus::all();
        $leave_types = LeaveType::all();
        return view('admin.leave.create' ,compact('employeeleave','leaveStatus','leave_types'));
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
            'leave_start_date' => 'required',
            'leave_end_date' =>  'required' ,
            'apply_date' => 'required',
            'leave_reason' => 'required',
            'leave_type_code' => 'required',
        ], [
            'leave_start_date.required' => 'Leave start date is required!',
            'leave_end_date.required'  => 'Leave end date is required!',
            'apply_date.required' => 'Apply date is required!',
            'leave_reason.required' => 'Leave reason is required!',
            'leave_type_code.required' => 'Apply date is required!',
        ]);

        if($request['leave_type_code'] == 1)
        {
            $request->validate([
                'leave_document' => 'required',
    
            ], [
                'leave_document.required' => 'Leave document is required!',
            ]);
        }

        $filename ='';
        if($request->file('leave_document'))
        {
            $file_name = time().'_'.trim($request->file('leave_document')->getClientOriginalName());
            
            $image = Image::make($request->file('leave_document')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);
            $filename= $file_name;  
        }
        
        $employeeleave = EmployeeLeaves::create([
            'leave_start_date' => $request['leave_start_date'],
            'leave_end_date' => $request['leave_end_date'],
            'apply_date' => $request['apply_date'],
            'leave_reason' => $request['leave_reason'],
            'leave_type_code' => $request['leave_type_code'],
            'leave_status_code' => 2,
            'leave_document' => $filename,
            'staff_id' => Auth::user()->id,
        ]);
        Toastr::success('Leave added successfully!');
        return redirect()->route('leave.list');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employeeleave = EmployeeLeaves::find($id);
        $html_response = view('admin.leave.partials.leave_view_modal', compact('employeeleave'))->render();

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
        $employeeleave = EmployeeLeaves::find($id);
        $leaveStatus = LeaveStatus::all();
        $leave_types = LeaveType::all();
        return view('admin.leave.edit',compact('employeeleave','leaveStatus','leave_types'));
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
            'leave_start_date' => 'required',
            'leave_end_date' =>  'required' ,
            'apply_date' => 'required',
            'leave_reason' => 'required',
            'leave_type_code' => 'required',
        ], [
            'leave_start_date.required' => 'Leave start date is required!',
            'leave_end_date.required'  => 'Leave end date is required!',
            'apply_date.required' => 'Apply date is required!',
            'leave_reason.required' => 'Leave reason is required!',
            'leave_type_code.required' => 'Apply date is required!',
        ]);

        $employeeleave = EmployeeLeaves::find($id);

        $employeeleave->leave_start_date = $request['leave_start_date'];
        $employeeleave->leave_end_date = $request['leave_end_date'];
        $employeeleave->apply_date = $request['apply_date'];
        $employeeleave->leave_reason = $request['leave_reason'];
        $employeeleave->leave_type_code = $request['leave_type_code'];
        if($request->file('leave_document'))
        {
            unlink(public_path('admin/assets/img/documents/'). $employeeleave->leave_document);
            $file_name = time().'_'.trim($request->file('leave_document')->getClientOriginalName());
            
             $image = Image::make($request->file('leave_document')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);
            $filename= $file_name;  
            $employeeleave->leave_document = $filename;
        }
        else
        {
            $employeeleave->leave_document =  $employeeleave->leave_document;

        }
        
      
      
        $employeeleave->save();

        Toastr::success('Leave updated successfully!');
        return redirect()->route('leave.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employeeleave = EmployeeLeaves::find($id);

        $employeeleave->delete();

        Toastr::success('Leave deleted successfully!');
        return back();
    }
}
