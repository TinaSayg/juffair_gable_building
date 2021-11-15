<?php

namespace App\Http\Controllers\admin;
use App\Models\Reservations;
use App\Models\Rooms;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservation = Reservations::orderBy('id','desc')->get();
        return view('admin.reservation.index',compact('reservation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservation = Reservations::all();
        $rooms = Rooms::all();
        return view('admin.reservation.create' ,compact('reservation','rooms'));
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
            'room_id' => 'required' ,
            'reservation_date' =>  'required' ,
            'start_time' => 'required',
            'end_time' => 'required',
            'tenant_name' => 'required',
        ], [
            'room_id.required'  => 'room id is required!',
            'reservation_date.required'  => 'reservation date is required!',
            'start_time.required' => 'start time is required!',
            'end_time.required' => 'end time is required!',
            'tenant_name' => 'tenant name is required!',
            
        ]);

        $reservation_id = random_int(10000,50000);
        // print_r([
        //     'room_id' => $request['room_id'],
        //     'reservation_date' => $request['reservation_date'],
        //     'start_time' => $request['start_time'],
        //     'end_time' => $request['end_time'],
        //     'tenant_name' => $request['tenant_name'],
        //     'reservation_id' =>  12
        // ]); exit;
       // echo $reservation_id; exit;
        $reservation = Reservations::create([
            'room_id' => $request['room_id'],
            'reservation_date' => $request['reservation_date'],
            'start_time' => $request['start_time'],
            'end_time' => $request['end_time'],
            'tenant_name' => $request['tenant_name'],
            'reservation_id' =>  12
        ]);
        $reservation->reservation_id = $reservation->id.rand(1000,9999);
        $reservation->save();
        
        Toastr::success('Reservation added successfully!');
        return redirect()->route('reservation.list');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservations::find($id);
        
        $html_response = view('admin.reservation.partials.reservationdetails_view_modal', compact('reservation'))->render();

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
        $reservation = Reservations::find($id);
       
        return view('admin.reservation.edit',compact('reservation'));
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
            'reservation_date' =>  'required' ,
            'start_time' => 'required',
            'end_time' => 'required',
            'tenant_name' => 'required',

        ], [
            'reservation_date.required'  => 'Reservation date is required!',
            'start_time.required' => 'Start time is required!',
            'end_time.required' => 'End Time is required!',
            'tenant_name.required' => 'Tenant Name is required!',
        ]);

        $reservation = Reservations::find($id);
        $reservation->reservation_date = $request['reservation_date'];
        $reservation->start_time = $request['start_time'];
        $reservation->end_time = $request['end_time'];
        $reservation->tenant_name = $request['tenant_name'];
      
      
        $reservation->save();

        Toastr::success('Reservation updated successfully!');
        return redirect()->route('reservation.list');
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation=Reservations::find($id);
        $reservation->delete();
        Toastr::success('Reservations deleted successfully!');
        return back();
    }
}
