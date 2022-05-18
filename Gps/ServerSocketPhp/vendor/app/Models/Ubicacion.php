<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = "ubicacion";
    protected $fillable = [
        'imei',
        'lat',
        'lng',
        'cadena',
        'fecha',
        'direccion',
        'envio_municipalidad'
    ];
}
