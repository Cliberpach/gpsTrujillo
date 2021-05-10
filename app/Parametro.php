<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametros';
    public $timestamps = true;
    protected $fillable = [
            'http',
            'token'
    ];
}
