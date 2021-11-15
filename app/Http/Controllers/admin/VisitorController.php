<?php
namespace App\Http\Controllers\admin;
use App\Models\Unit;
use App\Models\Floor;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\FloorDetail;
use App\Models\FloorType;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Session;
class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitor = Visitor::orderBy('id','desc')->get();
        return view('admin.visitors.index',compact('visitor'));
    }
    public function fetch_units($id)
    {
        $floor = Floor::find($id);
        $building_id = $floor->building->id;
        $units = Unit::where('building_id', $building_id)->where('floor_id', $id)->get();
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        foreach ($units as $unit) {
         $res .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
        }
        return response()->json([
            'options' => $res,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $visitor = Visitor::all();
        $floor_types = FloorType::all();

        return view('admin.visitors.create' ,compact('visitor','floor_types'));
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
            'visitor_full_name' => 'required',
            'visitor_entry_date' =>  'required' ,
            'visitor_phone_number' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required',
            'visitor_in_time' => 'required' ,
            'visitor_out_time' => 'required' ,

        ], [
            'visitor_full_name.required' => 'Visitor full name is required!',
            'visitor_entry_date.required'  => ' Visitor Entry date is required!',
            'visitor_phone_number.required' => 'Visitor Phone number is required',
            'floor_id.required' => 'Floor id is required',
            'unit_id.required' => 'unit is required',
            'visitor_in_time.required' =>  'Visitor Time IN is required' ,
            'visitor_out_time.required' => 'Visitor Time OUT is required',
        ]);
        $visitor = Visitor::create([
            'visitor_full_name' => $request['visitor_full_name'],
            'visitor_entry_date' => $request['visitor_entry_date'],
            'visitor_phone_number' => $request['visitor_phone_number'],
            'floor_id' => $request['floor_id'],
            'unit_id' => $request['unit_id'],
            'visitor_in_time' => $request['visitor_in_time'],
            'visitor_out_time' => $request['visitor_out_time'],
            
        ]);
        Toastr::success('Visitor added successfully!');
        return redirect()->route('visitor.list');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitor = Visitor::find($id);
        
        $html_response = view('admin.visitors.partials.visitors_view_modal', compact('visitor'))->render();

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
        $visitor = Visitor::find($id);
        $floor_types = FloorType::all();
        $floors = FloorDetail::where('floor_type_code' , $visitor->unit->floor->floor_type_code)->get();
        $units = Unit::where('floor_id' , $visitor->floor_id)->get();
        return view('admin.visitors.edit' ,compact('visitor','floor_types','floors','units'));
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
            'visitor_full_name' => 'required',
            'visitor_entry_date' =>  'required' ,
            'visitor_phone_number' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required',
            'visitor_in_time' => 'required' ,
            'visitor_out_time' => 'required' ,
        ], [
            'visitor_full_name.required' => 'Visitor full name is required!',
            'visitor_entry_date.required'  => ' Visitor Entry date is required!',
            'visitor_phone_number.required' => 'Visitor phone number is required',
            'floor_id.required' => 'Floor id is required',
            'unit_id.required' => 'Unit is required',
            'visitor_in_time.required' =>  ' Visitor time IN is required' ,
            'visitor_out_time.required' => 'Visitor time OUT is required',
        ]);
       

        $visitor =Visitor::find($id);

        $visitor->visitor_full_name = $request['visitor_full_name'];
        $visitor->visitor_entry_date = $request['visitor_entry_date'];
        $visitor->visitor_phone_number = $request['visitor_phone_number'];
        $visitor->floor_id = $request['floor_id'];
        $visitor->unit_id = $request['unit_id'];
        $visitor->visitor_in_time = $request['visitor_in_time'];
        $visitor->visitor_out_time = $request['visitor_out_time'];

        $visitor->save();
        Toastr::success('visitor updated successfully!');
        return redirect()->route('visitor.list');
    }


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitor =Visitor::find($id);

        $visitor->delete();

        Toastr::success('Visitor deleted successfully!');
        return back();
    }
}
