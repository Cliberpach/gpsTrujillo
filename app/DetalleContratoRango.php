<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleContratoRango extends Model
{
    protected $table = 'detalle_contratorango';
    public $timestamps = true;
    public $primaryKey = 'id';
    protected $fillable = [
            'contratorango_id',
            'lat',
            'lng'
    ];
}
