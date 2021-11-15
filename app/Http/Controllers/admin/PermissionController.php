<?php

namespace App\Http\Controllers\admin;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::orderBy('module_id')->get();
        
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();

        return view('admin.permission.create', compact('modules'));
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
            'module'=>['required'],
            'Permission_name' => ['required'],
            'Permission_slug' => ['required'],
        ]);

        foreach ($request['Permission_name'] as $key=>$Permission){
            $permission=Permission::where('name',$request['Permission_name'][$key])->get();
            if($permission->isEmpty()){    
                $permission=new Permission ();
                $permission->module_id=$request['module'];
                $permission->name=$request['Permission_name'][$key];
                $permission->slug=$request['Permission_slug'][$key];
                $permission->save();
            }else{
                Toastr::success('Permission already added.');
                return redirect()->route('permission.create');
            }

            
        }

        Toastr::success('Permission added successfully!'); 
        return redirect()->route('permission.list');                  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        $modules = Module::all();
        return view('admin.permission.edit', compact('permission','modules'));
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
            'module'=>['required'],
            'Permission_name' => ['required'],
            'Permission_slug' => ['required'],
        ]);

        $permission = Permission::where('name',$request['Permission_name'])->where('id','!=', $id)->get();
        if($permission->isNotEmpty())
        {
            Toastr::success('Permission already added with this name!'); 
            return redirect()->route('permission.edit',$id); 
        }
        else
        {
            $permission= Permission::find($id);
            $permission->module_id=$request['module'];
            $permission->name=$request['Permission_name'];
            $permission->slug=$request['Permission_slug'];
            $permission->save();

            Toastr::success('Permission updated successfully!'); 
            return redirect()->route('permission.list');
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
        $permission = Permission::find($id);
        $permission->delete();

        Toastr::success('Permission deleted successfully!');
        return redirect()->route('permission.list');
    }
}
