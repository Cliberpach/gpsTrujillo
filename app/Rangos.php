<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rangos extends Model
{
    protected $table = 'rangos';
    public $timestamps = true;
    public $primaryKey = 'id';
    protected $fillable = [
            'nombre','estado'
    ];
}
