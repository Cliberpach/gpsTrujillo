<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    protected $table = 'dispositivo';
    public $primaryKey = 'id';
    protected $fillable = [
        'nombre',
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
        'estado_municipalidad'
    ];
    public $timestamps = true;
}
