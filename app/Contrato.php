<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contrato';
    public $primaryKey = 'id';
    protected $fillable = ['empresa_id',
                           'cliente_id',
                           'fecha_inicio',
                           'fecha_fin',
                            'estado',
                            'costo_contrato',
                            'pago_total'
                        ];
    public $timestamps = true;
}
