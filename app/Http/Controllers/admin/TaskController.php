<?php

namespace App\Http\Controllers\admin;

use DataTables;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
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

        return view('admin.task.index', compact('tasks'));
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
            'title' => 'required',
            'description' => 'required',
            'assign_date' => 'required|string',
            'assign_time' => 'required',
        ]);

        $task = new Task();
        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->assign_date = Carbon::parse($request['assign_date'])->format('Y-m-d');
        $task->assign_time = Carbon::parse($request['assign_time'])->format("H:i");
        $task->assignor_id = Auth::user()->id;
        if(Auth::user()->userType != 'employee')
        {
            $task->assignee_id = $request['assignee_id'];
        }
        else
        {
            $task->assignee_id = Auth::user()->id;
        }

        $task->task_status_code = 1;
        

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
            'title' => 'required',
            'description' => 'required',
            'assign_date' => 'required|string',
            'assign_time' => 'required',
            'assignee_id' => 'required',
        ]);

        $task = Task::find($id);
        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->assign_date = Carbon::parse($request['assign_date'])->format('Y-m-d');
        $task->assign_time = Carbon::parse($request['assign_time'])->format("H:i");
        $task->assignor_id = Auth::user()->id;
        $task->assignee_id = $request['assignee_id'];
        $task->task_status_code = 1;
        

        if($task->save()){
            Toastr::success('Task updated successfully.');
            return redirect()->route('tasks.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('tasks.edit');
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

    public function complete_task($id)
    {
        $task = Task::find($id);

        $current_date_time = Carbon::now();
        $task->task_status_code = '2'; //completed
        $task->complete_date = Carbon::parse($current_date_time)->format('Y-m-d');
        $task->complete_time = Carbon::parse($current_date_time)->format('H:i');

        if($task->save()){
            Toastr::success('Your task is completed.');
            return back();
        }
        else
        {
            Toastr::success('Something went wrong.');
            return back();
        }
    }

    public function complete_task_list(Request $request)
    {
        $login_user_id = Auth::user()->id;
        $tasks = Task::where('assignee_id', $login_user_id)->where('task_status_code', 2)->get();
       
        return view('admin.task.completed_task', compact('tasks'));
    }
}
