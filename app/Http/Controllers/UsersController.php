<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Http\Resources\UserSimpleResource;
use App\Http\Resources\UserInfoResource;
use App\Models\User;
use App\Models\User_info;
use App\Models\Contrat;
use App\Models\Langues;
use App\Models\Education;
use App\Models\Cartification;
use App\Models\Post;
use App\Models\Competance;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
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
            'users' => UserSimpleResource::collection(User::all())
        ], 200);
    }

    public function get_employees(Request $request)
    {
        $users = User::whereHas('roles',function($q){ $q->where('slug','employee'); })->get();
        return response()->json([
            'users' => $users
        ], 200); 
    }
    public function getemployee(Request $request)
    {
        $user =  User::without(['prenom','email','adresse','statu','genre','password','user_info','contrat','competance','langues','posts','education','cartification','password'])
        ->whereHas('roles',function($q){
             $q->where('slug','employee'); })->get(array('id', 'name'));
        return response()->json([
        'user'=>$user,
        
        ], 200); 
    }
    
    public function getEmployeeInfo($user_id)
    {
        $user_info = User::findOrFail($user_id);
        return response()->json([
               'user_info' => $user_info
        ], 200); 
    }
    

 
    public function create(Request $request)
    {   
        $postedata = $request->all();
        $user = $postedata['user'];
        $user_info = $postedata['user_info'];
        $contrat = $postedata['contrat'];
       
        $cartification = $postedata['cartification'];
        $education = $postedata['education'];
        $posts = $postedata['posts'];
     
        $role_id = $postedata['role_id'];
        $langue_ids = $postedata['langue_ids'];
        $competance_ids = $postedata['competance_ids'];
     
      //enregistrement user 
        $newuser = User::create([
            'name'=>$user['name'],
            'prenom'=>$user['prenom'],
            'email'=>$user['email'],
            'adresse'=>$user['adresse'],
            'statu'=>$user['statu'],
            'genre'=>$user['genre'],
            'password'=>$user['password'],
        ]);
        //enregistrement user onfos
        $newInfo =  User_info::create([
            'numeroCIN'=>$user_info['numeroCIN'],
            'numeroCarteBancaire' => $user_info['numeroCarteBancaire'],
            'numeroTelephone'=> $user_info['numeroTelephone'],
            'user_id'=>$newuser['id']
         ]);
           //enregistrement contart
           $newcontrats =  Contrat::create([
            'debutdate'=>$contrat['debutdate'],
            'findate' => $contrat['findate'],
            'matricule'=> $contrat['matricule'] ,
            'nbheure'=> $contrat['nbheure'] ,
            'typeContart'=> $contrat['typeContart'],
            'user_id'=>$newuser['id'] ]);
           
 
    //enregistrement user education

        $ids_education = [];
        foreach($education as $edu){
           $newdiplome =  Education::create([
            'diplome'=>$edu['diplome'],
            'user_id'=>$newuser['id'] ]);
            array_push($ids_education, $newdiplome['id']);
        }
    //enregistrement user cartification

        $ids_cartification = [];
        foreach($cartification as $cart){
           $newCart =  Cartification::create([
            'titre'=>$cart['titre'],
            'date' => $cart['date'],
            'source'=> $cart['source'] ,
            'user_id'=>$newuser['id'] ]);
            array_push($ids_cartification, $newCart['id']);
        }
    //enregistrement user posts
    $ids_post = [];
    foreach($posts as $post){
           $newPost =  Post::create([
            'title'=>$post['title'],
            'description' => $post['description'],
            'user_id'=>$newuser['id'] ]);
            array_push($ids_post, $newPost['id']);
        }
         
     
        $user = User::find($newuser['id']) ;
        $user->roles()->sync($role_id);
        $user->langues()->sync($langue_ids);
        $user->competance()->sync($competance_ids);
        return response()->json(new UserSimpleResource($user), 200);
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$id)
    {    
        /*
        ** this is how to validate payloads before you work with them 
        
            $Validation = Validator::make($request->all(),[
                'xyz' =>['required','string','max:500']
            ]);
            if($Validation->fails())
                return response($Validation->errors());
        */  
        $old_user=User::find($id);
        // making sure that the user exists before doing any work
        if(!$old_user)
            return response(['success'=>false,'message'=>'user not found'],404);
        // i guess the test here of the findorfail is pointless since a use is sure to have user_info and a Contract
        $old_user_info=User_info::findOrFail(request('user_info')['id']);
        $old_contrat= Contrat::findOrFail(request('contrat')['id']);
        // starting the update process
        $old_user->update(request('user'));
        $old_user_info->update(request('user_info'));
        $old_contrat->update(request('contrat'));
        $old_user->roles()->sync(request('role_id'));
        $old_user->langues()->sync(request('langue_ids'));
        $old_user->competance()->sync(request('competance_ids'));

        foreach(request('cartification') as $certif){
            if(!array_key_exists('id',$certif))
                Cartification::create(array_merge($certif,['user_id'=> $id]));
            else
                Cartification::where('id',$certif['id'])->update($certif);
        }
        foreach(request('education') as $educ){
            if(!array_key_exists('id',$educ))
                Education::create(array_merge($educ,['user_id'=> $id]));
            else
                Education::where('id',$educ['id'])->update($educ);
        }
        foreach(request('posts') as $post){
            if(!array_key_exists('id',$post))
                Post::create(array_merge($post,['user_id'=> $id]));
            else
                Post::where('id',$post['id'])->update($post);
        }
        // this will be reached only if everything went according to plan
        return response(['success'=>true,'message'=>'user updated successfully!']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
 
        $deleted =  User::find($user_id);
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
