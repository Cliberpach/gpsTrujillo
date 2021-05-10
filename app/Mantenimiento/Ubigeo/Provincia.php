<?php

namespace App\Mantenimiento\Ubigeo;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';
    public $timestamps = false;

    public function departamentos()
    {
        return $this->belongsTo('App\Mantenimiento\Ubigeo\Departamento');
    }

    public function distritos()
    {
        return $this->hasMany('App\Mantenimiento\Ubigeo\Distrito');
    }
}
