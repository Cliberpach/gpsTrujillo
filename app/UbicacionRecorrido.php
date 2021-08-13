<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UbicacionRecorrido extends Model
{
    protected $table = 'ubicacion_recorrido';
    public $primaryKey = 'id';
    protected $fillable = [
                           'imei',
                           'lat',
                           'lng',
                            'cadena'

                        ];
    public $timestamps = true;
}
