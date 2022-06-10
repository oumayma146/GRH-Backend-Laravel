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

        $user_info_id =  $user_info['id'];
        $contart_id =  $contrat['id'];

        $old_user=User::findOrFail($id) ;
        $old_user_info=User_info::findOrFail($user_info_id) ;
        $old_contrat= Contrat::findOrFail($contart_id) ;

        $old_user->update($user);
        $old_user_info->update($user_info);
        $old_contrat->update($contrat);

        foreach($cartification as $certif){
            $id_certif = $certif['id'];
            $old_certif =Cartification::findOrFail($id_certif) ;
            $old_certif->update($certif);
        }

        foreach($education as $educ){
            $id_educ = $educ['id'];
            $old_educ =Education::findOrFail($id_educ) ;
            $old_educ->updateOrCreate($educ);
        }
   
        foreach($posts as $post){
            $id_post = $post['id'];
            $old_post =Post::findOrFail($id_post) ;
            $old_post->update($post);
        }

        $newuser = User::findOrFail($id) ; 
        $newuser->roles()->sync($role_id);
        $newuser->langues()->sync($langue_ids) ;                                                                                                                                                                    
        $newuser->competance()->sync($competance_ids); 
        if($old_user){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }

        
     
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
