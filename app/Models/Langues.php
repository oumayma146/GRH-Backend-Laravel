<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langues extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
       
    ];
    
    public function user(){
        return $this->belongsToMany(User::class);
    }
}
