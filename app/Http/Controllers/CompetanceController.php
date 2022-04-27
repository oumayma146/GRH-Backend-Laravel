<?php

namespace App\Http\Controllers;
use App\Http\Resources\CompetanceResource;
use App\Models\Competance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image ;
class CompetanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {

        $competance = Competance::orderBy('id');
        return response()->json([
            'competance' => CompetanceResource::collection(Competance::all())
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $competance = Competance::create([
                'nomCompetence' => $request->nomCompetence,
                
                
             ]);
        
             return response()->json([
                'competance' => $competance
            ], 200);
     

    }



  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy($annonce_id)
    {
        $deleted =  Competance::find($annonce_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
    }

   
}