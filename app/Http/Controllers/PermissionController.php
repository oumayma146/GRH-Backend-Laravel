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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    public function get(Request $request)
    {   
      
        $permissions = Permission::get();
        return response()->json([
            'permission' => $permissions
        ], 200); 
    }
    public function create(Request $request)
    {
        $permissions = Permission::create([
            'name'=>$request->name,
          

        ]);
        return response()->json([ 'permission' => $permissions], 201);
    }


   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salaire  $salaire
     * @return \Illuminate\Http\Response
     */
    public function destroy($permission_id)
    {
        $deleted =  Permission::find($permission_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
    }

}
