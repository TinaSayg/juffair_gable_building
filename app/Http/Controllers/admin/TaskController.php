<?php

namespace App\Http\Controllers\admin;

use DataTables;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\Unit;
use App\Models\User;
use App\Models\CommonArea;
use App\Models\TaskStatus;
use App\Models\FloorDetail;
use App\Models\ServiceArea;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::orderBy('id', 'desc')->get();
        $employee_list = User::where('userType', 'employee')->get();

        $task_status_list = TaskStatus::all();
        

        return view('admin.task.index', compact('tasks','employee_list','task_status_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee_list = User::where('userType', 'employee')->get();
        $task_status_list = TaskStatus::all(); 
        return view('admin.task.create', compact('task_status_list','employee_list'));
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
            'location_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ],[
            'location_id.required' => 'Select the task location',
        ]);

        $location_id = $request->input('location_id');
        $floor_id = $request->input('floor_id',null);
        $unit_id = $request->input('unit_id',null);
        $common_area_id = $request->input('common_area_id',null);
        $service_area_id = $request->input('service_area_id',null);

       
        $task = new Task();
        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->location_id = $location_id;
        $task->floor_id = $floor_id;
        $task->unit_id = $unit_id;
        $task->common_area_id = $common_area_id;
        $task->service_area_id = $service_area_id;
        
        // $task->assign_date = Carbon::parse($request['assign_date'])->format('Y-m-d');
        // $task->assign_time = Carbon::parse($request['assign_time'])->format("H:i");
        // $task->assign_date = Carbon::parse($request['deadline_date'])->format('Y-m-d');
        // $task->assign_time = Carbon::parse($request['deadline_time'])->format("H:i");
        // $task->assignor_id = Auth::user()->id;
        // if(Auth::user()->userType != 'employee')
        // {
        //     $task->assignee_id = $request['assignee_id'];
        // }
        // else
        // {
        //     $task->assignee_id = Auth::user()->id;
        // }

        if($task->save()){
            Toastr::success('Task added successfully.');
            return redirect()->route('tasks.list');
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
        $task = Task::find($id);
        return view('admin.task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        $employee_list = User::where('userType', 'employee')->get();
        $task_status_list = TaskStatus::all(); 
        return view('admin.task.edit', compact('task','employee_list','task_status_list'));
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
            'location_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ],[
            'location_id.required' => 'Select the task location',
        ]);

        $location_id = $request->input('location_id');
        $floor_id = $request->input('floor_id',null);
        $unit_id = $request->input('unit_id',null);
        $common_area_id = $request->input('common_area_id',null);
        $service_area_id = $request->input('service_area_id',null);

       
        $task = Task::find($id);
        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->location_id = $location_id;
        $task->floor_id = $floor_id;
        $task->unit_id = $unit_id;
        $task->common_area_id = $common_area_id;
        $task->service_area_id = $service_area_id;
        
        // $task->assign_date = Carbon::parse($request['assign_date'])->format('Y-m-d');
        // $task->assign_time = Carbon::parse($request['assign_time'])->format("H:i");
        // $task->assign_date = Carbon::parse($request['deadline_date'])->format('Y-m-d');
        // $task->assign_time = Carbon::parse($request['deadline_time'])->format("H:i");
        // $task->assignor_id = Auth::user()->id;
        // if(Auth::user()->userType != 'employee')
        // {
        //     $task->assignee_id = $request['assignee_id'];
        // }
        // else
        // {
        //     $task->assignee_id = Auth::user()->id;
        // }

        if($task->save()){
            Toastr::success('Task updated successfully.');
            return redirect()->route('tasks.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('tasks.update', $id);
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
        $task = Task::find($id);
        $task->delete();

        Toastr::success('Task deleted successfully!');
        return back();

    }

    public function change_task_status(Request $request)
    {
       
        $task_id = $request->input('task_id');
        $task_status_code = $request->input('task_status_code');
        $task = Task::find($task_id);

        $task->task_status_code = $task_status_code; 
        
        if($task_status_code == 3)
        {
            $current_date_time = Carbon::now();
            $task->complete_date = Carbon::parse($current_date_time)->format('Y-m-d');
            $task->complete_time = Carbon::parse($current_date_time)->format('H:i');
        }

        if($task->save()){
            
            Toastr::success('Your task status has been changed.');
            return back();
        }
        else
        {
            Toastr::success('Something went wrong.');
            return back();
        }
    }

    public function task_closed(Request $request,$id)
    {
        if($request->is('dashboard/task/closed/*')){
            $maintenance_request = MaintenanceRequest::find($id);

            $store = new Task();
            $store->title =  $maintenance_request->title;
            $store->description =  $maintenance_request->description;
            $store->location_id =  $maintenance_request->location_id;
            $store->floor_id =  $maintenance_request->floor_id;
            $store->unit_id =  $maintenance_request->unit_id;
            $store->common_area_id =  $maintenance_request->common_area_id;
            $store->service_area_id =  $maintenance_request->service_area_id;

            $store->task_status_code = 5;

            if($store->save())
            {
                $maintenance_request = MaintenanceRequest::find($id);
                $maintenance_request->maintenance_request_status_code = 4;
                $maintenance_request->save();

                Toastr::success('This Task is closed.');
                return redirect()->route('tasks.list');
            }

            else
            {
                Toastr::error('Something went wrong.');
                return redirect()->back();
            }


            
            dd($maintenance_request);
        }
        else
        {

            $task = Task::find($id);
    
            $task->task_status_code = 5;
    
            if($task->save())
            {
                if($task->task_status_code == 5)
                {
                    if($task->maintenance_request_id)
                    {
                        $maintenance_request = MaintenanceRequest::find($task->maintenance_request_id);
                        $maintenance_request->maintenance_request_status_code = 4;
                        $maintenance_request->save();
                    }
                }

                Toastr::success('This Task is closed.');
                return redirect()->route('tasks.list');
    
            }
            else
            {
                Toastr::error('Something went wrong.');
                return redirect()->route('tasks.list');
            }
        }
        

    }

    public function task_cancelled($id)
    {
        $task = Task::find($id);

        $task->task_status_code = 6;

        if($task->save())
        {
            Toastr::success('This Task is cancelled.');
            return redirect()->route('tasks.list');

        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('tasks.list');
        }

    }

    public function resubmit_task(Request $request)
    {
       
        $request->validate([
            'reason' => 'required',
        ]);

        $id = $request->input("task_id");
        $task = Task::find($id);

        $task->task_status_code = 4;
        $task->complete_date = null;
        $task->complete_time = null;
        $task->comments = $request->input('reason');

        if($task->save())
        {
            Toastr::success('This Task is resubmit again.');
            return redirect()->route('tasks.list');

        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('tasks.list');
        }

    }

    public function complete_task_list(Request $request)
    {
        $login_user_id = Auth::user()->id;
        $tasks = Task::where('assignee_id', $login_user_id)->where('task_status_code', 3)->get();
       
        return view('admin.task.completed_task', compact('tasks'));
    }

    public function get_task_location($location_id)
    {
        if($location_id == 1)
        {
            $floors = FloorDetail::where('floor_type_code', 2)->get();

            $res = '<div class="form-group col-md-4 floor-dropdown"><label>Select Floor</label><select onchange="getUnits(this.value)" class="form-control" name="floor_id" id="floorSelect">';
            $res1 = '<div class="form-group col-md-4 unit-dropdown"><label>Select Apartment</label><select class="form-control" name="unit_id" id="unitSelect">';

            $res .= '<option value="' . 0 . '" disabled >---Select---</option>';
            foreach ($floors as $floor) {
                $res .= '<option value="' . $floor->id . '"  >' . $floor->number . '</option>';
            }

            $res .= "</select></div>";

            $res1 .= '<option value="' . 0 . '" disabled >---Select---</option>';

            if($floors->isNotEmpty())
            {
                
                $first_floor_id = $floors->first()->id;
                
                $units = Unit::where('floor_id' , $first_floor_id)->get();
                
                foreach ($units as $unit) {
                    $res1 .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
                }
            }

            $res1 .= "</select></div>";
       
            return response()->json([
                'floor_select' => $res,
                'unit_select' => $res1,
            ]);
        
        }
        elseif($location_id == 2)
        {
            $res = '<div class="form-group col-md-4 common_area_select"><label>Select Common Area</label><select class="form-control" name="common_area_id" id="commonAreaSelect">';
            $common_areas = CommonArea::all();
            
            foreach ($common_areas as $common_area) {
                $res .= '<option value="' . $common_area->id . '"  >' . $common_area->area_name . '</option>';
            }

            return response()->json([
                'common_area_select' => $res,
            ]);
        }
        elseif($location_id == 3)
        {
            $res = '<div class="form-group col-md-4 parking_floor_select"><label>Select Floor</label><select class="form-control" name="floor_id" id="parkingFloorSelect">';
            $parking_floors = FloorDetail::where('floor_type_code', 1)->get();
           
            
            foreach ($parking_floors as $floor) {
                $res .= '<option value="' . $floor->id . '"  >' . $floor->number . '</option>';
            }

            return response()->json([
                'parking_floors' => $res,
            ]);
        }
        else
        {
            $res = '<div class="form-group col-md-4 service_area_select"><label>Select Service Area</label><select class="form-control" name="service_area_id" id="serviceAreaSelect">';
            $service_area_list = ServiceArea::all();
           
            
            foreach ($service_area_list as $service_area) {
                $res .= '<option value="' . $service_area->id . '"  >' . $service_area->service_area_name . '</option>';
            }

            return response()->json([
                'service_areas_select' => $res,
            ]);
        }
    }

    public function assign_task(Request $request)
    {
        
        $request->validate([
            'employee_id' => 'required',
            'deadline_date' => 'required',
            'deadline_time' => 'required',
        ],[
            'employee_id.required' => 'Please select the Employee before proceeding.'
        ]);

        if($request['now_cb'] == 'on')
        {
            $current_date = Carbon::now();

            $assign_date = Carbon::parse($current_date)->format('Y-m-d');
            $assign_time = Carbon::parse($current_date)->format('H:i');
        }
        else
        {
            $request->validate([
                'assign_date' => 'required',
                'assign_time' => 'required|string',
            ]);

            $assign_date = Carbon::parse($request['assign_date'])->format('Y-m-d');
            $assign_time = Carbon::parse($request['assign_time'])->format("H:i");
        }

       
        $id = $request->input('task_id');
        $task = Task::find($id);
        
        $task->assign_date = $assign_date;
        $task->assign_time = $assign_time;
        $task->deadline_date = Carbon::parse($request['deadline_date'])->format('Y-m-d');
        $task->deadline_time = Carbon::parse($request['deadline_time'])->format("H:i");
        $task->assignor_id = Auth::user()->id;
        $task->assignee_id = $request['employee_id'];
        // $task->comments = $request['comment'];
        $task->task_status_code = 1;

        if($task->save())
        {
            Toastr::success('Task assigned to employee successfully.');
            return redirect()->route('tasks.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('tasks.list');
        }
    }

    public function assign_task_for_maintenance(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'employee_id' => 'required',
            'deadline_date' => 'required',
            'deadline_time' => 'required',
        ],[
            'employee_id.required' => 'Please select the Employee before proceeding.'
        ]);

        $maintenance_request = MaintenanceRequest::find($request->input('maintenance_request_id'));
        if($request['now_cb'] == 'on')
        {
            $current_date = Carbon::now();

            $assign_date = Carbon::parse($current_date)->format('Y-m-d');
            $assign_time = Carbon::parse($current_date)->format('H:i');
        }
        else
        {
            $request->validate([
                'assign_date' => 'required',
                'assign_time' => 'required|string',
            ]);

            $assign_date = Carbon::parse($request['assign_date'])->format('Y-m-d');
            $assign_time = Carbon::parse($request['assign_time'])->format("H:i");
        }

        $task = new Task();
        $task->title = $maintenance_request->title;
        $task->description = $maintenance_request->description;
        $task->location_id = $maintenance_request->location_id;
        $task->floor_id = $maintenance_request->floor_id;
        $task->unit_id = $maintenance_request->unit_id;
        $task->common_area_id = $maintenance_request->common_area_id;
        $task->service_area_id = $maintenance_request->service_area_id;
        $task->assign_date = $assign_date;
        $task->assign_time = $assign_time;
        $task->deadline_date = Carbon::parse($request['deadline_date'])->format('Y-m-d');
        $task->deadline_time = Carbon::parse($request['deadline_time'])->format("H:i");
        $task->assignor_id = Auth::user()->id;
        $task->assignee_id = $request['employee_id'];
        // $task->comments = $request['comment'];
        $task->task_status_code = 1;
        $task->maintenance_request_id = $request->input('maintenance_request_id');

        if($task->save())
        {
            $maintenance_request->maintenance_request_status_code = 3;

            $maintenance_request->save();

            Toastr::success('Task assigned to employee successfully.');
            return back();
        }
        else
        {
            Toastr::success('Something went wrong.');
            return back();
        }
    }

    public function search_tasks_by_status(Request $request)
    {
        $task_status_code = $request->input('task_status_code',null);
        

        $query = Task::query();

        if($task_status_code)
        {
            $query->where('task_status_code', $task_status_code);
        }

        $tasks = $query->orderBy('id','desc')->get();
        $employee_list = User::where('userType', 'employee')->get();

        $task_status_list = TaskStatus::all();
        

        return view('admin.task.index', compact('tasks','employee_list','task_status_list','task_status_code'));
    }

   
}
