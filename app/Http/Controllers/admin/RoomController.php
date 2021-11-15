<?php
namespace App\Http\Controllers\admin;
use App\Models\ReservationStatus;
use App\Models\Rooms;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room = Rooms::orderBy('id','desc')->get();
        return view('admin.room.index',compact('room'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room = Rooms::all();
        return view('admin.room.create' ,compact('room'));
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
            'room_id' => ' required',
            'reservation_date' => ' required',
            'start_time' => ' required',
            'end_time' => ' required',
            'tenant_name' => ' required',
        ], [
            'name.required' => 'Select the assign to value',
        ]);

        $room = new Rooms();
        $room->name = $request['name'];
        $room->room_statuses_code = 1; //available
        if($room->save())
        {
            Toastr::success('room created successfully!');
            return redirect()->route('room.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('room.create');
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
        $room = Rooms::find($id);
        
        $html_response = view('admin.room.partials.addroom_view_modal', compact('room'))->render();

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
        $room = Rooms::find($id);
       
        return view('admin.room.edit',compact('room'));
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
            'name' => 'required',
        ], [
            'name.required' => 'Select the assign to value',
        ]);

        $room = Rooms::find($id);
        $room->name = $request['name'];
        if($room->save())
        {
            Toastr::success('Room updated successfully!');
            return redirect()->route('room.list');
        }
        else
        {
            Toastr::success('Something went wrong.');
            return redirect()->route('room.create');
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
        $room=Rooms::find($id);
        $room->delete();
        Toastr::success('Room deleted successfully!');
        return back();
    }
}
