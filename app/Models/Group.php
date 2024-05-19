<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Group extends Authenticatable
{
    use HasFactory;

    // protected $table = 'groups'; //addition
    
    protected $guarded = ['id'];
    
    // protected $fillable = ['name', 'username', 'email', 'password', 'category', 'description', 'image'];

    // public function user(){
    //     return $this->belongsToMany(User::class);
    // }

    public function member(){
        return $this->hasMany(User::class);
    }
}
