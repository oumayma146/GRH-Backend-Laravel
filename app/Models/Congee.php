<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Congee extends Model
{
    use HasFactory;
    protected $fillable = [
        'debut',
        'fin',
        'nbJour',
        'typeCongee',
        'user_id',
        
        
    ];
    
    protected $with = ['user'];
  
public function user(){
    return $this->belongsTo(User::class);
}
}