<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class MessageController extends Controller
{
    public function index()
    {
        $message_list = Message::orderBy('id','desc')->get();
        return view('admin.messages.index', compact('message_list'));
    }

    public function show($id)
    {
        $message = Message::find($id);

        return view('admin.messages.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = Message::find($id);

        if($message->delete())
        {
            Toastr::success('Message deleted successfully!.');
            return redirect()->route('request.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('request.list');
        }
    }
}
