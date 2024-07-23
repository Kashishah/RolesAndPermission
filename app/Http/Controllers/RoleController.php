<?php

namespace App\Http\Controllers;

// use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Validated;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // $permissions =Permission::with('roles')->get();
        $roles = Role::all();
        return view('roles-and-permission.roles.index'
                ,['roles' =>  $roles,
                    // 'permissions' => $permissions
                ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = DB::table('permissions')->pluck('name','name');
        return view('roles-and-permission.roles.create',['permissions' => $permissions]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
        $data = $request->validate([
            'permissions' => 'required',
            'name' => 'required|
                       unique:roles'
        ]);



        $role = Role::create(
            [ 'name' => $request->name]);
        

        $permissions = $request->permissions;
        $role->syncPermissions($permissions);

        $role->save();

        return redirect('roles')->with('status','Role successfully inserted');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        
        return view('roles-and-permission.roles.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|
                       unique:roles'
        ]);

        $role = Role::findOrfail($id);

        if($role){
            $role->update($data);
        }else{
        return redirect('roles')->with('status','Something is wrong Role cannot updated please try again');

        }

        
        return redirect('roles')->with('status','Role successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrfail($id);


        if($role){
            $role->delete();
        }else{
        return redirect('roles')->with('status','Something is wrong Role cannot be delete please try again');
        }

        return redirect('roles')->with('status','Role deleted successfully');
    }
}
