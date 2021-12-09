<?php

namespace App\Http\Controllers\admin;

use Hash;
use Image;
use Session;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Floor;
use App\Models\Tenant;
use App\Models\Building;
use App\Models\FloorType;
use App\Models\TenantType;
use App\Models\FloorDetail;
use App\Models\TenantStatus;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class TenantController extends Controller
{
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::orderBy('id','desc')->get();
        return view('admin.tenants.index', compact('tenants'));
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
        // $floor_types = FloorType::where('floor_type_code', 2)->get();
        $floor_list = FloorDetail::where('floor_type_code', 2)->get();
        $tenant_types = TenantType::all();
        return view('admin.tenants.create', compact('floor_list','tenant_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tenant_first_name' => 'required',
            'tenant_last_name' => 'required',
            'tenant_mobile_phone' => 'required|unique:tenants,tenant_mobile_phone',
            'tenant_email_address' => 'required|string|unique:tenants,tenant_email_address',
            'tenant_email_address' => 'required|string|unique:users,email',
            'tenant_date_of_birth' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required',
            'tenant_present_address' => 'required',
            'tenant_permanent_address' => 'required',
            'home_country_address' => 'required',
            'password' => 'required',
            'tenant_cpr_no' => 'required|unique:tenants,tenant_cpr_no',
            'lease_period_start_datetime' => 'required',
            'lease_period_end_datetime' => 'required',
            // 'security_deposit' => 'required',
            'emergancy_contact_number' => 'required',
            'emergancy_email' => 'required',
            'tenant_type_code' => 'required',
            'tenant_image' => 'required',
            'tenant_passport_copy' => 'required',
            'tenant_cpr_copy' => 'required',
            'tenant_contract_copy' => 'required',
        ]);

        $tenant = new Tenant();
        $tenant->tenant_first_name = $request['tenant_first_name'];
        $tenant->tenant_last_name = $request['tenant_last_name'];
        $tenant->tenant_mobile_phone = $request['tenant_mobile_phone'];
        $tenant->tenant_email_address = $request['tenant_email_address'];
        $tenant->floor_id = $request['floor_id'];
        $tenant->unit_id = $request['unit_id'];
        $tenant->tenant_present_address = $request['tenant_present_address'];
        $tenant->tenant_permanent_address = $request['tenant_permanent_address'];
        $tenant->home_country_address = $request['home_country_address'];
        $tenant->password = Hash::make($request['password']);
        $tenant->tenant_cpr_no = $request['tenant_cpr_no'];
        $tenant->lease_period_start_datetime = $request['lease_period_start_datetime'];
        $tenant->lease_period_end_datetime = $request['lease_period_end_datetime'];
        // $tenant->security_deposit = $request['security_deposit'];
        $tenant->emergancy_contact_number = $request['emergancy_contact_number'];
        $tenant->emergancy_email = $request['emergancy_email'];
        $tenant->tenant_date_of_birth = $request['tenant_date_of_birth'];
        $tenant->tenant_type_code = $request['tenant_type_code'];
        $tenant->tenant_rent = $request['total_rent'];
        $tenant->tenant_facilities_list = explode(',',$request['all_facilities']);
        
        //save tenant image
        if($request->file('tenant_image'))
        {
            $file_name = time().'_'.trim($request->file('tenant_image')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_image')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/staff/'). $file_name);

            $tenant->tenant_image  = $file_name;
        }

        //save passport image
        if($request->file('tenant_passport_copy'))
        {
            $file_name = time().'_'.trim($request->file('tenant_passport_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_passport_copy')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $tenant->tenant_passport_copy  = $file_name;
        }

        //save cpr copy
        if($request->file('tenant_cpr_copy'))
        {
            $file_name = time().'_'.trim($request->file('tenant_cpr_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_cpr_copy')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $tenant->tenant_cpr_copy  = $file_name;
        }

        //save contract copy
        if($request->file('tenant_contract_copy'))
        {
            $file_name = time().'_'.trim($request->file('tenant_contract_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_contract_copy')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $tenant->tenant_contract_copy  = $file_name;
        }

        if($tenant->save())
        {
            //save tenant information in user table
            $user = new User();
            $user->name =  $tenant->tenant_first_name.' '.  $tenant->tenant_last_name;
            $user->number = $tenant->tenant_mobile_phone;
            $user->email = $tenant->tenant_email_address;
            $user->password = $tenant->password;
            $user->userType = 'tenant';
            $user->address = $tenant->tenant_present_address;
            $user->status = 1;
            $user->image = $tenant->tenant_image;

            $user->save();

            //Assign role to tenant
            $role = Role::where('slug',$user->userType)->pluck('id')->first();
            $user->roles()->attach($role);
            
            //book unit
            $unit = Unit::where('id', $request['unit_id'])->where('floor_id' , $request['floor_id'])->first();
            
            $unit->unit_status_code = 1;

            $unit->save();
        }

        Toastr::success('Tenant inserted successfully!');
        return redirect()->route('tenants.list');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant = Tenant::find($id);
        
        return view('admin.tenants.show',compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $tenant = Tenant::find($id);
        $floor_types = FloorType::where('floor_type_code', '!=', 1)->get();
        $tenant_types = TenantType::all();
        $units = Unit::where('floor_id' , $tenant->floor_id)->get();
       
        
        $floors = FloorDetail::where('floor_type_code' , $tenant->unit->floor->floor_type_code)->get();
        return view('admin.tenants.edit',compact('tenant','floor_types','tenant_types','units','floors'));
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
        
        $tenant = Tenant::find($id);

        // Tenant old email
        $tenant_old_email = $tenant->tenant_email_address;
        $user_id = User::where('email', $tenant_old_email)->first()->id;

        $request->validate([
            'tenant_first_name' => 'required',
            'tenant_last_name' => 'required',
            'tenant_mobile_phone' => 'required|unique:tenants,tenant_mobile_phone,'.$id,
            'tenant_email_address' => 'required|email|string|unique:tenants,tenant_email_address,'.$id,
            'tenant_email_address' => 'required|email|string|unique:users,email,'. $user_id,
            'tenant_date_of_birth' => 'required',
            'floor_id' => 'required',
            'unit_id' => 'required',
            'tenant_present_address' => 'required',
            'tenant_permanent_address' => 'required',
            'home_country_address' => 'required',
            'tenant_cpr_no' => 'required|unique:tenants,tenant_cpr_no,'.$id,
            'lease_period_start_datetime' => 'required',
            'lease_period_end_datetime' => 'required',
            // 'security_deposit' => 'required',
            'emergancy_contact_number' => 'required',
            'emergancy_email' => 'required|email',
            'tenant_type_code' => 'required',
        ]);

        
        
        $tenant->tenant_first_name = $request['tenant_first_name'];
        $tenant->tenant_last_name = $request['tenant_last_name'];
        $tenant->tenant_mobile_phone = $request['tenant_mobile_phone'];
        $tenant->tenant_email_address = $request['tenant_email_address'];
        $tenant->floor_id = $request['floor_id'];
        $tenant->unit_id = $request['unit_id'];
        $tenant->tenant_present_address = $request['tenant_present_address'];
        $tenant->tenant_permanent_address = $request['tenant_permanent_address'];
        $tenant->home_country_address = $request['home_country_address'];
        $tenant->tenant_cpr_no = $request['tenant_cpr_no'];
        $tenant->lease_period_start_datetime = $request['lease_period_start_datetime'];
        $tenant->lease_period_end_datetime = $request['lease_period_end_datetime'];
        // $tenant->security_deposit = $request['security_deposit'];
        $tenant->emergancy_contact_number = $request['emergancy_contact_number'];
        $tenant->emergancy_email = $request['emergancy_email'];
        $tenant->tenant_date_of_birth = $request['tenant_date_of_birth'];
        $tenant->tenant_type_code = $request['tenant_type_code'];
        $tenant->tenant_rent = $request['total_rent'];
        $tenant->tenant_facilities_list = explode(',',$request['all_facilities']);

        //save tenant image
        if($request->file('tenant_image'))
        {
            unlink(public_path('admin/assets/img/staff/'). $tenant->tenant_image);

            $file_name = time().'_'.trim($request->file('tenant_image')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_image')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/staff/'). $file_name);

            $tenant->tenant_image  = $file_name;
        }

        //save passport image
        if($request->file('tenant_passport_copy'))
        {
            unlink(public_path('admin/assets/img/documents/'). $tenant->tenant_passport_copy);

            $file_name = time().'_'.trim($request->file('tenant_passport_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_passport_copy')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $tenant->tenant_passport_copy  = $file_name;
        }

        //save cpr copy
        if($request->file('tenant_cpr_copy'))
        {
            unlink(public_path('admin/assets/img/documents/'). $tenant->tenant_cpr_copy);

            $file_name = time().'_'.trim($request->file('tenant_cpr_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_cpr_copy')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $tenant->tenant_cpr_copy  = $file_name;
        }

        //save contract copy
        if($request->file('tenant_contract_copy'))
        {
            unlink(public_path('admin/assets/img/documents/'). $tenant->tenant_contract_copy);

            $file_name = time().'_'.trim($request->file('tenant_contract_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('tenant_contract_copy')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $tenant->tenant_contract_copy  = $file_name;
        }



        if($tenant->save())
        {
            //save tenant information in user table
            $user = User::where('email', $tenant_old_email)->first();
            $user->name =  $tenant->tenant_first_name.' '.  $tenant->tenant_last_name;
            $user->number = $tenant->tenant_mobile_phone;
            $user->email = $tenant->tenant_email_address;
            $user->password = $tenant->password;
            $user->userType = 'tenant';
            $user->address = $tenant->tenant_present_address;
            $user->status = 1;
            $user->image = $tenant->tenant_image;

            $user->save();

        }

        Toastr::success('Tenant updated successfully!');
        return redirect()->route('tenants.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tenant = Tenant::find($id);
        // Tenant old email
        $email_address = $tenant->tenant_email_address;
        
        //check email exist in user table
        $user = User::where('email', $email_address)->first();
        $role_id = UserRole::select('role_id')->where('user_id', $user->id)->first()->role_id;
       
        $user->roles()->detach($role_id);
        $user->delete();
        $tenant->delete();

        Toastr::success('Tenant deleted successfully!');
        return back();
    }

    public function tenant_passed($id)
    {
        $tenant = Tenant::find($id);

        $tenant->is_passed = 1;

        if($tenant->save())
        {
            $unit = Unit::find($tenant->unit_id);
            $unit->unit_status_code = 2; // vacant

            $unit->save();
            
            Toastr::success('Tenant is passed.');
            return back();
        }
        else
        {
            Toastr::error('Something went wrong.');
            return back();
        }
    }
}
