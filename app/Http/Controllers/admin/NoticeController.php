<?php

namespace App\Http\Controllers\admin;
use App\Models\User;
use App\Models\NoticeBoard;
use Illuminate\Http\Request;
use App\Models\NoticeBoardStatus;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;


class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticeboard =NoticeBoard::orderBy('id','desc')->get();
        return view('admin.notice.index',compact('noticeboard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $noticeboard = NoticeBoard::all();
        $noticeStatus = NoticeBoardStatus::all();
        $role =Role::where('slug', '!=' , 'admin')->get();
        return view('admin.notice.create',compact('noticeboard','noticeStatus','role'));
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
            'notice_text' => 'required',
            'notice_date' =>  'required' ,
            'notice_board_status_code' => 'required',
        ], [
            'notice_text.required' => 'Select the assign to value',
            'notice_date.required' => 'Select the date',
            'role_id.required' => 'Select the role id',
            'notice_board_status_code.required' => 'Select the status',
        ]);

        $user = User::with('roles')->where('id', Auth::user()->id)->first();
        $role_id = $user->roles()->first()->id;
        $noticeboard = NoticeBoard::create([
            'notice_text' => $request['notice_text'],
            'notice_date' => $request['notice_date'],
            'notice_board_status_code' => $request['notice_board_status_code'],
            'role_id' => $role_id
            
        ]);
        Toastr::success('Notice added successfully!');
        return redirect()->route('notice.list');
    }
  
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noticeboard = NoticeBoard::find($id);
    
        $html_response = view('admin.notice.partials.noticeboard_view_modal', compact('noticeboard'))->render();

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
        $noticeboard = NoticeBoard::find($id);
        $noticeStatus = NoticeBoardStatus::all();
        $role = Role::all();
        return view('admin.notice.edit',compact('noticeboard','noticeStatus','role'));
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
            'notice_text' => 'required',
            'notice_date' =>  'required' ,
            'notice_board_status_code' => 'required',
            
        ], [
            'notice_text.required' => 'Select the assign to value',
            'notice_date.required' => 'Select the date',
            'notice_board_status_code.required' => 'Select the status',
        ]);

        $noticeboard = NoticeBoard::find($id);
        $noticeboard->notice_text = $request['notice_text'];
        $noticeboard->notice_date = $request['notice_date'];
        $noticeboard->notice_board_status_code = $request['notice_board_status_code'];
        
        
        if($noticeboard->save())
        {
            Toastr::success('Notice updated successfully!');
            return redirect()->route('notice.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('notice.create');
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
        $noticeboard = NoticeBoard::find($id);

        $noticeboard->delete();

        Toastr::success('Notice deleted successfully!');
        return back();
    }
}
