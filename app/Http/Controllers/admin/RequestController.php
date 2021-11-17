<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Complain;
use Illuminate\Http\Request;
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
        $complaints =Complain::where('complain_person_id', Auth::user()->id)->orWhere('assigneed_id', Auth::user()->id)->orderBy('id','desc')->get();
        $complaint_status_list = ComplainStatus::all();
        return view('admin.request.index', compact('complaints','complaint_status_list'));
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
            'posted_date' => 'required|string',
        ]);

        $complaint = new Complain();
        $complaint->complain_title = $request->input('title');
        $complaint->complain_description = $request->input('description');
        $complaint->complain_date = $request->input('posted_date');
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
