<?php

namespace App\Http\Controllers;

// use App\Models\Role;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:Delete Permission', ['only' => ['destroy']]);
        $this->middleware('permission:Edit Permission', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Create Permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:View Permission', ['only' => ['view']]);
        $this->middleware('permission:Index Permission', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $roles = Role::paginate(3);

        return view(
            'roles-and-permission.roles.index',
            [
                'roles' =>  $roles,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = DB::table('permissions')->pluck('name', 'name');
        return view('roles-and-permission.roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $data = $request->validate([
            'permissions' => 'required|array',
            'name' => 'required|
                       unique:roles'
        ]);



        $role = Role::create(
            ['name' => $request->name]
        );


        $permissions = $request->permissions;
        $role->syncPermissions($permissions);

        $role->save();

        return redirect('roles')->with('status_success', 'Role successfully inserted');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function compareRole($rolename)
    {
        $user = Auth::user();
        $loggedInUserRoleName = $user->roles->pluck('name', 'name');
        foreach ($loggedInUserRoleName as $role) {
            $loggedInUserRole = $role;
        }
        if ($loggedInUserRole === $rolename) {
            return true;
        }
        return false;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $compareRole = $this->compareRole($role->name);
        if ($compareRole == true) {
            return redirect()->route('roles.index')->with('status_error', 'You can\'t update your own role and permission');
        } else {
            $rolePermissions = DB::table('role_has_permissions')
                ->where('role_has_permissions.role_id', $role->id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();

            return view(
                'roles-and-permission.roles.edit',
                [
                    'role' => $role,
                    'rolePermissions' => $rolePermissions,
                    'permissions' => $permissions
                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrfail($id);

        $permissions = $request->permissions;


        if ($role) {
            $role->syncPermissions($permissions);
            $role->update(['name' => $request->name]);
            return redirect('roles')->with('status_success', 'Role successfully updated');
        } else {
            return redirect('roles')->with('status_error', 'Something is wrong Role cannot updated please try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrfail($id);

        $compareRole = $this->compareRole($role->name);
        if ($compareRole == true) {
            return redirect()->route('roles.index')->with('status_error', 'You can\'t delete your own role and permission');
        } else {
            if ($role) {
                $role->delete();
                return redirect('roles')->with('status_success', 'Role deleted successfully');
            } else {
                return redirect('roles')->with('status_error', 'Something is wrong Role cannot be delete please try again');
            }
        }
    }


    public function checkRole(Request $request)
    {
        $roleName =  $request->input('roleName');   
        $roleExists = Role::where('name', $roleName)->exists();
        return response()->json(['exists' => $roleExists]);
    }
}
