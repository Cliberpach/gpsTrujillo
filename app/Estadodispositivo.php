<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadodispositivo extends Model
{
    protected $table = 'estadodispositivo';
    public $primaryKey = 'id';
    protected $fillable = ['imei',
                           'estado',
                           'fecha',
                           'movimiento',
                           'cadena'
                        ];
                        public $timestamps = false;
}
