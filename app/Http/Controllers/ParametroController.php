<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ParametroController extends Controller
{
    public function apiRuc($ruc)
    {
        $parametro = consultaRuc();
        $http = $parametro->http.$ruc.$parametro->token;
        $request = Http::get($http);
        $resp = $request->json();
        return $resp;
    }
    public function apiDni($dni)
    {
        $parametro = consultaDni();
        $http = $parametro->http.$dni.$parametro->token;
        $request = Http::get($http);
        $resp = $request->json();
        return $resp;
    }
}
