<?php

namespace App\Http\Controllers\admin;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\RolesPermission;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();
        return view('admin.Module.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Module.create');
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
            'name' => 'required|string|max:100|unique:modules,name',
        ]);

        $module = new Module();
        $module->name = $request['name'];
        $module->status = 1;
        

        if($module->save())
        {
            Toastr::success('Module added successfully!');
            return redirect()->route('module.list');
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
        $module = Module::find($id);

        return view('admin.Module.edit', compact('module'));
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
            'name' => 'required|string|max:100|unique:modules,name,' . $id,
        ]);

        $module = Module::find($id);
        $module->name = $request['name'];
        $module->status = 1;
        

        if($module->save())
        {
            Toastr::success('Module updated successfully!');
            return redirect()->route('module.list');
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
        
        $module = Module::find($id);
        $module->delete();
        
        // Permission::where('module_id', $id)->delete();
        // $permission_list = Permission::where('module_id', $id)->pluck('id')->toArray();
        // RolesPermission::whereIn('permission_id', $permission_list)->delete();

        Toastr::success('Module deleted successfully!');
        return redirect()->route('module.list');
    }
}
