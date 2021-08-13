<?php

namespace App\Mantenimiento;

use Illuminate\Database\Eloquent\Model;

class Talonario extends Model
{
    protected $table = 'talonarios';
    protected $fillable = [
        'empresa_id',
        'tipo_documento',
        'serie',
        'numero_inicio',
        'numero_final',
        'numero_actual',
        'estado'
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Mantenimiento\Empresa\Empresa','empresa_id');
    }
}
