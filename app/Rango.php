<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rango extends Model
{
    protected $table = 'rango';
    public $timestamps = true;
    public $primaryKey = 'id';
    protected $fillable = [
            'nombre'
    ];
}
