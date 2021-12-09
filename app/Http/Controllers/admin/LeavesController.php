<?php
namespace App\Http\Controllers\admin;
use Hash;
use Image;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
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
            'leave_reason' => 'required',
            'leave_type_code' => 'required',
        ], [
            'leave_start_date.required' => 'Leave start date is required!',
            'leave_end_date.required'  => 'Leave end date is required!',
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

        $leave_start_date = Carbon::parse($request['leave_start_date'])->format("Y-m-d");
        $leave_end_date = Carbon::parse($request['leave_end_date'])->format("Y-m-d");

        if(Carbon::parse($leave_end_date)->lt(Carbon::parse($leave_start_date)))
        {
            Toastr::error('Leave end date must be less then Leave start date.');
            return redirect()->back();
        }
        // dd($leave_start_date,$leave_end_date);
        $aleary_applied_for_leave_on_same_date_count = EmployeeLeaves::where('staff_id', Auth::user()->id)
                                                                    ->where(function($query) use($leave_start_date,$leave_end_date) {
                                                                        $query->whereDate('leave_start_date', $leave_start_date)
                                                                              ->orWhereDate('leave_end_date', $leave_end_date);
                                                                    })->orWhere(function($query) use($leave_start_date,$leave_end_date) {
                                                                        $query->whereDate('leave_start_date', $leave_end_date)
                                                                              ->orWhereDate('leave_end_date', $leave_start_date);
                                                                    })
                                                                    ->get()->count();
        // dd($aleary_applied_for_leave_on_same_date_count);                                                                
       
        if($aleary_applied_for_leave_on_same_date_count > 0)
        {
            Toastr::error('You already apply for leave between these selected dates.');
            return redirect()->back();
        }

        $filename ='';

        if($request->file('leave_document'))
        {
          
            $file_name = time().'_'.trim($request->file('leave_document')->getClientOriginalName());
            //print_r(public_path('admin/assets/img/servicecontract/').$file_name); exit;
            $request->file('leave_document')->move(public_path('admin/assets/img/documents/'), $file_name);
            $filename= $file_name;  
        }

        
        $employeeleave = EmployeeLeaves::create([
            'leave_start_date' => date('Y-m-d 00:00:00',strtotime($request['leave_start_date'])),
            'leave_end_date' => date('Y-m-d 23:59:59',strtotime($request['leave_end_date'])),
            'apply_date'   => Carbon::now(),
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
            'leave_reason' => 'required',
            'leave_type_code' => 'required',
        ], [
            'leave_start_date.required' => 'Leave start date is required!',
            'leave_end_date.required'  => 'Leave end date is required!',
             'leave_reason.required' => 'Leave reason is required!',
            'leave_type_code.required' => 'Apply date is required!',
        ]);

        $leave_start_date = Carbon::parse($request['leave_start_date'])->format("Y-m-d");
        $leave_end_date = Carbon::parse($request['leave_end_date'])->format("Y-m-d");
        

        if(Carbon::parse($leave_end_date)->lt(Carbon::parse($leave_start_date)))
        {
            Toastr::error('Leave end date must be less then Leave start date.');
            return redirect()->back();
        }

        $aleary_applied_for_leave_on_same_date_count = EmployeeLeaves::where('staff_id', Auth::user()->id)
                                                                    ->where(function($query) use($leave_start_date,$leave_end_date) {
                                                                        $query->orWhereDate('leave_start_date', $leave_start_date)
                                                                              ->orWhereDate('leave_end_date', $leave_end_date);
                                                                    })->get()->count();
                                                                    
        if($aleary_applied_for_leave_on_same_date_count > 0)
        {
            Toastr::error('You already apply for leave between these selected dates.');
            return redirect()->back();
        }

        $employeeleave = EmployeeLeaves::find($id);

        $employeeleave->leave_start_date = date('Y-m-d 00:00:00',strtotime($request['leave_start_date']));
        $employeeleave->leave_end_date = date('Y-m-d 23:59:59',strtotime($request['leave_end_date']));
        $employeeleave->apply_date = Carbon::now();
        $employeeleave->leave_reason = $request['leave_reason'];
        $employeeleave->leave_type_code = $request['leave_type_code'];
        
        if($request->file('leave_document'))
        {
            // unlink(public_path('admin/assets/img/documents/'). $employeeleave->leave_document);
            $file_name = time().'_'.trim($request->file('leave_document')->getClientOriginalName());
            //print_r(public_path('admin/assets/img/servicecontract/').$file_name); exit;
            $request->file('leave_document')->move(public_path('admin/assets/img/documents/'), $file_name);
            $employeeleave->leave_document = $file_name;
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

    public function save_leave_status(Request $request)
    {
        $id = $request->input("leave_id");
        $leave_status_code = $request->input("leave_status_code");

        $leave = EmployeeLeaves::find($id);

        if($leave_status_code == 3) 
        {
            $leave->leave_status_code = 3; // dissapprove
            if($leave->save())
            {
                Toastr::success('This leave request is disapproved.');
                return back();

            }
            else
            {
                Toastr::error('Something went wrong.');
                return back();
            }
        }
        else
        {
            $email = User::where('id', $leave->staff_id)->first()->email;
            $employee_detail = Employee::where('employee_email_address', $email)->first();

            $leave_apply_date = Carbon::parse($leave->apply_date);
            $employee_contract_start_date = Carbon::parse($employee_detail->employee_start_datetime);
            $employee_contract_end_date = Carbon::parse($employee_detail->employee_end_datetime);
            
            if($leave->leave_type_code == 2) //vaction leave
            {
                if($leave_apply_date->gt($employee_contract_start_date) && $leave_apply_date->lt($employee_contract_end_date))
                {
                    $leave_start_date = Carbon::parse($leave->leave_start_date);
                    $leave_end_date = Carbon::parse($leave->leave_end_date);
    
                    //leave taken days
                    $leave_taken = $leave_start_date->diffInDays($leave_end_date) + 1 ;
    
                    //leave taken contract years
                    $leave_contract_years = Carbon::parse($employee_contract_start_date)->format('Y'). '-'. Carbon::parse($employee_contract_end_date)->format('Y');
                    
                    $leave->leave_status_code = 1; // approved
                    $leave->leaves_taken = $leave_taken;
                    $leave->leaves_taken_year = $leave_contract_years;
    
                    if($leave->save())
                    {
                        Toastr::success('This leave request is approved.');
                        return back();
    
                    }
                    else
                    {
                        Toastr::error('Something went wrong.');
                        return back();
                    }
                    
                }
                else
                {
                    Toastr::error('Employee contract period is finished.');
                    return back();
                }

            }
            else
            {
                $leave->leave_status_code = 1; // approved
                if($leave->save())
                {
                    Toastr::success('This leave request is approved.');
                    return back();

                }
                else
                {
                    Toastr::error('Something went wrong.');
                    return back();
                }
            }
            
        }

    }

    public function get_approved_leave_info()
    {
        $approve_leaves = [];

        $leaves_list = EmployeeLeaves::select('id','leave_status_code','leave_start_date','leave_end_date','staff_id')->whereIn('leave_status_code', [1,3])->get();
        $className = '';
        foreach($leaves_list as $leave)
        {
            $name = User::where('id', $leave->staff_id)->first()->name;
            $start_date = Carbon::parse($leave->leave_start_date)->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($leave->leave_end_date)->format('Y-m-d H:i:s');

            if($leave->leave_status_code == '1')
            {
                $className = "approved";
            }
            else
            {
                $className = "disapproved";
            }
           
            $approve_leaves[] = ['className'=> $className,'title'=> $name, 'start' => $start_date, 'end' => $end_date,'id' => $leave->id];    
        }

        return json_encode($approve_leaves);
    }

}
