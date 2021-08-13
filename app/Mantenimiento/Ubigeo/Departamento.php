<?php

namespace App\Mantenimiento\Ubigeo;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $fillable = ['id', 'name'];
    public $timestamps = false;

    public function provincias()
    {
        return $this->hasMany('App\Mantenimiento\Ubigeo\Provincia');
    }

    public function distritos()
    {
        return $this->hasMany('App\Mantenimiento\Ubigeo\Distrito');
    }
}
