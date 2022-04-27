<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class Contrat extends Model
{  use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'debutdate',
        'findate',
        'matricule',
        'nbheure',
        'typeContart',
        'user_id',
       
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class );
    }
}
