<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Role;
use App\Models\Contrat;
use App\Models\Congee;
class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'adresse',
        'statu',
        'genre',
        'password'
        
    ];

    /**
     * Add a mutator to ensure hashed passwords
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes["password"] = bcrypt($password);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
       // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array 
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = ['roles','user_info','contrat','competance','langues','posts','education','cartification'];
 

    

    public function roles()
    {
        return $this->belongsToMany('\App\Models\Role', 'user_has_roles', 'user_id', 'role_id')/* ->where('model_type','App\Models\User') */;
    }
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function user_info(){
        return $this->hasOne(User_info::class );
    }
    public function contrat(){
        return $this->hasOne(Contrat::class );
    }
    public function annonce(){
        return $this->hasmany(Annonce::class );
    }
    public function congee(){
        return $this->hasmany(Congee::class );
    }

    public function competance(){
        return $this->hasMany(Competance::class);
    }
    public function langues(){
        return $this->hasMany(Langues::class);
    }
    public function salaire(){
        return $this->hasMany(Salaire::class);
    }
    public function formation(){
        return $this->hasMany(Formation::class);
    }
    public function education(){
        return $this->hasMany(Education::class);
    }
    public function cartification(){
        return $this->hasMany(Cartification::class);
    }
}
