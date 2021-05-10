<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial';
    public $primaryKey = 'id';
    protected $fillable = ['imei',
                           'lat',
                           'lng',
                           'cadena',
		           'fecha'
                            ];
    public $timestamps = true;

}
