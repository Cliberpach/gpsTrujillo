<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sutran extends Model
{
    protected $table = 'sutran';
    protected $fillable = [
        'placa','latitud','longitud','rumbo','velocidad','evento','fecha','fechaemv','estado','respuesta'
    ];
    public $timestamps =true;

}
