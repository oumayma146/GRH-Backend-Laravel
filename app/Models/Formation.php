<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'nbHeure',
        'titre',
        'local',
        'prix',
        'type_payement',
        'user_id',
        
    ];
    protected $with = ['formateurs'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function formateurs(){
        return $this->belongsToMany('App\Models\Formateur','formation_has_formateur','formation_id','formateur_id');
    }
}
