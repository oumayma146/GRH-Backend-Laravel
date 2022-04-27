<?php

namespace App\Http\Controllers;
use App\Http\Resources\SalaireResource;
use App\Models\Salaire;
use Illuminate\Http\Request;

class SalaireController extends Controller
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
            'salaires' => SalaireResource::collection(Salaire::all())
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
        $salaire = Salaire::create([
            'Datedebut'=>$request->Datedebut,
            'ChargePaterneles'=>$request->ChargePaterneles,
            'SalaireBrut'=>$request->SalaireBrut,
            'user_id'=> $request->get('user')

        ]);
        return response()->json(new SalaireResource($salaire), 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$salaire_id)
    {
        $updated = Salaire::where('id', $salaire_id)->update([
            'Datedebut'=>$request->Datedebut,
            'ChargePaterneles'=>$request->ChargePaterneles,
            'SalaireBrut'=>$request->SalaireBrut,
        ]);
        return response()->json([
            'status' => $updated
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salaire  $salaire
     * @return \Illuminate\Http\Response
     */
    public function destroy($salaire_id)
    {
        $deleted =  Salaire::find($salaire_id);
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