<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\RolePermissions;

class RoleController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_role', ['only'=>'index', 'show']);
    $this->middleware('permission:add_role', ['only'=>'create', 'store']);
    $this->middleware('permission:edit_role', ['only'=>'edit', 'update']);
    $this->middleware('permission:delete_role', ['only'=>'destroy']);
  }
    public function index()
    {
        $roles = Role::whereNotIn('id', [1])->paginate(15);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['title']);
        $role = Role::create($data);
        $permissions = $request['permissions'];
        foreach ($permissions as $permission) {
            $permission = Permission::where('id', '=', $permission)->firstOrFail();
            $role->permissions()->detach($permission->id);
            $role->permissions()->attach($permission->id);
        }
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('roles.index')->with($notification);
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
    public function edit(Role $role)
    {
        $permissions = RolePermissions::where('role_id', $role->id)->get();
        $arrPermissions = [];
        foreach ($permissions as $permission) {
            $arrPermissions[] =  $permission->permission_id;
        }
        return view('admin.roles.edit', compact('role','arrPermissions'));
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
            $role = Role::findOrFail($id);
            $data = $request->only(['title']);
            $role->update($data);
        
        
        $permissions = $request['permissions'];
        $role->permissions()->sync($permissions);
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('roles.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
