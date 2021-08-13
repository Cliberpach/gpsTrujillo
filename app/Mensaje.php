<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensaje';
    public $primaryKey = 'id';
    
    protected $fillable = ['asunto',
                           'mensaje',
                           'ruta_logo',
                           'nombre_logo',
                           'base64_logo',
                           'estado'
                        ];
    public $timestamps = true;
                    
}
