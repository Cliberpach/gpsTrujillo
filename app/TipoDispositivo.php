<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDispositivo extends Model
{
    protected $table = 'tipodispositivo';
    public $primaryKey = 'id';
    protected $fillable = ['id',
                           'nombre',
                           'activo',
                           'estado',
                            'nombre_logo',
                            'ruta_logo' ,
                            'base64_logo',
                            'precio'

                        ];
    public $timestamps = true;
}
