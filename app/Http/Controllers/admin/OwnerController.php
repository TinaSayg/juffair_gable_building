<?php

namespace App\Http\Controllers\admin;
use Hash;
use Image;
use App\Models\Unit;
use App\Models\User;
use App\Models\Owner;
use App\Models\Building;
use App\Models\OwnerType;
use App\Models\OwnerStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::orderBy('id','desc')->get();
        
        return view('owners.index',compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buildings = Building::all();
        return view('owners.create', compact('buildings'));
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
            'owner_first_name' => 'required',
            'owner_last_name' =>  'required' ,
            'owner_email_address'=> 'required|email|string|unique:owners,owner_email_address',
            'owner_present_address' => 'required', 
            'owner_permanent_address' => 'required', 
            'owner_mobile_phone' => 'required|unique:owners,owner_mobile_phone' ,
            'password' => 'required',
            'owner_cpr_no' => 'required|integer|size:9|unique:owners,owner_cpr_no',
            'image' => 'required',
        ]);

        //save owner image
        if($request->file('image'))
        {
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $image = Image::make($request->file('image')->getRealPath());
            $image->resize(500,500);
            $image->save(public_path('admin/assets/img/users/'). $file_name);
        }

        $name = $request['owner_first_name'] . ' ' . $request['owner_last_name'];
        
        $user = User::create([
            'name' => $name,
            'email' => $request['owner_email_address'],
            'password' => Hash::make($request['password']),
        ]);

        $owner = Owner::create([
            'owner_first_name' => $request['owner_first_name'],
            'owner_last_name' => $request['owner_last_name'],
            'owner_email_address' => $request['owner_email_address'],
            'owner_mobile_phone' => $request['owner_mobile_phone'],
            'owner_present_address' => $request['owner_present_address'],
            'owner_permanent_address' => $request['owner_permanent_address'],
            'owner_cpr_no' => $request['owner_cpr_no'],
            'owner_image' => $file_name,
        ]);

        
        $owner->users()->attach($user->id,['role' => 'owner']);
        
        Toastr::success('owner added successfully!');
        return redirect()->route('owners.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $owner = Owner::find($id);
        
        $html_response = view('owners.partials.owner_view_modal', compact('owner'))->render();

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
        
        $owner = Owner::find($id);
        return view('owners.edit',compact('owner'));
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
            'owner_first_name' => 'required',
            'owner_last_name' =>  'required' ,
            'owner_email_address'=> 'required|string|email|unique:owners,owner_email_address,' . $id,
            'owner_present_address' => 'required', 
            'owner_permanent_address' => 'required', 
            'owner_mobile_phone' => 'required|integer|unique:owners,owner_mobile_phone,' . $id,
            'owner_cpr_no' => 'required|min:9|max:9|unique:owners,owner_cpr_no,' . $id,
        ]);

        $owner = Owner::find($id);

        $owner->owner_first_name = $request['owner_first_name'];
        $owner->owner_last_name = $request['owner_last_name'];
        $owner->owner_email_address = $request['owner_email_address'];
        $owner->owner_mobile_phone = $request['owner_mobile_phone'];
        
        $owner->owner_cpr_no = $request['owner_cpr_no'];
        $owner->owner_present_address = $request['owner_present_address'];
        $owner->owner_permanent_address = $request['owner_permanent_address'];

        //save owner image
        if($request->file('image'))
        {
            unlink(public_path('admin/assets/img/users/'). $owner->owner_image);
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $image = Image::make($request->file('image')->getRealPath());
            $image->resize(100,50);
            $image->save(public_path('admin/assets/img/users/'). $file_name);
            $owner->owner_image = $file_name;
        }

        $owner->save();

        // update data from user
        $user_id = $owner->users->pluck('id')->first();
      
        $user = User::find($user_id);
        $name = $request['owner_first_name'] . ' ' . $request['owner_last_name'];
        $user->name = $name;
        $user->email = $request['owner_email_address'];
        $user->save();


        Toastr::success('Owner updated successfully!');
        return redirect()->route('owners.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $owner = Owner::find($id);
        $user = $owner->users->pluck('id');
        User::whereIn('id' , $user)->delete();
        $owner->delete();
        $owner->users()->detach();

        Toastr::success('Owner deleted successfully!');
        return back();
    }
}
