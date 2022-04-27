<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use DB;
use App\Http\Resources\FormateurResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Formateur;


class FormateurController extends Controller
{
    public function get()
    {
        $formateur = Formateur::orderBy('id');
            return response()->json([
                'formateur' => FormateurResource::collection(Formateur::all())
     
            ], 200);
    }
       /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $formateur_id)
    {      
        $deleted =  Formateur::find($formateur_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
     
        $formateur = Formateur::create([
            'nom'=>$request->nom,
            'specialité'=>$request->specialité,
            'numero'=>$request->numero,
        ]);
      
        
        return response()->json(new FormateurResource($formateur), 200);
    }
    public function getNom(Request $request)
    {
        $formateur =  Formateur::without(['specialité','numero'])
        ->get(array('id', 'nom'));
        return response()->json([
        'formateur'=>$formateur,
        
        ], 200); 
    }
    public function update(Request $request ,$formateur_id)
    {
        $updated = Formateur::where('id', $formateur_id)->update([
            'nom'=>$request->nom,
            'specialité'=>$request->specialité,
            'numero'=>$request->numero,
        ]);
        return response()->json([
            'status' => $updated
        ], 200);
    }

}
