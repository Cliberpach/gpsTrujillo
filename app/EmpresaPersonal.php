<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaPersonal extends Model
{
    protected $table = 'empresa';
    public $primaryKey = 'id';
    protected $fillable = ['ruc',
                           'razon_social',
                           'nombre_comercial',
                           'direccion_fiscal',
                           'direccion',
                           'telefono_movil',
                           'correo_electronico',
                           'whatsapp',
                           'contraseña',
                           'facebook',

                           'ruta_logo',
                           'nombre_logo',
                           'base64_logo',

                           'ruta_logo_icon',
                           'nombre_logo_icon',
                           'base64_logo_icon',

                           'ruta_logo_large',
                           'nombre_logo_large',
                           'base64_logo_large',

                           'color',
                           'estado'
                        ];
    public $timestamps = true;
}
