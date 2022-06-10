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

// Generate PDF
public function generatePDF($congee_id) {

 
    $doc = $this->pdf_congee($congee_id);
    $doc = preg_replace('/>\s+</', "><",$doc);
    $dompdf = \App::make('dompdf.wrapper');
    $dompdf->loadHTML($doc,'UTF-8');
    $dompdf->setPaper("portrait");
    $pdf_name = 'DemandeCongee-'.$congee_id.'.pdf';
   // return $dompdf->download($pdf_name);
    return $dompdf->stream($pdf_name,array('Attachment'=>0));
  }
  public function pdf_congee($congee_id) {
    $congee = Congee::where('id', $congee_id)->first(); 
    $congee->load('user');
    return \View::make('CongePDF',compact('congee'))->render();
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
            'user_id'=>$request->user_id,

        ]);

            return response()->json(['success'=>true],200);
        
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
