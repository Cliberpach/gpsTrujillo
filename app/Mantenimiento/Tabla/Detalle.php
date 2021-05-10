<?php

namespace App\Mantenimiento\Tabla;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = 'tabladetalles';
    public $timestamps = true;
    protected $fillable = ['tabla_id','descripcion','simbolo','estado'];

    public function tabla()
    {
        return $this->belongsTo('App\Mantenimiento\Tabla\General','tabla_id');
    }
}
