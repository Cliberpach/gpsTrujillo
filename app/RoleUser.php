<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';
    public $primaryKey = 'id';
    protected $fillable = ['role_id',
                           'user_id'
                        ];
    public $timestamps = true;
}
