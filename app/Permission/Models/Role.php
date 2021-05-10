<?php

namespace App\Permission\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug', 
        'description','full-access','eliminar'
    ];
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    public function permissions()
    {
        return $this->belongsToMany('App\Permission\Models\Permission')->withTimestamps();
    }
}
