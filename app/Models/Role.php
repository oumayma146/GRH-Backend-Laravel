<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'guard_name',
        'slug'
    ];

    protected $with = ['permissions'];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission','role_has_permissions','role_id','permission_id');
    }
    
}
