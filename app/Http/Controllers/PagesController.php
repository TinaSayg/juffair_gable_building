<?php

namespace App\Http\Controllers;
use Image;
use App\Models\Unit;
use App\Models\Building;
use App\Models\JobOpportunities;
use App\Models\FloorType;
use App\Models\FloorDetail;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;


class PagesController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        
        return view('dashboard' , compact('buildings'));
    }

    public function fetch_all_units_and_floors_list($floor_type_code)
    {
       
        $floors = FloorDetail::where('floor_type_code', $floor_type_code)->get();
       
        
        
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        foreach ($floors as $floor) {
            $res .= '<option value="' . $floor->id . '"  >' . $floor->number . '</option>';
        }
        
        $res1 = '<option value="' . 0 . '" disabled >---Select---</option>';

        if($floors->isNotEmpty())
        {
            
            $first_floor_id = $floors->first()->id;
           
            $units = Unit::where('floor_id' , $first_floor_id)->get();
            
            foreach ($units as $unit) {
                $res1 .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
            }
        }
        return response()->json([
            'options' => $res,
            'options1' => $res1,
        ]);
    }

    public function fetch_floors($floor_type_code)
    {
        $floors = FloorDetail::where('floor_type_code', $floor_type_code)->get();
       
        
        
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        foreach ($floors as $floor) {
            $res .= '<option value="' . $floor->id . '"  >' . $floor->number . '</option>';
        }
        
        $res1 = '<option value="' . 0 . '" disabled >---Select---</option>';

        if($floors->isNotEmpty())
        {
            
            $first_floor_id = $floors->first()->id;
            
            $units = Unit::where('unit_status_code' , 2)->where('floor_id' , $first_floor_id)->get();
            
            foreach ($units as $unit) {
                $res1 .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
            }
        }
        return response()->json([
            'options' => $res,
            'options1' => $res1,
        ]);
    }
    public function save_job_info(Request  $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' =>  'required' ,
            'address' => 'required',
            'date_of_birth' => 'required',
            'email_address' =>  'required|email|unique:job_opportunities,email_address',
            'phone' =>  'required|unique:job_opportunities,phone',
            'cv' => 'required|max:20480| mimes:application/pdf',
        ], [
            'first_name.required' => 'First Name is required!',
            'last_name.required'  => 'Last Name  is required!',
            'address.required' => 'Address is required!',
            'date_of_birth.required' => 'Date of birth is required!',
            'email_address.required' => 'Email is required!',
            'phone.required' =>  'Phone is required',
            'cv.required' => 'cv required!',
            'cv.mimes' => 'CV should should be in .pdf format',
        ]);
        
        $filename ='';
        if($request->file('cv'))
        {
            $file_name = time().'_'.trim($request->file('cv')->getClientOriginalName());
            
            $image = Image::make($request->file('cv')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);
            $filename= $file_name;  
        }
       
        $jobopprotunities = new JobOpportunities();
        $jobopprotunities->first_name = $request['first_name'];
        $jobopprotunities->last_name = $request['last_name'];
        $jobopprotunities->address = $request['address'];
        $jobopprotunities->date_of_birth = $request['date_of_birth'];
        $jobopprotunities->email_address = $request['email_address'];
        $jobopprotunities->phone = $request['phone'];
        $jobopprotunities->cv = $request['cv'];
        $jobopprotunities->save();
       return redirect()->back()->with('message', 'Application submitted successfully!We will contact you soon!');
    }
        
    public function fetch_units($floor_id)
    {
        
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        $units = Unit::where('unit_status_code' , 2)->where('floor_id' , $floor_id)->get();
        
        foreach ($units as $unit) {
            $res .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
        }

        return response()->json([
            'options' => $res,
        ]);
    }

    public function fetch_all_units($floor_id)
    {
       
        $res = '<option value="' . 0 . '" disabled >---Select---</option>';
        $units = Unit::where('floor_id' , $floor_id)->get();
        
        foreach ($units as $unit) {
            $res .= '<option value="' . $unit->id . '"  >' . $unit->unit_number . '</option>';
        }

        return response()->json([
            'options' => $res,
        ]);
    }
}
