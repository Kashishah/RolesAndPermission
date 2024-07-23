<?php

namespace App\Http\Controllers;

// use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // echo "In";
        $permissions = Permission::all();
        return view('roles-and-permission.permissions.index',compact('permissions')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles-and-permission.permissions.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|
                       unique:permissions'
        ]);
        
        $permission = Permission::create($data);
        
        $permission->save();

        return redirect('permissions')->with('status','Permission successfully inserted');
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
        $permission = Permission::findOrFail($id);
        
        return view('roles-and-permission.permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|
                       unique:permissions'
        ]);

        $permission = Permission::findOrfail($id);

        if($permission){
            $permission->update($data);
        }else{
        return redirect('permissions')->with('status','Something is wrong Permission cannot updated please try again');

        }

        
        return redirect('permissions')->with('status','Permission successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrfail($id);


        if($permission){
            $permission->delete();
        }else{
        return redirect('permissions')->with('status','Something is wrong Permission cannot be delete please try again');
        }

        return redirect('permissions')->with('status','Permission deleted successfully');
    }
}
