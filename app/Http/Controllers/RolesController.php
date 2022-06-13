<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Http\Resources\RolesResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

    }
    public function normalRoles(){
        return response(Role::where('slug','!=','admin')->get());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $roles = Role::orderBy('id');
        $roles->with('permissions');
            return response()->json([
                'roles' => RolesResource::collection(Role::all())
     
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function createPermisson()
    {
        $permissions = Permission::get();
        return response()->json([
            'permission' => $permissions
        ], 200); 
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
      $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]); 
        $title = $request->get('name');
        $slug = Str::slug($title);
        $permissions = json_decode($request->get('permission'),true);
        $role = Role::create(['name' => $title,'slug' => $slug]);
      
       foreach($permissions as $perm_id)
          $role->permissions()->attach([$perm_id]);

          return (new RolesResource($role))
               ->response()
               ->setStatusCode(Response::HTTP_CREATED);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
 
   
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRolePermission($role_id)
    {
        $role = Role::findOrFail($role_id);
        $role->load('permissions');
        $permissions = $role->permissions->pluck('name')->toArray();
        return response()->json([
            'permissions' => $permissions
        ], 200); 
    }
  
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($role_id, Request $request)
    {
    $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]); 
        
        $role = Role::findOrFail($role_id);
        $data = ['name' => $request->get('name')];
        $permissions = $request->get('permission');
        $role->update($data);
        $role->permissions()->detach();

        foreach($permissions as $perm_id)
          $role->permissions()->attach([$perm_id]);
  
     
          return (new RolesResource($role))
               ->response()
               ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role_id)
    {
                        
        $deleted =  Role::find($role_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
    }
}
