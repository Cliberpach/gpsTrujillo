<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission\Models\Permission;
use App\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use function PHPSTORM_META\map;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      return view('roles.index');
    }
    public function getTable()
    {
        return datatables()->query(DB::table('roles')->select('roles.*')->orderBy('roles.id', 'desc'))->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('haveaccess','roles.create');
        $action = route('roles.store');
        $role = new Role();
        $permissions_role=[];
        $permissions=Permission::get();
        return view('roles.create',compact('permissions','action','role','permissions_role'));
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
            'name'=>'required|max:50|unique:roles,name',
            'slug'=>'required|max:50|unique:roles,slug',
            'full-access'=>'required|in:yes,no',
            'description'=>'required'
        ]);
        $role=Role::create($request->all());
        if($request->get('permission'))
        {
            $role->permissions()->sync($request->get('permission'));
        }
        else
        {
            $role->permissions()->detach();
        }
        return redirect()->route('roles.index');
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
        $role= Role::findOrFail($id);
        $permissions_role=[];
        foreach($role->permissions as $permission)
        {
            $permissions_role[]=$permission->id;
        }
        //return $permissions_role;
        $permissions=Permission::get();
        $put = True;
        $action = route('roles.update', $id);
        return view('roles.edit', [
            'role' => $role,
            'action' => $action,
            'put' => $put,
            'permissions'=>$permissions,
            'permissions_role'=>$permissions_role
        ]);
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


        $role= Role::findOrFail($id);
        $request->validate([
            'name'=>'required|max:50|unique:roles,name,'.$id,
            'slug'=>'required|max:50|unique:roles,slug,'.$id,
            'full-access'=>'required|in:yes,no',
            'description'=>'required'
        ]);
        $role->update($request->all());
        if($request->get('permission'))
        {
            $role->permissions()->sync($request->get('permission'));
        }
        else
        {
            $role->permissions()->detach();
        }
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role= Role::findOrFail($id);
        if($role->eliminar=="yes")
        {
         $role->delete();   
        }
        return redirect()->route('roles.index');
    }
}
