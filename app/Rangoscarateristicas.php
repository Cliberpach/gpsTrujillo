<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rangoscarateristicas extends Model
{
    protected $table = 'rangospuntos';
    public $timestamps = true;
    public $primaryKey = 'id';
    protected $fillable = [
            'rango_id','lat','lng'
    ];
}
