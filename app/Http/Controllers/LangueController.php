<?php

namespace App\Http\Controllers;
use App\Http\Resources\langueResource;
use App\Models\Langues;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image ;
class LangueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {

        $langue = Langues::orderBy('id');
        return response()->json([
            'langue' =>   langueResource::collection(Langues::all())
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
            $langue = Langues::create([
                'nom' => $request->nom,
             ]);
             return response()->json([
                'langue'=>$langue,
                
                ], 200); 
   
    


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy($langue_id)
    {
        $deleted =  Langues::where('id', $langue_id)->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
    }

   
}