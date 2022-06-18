<?php

namespace App\Http\Controllers;
use App\Models\Congee;
use App\Models\Annonce;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
class ChartController extends Controller
{
    public function Piechart(Request $request)
    {
    	$maternity = Congee::where('typeCongee','congé de maladie')->get();
    	$sick = Congee::where('typeCongee','Congé sans solde')->get();
    	$Unpaid = Congee::where('typeCongee','congé maternité')->get();
    	$maternity_count = count($maternity);    	
    	$sick_count = count($sick);
    	$Unpaid_count = count($Unpaid);
        return response()->json([
             $maternity_count ,
             $sick_count,
         $Unpaid_count,
           ], 200);
    
    }
    public function Donutchart(Request $request)
    {
        $check = Formation::where('type_payement','check')->get();
    	$cash = Formation::where('type_payement','cash')->get();
    	$Bank_cards = Formation::where('type_payement','Bank cards')->get();
    	$check_count = count($check);    	
    	$cash_count = count($cash);
    	$Bank_cards_count = count($Bank_cards);
        return response()->json([
            $check_count ,
           $cash_count,
           $Bank_cards_count,
           ], 200); 
        }
}