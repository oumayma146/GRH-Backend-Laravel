<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'Datedebut',
        'ChargePaterneles',
        'SalaireBrut',
        'user_id',
        
    ];
    protected $with = ['user'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
