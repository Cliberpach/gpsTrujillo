<?php

namespace App\Mantenimiento\Ubigeo;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distritos';
    public $timestamps = false;

    public function provincia()
    {
        return $this->belongsTo('App\Mantenimiento\Ubigeo\Provincia');
    }

    public function departamento()
    {
        return $this->belongsTo('App\Mantenimiento\Ubigeo\Departamento');
    }
}
