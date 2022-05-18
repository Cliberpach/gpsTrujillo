<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispositivoUbicacion extends Model
{
    protected $table = "dispositivo_ubicacion";
    protected $fillable = [
        'imei',
        'lat',
        'lng',
        'cadena',
        'fecha',
        'direccion'
    ];

}
