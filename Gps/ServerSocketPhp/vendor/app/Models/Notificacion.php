<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    public $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'informacion',
        'read_user',
        'creado'
    ];
    public $timestamps = false;
}
