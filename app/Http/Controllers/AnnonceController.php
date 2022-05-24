<?php

namespace App\Http\Controllers;
use App\Http\Resources\AnnonceResource;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {

        $annonce = Annonce::orderBy('id');
        return response()->json([
            'annonces' => AnnonceResource::collection(Annonce::all())
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

   

        try{
            $imageName =Str::random().'.'.$request->affiche->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('annonce/image/', $request->affiche,$imageName);
                $annonce= Annonce::create([
                    'titre' => $request->titre,
                    'resume' => $request->resume,
                    'date' => $request->date,
                    'affiche'=>$imageName,
                ]);
            $typeAnnonce = json_decode($request->get('typeAnnonce'),true);
        
            foreach($typeAnnonce as $type)
            $annonce->typeAnnonce()->attach([$type]);
          
    
            return response()->json([
                
                new AnnonceResource($annonce),
                'message'=>'annonce Created Successfully!!'
            ]);
         
     
     }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while creating a annonce!!'
            ],500);
        }  

    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $annonce_id)
    {
        $annonce = Annonce::where('id', $annonce_id)->update([
            'titre' => $request->titre,
            'resume' => $request->resume,
            'date' => $request->date,
       
        ]);

  //try{

        if($request->hasFile('affiche')){

            // remove old image
            if($annonce->affiche){
                $exists = Storage::disk('public')->exists("annonce/image/{$annonce->affiche}");
                if($exists){
                    Storage::disk('public')->delete("annonce/image/{$annonce->affiche}");
                }
            }
          
            $imageName =Str::random().'.'.$request->affiche->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('annonce/image/', $request->affiche,$imageName);
            $annonce->affiche = $imageName;
            $annonce->save();
        }

  $annonce = Annonce::find($annonce_id);
  $ids = $request->typeAnnonce ;
  $annonce->typeAnnonce()->sync($ids);
  
        return response()->json([
            'message'=>'annonce Updated Successfully!!'
        ]);

  /* }catch(\Exception $e){
        \Log::error($e->getMessage());
        return response()->json([
            'message'=>'Something goes wrong while updating a annonce!!'
        ],500);
    }  */
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy($annonce_id)
    {
        $deleted =  Annonce::find($annonce_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
       
    }
   
}
