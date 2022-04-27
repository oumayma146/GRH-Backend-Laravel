<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Resources\CongeeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Congee;


class CongeeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        return response()->json([
         'congees' => CongeeResource::collection(Congee::all())
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      
        $congee = Congee::create([
            'debut' => $request->debut,
            'fin' => $request->fin,
            'nbJour' => $request->nbJour,
            'typeCongee' => $request->typeCongee,
            'user_id'=> $request->get('user')
           
        ]);
 
       
        return response()->json(new CongeeResource($congee), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$congee_id)
    {
        $updated = Congee::where('id', $congee_id)->update([
            'debut' => $request->debut,
            'fin' => $request->fin,
            'nbJour' => $request->nbJour,
            'typeCongee' => $request->typeCongee,

        ]);
        return response()->json([
            'status' => $updated
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Congee  $congee
     * @return \Illuminate\Http\Response
     */
    public function destroy( $congee_id)
    {
        $deleted =  Congee::find($congee_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
    }
    

    /**
     * Respond with error.
     *
     * @param  string  $message
     * @param  int  $code
     * @return \Illuminate\Http\Response
     */
    private function error($message, $code = 401){
        return response()->json([
            'message' => $message
        ], $code);
    }
}
