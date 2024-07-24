<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
// use Illuminate\Foundation\Auth\User;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

     public static function middleware(): array
     {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            'role_or_permission:Super-Admin|access UserController',
            new Middleware('role:Super-Admin', ['only'=> ['index','create','edit','store','update','destroy']]),
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('Super-Admin'), except:['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('access UserController'), ['only'=> ['index','create','edit','store','update','destroy']]),

            'role_or_permission:Staff|access UserController',
            new Middleware('role:Staff', ['only'=> ['index','show']]),
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('Staff'), except:['create','edit','store','update','destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('access UserController'), ['only'=> ['index','show']]),
        ];
     }

    public function index()
    {
        $users = User::get();
        return view('roles-and-permission.users.index',
                     ['users' => $users]
                    );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        return view('roles-and-permission.users.create',
                     ['roles'=> $roles]
                    );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:8|max:20',
            'roles' => 'required'
        ]);

        $user = User::create(
            [
                'name' => $request->name,
                'email'=> $request->email,
                'password' => Hash::make($request->password),
            ]);

        // synRoles() is a method of a SPATIE to assign a role to user  
        $user->syncRoles($request->roles);      //It will sync all roles of the user and store in model_has_roles  

        return redirect('users')->with('status','User succesfully created with roles');
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
    public function edit(User $user)
    {
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('roles-and-permission.users.edit',
                     ['user'=> $user , 'roles' => $roles , 'userRoles' => $userRoles]
                    );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email',
            'password' => 'nullable|min:8|max:20',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email'=> $request->email,
        ];

        if(!empty($request->password)){
            $data += ['password' => Hash::make($request->password)];
        }

        $user = User::findOrFail($id);
        
        if($user){
            $user->update($data);
            $user->syncRoles($request->roles);
            return redirect('users')->with('status','User succesfully updated with roles');
        }else{
            return redirect('users')->with('status','User not updated with roles');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        echo $id;
        $user = User::findOrFail($id);
        if($user){
            $user->delete();
            return redirect('users')->with('status','User succesfully deleted');        
        }else{
            return redirect('users')->with('status','User not deleted');        

        }

    }
}
