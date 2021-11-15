<?php

namespace App\Http\Controllers\admin;

use App\Models\Role;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.role.create');
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
            'name' => 'required|string|max:100|unique:roles,name',
            'slug' => 'required|string|unique:roles,slug',
        ]);

        $role = new Role();
        $role->name = $request['name'];
        $role->slug = $request['slug'];

        if($role->save())
        {
            Toastr::success('Role added successfully!');
            return redirect()->route('role.list');
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
        $role = Role::find($id);

        return view('admin.role.edit', compact('role'));
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
            'name' => 'required|string|unique:roles,name,' . $id,
            'slug' => 'required|string|unique:roles,slug,' . $id,
        ]);

        $role = Role::find($id);
        
        $role->name = $request['name'];
        $role->slug = $request['slug'];

        if($role->save())
        {
            Toastr::success('Role update successfully!');
            return redirect()->route('role.list');
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
        $role = Role::find($id);
        $role->delete();

        Toastr::success('Role deleted successfully!');
        return redirect()->route('role.list');
    }

    public function assignPermission(Request $request,$id)
    {
        
        $modules = Module::orderBy('id', 'asc')->get()->toArray();
        $result = [];
  
        foreach ($modules as $item){
        
         
                $permission = DB::table('permissions')
                ->select('permissions.*','roles_permissions.*')
                ->leftJoin("roles_permissions",function($join) use($id) {
                    $join->on("roles_permissions.permission_id","=","permissions.id")
                        ->on("roles_permissions.role_id","=",DB::raw($id));
                })
                ->where('permissions.module_id', $item['id'])
                ->orderBy('permissions.name')
                ->get()->toArray();
            $result[] = array(
                'module' => $item,
                'permission' => $permission
            );
        }
        // echo "<pre>";
        // print_r($role); exit;
        if ($request->ajax()) {
            
                $role = Role::where('id',$request->id)->first();
                $permission = Permission::where('id', $request->value)->first();
              
                if($request->checked == "Yes"){
                    $permission->roles()->attach($role);
                   
                }
                else{
                    $permission->roles()->detach($role);
                }
        }
           
    
        return view('admin.role.assign-permission')->with('modules',$result);
    }
}
