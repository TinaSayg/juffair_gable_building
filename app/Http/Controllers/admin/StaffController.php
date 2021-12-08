<?php

namespace App\Http\Controllers\admin;

use Image;
use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use App\Models\StaffDetail;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->userType == 'Admin')
        {
            $staffs=User::with('StaffDetail')->whereIn('userType',['employee','officer','general-manager'])->get()->except(Auth::id())->toArray();

        }
        else
        {
            $staffs=User::with('StaffDetail')->whereIn('userType',['employee','officer','general-manager'])->get()->except(Auth::id())->toArray();

        }
        
        return view('admin.staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereIn('slug', ['employee','officer','general-manager'])->orderBy('name','asc')->get();

        return view('admin.staff.create', compact('roles'));
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
            'name'=>'required|string ',
            'number'=>'required|size:8|unique:users,number',
            'email'=>'required|email|unique:users,email',
            'email'=>'required|email|unique:employees,employee_email_address',
            'password'=>'required',
            'staff_image'=>'required|image|mimes:jpeg,png,jpg',
            'staffType'=>'required',
            'staff_date_of_birth' => 'required',
            'staff_present_address' => 'required',
            'staff_permanent_address' => 'required',
            'annual_leaves' => 'required',
            'sallery' => 'required',
            'staff_cpr_no' => 'required|unique:employees,employee_cpr_no',
            'passport_number' => 'required|unique:employees,passport_number',
            'lease_period_start_datetime' => 'required',
            'lease_period_end_datetime' => 'required',
            'staff_passport_copy' => 'required',
            'staff_cpr_copy' => 'required',
            'staff_contract_copy' => 'required',
        ]);
        
        $staff = new User();
        $staff->name = $request->name;
        $staff->number = $request->number;
        $staff->email = $request->email;
        $staff->password = Hash::make($request->password);
        $staff->userType = $request->staffType;
        $staff->address='';
        $staff->status=1;
        
        //save owner image
        if($request->file('staff_image'))
        {
            $file_name = time().'_'.trim($request->file('staff_image')->getClientOriginalName());
            $image = Image::make($request->file('staff_image')->getRealPath());
            $image->resize(300,300);
            $image->save(public_path('admin/assets/img/staff/'). $file_name);
            $staff->image = $file_name;
        }
        
        if($staff->save())
        {
            $employee = new Employee();
            $employee->employee_name = $request->name;
            $employee->employee_mobile_phone = $request->number;
            $employee->employee_email_address =  $request->email;;
            $employee->employee_sallery = $request['sallery'];
            $employee->annual_leaves = $request['annual_leaves'];
            $employee->employee_present_address = $request['staff_present_address'];
            $employee->employee_permanent_address = $request['staff_permanent_address'];
            $employee->employee_cpr_no = $request['staff_cpr_no'];
            $employee->passport_number = $request['passport_number'];
            $employee->employee_start_datetime = $request['lease_period_start_datetime'];
            $employee->employee_end_datetime = $request['lease_period_end_datetime'];
            $employee->employee_date_of_birth = $request['staff_date_of_birth'];
            $employee->employee_image  = $file_name;

            
            //save passport image
            if($request->file('staff_passport_copy'))
            {
                $file_name = time().'_'.trim($request->file('staff_passport_copy')->getClientOriginalName());
                
                $image = Image::make($request->file('staff_passport_copy')->getRealPath());
                $image->resize(600,500);
                $image->save(public_path('admin/assets/img/documents/'). $file_name);

                $employee->employee_passport_copy  = $file_name;
            }

            //save cpr copy
            if($request->file('staff_cpr_copy'))
            {
                $file_name = time().'_'.trim($request->file('staff_cpr_copy')->getClientOriginalName());
                
                $image = Image::make($request->file('staff_cpr_copy')->getRealPath());
                $image->resize(600,500);
                $image->save(public_path('admin/assets/img/documents/'). $file_name);

                $employee->employee_cpr_copy  = $file_name;
            }

            

            //save contract copy
            if($request->file('staff_contract_copy'))
            {
                $file_name = time().'_'.trim($request->file('staff_contract_copy')->getClientOriginalName());
                
                $image = Image::make($request->file('staff_contract_copy')->getRealPath());
                $image->resize(600,500);
                $image->save(public_path('admin/assets/img/documents/'). $file_name);

                $employee->employee_contract_copy  = $file_name;
            }

            $employee->save();
            $role = Role::where('slug',$request->staffType)->pluck('id')->first();
            $staff->roles()->attach($role);

            Toastr::success('Staff added successfully!');
            return redirect()->route('staff.list');
        }
        else
        {
            Toastr::success('Something went wrong try again');
            return redirect()->route('staff.create');
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
        $email = User::where('id', $id)->first()->email;
        $employee = Employee::where('employee_email_address', $email)->first();
       
        return view('admin.staff.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $email = User::where('id',$id)->first()->email;
        $staffData = Employee::where('employee_email_address', $email)->first()->toArray();
        
        $roles = Role::whereIn('slug', ['employee','officer'])->orderBy('name','asc')->get()->toArray();
        $selectedRole = DB::table('user_roles')->where('user_id',$id)->first();
        return view('admin.staff.edit')->with(compact('roles','staffData','selectedRole'));
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
            'name'=>'required|string ',
            'number'=>'required|size:8|unique:employees,employee_mobile_phone,' . $id,
            'email'=>'required|email|unique:employees,employee_email_address,' . $id,
            'staffType'=>'required',
            'staff_date_of_birth' => 'required',
            'staff_present_address' => 'required',
            'staff_permanent_address' => 'required',
            'sallery' => 'required',
            'annual_leaves' => 'required',
            'staff_cpr_no' => 'required|unique:employees,employee_cpr_no,' . $id,
            'passport_number' => 'required|unique:employees,passport_number,' . $id,
            'lease_period_start_datetime' => 'required',
            'lease_period_end_datetime' => 'required',
        ]);

        $employee = Employee::find($id);
        $old_email = $employee->employee_email_address;
        $employee->employee_name = $request->name;
        $employee->employee_mobile_phone = $request->number;
        $employee->employee_email_address =  $request->email;
        $employee->annual_leaves = $request['annual_leaves'];
        $employee->employee_sallery = $request['sallery'];
        $employee->employee_present_address = $request['staff_present_address'];
        $employee->employee_permanent_address = $request['staff_permanent_address'];
        $employee->employee_cpr_no = $request['staff_cpr_no'];
        $employee->passport_number = $request['passport_number'];
        $employee->employee_start_datetime = $request['lease_period_start_datetime'];
        $employee->employee_end_datetime = $request['lease_period_end_datetime'];
        $employee->employee_date_of_birth = $request['staff_date_of_birth'];
        

        //save passport image
        if($request->file('employee_passport_copy'))
        {
            unlink(public_path('admin/assets/img/documents/'). $employee->employee_passport_copy);

            $file_name = time().'_'.trim($request->file('employee_passport_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_passport_copy')->getRealPath());
            $image->resize(600,500);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $employee->employee_passport_copy  = $file_name;
        }

        //save cpr copy
        if($request->file('employee_cpr_copy'))
        {
            unlink(public_path('admin/assets/img/documents/'). $employee->employee_cpr_copy);

            $file_name = time().'_'.trim($request->file('employee_cpr_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_cpr_copy')->getRealPath());
            $image->resize(600,500);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $employee->employee_cpr_copy  = $file_name;
        }
       

        //save contract copy
        if($request->file('employee_contract_copy'))
        {
            unlink(public_path('admin/assets/img/documents/'). $employee->employee_contract_copy);

            $file_name = time().'_'.trim($request->file('employee_contract_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_contract_copy')->getRealPath());
            $image->resize(600,500);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $employee->employee_contract_copy  = $file_name;
        }

        //save owner image
        if($request->file('staff_image'))
        {
            // unlink(public_path('admin/assets/img/staff/'). $staff->image);
            $file_name = time().'_'.trim($request->file('staff_image')->getClientOriginalName());
            
            $image = Image::make($request->file('staff_image')->getRealPath());
            $image->resize(300,300);
            $image->save(public_path('admin/assets/img/staff/'). $file_name);
            $employee->employee_image  = $file_name;
        }
        
        $employee->save();
        
        
        $staff = User::where('email', $old_email)->first();
        $staff->name = $request->name;
        $staff->number = $request->number;
        $staff->email = $request->email;
        $staff->userType = $request->staffType;
        $staff->address='';
        $staff->status=1;
        if(isset($file_name))
        $staff->image = $file_name;

        

        if($staff->save())
        {
            $role = Role::where('slug',$request->staffType)->pluck('id')->first();
           
            $selectedRole = DB::table('user_roles')->where('user_id',$staff->id)->first();
            if($selectedRole){
                $staff->roles()->detach($role);   
            }

            $staff->roles()->attach($role);

            Toastr::success('Staff updated successfully!');
            return redirect()->route('staff.list');
        }
        else
        {
            Toastr::success('Something went wrong try again');
            return redirect()->route('staff.create');
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
        $staff = User::find($id);
        $role_id = UserRole::select('role_id')->where('user_id', $id)->first()->role_id;
        Employee::where('employee_email_address', $staff->email)->delete();
        $staff->roles()->detach($role_id);
        $staff->delete();

        Toastr::success('Staff deleted successfully!');
        return redirect()->route('staff.list');
    }

    public function profile(Request $request)
    {
        return view('admin.staff.profile');
    }

    public function change_profile_image(Request $request, $id)
    {
        $staff = User::find($id);
       
        //save owner image
        if($request->file('profile_image'))
        {
            
            unlink(public_path('admin/assets/img/staff/'). $staff->image);
            $file_name = time().'_'.trim($request->file('profile_image')->getClientOriginalName());
            $image = Image::make($request->file('profile_image')->getRealPath());
            $image->resize(300,300);
            $image->save(public_path('admin/assets/img/staff/'). $file_name);
            $staff->image = $file_name;
        }

        if($staff->save())
        {
            $employee = Employee::where('employee_email_address', $staff->email)->first();
            $employee->employee_image = $file_name;
            $employee->save();
            Toastr::success('Profile image changed.');
            return redirect()->back();
        }
        else
        {
            Toastr::error('Something went wrong');
            return redirect()->back();
        }
    }

    public function edit_profile(Request $request,$id)
    {
        $request->validate([
            'number'=>'required|size:8|unique:users,number,' . $id,
            'present_address' => 'required',
            'permanent_address' => 'required',
        ]);

        

        $staff = User::find($id);

        $staff->number = $request->input('number');

        if($staff->save())
        {
            $employee = Employee::where('employee_email_address', $staff->email)->first();
            $employee->employee_mobile_phone = $request->input('number');
            $employee->employee_present_address = $request->input('present_address');
            $employee->employee_permanent_address = $request->input('permanent_address');
            $employee->save();
            Toastr::success('Profile information updated successfully.');
            return redirect()->back();
        }
        else
        {
            Toastr::error('Something went wrong');
            return redirect()->back();
        }
    }

    public function change_password(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ],[
            'confirm_password.same' => 'Confirm password field does not match.'
        ]);

        $staff = User::find($id);
        $staff->password = Hash::make($request->input('password'));

        if($staff->save())
        {
            Toastr::success('Your password is changed.');
            return redirect()->back();
        }
        else
        {
            Toastr::error('Something went wrong');
            return redirect()->back();
        }

    }

    public function staff_passed($id)
    {
        $user = User::find($id);

        $user->is_passed = 1;

        if($user->save())
        {
            Toastr::success('This employee is passed.');
            return back();
        }
        else
        {
            Toastr::error('Something went wrong.');
            return back();
        }
    }
}
