<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratorango extends Model
{
    protected $table = 'contratorango';
    public $timestamps = true;
    public $primaryKey = 'id';
    protected $fillable = [
            'contrato_id',
            'rango_id',
            'lat',
            'lng'
    ];
}
