<?php

use Illuminate\Database\Capsule\Manager as DB;

trait RecursoDatabase
{
    public function getUsers($imei)
    {
        return DB::table('contrato as c')
            ->join('cliente as cli', 'cli.id', '=', 'c.cliente_id')
            ->join('dispositivo as d','d.id','=','c.dispositivo_id')
            ->select('cli.user_id')
            ->where('c.estado', 'ACTIVO')
            ->where('d.imei',$imei)
            ->where('c.estado_contrato', 'ACEPTADO')
            ->get();
    }
}
