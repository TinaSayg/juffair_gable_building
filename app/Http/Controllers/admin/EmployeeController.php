<?php

namespace App\Http\Controllers\admin;

use Hash;
use Image;
use App\Models\Building;
use App\Models\Employee;
use App\Models\EmployeeType;
use Illuminate\Http\Request;
use App\Models\EmployeeStatus;
use App\Models\EmployeeDesignation;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Session;

class EmployeeController extends Controller
{
    public $building_id;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->building_id = Session::get('building_id');
    
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::where('building_id', $this->building_id)->orderBy('id','desc')->get();
        return view('admin.employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee_designations = EmployeeDesignation::all();
        $employee_types = EmployeeType::all();
        $employee_status = EmployeeStatus::all();
        return view('admin.employees.create',compact('employee_designations','employee_types','employee_status'));
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
            'employee_first_name' => 'required',
            'employee_last_name' => 'required',
            'employee_mobile_phone' => 'required|unique:employees,employee_mobile_phone',
            'employee_email_address' => 'required|string|unique:employees,employee_email_address',
            'employee_date_of_birth' => 'required',
            'employee_sallery' => 'required',
            'employee_present_address' => 'required',
            'employee_permanent_address' => 'required',
            'password' => 'required',
            'employee_designation_code' => 'required',
            'employee_cpr_no' => 'required|unique:employees,employee_cpr_no',
            'employee_start_datetime' => 'required',
            'employee_end_datetime' => 'required',
            'employee_emergancy_contact_number' => 'required',
            'employee_type_code' => 'required',
            'employee_status_code' => 'required',
            'employee_image' => 'required',
            'employee_passport_copy' => 'required',
            'employee_cpr_copy' => 'required',
            'passport_size_photo' => 'required',
            'employee_contract_copy' => 'required',
        ]);

        $employee = new Employee();
        $employee->employee_first_name = $request['employee_first_name'];
        $employee->employee_last_name = $request['employee_last_name'];
        $employee->employee_mobile_phone = $request['employee_mobile_phone'];
        $employee->employee_email_address = $request['employee_email_address'];
        $employee->building_id = $this->building_id;
        $employee->employee_sallery = $request['employee_sallery'];
        $employee->employee_present_address = $request['employee_present_address'];
        $employee->employee_permanent_address = $request['employee_permanent_address'];
        $employee->password = Hash::make($request['password']);
        $employee->employee_designation_code = $request['employee_designation_code'];
        $employee->employee_cpr_no = $request['employee_cpr_no'];
        $employee->employee_start_datetime = $request['staff_start_datetime'];
        $employee->employee_end_datetime = $request['staff_end_datetime'];

        $employee->employee_date_of_birth = $request['employee_date_of_birth'];
        $employee->employee_type_code = $request['employee_type_code'];
        $employee->employee_status_code = $request['employee_status_code'];

        //save employee image
        if($request->file('employee_image'))
        {
            $file_name = time().'_'.trim($request->file('employee_image')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_image')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/employee/'). $file_name);

            $employee->employee_image  = $file_name;
        }

        //save passport image
        if($request->file('employee_passport_copy'))
        {
            $file_name = time().'_'.trim($request->file('employee_passport_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_passport_copy')->getRealPath());
            $image->resize(600,500);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $employee->employee_passport_copy  = $file_name;
        }

        //save cpr copy
        if($request->file('employee_cpr_copy'))
        {
            $file_name = time().'_'.trim($request->file('employee_cpr_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_cpr_copy')->getRealPath());
            $image->resize(600,500);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $employee->employee_cpr_copy  = $file_name;
        }

        //save passport size photo
        if($request->file('passport_size_photo'))
        {
            
            $file_name = time().'_'.trim($request->file('passport_size_photo')->getClientOriginalName());
            
            $image = Image::make($request->file('passport_size_photo')->getRealPath());
            $image->resize(240,320);
            $image->save(public_path('admin/assets/img/passport/'). $file_name);

            $employee->passport_size_photo  = $file_name;
        }

        //save contract copy
        if($request->file('employee_contract_copy'))
        {
            $file_name = time().'_'.trim($request->file('employee_contract_copy')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_contract_copy')->getRealPath());
            $image->resize(600,500);
            $image->save(public_path('admin/assets/img/documents/'). $file_name);

            $employee->employee_contract_copy  = $file_name;
        }

        $employee->save();

        Toastr::success('Employee inserted successfully!');
        return redirect()->route('employee.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        $employee_types = EmployeeType::all();
        $employee_status = EmployeeStatus::all();
        return view('admin.employees.show',compact('employee','employee_types','employee_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $employee_types = EmployeeType::all();
        $employee_status = EmployeeStatus::all();

        return view('admin.employees.edit',compact('employee','buildings','employee_types','employee_status'));
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
            'employee_first_name' => 'required',
            'employee_last_name' => 'required',
            'employee_mobile_phone' => 'required|unique:employees,employee_mobile_phone,' . $id,
            'employee_email_address' => 'required|string|unique:employees,employee_email_address,' . $id,
            'employee_date_of_birth' => 'required',
            'employee_sallery' => 'required',
            'employee_present_address' => 'required',
            'employee_permanent_address' => 'required',
            'employee_designation_code' => 'required',
            'employee_cpr_no' => 'required|unique:employees,employee_cpr_no,' . $id,
            'employee_start_datetime' => 'required',
            'employee_end_datetime' => 'required',
            'employee_emergancy_contact_number' => 'required',
            'employee_type_code' => 'required',
            'employee_status_code' => 'required',
            'employee_image' => 'required',
            'employee_passport_copy' => 'required',
            'employee_cpr_copy' => 'required',
            'passport_size_photo' => 'required|dimensions:max_width=240,max_height=320',
            'employee_contract_copy' => 'required',
        ]);

        $employee = Employee::find($id);
        $employee->employee_first_name = $request['employee_first_name'];
        $employee->employee_last_name = $request['employee_last_name'];
        $employee->employee_mobile_phone = $request['employee_mobile_phone'];
        $employee->employee_email_address = $request['employee_email_address'];
        $employee->building_id = $this->building_id;
        $employee->employee_sallery = $request['employee_sallery'];
        $employee->employee_present_address = $request['employee_present_address'];
        $employee->employee_permanent_address = $request['employee_permanent_address'];
        $employee->employee_designation_code = $request['employee_designation_code'];
        $employee->employee_cpr_no = $request['employee_cpr_no'];
        $employee->employee_start_datetime = $request['employee_start_datetime'];
        $employee->employee_end_datetime = $request['employee_end_datetime'];
        $employee->employee_emergency_contact_number = $request['employee_emergancy_contact_number'];
        $employee->employee_date_of_birth = $request['employee_date_of_birth'];
        $employee->employee_type_code = $request['employee_type_code'];
        $employee->employee_status_code = $request['employee_status_code'];

        //save employee image
        if($request->file('employee_image'))
        {
            unlink(public_path('admin/assets/img/employee/'). $employee->employee_image);
            $file_name = time().'_'.trim($request->file('employee_image')->getClientOriginalName());
            
            $image = Image::make($request->file('employee_image')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/employee/'). $file_name);

            $employee->employee_image  = $file_name;
        }

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
        //save passport size photo
        if($request->file('passport_size_photo'))
        {
            unlink(public_path('admin/assets/img/passport_size_image/'). $employee->passport_size_photo);

            $file_name = time().'_'.trim($request->file('passport_size_photo')->getClientOriginalName());
            
            $image = Image::make($request->file('passport_size_photo')->getRealPath());
            $image->resize(240,320);
            $image->save(public_path('admin/assets/img/passport/'). $file_name);

            $employee->passport_size_photo  = $file_name;
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

        $employee->save();

        Toastr::success('Employee updated successfully!');
        return redirect()->route('employee.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        $employee->delete();

        Toastr::success('Employee deleted successfully!');
        return back();
    }
}
