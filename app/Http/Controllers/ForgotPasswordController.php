<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use App\User;

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
    



   public function reset(Request $request) {
       
    $credentials =request()->validate( [
          
        'email' => 'required|email',
          'password' => 'min:6|required_with:password_confirmation',
        'password_confirmation' => 'min:6',
        'token' => 'required|string'
        ]);
    
     //dd($credentials);
  
    $credentials['password'] = Hash::make($request->password);
    $credentials['password_confirmation'] = Hash::make($request->password_confirmation);

    // dd($credentials);
     
    $reset_password_status = Password::reset($credentials, function($user, $password) {
       
    
        $user->password = $password;
        
        $user->save();

    });
    // dd($reset_password_status);
  
    
    if ($reset_password_status == Password::INVALID_TOKEN) {
        return response()->json(["msg" => "Invalid token provided",'status'=>'404','data'=>'']);
    }

    return response()->json(["msg" => "Password has been successfully changed",'status'=>'200','data'=>'']);
}
      
   /*  $request->validate([
        'email' => 'required|email|exists:users',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',

    ]);

    $updatePassword = DB::table('password_resets')
                        ->where(['email' => $request->email, 'token' => $request->token])
                        ->first();

    if(!$updatePassword)
        return back()->withInput()->with('error', 'Invalid token!');

      $user = User::where('email', $request->email)
                  ->update(['password' => Hash::make($request->password)]);

      DB::table('password_resets')->where(['email'=> $request->email])->delete();

        // dd($reset_password_status);

        return response()->json(["msg" => "Password has been successfully changed",'status'=>'200','data'=>'']);
    }
 */

}