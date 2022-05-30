<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competance extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomCompetence',
      
    ];
    
    public function user(){
        return $this->belongsToMany(User::class);
    }
}
