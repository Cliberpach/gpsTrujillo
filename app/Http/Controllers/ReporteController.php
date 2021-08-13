<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dispositivo;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade;
use GeometryLibrary\SphericalUtil;
use function GuzzleHttp\json_decode;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes.index');
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
    public function data(Request $request)
    {
        $fechainicio = explode(' ', $request->fechainicio)[0];
        $fechafinal = explode(' ', $request->fechafinal)[0];
        $fechanow = $request->fechanow;
        $data = array();
        $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
            ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
        if (($fechainicio != $fechanow) && ($fechanow == $fechafinal)) {
            $consulta_dos = $consulta->join('historial as m', 'm.imei', '=', 'd.imei');
            $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
                ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->union($consulta_dos)->orderByRaw('fecha DESC')->get();
        } else if (($fechainicio == $fechafinal) && ($fechanow == $fechainicio)) {
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->get();
        } else {
            $consulta = $consulta->join('historial as m', 'm.imei', '=', 'd.imei')->get();
        }
        for ($i = 0; $i < count($consulta); $i++) {
            $velocidad = 0;
            $estado = "Sin movimiento";
            $evento = "-";
            $altitud = 0;
            $cadena = explode(',', $consulta[$i]->cadena);
            $marcador = "final";
            if ($i < count($consulta) - 1) {
                $marcador = SphericalUtil::computeHeading(
                    ['lat' => $consulta[$i]->lat, 'lng' => $consulta[$i]->lng], //from array [lat, lng]
                    ['lat' => $consulta[$i + 1]->lat, 'lng' => $consulta[$i + 1]->lng]
                );
            }
            if ($consulta[$i]->nombre == "MEITRACK") {
                $velocidad = $cadena[10];
                $estado_gps = $cadena[3];
                $altitud = $cadena[13];
                $evento = $cadena[3];
                switch ($estado_gps) {
                    case 2:
                    case 10:
                    case 35:
                        if ($velocidad != "0") {
                            $estado = "movimiento";
                        }
                        break;
                    case 22:
                        $estado = "bateria conectada";
                        break;
                    case 23:
                        $estado = "bateria desconectada";
                        break;
                    case 41:
                        $estado = "Sin movimiento";
                        break;
                    case 42:
                        $estado = "Arranque";
                        break;
                    case 120:
                        $estado = "En movimiento";
                        break;
                    default:
                        $estado = "Sin associar";
                        break;
                }
            } else if ($consulta[$i]->nombre == "TRACKER303") {
                if (count($cadena) >= 11) {
                    $velocidad = floatval($cadena[11]) * 1.85;
                    if ($velocidad != "0") {
                        $estado = "En movimiento";
                    }
                }
            }
            array_push($data, array(
                "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                "velocidad" =>sprintf("%.2f", $velocidad). " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                "evento" => $evento,"direccion"=>$consulta[$i]->direccion
            ));
        }
        return response($data)
            ->header('Content-Type', "application/json")
            ->header('X-Header-One', 'Header Value')
            ->header('X-Header-Two', 'Header Value');
    }
    public function alerta()
    {
        return view('reportes.alerta');
    }
    public function reportemovimiento(Request $request)
    {
        $arreglo = json_decode($request->arreglo_reporte);
        $cliente = DB::table('contrato as c')
            ->join('detallecontrato as dc', 'c.id', '=', 'dc.contrato_id')
            ->join('dispositivo as d', 'd.id', '=', 'dc.dispositivo_id')
            ->join('clientes as cl', 'cl.id', '=', 'c.cliente_id')
            ->select('d.nombre as ndispositivo', 'cl.nombre', 'd.placa', 'd.color')
            ->where('d.id', '=', $request->dispositivo_reporte)->first();
        $pdf = Facade::loadview('reportes.pdf.pdfmovimiento', [
            'fecha' => $request->fecha_reporte,
            'hinicio' => $request->hinicio_reporte,
            'hfinal' => $request->hfinal_reporte,
            'dispositivo' => $cliente->ndispositivo,
            'placa' => $cliente->placa,
            'color' => $cliente->color,
            'cliente' => $cliente->nombre,
            'arreglodispositivo' => $arreglo,
        ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
    public function reportealerta(Request $request)
    {
        $arreglo = json_decode($request->arreglo_reporte);
        $cliente = DB::table('contrato as c')
            ->join('detallecontrato as dc', 'c.id', '=', 'dc.contrato_id')
            ->join('dispositivo as d', 'd.id', '=', 'dc.dispositivo_id')
            ->join('clientes as cl', 'cl.id', '=', 'c.cliente_id')
            ->select('d.nombre as ndispositivo', 'cl.nombre', 'd.placa', 'd.color')
            ->where('d.id', '=', $request->dispositivo_reporte)->first();
        $pdf = Facade::loadview('reportes.pdf.pdfalerta', [
            'fecha' => $request->fecha_reporte,
            'hinicio' => $request->hinicio_reporte,
            'hfinal' => $request->hfinal_reporte,
            'dispositivo' => $cliente->ndispositivo,
            'placa' => $cliente->placa,
            'color' => $cliente->color,
            'alerta' => $request->alerta,
            'cliente' => $cliente->nombre,
            'arreglodispositivo' => $arreglo,
        ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
    public function datalerta(Request $request)
    {
        $alerta = DB::table('alertas')->where('id', $request->alerta)->first();
        $fechainicio = explode(' ', $request->fechainicio)[0];
        $fechafinal = explode(' ', $request->fechafinal)[0];
        $fechanow = $request->fechanow;
        $data = array();
        $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
            ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
        if (($fechainicio != $fechanow) && ($fechanow == $fechafinal)) {
            $consulta_dos = $consulta->join('historial as m', 'm.imei', '=', 'd.imei');
            $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
                ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->union($consulta_dos)->orderByRaw('fecha DESC')->get();
        } else if (($fechainicio == $fechafinal) && ($fechanow == $fechainicio)) {
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->get();
        } else {
            $consulta = $consulta->join('historial as m', 'm.imei', '=', 'd.imei')->get();
        }
        for ($i = 0; $i < count($consulta); $i++) {
            $alerta_dispositivo = false;
            $velocidad = 0;
            $estado = "Sin movimiento";
            $evento = "-";
            $altitud = 0;
            $cadena = explode(',', $consulta[$i]->cadena);
            $marcador = "";
            if ($i < count($consulta) - 1) {
                $marcador = SphericalUtil::computeHeading(
                    ['lat' => $consulta[$i]->lat, 'lng' => $consulta[$i]->lng],
                    ['lat' => $consulta[$i + 1]->lat, 'lng' => $consulta[$i + 1]->lng]
                );
            } else {
                $marcador = "final";
            }
            if ($consulta[$i]->nombre == "MEITRACK") {
                $evento = $cadena[3];
                $velocidad = $cadena[10];
                if ($alerta->alerta == "speed") {
                    if ($velocidad >= 90) {
                        $alerta_dispositivo = true;
                    }
                } else if ($alerta->alerta == "acc off") {
                    if ($evento == 22 || $evento == 23) {
                        $alerta_dispositivo = true;
                    }
                }
                $estado_gps = $evento;
                $altitud = $cadena[13];
                switch ($estado_gps) {
                    case 2:
                    case 10:
                    case 35:
                        if ($velocidad != "0") {
                            $estado = "movimiento";
                        }
                        break;
                    case 22:
                        $estado = "bateria conectada";
                        break;
                    case 23:
                        $estado = "bateria desconectada";
                        break;
                    case 41:
                        $estado = "Sin movimiento";
                        break;
                    case 42:
                        $estado = "Arranque";
                        break;
                    case 120:
                        $estado = "En movimiento";
                        break;
                    default:
                        $estado = "Sin associar";
                        break;
                }
            } else if ($consulta[$i]->nombre == "TRACKER303") {
                if (count($cadena) >= 11) {
                    $velocidad = floatval($cadena[11]) * 1.85;
                    $estado = "Sin movimiento";
                    if ($velocidad != "0") {
                        $estado = "En movimiento";
                    }
                    if ($alerta->alerta == "speed") {
                        if ($velocidad >= 90) {
                            $alerta_dispositivo = true;
                        }
                    } else if ($alerta->alerta == "acc off") {
                        if ($cadena[1] == "ac alarm") {
                            $alerta_dispositivo = true;
                        }
                    }
                }
            }
            if ($alerta_dispositivo) {
                array_push($data, array(
                    "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                    "velocidad" => sprintf("%.2f", $velocidad). " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                    "evento" => $evento,"direccion"=>$consulta[$i]->direccion
                ));
            }
        }
        return response($data)
            ->header('Content-Type', "application/json")
            ->header('X-Header-One', 'Header Value')
            ->header('X-Header-Two', 'Header Value');
    }
    public function geozona()
    {
        return view('reportes.geozona');
    }
    public function geozonasalida()
    {
        return view('reportes.geozonasalida');
    }
    public function geozonagrupo()
    {
        return view('reportes.geozonagrupo');
    }
    public function datageozona(Request $request)
    {
        $dispositivo = Dispositivo::findOrFail($request->dispositivo);
        $data = DB::table('contrato as c')
            ->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
            ->join('contratorango as cr', 'cr.contrato_id', 'c.id')
            ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')
            ->select('cr.nombre', 'cr.id')
            ->where('c.estado', 'ACTIVO')
            ->where('d.id', $dispositivo->id)->get();
        return $data;
    }
    public function dispositivogeozona(Request $request)
    {
        $data = array();
        $arreglo_geozona = array();
        $geozona = DB::table('contratorango as cr')
            ->join('detalle_contratorango as dcr', 'dcr.contratorango_id', 'cr.id')
            ->select('dcr.lat', 'dcr.lng')
            ->where('cr.id', $request->geozona)->get();
        foreach ($geozona as $fila) {
            array_push($arreglo_geozona, array('lat' => floatval($fila->lat), 'lng' => floatval($fila->lng)));
        }
        $fechainicio = explode(' ', $request->fechainicio)[0];
        $fechafinal = explode(' ', $request->fechafinal)[0];
        $fechanow = $request->fechanow;
        $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
            ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
        if (($fechainicio != $fechanow) && ($fechanow == $fechafinal)) {
            $consulta_dos = $consulta->join('historial as m', 'm.imei', '=', 'd.imei');
            $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
                ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->union($consulta_dos)->orderByRaw('fecha DESC')->get();
        } else if (($fechainicio == $fechafinal) && ($fechanow == $fechainicio)) {
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->get();
        } else {
            $consulta = $consulta->join('historial as m', 'm.imei', '=', 'd.imei')->get();
        }
        for ($i = 0; $i < count($consulta); $i++) {
            $velocidad = 0;
            $estado = "-";
            $evento = "-";
            $altitud = 0;
            $cadena = explode(',', $consulta[$i]->cadena);
            $marcador = "";
            $response =  \GeometryLibrary\PolyUtil::containsLocation(
                ['lat' => $consulta[$i]->lat, 'lng' => $consulta[$i]->lng],
                $arreglo_geozona
            );
            if ($consulta[$i]->nombre == "MEITRACK") {
                $velocidad = $cadena[10];
                $estado_gps = $cadena[3];
                $altitud = $cadena[13];
                $evento = $cadena[3];
                switch ($estado_gps) {
                    case 2:
                    case 10:
                    case 35:
                        $estado = "Sin movimiento";
                        if ($velocidad != "0") {
                            $estado = "movimiento";
                        }
                        break;
                    case 22:
                        $estado = "bateria conectada";
                        break;
                    case 23:
                        $estado = "bateria desconectada";
                        break;
                    case 41:
                        $estado = "Sin movimiento";
                        break;
                    case 42:
                        $estado = "Arranque";
                        break;
                    case 120:
                        $estado = "En movimiento";
                        break;
                    default:
                        $estado = "Sin associar";
                        break;
                }
            } else if ($consulta[$i]->nombre == "TRACKER303") {
                if (count($cadena) >= 11) {
                    $velocidad = floatval($cadena[11]) * 1.85;
                    if ($velocidad != "0") {
                        $estado = "En movimiento";
                    } else {
                        $estado = "Sin movimiento";
                    }
                }
            }
            if ($response == true) {
                array_push($data, array(
                    "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                    "velocidad" => sprintf("%.2f", $velocidad). " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                    "evento" => $evento,"direccion"=>$consulta[$i]->direccion
                ));
            }
        }
        /*return response($respuesta)
        ->header('Content-Type', "application/json")
        ->header('X-Header-One', 'Header Value')
        ->header('X-Header-Two', 'Header Value');*/
        return $data;
    }
    public function dispositivogeozonasalida(Request $request)
    {
        $data = array();
        $arreglo_geozona = array();
        $geozona = DB::table('contratorango as cr')
            ->join('detalle_contratorango as dcr', 'dcr.contratorango_id', 'cr.id')
            ->select('dcr.lat', 'dcr.lng')
            ->where('cr.id', $request->geozona)->get();
        foreach ($geozona as $fila) {
            array_push($arreglo_geozona, array('lat' => $fila->lat, 'lng' => $fila->lng));
        }
        $fechainicio = explode(' ', $request->fechainicio)[0];
        $fechafinal = explode(' ', $request->fechafinal)[0];
        $fechanow = $request->fechanow;
        $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
            ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
        if (($fechainicio != $fechanow) && ($fechanow == $fechafinal)) {
            $consulta_dos = $consulta->join('historial as m', 'm.imei', '=', 'd.imei');
            $consulta = DB::table('dispositivo as d')->where([['m.lat', '<>', '0'], ['lng', '<>', '0'], ['d.id', '=', $request->dispositivo]])
                ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->union($consulta_dos)->orderByRaw('fecha DESC')->get();
        } else if (($fechainicio == $fechafinal) && ($fechanow == $fechainicio)) {
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->get();
        } else {
            $consulta = $consulta->join('historial as m', 'm.imei', '=', 'd.imei')->get();
        }
        $ES=0;
        $valorRuta=false;
        for ($i = 0; $i < count($consulta); $i++) {
            $velocidad = 0;
            $posicion="-";
            $estado = "-";
            $evento = "-";
            $altitud = 0;
            $cadena = explode(',', $consulta[$i]->cadena);
            $marcador = "";
            $response =  \GeometryLibrary\PolyUtil::containsLocation(
                ['lat' => $consulta[$i]->lat, 'lng' => $consulta[$i]->lng],
                $arreglo_geozona
            );
            if($response==$valorRuta)
            {
                $ES=1;
                if($valorRuta==false)
                {
                    $posicion="Fuera de la Geozona";
                    $valorRuta=true;
                }
                else
                {
                    $valorRuta=false;
                    $posicion="Dentro de la Geozona";
                }

            }

            if ($consulta[$i]->nombre == "MEITRACK") {
                $velocidad = $cadena[10];
                $estado_gps = $cadena[3];
                $altitud = $cadena[13];
                $evento = $cadena[3];
                switch ($estado_gps) {
                    case 2:
                    case 10:
                    case 35:
                        $estado = "Sin movimiento";
                        if ($velocidad != "0") {
                            $estado = "movimiento";
                        }
                        break;
                    case 22:
                        $estado = "bateria conectada";
                        break;
                    case 23:
                        $estado = "bateria desconectada";
                        break;
                    case 41:
                        $estado = "Sin movimiento";
                        break;
                    case 42:
                        $estado = "Arranque";
                        break;
                    case 120:
                        $estado = "En movimiento";
                        break;
                    default:
                        $estado = "Sin associar";
                        break;
                }
            } else if ($consulta[$i]->nombre == "TRACKER303") {
                if (count($cadena) >= 11) {
                    $velocidad = floatval($cadena[11]) * 1.85;
                    if ($velocidad != "0") {
                        $estado = "En movimiento";
                    } else {
                        $estado = "Sin movimiento";
                    }
                }
            }
            if ($ES==1) {
                $ES=0;
                array_push($data, array(
                    "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                    "velocidad" => sprintf("%.2f", $velocidad). " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                    "evento" => $evento,"direccion"=>$consulta[$i]->direccion,"posicion"=>$posicion
                ));
            }
        }
        /*return response($respuesta)
        ->header('Content-Type', "application/json")
        ->header('X-Header-One', 'Header Value')
        ->header('X-Header-Two', 'Header Value');*/
        return $data;
    }
    public function clientescontrato(Request $request)
    {
        return DB::table('contrato as c')
            ->join('empresas as e', 'e.id', '=', 'c.empresa_id')
            ->join('clientes as cl', 'cl.id', '=', 'c.cliente_id')
            ->select('cl.*')
            ->where('e.id', $request->empresa)->get();
    }
    public function dispositivogeozonagrupo(Request $request)
    {
        //::info($request);
        $fechainicio = explode(' ', $request->fechainicio)[0];
        $fechafinal = explode(' ', $request->fechafinal)[0];
        $fechanow = $request->fechanow;
        $consulta = DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
            ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('m.*', 'd.nombre', 'd.placa')->where([
                ['m.lat', '<>', '0'], ['m.lng', '<>', '0'],
                ['c.empresa_id', '=', $request->empresa], ['c.cliente_id', '=', $request->cliente]
            ])
            ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
        if (($fechainicio != $fechanow) && ($fechanow == $fechafinal)) {
            $consulta_dos = $consulta->join('historial as m', 'm.imei', '=', 'd.imei');
            $consulta = DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
                ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('m.*', 'd.nombre', 'd.placa')->where([
                    ['m.lat', '<>', '0'], ['m.lng', '<>', '0'],
                    ['c.empresa_id', '=', $request->empresa], ['c.cliente_id', '=', $request->cliente]
                ])
                ->whereBetween('m.fecha', [$request->fechainicio, $request->fechafinal]);
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->union($consulta_dos)->orderByRaw('d.placa DESC')->get();
        } else if (($fechainicio == $fechafinal) && ($fechanow == $fechainicio)) {
            $consulta = $consulta->join('ubicacion as m', 'm.imei', '=', 'd.imei')->orderByDesc('d.placa')->get();
        } else {
            $consulta = $consulta->join('historial as m', 'm.imei', '=', 'd.imei')->orderByDesc('d.placa')->get();
        }
        $dispositivos = DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
            ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('d.nombre', 'd.placa')->orderByDesc('d.placa')->get();
        $dispositivo_agrupar = DB::table("contrato as c")->join('detallecontrato as dc', 'dc.contrato_id', 'c.id')
            ->join('dispositivo as d', 'd.id', 'dc.dispositivo_id')->select('d.nombre', 'd.placa')->orderByDesc('d.placa')->first()->placa;
        $data_all = array();
        for ($k = 0; $k < count($dispositivos); $k++) {
            array_push($data_all, array("datos" => [], "nombre" => $dispositivos[$k]->placa));
        }


        $data = array();
        for ($i = 0; $i < count($consulta); $i++) {
            $velocidad = 0;
            $estado = "Sin movimiento";
            $evento = "-";
            $altitud = 0;
            $cadena = explode(',', $consulta[$i]->cadena);
            $marcador = "";
            if ($i < count($consulta) - 1) {
                $marcador = SphericalUtil::computeHeading(
                    ['lat' => $consulta[$i]->lat, 'lng' => $consulta[$i]->lng], //from array [lat, lng]
                    ['lat' => $consulta[$i + 1]->lat, 'lng' => $consulta[$i + 1]->lng]
                );
            } else {
                $marcador = "final";
            }
            if ($consulta[$i]->nombre == "MEITRACK") {
                $velocidad = $cadena[10];
                $estado_gps = $cadena[3];
                $altitud = $cadena[13];
                $evento = $cadena[3];
                switch ($estado_gps) {
                    case 2:
                    case 10:
                    case 35:
                        if ($velocidad != "0") {
                            $estado = "movimiento";
                        }
                        break;
                    case 22:
                        $estado = "bateria conectada";
                        break;
                    case 23:
                        $estado = "bateria desconectada";
                        break;
                    case 41:
                        $estado = "Sin movimiento";
                        break;
                    case 42:
                        $estado = "Arranque";
                        break;
                    case 120:
                        $estado = "En movimiento";
                        break;
                    default:
                        $estado = "Sin associar";
                        break;
                }
            } else if ($consulta[$i]->nombre == "TRACKER303") {
                if (count($cadena) >= 11) {
                    $velocidad = floatval($cadena[11]) * 1.85;
                    if ($velocidad != "0") {
                        $estado = "En movimiento";
                    }
                }
            }
            /*$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$consulta[$i]->lat.",".$consulta[$i]->lng."&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI";
            $contexto = stream_context_create($opciones);
            $resultado = file_get_contents($url, false, $contexto);
            $resultado=json_decode($resultado,true);*/
            /*array_push($data,array(
                "imei"=>$consulta[$i]->imei,"lat"=>$consulta[$i]->lat,"lng"=>$consulta[$i]->lng,"cadena"=>$consulta[$i]->cadena,
                "velocidad"=>$velocidad." kph","fecha"=>$consulta[$i]->fecha,"direccion"=>$resultado['results'][0]['formatted_address']
            ));*/
            if ($consulta[$i]->placa == $dispositivo_agrupar) {
                array_push($data, array(
                    "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                    "velocidad" => sprintf("%.2f", $velocidad). " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                    "evento" => $evento, "placa" => $consulta[$i]->placa,"direccion"=>$consulta[$i]->direccion
                ));
            } else {
                $posicion = array_search($dispositivo_agrupar, array_column($data_all, 'nombre'));
                $data_all[$posicion]['datos']=$data;
                $dispositivo_agrupar = $consulta[$i]->placa;
                $data = array();
                array_push($data, array(
                    "imei" => $consulta[$i]->imei, "lat" => $consulta[$i]->lat, "lng" => $consulta[$i]->lng, "cadena" => $consulta[$i]->cadena,
                    "velocidad" => sprintf("%.2f", $velocidad). " kph", "fecha" => $consulta[$i]->fecha, "estado" => $estado, "altitud" => $altitud, "marcador" => $marcador,
                    "evento" => $evento, "placa" => $consulta[$i]->placa,"direccion"=>$consulta[$i]->direccion
                ));
            }
        }
        $posicion = array_search($dispositivo_agrupar, array_column($data_all, 'nombre'));
        $data_all[$posicion]['datos']=$data;
        return response($data_all);
    }
}
