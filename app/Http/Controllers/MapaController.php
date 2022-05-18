<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Events\NuevaUbicacionEvent;
use App\Events\TestEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notificacion;
use App\Rango;
use GeometryLibrary\SphericalUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dispositivos = Dispositivo::with(['dispositivoUbicacion', 'estadoDispositivo'])->get()->filter(function ($dispositivo) {
            if ($dispositivo->dispositivoUbicacion != null) {
                $estado = "Sin Movimiento";
                $velocidad_km = 0;

                $arreglo_cadena = explode(',', $dispositivo->dispositivoUbicacion->cadena);
                if ($dispositivo->nombre == "TRACKER303") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($dispositivo->nombre == "MEITRACK") {

                    $velocidad_km = floatval($arreglo_cadena[10]);
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($dispositivo->nombre == "TELTONIKA12O") {
                    $velocidad_km = floatval($arreglo_cadena[3]);
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($dispositivo->nombre == "COBAN") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                }
                elseif($dispositivo->nombre == "CONCOX") {
                    $velocidad_km = hexdec(substr($dispositivo->dispositivoUbicacion->cadena,38,2));
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                }
                $dispositivo->dispositivoUbicacion->velocidad = $velocidad_km;
                $dispositivo->dispositivoUbicacion->estado = $estado;
            }

            //------------------------------------
            $resultado = false;
            if ($dispositivo->estado == "ACTIVO") {
                $resultado = true;
                $user = Auth::user();
                if ($user->tipo != "ADMIN") {
                    $consulta = DB::table('contrato as c')
                        ->join('detallecontrato as dc', 'c.id', 'dc.contrato_id')->where('dc.dispositivo_id', $dispositivo->id)->where('c.estado', 'ACTIVO');
                    if ($user->tipo == "CLIENTE") {
                        $consulta = $consulta
                            ->join('clientes as cl', 'cl.id', 'c.cliente_id')
                            ->where('cl.user_id', $user->id);
                    } else {
                        $consulta = $consulta
                            ->join('empresas as emp', 'emp.id', 'c.empresa_id')
                            ->where('emp.user_id', $user->id);
                    }
                    if ($consulta->count() == 0) {
                        $resultado = false;
                    }
                }
                return $resultado;
            }
            return $resultado;
        });
        return view('mapa.index', compact('dispositivos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function rango()
    {
        return view('mapa.rango');
    }
    public function notificaciones(Request $request)
    {
        $user = $request->user();
        return DB::table('notificaciones')->where('user_id', $user->id)->orderByDesc('creado')
            ->limit(7)->get();
    }
    public function notificacion_vista(Request $request)
    {
        $user = $request->user();
        Notificacion::where('user_id', $user->id)
            ->update(['read_user' => "1"]);
        return "Exito";
    }
    public function agregar_rango(Request $request)
    {
        DB::table('rango')->truncate();
        $var = json_decode($request->posiciones_guardar);
        for ($i = 0; $i < count($var); $i++) {
            $rango = new Rango();
            $rango->nombre = ($i + 1) . "-posicion";
            $rango->lat = $var[$i][0];
            $rango->lng = $var[$i][1];
            $rango->save();
        }
        return redirect()->route('mapas.rango');
    }
    public function ruta(Request $request)
    {
        $data = array();
        $fila = DB::table('ubicacion_recorrido as ur')->join('dispositivo as d', 'd.imei', '=', 'ur.imei')
            ->select('ur.*', 'd.nombre', 'd.placa')
            ->where('ur.lat', '!=', 0)
            ->where('ur.imei', $request->imei)->orderBy('ur.fecha', 'asc')->get();
        for ($i = 0; $i < count($fila); $i++) {

            $arreglo_cadena = explode(',', $fila[$i]->cadena);
            $velocidad_km = "0 kph";
            $altitud = "0 Metros";
            $odometro = "0 Km";
            $nivelCombustible = "0%";
            $volumenCombustible = "0.0 gal";
            $horaDelMotor = "0.0";
            $intensidadSenal = "0.0";
            $estado = "Sin Movimiento";
            $vkm = 0;
            if ($fila[$i]->nombre == "TRACKER303") {


                $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                $vkm = $velocidad_km;
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            } elseif ($fila[$i]->nombre == "MEITRACK") {

                $velocidad_km = floatval($arreglo_cadena[10]);
                $vkm = $velocidad_km;
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $altitud = $arreglo_cadena[13];
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            } elseif ($fila[$i]->nombre == "TELTONIKA12O") {
                $velocidad_km = floatval($arreglo_cadena[3]);
                $vkm = $velocidad_km;
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            } elseif ($fila[$i]->nombre == "COBAN") {
                $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                $vkm = $velocidad_km;
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            }
            elseif($fila[$i]->nombre == "CONCOX") {
                $velocidad_km = hexdec(substr($fila[$i]->cadena,38,2));
                $vkm = $velocidad_km;
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            }


            // if ($vkm > 2) {
            array_push($data, array(
                "placa" => $fila[$i]->placa,
                "imei" => $fila[$i]->imei,
                "estado" => $estado,
                "lat" => $fila[$i]->lat,
                "intensidadSenal" => $intensidadSenal,
                "lng" => $fila[$i]->lng,
                "fecha" => $fila[$i]->fecha,
                "altitud" => $altitud,
                "velocidad" => $velocidad_km,
                "nivelCombustible" => $nivelCombustible,
                "volumenCombustible" => $volumenCombustible,
                "horaDelMotor" => $horaDelMotor,
                "direccion" => $fila[$i]->direccion,
                "odometro" => $odometro
            ));
            // }
        }
        return $data;
    }
    public function  nuevaUbicacion($imei)
    {
        $consulta = Dispositivo::where('imei', $imei);
        if ($consulta->count() != 0) {
            $dispositivo = $consulta->first();
            $usuarios = DB::table('contrato as c')
                ->join('detallecontrato as dc', 'dc.contrato_id', '=', 'c.id')
                ->join('dispositivo as d', 'd.id', '=', 'dc.dispositivo_id')
                ->join('clientes as cl', 'cl.id', '=', 'c.cliente_id')
                ->where('d.imei', $imei)->select('cl.user_id')->get();
            $consultaUbicacion = DB::table('dispositivo_ubicacion')->where('imei', $imei)->first();
            $arreglo_cadena = explode(',', $consultaUbicacion->cadena);
            $estado = "Sin Movimiento";
            $velocidad_km = 0;

            if ($dispositivo->nombre == "TRACKER303") {
                $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            } elseif ($dispositivo->nombre == "MEITRACK") {

                $velocidad_km = floatval($arreglo_cadena[10]);
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            } elseif ($dispositivo->nombre == "TELTONIKA12O") {
                $velocidad_km = floatval($arreglo_cadena[3]);
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            } elseif ($dispositivo->nombre == "COBAN") {
                $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            }
            elseif($dispositivo->nombre == "CONCOX") {
                $velocidad_km = hexdec(substr($consultaUbicacion->cadena,38,2));
                $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
            }

            $consultaUbicacion->velocidad = $velocidad_km;
            $consultaUbicacion->estado = $estado;
            $consultaUbicacion->estado_dispositivo = DB::table('estadodispositivo')->where('imei', $imei)->first();
            $recorrido = self::recorrido($imei);
            $consultaUbicacion->recorrido = $recorrido['recorrido'];
            $consultaUbicacion->recorrido_arreglo = $recorrido['data_recorrido'];
            broadcast(new NuevaUbicacionEvent($consultaUbicacion, $usuarios));
        }
    }
    public static function recorrido($imei)
    {
        $recorrido = array();
        $arreglo_recorrido = array();
        $fila = DB::table('ubicacion_recorrido as ur')
            ->join('dispositivo as d', 'd.imei', '=', 'ur.imei')
            ->select('ur.*', 'd.nombre', 'd.placa')
            ->where('ur.lat', '!=', 0)
            ->where('ur.imei', $imei)->orderBy('ur.fecha', 'asc')->get();
        for ($i = 0; $i < count($fila); $i++) {

            $arreglo_cadena = explode(',', $fila[$i]->cadena);
            $velocidad_km = "0 kph";
            $altitud = "0 Metros";
            $odometro = "0 Km";
            $nivelCombustible = "0%";
            $volumenCombustible = "0.0 gal";
            $horaDelMotor = "0.0";
            $intensidadSenal = "0.0";
            $estado = "Sin Movimiento";
            $vkm = 0;
            $latLng = array();
            array_push($latLng, $fila[$i]->lat);
            array_push($latLng, $fila[$i]->lng);

            array_push($arreglo_recorrido, $latLng);
            if ($i < count($fila) - 1) {
                if ($fila[$i]->nombre == "TRACKER303") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $vkm = $velocidad_km;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } else if ($fila[$i]->nombre == "MEITRACK") {
                    $velocidad_km = floatval($arreglo_cadena[10]);
                    $vkm = $velocidad_km;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $altitud = $arreglo_cadena[13];
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($fila[$i]->nombre == "TELTONIKA12O") {
                    $velocidad_km = floatval($arreglo_cadena[3]);
                    $vkm = $velocidad_km;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($fila[$i]->nombre == "COBAN") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                }
                elseif($fila[$i]->nombre == "CONCOX") {
                    $velocidad_km = hexdec(substr($fila[$i]->cadena,38,2));
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                }
                $marcador = SphericalUtil::computeHeading(
                    ['lat' => $fila[$i]->lat, 'lng' => $fila[$i]->lng], //from array [lat, lng]
                    ['lat' => $fila[$i + 1]->lat, 'lng' => $fila[$i + 1]->lng]
                );
                // if ($vkm > 2) {
                array_push($recorrido, array(
                    "placa" => $fila[$i]->placa,
                    "imei" => $fila[$i]->imei,
                    "img" => self::imgComputeHeading($marcador),
                    "estado" => $estado,
                    "lat" => $fila[$i]->lat,
                    "lng" => $fila[$i]->lng,
                    "intensidadSenal" => $intensidadSenal,
                    "fecha" => $fila[$i]->fecha,
                    "altitud" => $altitud,
                    "velocidad" => $velocidad_km,
                    "nivelCombustible" => $nivelCombustible,
                    "volumenCombustible" => $volumenCombustible,
                    "horaDelMotor" => $horaDelMotor,
                    "direccion" => $fila[$i]->direccion,
                    "odometro" => $odometro
                ));
                // }
            }
        }
        return array("recorrido" => $recorrido, "data_recorrido" => $arreglo_recorrido);
    }
    public static function imgComputeHeading($valor)
    {
        $image = array();
        if ($valor == 0) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_0.png"
            );
        } else if ($valor > 0 && $valor < 45) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_22.png"
            );
        } else if ($valor == 45) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_45.png"
            );
        } else if ($valor > 45 && $valor < 90) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_67.png"
            );
        } else if ($valor == 90) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_90.png"
            );
        } else if ($valor > 90 && $valor < 135) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_112.png"
            );
        } else if ($valor == 135) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_135.png"
            );
        } else if ($valor > 135 && $valor < 180) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_157.png"
            );
        } else if ($valor == 180 || $valor == -180) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_180.png"
            );
        } else if ($valor < 0 && $valor > -45) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_N22.png"
            );
        } else if ($valor == -45) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_N45.png"
            );
        } else if ($valor < -45 && $valor > -90) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_N67.png"
            );
        } else if ($valor == -90) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_N90.png"
            );
        } else if ($valor < 90 && $valor > -135) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_N112.png"
            );
        } else if ($valor == -135) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_N135.png"
            );
        } else if ($valor < -135 && $valor > -180) {
            $image = array(
                "url" =>
                "https://" . $_SERVER['SERVER_NAME'] . "/" .
                    "img/rotation/gpa_prueba_N157.png"
            );
        }
        return $image;
    }
}
