<?php

namespace App\Http\Controllers;
use Mail;
use Image;
use App\Models\Unit;
use App\Models\Message;
use App\Models\Building;
use App\Models\FloorType;
use App\Models\FloorDetail;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use App\Models\JobOpportunities;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMailToGeneralManager;

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
            'cv' => 'required|max:20480| mimes:pdf',
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
        
        if($request->file('image'))
        {
          
            $file_name = time().'_'.trim($request->file('cv')->getClientOriginalName());
            //print_r(public_path('admin/assets/img/servicecontract/').$file_name); exit;
            $request->file('cv')->move(public_path('admin/assets/img/documents/'), $file_name);
            $filename= $file_name;  
        }
       
        $jobopprotunities = new JobOpportunities();
        $jobopprotunities->first_name = $request['first_name'];
        $jobopprotunities->last_name = $request['last_name'];
        $jobopprotunities->address = $request['address'];
        $jobopprotunities->date_of_birth = $request['date_of_birth'];
        $jobopprotunities->email_address = $request['email_address'];
        $jobopprotunities->phone = $request['phone'];
        $jobopprotunities->cv = $filename;
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

    public function testimonials_info()
    {
        $testimonial = Testimonials::all();
        
        return view('/testimonials' , compact('testimonial'));
     
    }

    public function send_message(Request $request)
    {
        return view('admin.messages.create');
    }

    public function send_email(Request $request)
    {
        
        $request->validate([
            'subject' => 'required',
            'message' =>  'required' ,   
        ]);

        $data = [ 'subject' => $request['subject'], 'message' => $request['message']];
        
        Mail::to('mrshaheen@juffairgables.com')->send(new SendMailToGeneralManager($data));
 
        if (Mail::failures()) {
            return response()->Fail('Something went wrong.');
        }
        else
        {
            $message = new Message();
            $message->subject = $request['subject'];
            $message->description = $request['message'];
            $message->sender_id = Auth::user()->id;
            
            $message->save();

            Toastr::success('Your message sent successfully.');
            return redirect()->back();
        }
    }
}
