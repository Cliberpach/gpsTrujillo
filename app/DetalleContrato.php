<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleContrato extends Model
{
    protected $table = 'detallecontrato';
    public $primaryKey = 'id';
    protected $fillable = ['contrato_id',
                           'dispositivo_id',
                           'pago',
                           'estado',
                           'costo_instalacion'
                        ];
    public $timestamps = true;
}
