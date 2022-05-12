<?php

namespace App\Http\Controllers;
use App\Http\Resources\AnnonceResource;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image ;
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
        $request->validate([
            'titre'=>'required',
            'resume'=>'required',
            'date'=>'required',
            'affiche'=>'required|affiche'
        ]);
    
        try{
            $image_file=$request->affiche;
            $imageName = time().'_'.$image_file->getClientOriginalName();
            Storage::disk('public')->putFileAs('annonce/image/', $image_file,$imageName);
            $annonce= Annonce::create($request->post()+['affiche'=>'annonce/image/'.$imageName]);
            $typeAnnonce = json_decode($request->get('typeAnnonce'),true);
        
            foreach($typeAnnonce as $type)
            $annonce->typeAnnonce()->attach([$type]);
          
    
            return (new AnnonceResource($annonce))
          ->response()
          ->setStatusCode(Response::HTTP_CREATED);
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
    public function update(Request $request , Annonce $annonce)
    {
       /*  $updated = Annonce::where('id', $request->id)->update([
            "titre" => $request->titre,
            "resume" => $request->resume,
            "date" => $request->date,
            "affiche" => $request->affiche,         
        ]);
       
        return response()->json([
            'status' => $updated
        ], 200);
    } */
    $request->validate([
        'titre'=>'required',
        'resume'=>'required',
        'date'=>'required',
        'affiche'=>'nullable'
    ]);

    try{

        $annonce->fill($request->post())->update();

        if($request->hasFile('affiche')){

            // remove old image
            if($annonce->affiche){
                $exists = Storage::disk('public')->exists("annonce/image/{$product->affiche}");
                if($exists){
                    Storage::disk('public')->delete("annonce/image/{$product->affiche}");
                }
            }
            $image_file=$request->affiche;
            $imageName = Str::random().'.'.$image_file->getClientOriginalName();
            Storage::disk('public')->putFileAs('annonce/image', $image_file,$imageName);
            $annonce->affiche = $imageName;
            $annonce->save();
        }

        return response()->json([
            'message'=>'annonce Updated Successfully!!'
        ]);

    }catch(\Exception $e){
        \Log::error($e->getMessage());
        return response()->json([
            'message'=>'Something goes wrong while updating a annonce!!'
        ],500);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annonce $annonce)
    {
      
        {
            try {
    
                if($annonce->affiche){
                    $exists = Storage::disk('public')->exists("annonce/image/{$annonce->affiche}");
                    if($exists){
                        Storage::disk('public')->delete("annonce/image/{$annonce->affiche}");
                    }
                }
    
                $annonce->delete();
    
                return response()->json([
                    'message'=>'annonce Deleted Successfully!!'
                ]);
                
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while deleting a product!!'
                ]);
            }
        }
    }
   
}
