<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionRecorrido extends Model
{
    protected $table = "ubicacion_recorrido";
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'imei',
        'lat',
        'lng',
        'cadena',
        'fecha',
        'direccion'
    ];
}
