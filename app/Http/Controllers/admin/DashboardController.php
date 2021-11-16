<?php

namespace App\Http\Controllers\admin;

use Session;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_minutes = 0;
        $average_time = 0;
        if(Auth::user()->userType == 'employee'){

            $login_user_id = Auth::user()->id;
            $tasks = Task::where('assignee_id', $login_user_id)->where('task_status_code', 2)->get();
            $number = $tasks->count();
            
            if($number > 0)
            {
                foreach($tasks as $task)
                {
                    $assigned_date_time = Carbon::parse($task->assign_date)->format('Y-m-d') .' '. Carbon::parse($task->assign_time)->format("H:i:s");
                    $complete_date_time = Carbon::parse($task->complete_date)->format('Y-m-d') .' '.  Carbon::parse($task->complete_time)->format("H:i:s");
                   
                    $minutes = Carbon::parse($assigned_date_time)->diffInMinutes(Carbon::parse($complete_date_time));
                    $total_minutes = $total_minutes + $minutes;
                    // dump($total_minutes);
                }
        
                $avg_in_minutes = $total_minutes/$number;
                // dd($avg_in_minutes);
                $average_time = floor($avg_in_minutes / 60).':'.($avg_in_minutes -   floor($avg_in_minutes / 60) * 60);
            }
        }
        
        return view('admin.index', compact('average_time'));
    }
}
