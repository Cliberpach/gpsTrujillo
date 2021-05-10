<?php

namespace App\Mantenimiento\Vendedor;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';

    public function empleado()
    {
        return $this->belongsTo('App\Mantenimiento\Colaborador\Colaborador','colaborador_id');
    }
}
