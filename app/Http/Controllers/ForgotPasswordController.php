<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
  
    public function forgot(Request $request) {
         $credentials = request()->validate(['email' => 'required|email']);
        // dd($credentials);
    Password::sendResetLink($credentials);

    return response()->json(["msg" => 'Reset password link sent on your email id.','status'=>'200','data'=>'']);
} 


     /*    $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send( 'auth.verify', ['token' => $token], function($message) use ($request) {
                  $message->from($request->email);
                  $message->to('oumaima.loussaif97@gmail.com');
                  $message->subject('Reset Password Notification');
               });

        return response()->json(["msg" => 'Reset password link sent on your email id.','status'=>'200','data'=>'']); 
            }*/
    



   public function reset(Request $request) 
   {
       
    $Validation = Validator::make($request->all(),[
        'email' => 'required|email',
        'password' => 'min:6|confirmed',
        'token' => 'required|string'
    ]);
    if($Validation->fails())
        return response($Validation->errors());
    
    $updated = User::where('email',request('email'))->update(['password'=> Hash::make($request->password)]);
    

    if (!$updated) {
        return response()->json(["msg" => "Invalid token provided",'status'=>'404','data'=>'']);
    }

    return redirect()->away('http://localhost:3000/login');
    }

}