<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartification extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'date',
        'source',
        'user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
