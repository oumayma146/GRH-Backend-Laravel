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
        $user =  User::without(['prenom','email','adresse','statu','genre','password','user_info','contrat','competance','langues','posts','education','cartification'])
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
        $langues = $postedata['langues'];
        $cartification = $postedata['cartification'];
        $education = $postedata['education'];
        $posts = $postedata['posts'];
        $competance = $postedata['competance'];
       
       //dd($postedata['roles']);
      //enregistrement user 
        $newuser = User::create([
            'name'=>$user['name'],
            'prenom'=>$user['prenom'],
            'email'=>$user['email'],
            'adresse'=>$user['adresse'],
            'statu'=>$user['statu'],
            'genre'=>$user['genre'],
            'password'=>$user['password'],
            'role_id'=>$user['role_id']
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
            //enregistrement role
            $ids_role = [];
            foreach($roles as $role){
               $newrole =  Role::create([
                'id'=>$role['id'],
                'user_id'=>$newuser['id'] ]);
                array_push($ids_role, $newrole['id']);
            }
            
  //enregistrement user langue
        $ids_langues = [];
        foreach($langues as $langue){
           $newlangue =  Langues::create([
            'nom'=>$langue['nom'],
            'user_id'=>$newuser['id'] ]);
            array_push($ids_langues, $newlangue['id']);
        }
       // dd($newInfo['id']);
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
         
      //enregistrement user competance

        $ids_competance = [];
        foreach($competance as $compt){
            //creation
           $newCompt =  Competance::create([
            'nomCompetence'=>$compt['nomCompetence'], 
            'user_id'=>$newuser['id'] ]);
            //push id of new competance
            array_push($ids_competance, $newCompt['id']);
        }
        
       /*  // liason 
      //  $user->user_info()->attach($newInfo['id']);
        $user->langues()->attach($ids_langues);
       // $user->contrat()->attach($newcontrats['id']);
        $user->education()->attach($ids_education);
        $user->cartification()->attach($ids_cartification);
        $user->posts()->attach($ids_post);
        $user->competance()->attach($ids_competance); */
        $user = User::find($newuser['id']) ;
        return response()->json(new UserSimpleResource($user), 200);
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $updated = User::where('id', $request->id)->update([
            'name'=>$request->name,
            'prenom'=>$request->prenom,
            'email'=>$request->email,
            'adresse'=>$request->adresse,
            'statu'=>$request->statu,
            'genre'=>$request->genre,
            'role'=>$request->role,
        ]);
        return response()->json([
            'status' => $updated
        ], 200);
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
