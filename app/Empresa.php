<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    public $primaryKey = 'id';
    protected $fillable = ['ruc',
                           'razon_social',
                           'nombre_comercial',
                           'direccion_fiscal',
                           'direccion',
                           'tipo_documento_contacto',
                           'documento_contacto',
                           'nombre_contacto',
                           'telefono_movil',
                           'correo_electronico',
                           'whatsapp',
                           'facebook',
                           'ruta_logo',
                           'nombre_logo',
                           'base64_logo',
                           'estado',
                           'user_id'
                        ];
    public $timestamps = true;
}
