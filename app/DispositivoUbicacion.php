<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispositivoUbicacion extends Model
{
    protected $table = 'dispositivo_ubicacion';
    public $primaryKey = 'id';
    protected $fillable = [
        'imei',
        'lat',
        'lng',
        'cadena',
        'fecha'
    ];
}
