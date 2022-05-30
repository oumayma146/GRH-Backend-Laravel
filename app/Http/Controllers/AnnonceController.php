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
use Illuminate\Support\Facades\File;

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
            Storage::disk('public')->putFileAs('', $request->affiche,$imageName);
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
        $annonce=Annonce::findOrFail($annonce_id);
        
        $destination=public_path("public".$annonce->affiche);
        $filename="";
        if($request->hasFile('affiche')){
            if(File::exists($destination)){
                File::delete($destination);
            }

            $filename=$request->file('affiche')->store('','public');
        }else{
            $filename=$request->affiche;
        }
        $typeAnnonce = $request->get('typeAnnonce');

       
        $annonce->typeAnnonce()->sync($typeAnnonce);
      
        $annonce->titre=$request->titre;
        $annonce->resume=$request->resume;
        $annonce->date=$request->date;
        $annonce->affiche=$filename;
        $result=$annonce->save();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }

}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy($annonce_id)
    {
        $annonce=Annonce::findOrFail($annonce_id);
        $destination=public_path("public".$annonce->affiche);
        if(File::exists($destination)){
            File::delete($destination);
        }
        $result=$annonce->delete();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }
      /*   $deleted =  Annonce::find($annonce_id);
        $deleted->delete();
        return response()->json([
            'status' => $deleted ? 'success' : 'failed'
        ], 200);
       
    } */
   
}
