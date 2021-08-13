<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opcionalerta extends Model
{
    protected $table = 'opcionalerta';
    public $primaryKey = 'id';
    protected $fillable = ['dispositivo_id',
                           'alerta_id'
                        ];
    public $timestamps = true;
}
