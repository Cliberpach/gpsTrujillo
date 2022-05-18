<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoDispositivo extends Model
{
    protected $table = "estadodispositivo";
    protected $fillable = [
        'imei',
        'estado',
        'fecha',
        'movimiento',
        'cadena'
    ];
    public $timestamps = false;
}
