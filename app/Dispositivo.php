<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    protected $table = 'dispositivo';
    public $primaryKey = 'id';
    protected $fillable = ['nombre',
                           'tipodispotivo_id',
                           'imei',
                           'nrotelefono',
                           'operador',
                           'cliente_id',
                           'placa',
                           'color',
                           'modelo',
                           'marca',
                           'activo',
                           'estado',
                           'pago',
                           'sutran',
                           'km_inicial',
                           'km_actual',
                           'km_aumento'
                        ];
    public $timestamps = true;
}
