<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use DB;
use App\Http\Resources\FormationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Response;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $formation = Formation::orderBy('id');
            return response()->json([
                'formation' => FormationResource::collection(Formation::all())
     
            ], 200);
    }

    public function getFormateurInfo($formation_id)
    {
        $formation = Formation::findOrFail($formation_id);
        $formation->load('formateurs');
        $formateurs = $formation->formateurs;
        return response()->json([
            'formateurs' => $formateurs
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
        $formation = Formation::create([
            'date' => $request->date,
            'nbHeure' => $request->nbHeure,
            'titre' => $request->titre,
            'local' => $request->local,
            'prix' => $request->prix,
            'type_payement' => $request->type_payement,
         ]);
        $formateurs = json_decode($request->get('formateurs'),true);

       foreach($formateurs as $form_id)
          $formation->formateurs()->attach([$form_id]);

          return (new FormationResource($formation))
               ->response()
               ->setStatusCode(Response::HTTP_CREATED);
    
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $formation_id)
    {
        $updatedFormation = Formation::where('id', $formation_id)->update([
            'date' => $request->date,
            'nbHeure' => $request->nbHeure,
            'titre' => $request->titre,
            'local' => $request->local,
            'prix' => $request->prix,
            'type_payement' => $request->type_payement]);
        //get formation with updates
        $formation = Formation::find($formation_id);
        $ids = $request->formateurs ;
        $formation->formateurs()->sync($ids);
        
        return response()->json([
            'status' => $formation
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $formation_id)
    {
        $deleted =  Formation::find($formation_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
    }

}
