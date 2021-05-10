<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispositivoEmpresa extends Model
{
    protected $table = 'dispositivoempresa';
    public $primaryKey = 'id';
    protected $fillable = ['empresa_id',
                           'tipodispositivo_id',
                           'estado'
                        ];
    public $timestamps = true;
}
