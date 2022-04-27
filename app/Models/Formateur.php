<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'specialité',
        'numero',
        
    ];
    public function Formation(){
        return $this->belongsToMany(Formation::class);
    }
}
