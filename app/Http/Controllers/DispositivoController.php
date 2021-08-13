<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use App\Opcionalerta;
use App\Dispositivo;
use App\TipoDispositivo;
use App\UbicacionRecorrido;
use Illuminate\Support\Facades\Auth;
use GeometryLibrary\SphericalUtil;
use Yajra\Datatables\Datatables;
use App\User;
use Illuminate\Support\Facades\Log;

class DispositivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dispositivo.index');
    }
    public function getTable()
    {
        // return datatables()->query(DB::table('dispositivo')->select('*')->where('dispositivo.estado','ACTIVO')->orderBy('dispositivo.id', 'desc')    )->toJson();
        $data = DB::table('dispositivo')->select('*')->where('dispositivo.estado', 'ACTIVO')->orderBy('dispositivo.id', 'desc')->get();
        return Datatables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('dispositivo.store');
        $dispositivo = new Dispositivo();
        return view('dispositivo.create')->with(compact('action', 'dispositivo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $rules = [
            'nombre' => 'required',
            'nrotelefono' => 'required',
            'operador' => 'required',
            'color' => 'required',
            'cliente' => 'required',
            'pago' => 'required',
            'activo' => 'required',
            'modelo' => 'required',
            'imei' => 'required',
            'marca' => 'required',

        ];
        $message = [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nrotelefono.required' => 'El campo telfono es obligatorio',
            'operador.required' => 'El campo  operador es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'cliente.required' => 'El campo cliente es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'imei.required' => 'El campo imei es obligatorio',
            'marca.required' => 'El campo marca es obligatorio',
            'pago.required' => 'El campo pago es Obligatorio',
            'activo.required' => 'El campo activo es Obligatorio',


        ];

        Validator::make($data, $rules, $message)->validate();

        $dispositivo = new Dispositivo();
        $tipo = TipoDispositivo::FindOrFail($request->nombre);
        $dispositivo->nombre = $tipo->nombre;
        $dispositivo->tipodispositivo_id = $request->nombre;
        $dispositivo->imei = $request->imei;
        $dispositivo->nrotelefono = $request->nrotelefono;
        $dispositivo->operador = $request->operador;
        $dispositivo->cliente_id =$request->cliente;
        $dispositivo->placa = $request->placa;
        $dispositivo->color = $request->color;
        $dispositivo->modelo = $request->modelo;
        $dispositivo->marca = $request->marca;

        $dispositivo->pago = $request->pago;
        $dispositivo->activo = $request->activo;
        $dispositivo->sutran=$request->sutran;
        $dispositivo->km_inicial=$request->km_inicial;
        $dispositivo->km_actual= $request->km_inicial;
        $dispositivo->km_aumento=$request->km_aumento;
        $dispositivo->save();
        if ($request->alerta_tabla != "[]" && $request->alerta_tabla != "") {

            $var = json_decode($request->alerta_tabla);
            for ($i = 0; $i < count($var); $i++) {
                Opcionalerta::create([
                    'dispositivo_id' => $dispositivo->id,
                    'alerta_id' => $var[$i]->alerta_id,
                ]);
            }
        }

        //Registro de actividad

        Session::flash('success', 'Dispositivo creado.');
        return redirect()->route('dispositivo.index')->with('guardar', 'success');
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
        $dispositivo = Dispositivo::findOrFail($id);

        $put = True;
        $action = route('dispositivo.update', $id);
        $detalle_alerta = DB::table('opcionalerta')
            ->join('alertas as a', 'a.id', '=', 'opcionalerta.alerta_id')
            ->select('opcionalerta.alerta_id', 'a.alerta')
            ->where('dispositivo_id', $id)->get();

        return view('dispositivo.edit', [
            'dispositivo' => $dispositivo,
            'action' => $action,
            'put' => $put,
            'detalle_alerta' => json_encode($detalle_alerta),
        ]);
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

        $data = $request->all();

        $rules = [
            'nombre' => 'required',
            'nrotelefono' => 'required',
            'operador' => 'required',
            'color' => 'required',
            'cliente' => 'required',
            'pago' => 'required',
            'activo' => 'required',
            'modelo' => 'required',
            'imei' => 'required',
            'marca' => 'required',

        ];
        $message = [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nrotelefono.required' => 'El campo telfono es obligatorio',
            'operador.required' => 'El campo  operador es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'cliente.required' => 'El campo cliente es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'imei.required' => 'El campo imei es obligatorio',
            'marca.required' => 'El campo marca es obligatorio',
            'pago.required' => 'El campo pago es Obligatorio',
            'activo.required' => 'El campo activo es Obligatorio',


        ];

        Validator::make($data, $rules, $message)->validate();

        $dispositivo = Dispositivo::FindOrFail($id);
        $tipo = TipoDispositivo::FindOrFail($request->nombre);
        $dispositivo->nombre = $tipo->nombre;
        $dispositivo->tipodispositivo_id = $request->nombre;
        $dispositivo->imei = $request->imei;
        $dispositivo->nrotelefono = $request->nrotelefono;
        $dispositivo->operador = $request->operador;
        $dispositivo->cliente_id =$request->cliente;
        $dispositivo->placa = $request->placa;
        $dispositivo->color = $request->color;
        $dispositivo->modelo = $request->modelo;
        $dispositivo->marca = $request->marca;

        $dispositivo->pago = $request->pago;
        $dispositivo->activo = $request->activo;
        $dispositivo->sutran=$request->sutran;
        $dispositivo->km_inicial=$request->km_inicial;
        $dispositivo->km_actual= $request->km_inicial;
        $dispositivo->km_aumento=$request->km_aumento;
        $dispositivo->update();

        if ($request->alerta_tabla != "[]" && $request->alerta_tabla != "") {
            Opcionalerta::where('dispositivo_id', $dispositivo->id)->delete();
            $var = json_decode($request->alerta_tabla);
            for ($i = 0; $i < count($var); $i++) {
                Opcionalerta::create([
                    'dispositivo_id' => $dispositivo->id,
                    'alerta_id' => $var[$i]->alerta_id,
                ]);
            }
        }

        //Registro de actividad

        Session::flash('success', 'Dispositivo modificado.');
        return redirect()->route('dispositivo.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $dispositivo->estado = 'ANULADO';
        $dispositivo->update();

        //Registro de actividad


        Session::flash('success', 'Dispositivo eliminado.');
        return redirect()->route('dispositivo.index')->with('eliminar', 'success');
    }
    public function getvalores(Request $request)
    {

        $existeplaca = false;
        $existeimei = false;
        if (DB::table('dispositivo')->where('placa', $request->placa)->where('id', '!=', $request->id)->where('estado', 'ACTIVO')->count() != 0) {
            $existeplaca = true;
        } else if (DB::table('dispositivo')->where('imei', $request->imei)->where('id', '!=', $request->id)->where('estado', 'ACTIVO')->count() != 0) {
            $existeimei = true;
        }

        $result = [
            'existeplaca' => $existeplaca,
            'existeimei' => $existeimei
        ];

        return response()->json($result);
    }
    public function gps(Request $request)
    {

        $user = Auth::user();

        if ($user->tipo == 'ADMIN') {
            $resultado = array();
            $dispositivos = DB::select("SELECT t1.* FROM (select d.color,u.id,u.cadena,u.imei,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
            // array_push($var,$dipositivos);
            foreach ($dispositivos as $dispositivo) {
                $ubicaciones = [];
                if ($dispositivo->nombre == "TRACKER 103B") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',2),',',-1) as bateria,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',13),',',-1) as apagado,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',15),',',-1) as prendido from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.bateria!='acc off%' and m.apagado!='0' and m.apagado!=' '"));
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',4),',',-1) as evento from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.evento!='41'"));
                }

                $suma = 0.0;
                for ($i = 0; $i < count($ubicaciones); $i++) {
                    if ($i < count($ubicaciones) - 1) {
                        $response = SphericalUtil::computeDistanceBetween(
                            ['lat' => $ubicaciones[$i]->lat, 'lng' =>  $ubicaciones[$i]->lng], //from array [lat, lng]
                            ['lat' =>  $ubicaciones[$i + 1]->lat, 'lng' =>  $ubicaciones[$i + 1]->lng]
                        );
                        $suma = $suma + $response;
                    }
                }
                array_push($resultado, array(
                    "recorrido" => $suma,
                    "imei" => $dispositivo->imei,
                    "color" => $dispositivo->color,
                    "id" => $dispositivo->id,
                    "cadena" => $dispositivo->cadena,
                    "lat" => $dispositivo->lat,
                    "lng" => $dispositivo->lng,
                    "fecha" => $dispositivo->fecha,
                    "placa" => $dispositivo->placa,
                    "marca" => $dispositivo->marca,
                    "modelo" => $dispositivo->modelo,
                    "nombre" => $dispositivo->nombre
                ));
            }

            return $resultado;
        } else if ($user->tipo == 'CLIENTE') {

            $cliente = DB::table('clientes')->where('user_id', $user->id)->first();
            $dispositivos = DB::select("SELECT t1.* FROM (select d.color,u.id,u.cadena,u.imei,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and c.cliente_id='" . $cliente->id . "') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 and c.cliente_id='" . $cliente->id . "' ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
            $resultado = array();

            // array_push($var,$dipositivos);
            foreach ($dispositivos as $dispositivo) {
                $ubicaciones = [];
                if ($dispositivo->nombre == "TRACKER 103B") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',2),',',-1) as bateria,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',13),',',-1) as apagado,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',15),',',-1) as prendido from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.bateria!='acc off%' and m.apagado!='0' and m.apagado!=' '"));
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',4),',',-1) as evento from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.evento!='41'"));
                }
                $suma = 0.0;
                for ($i = 0; $i < count($ubicaciones); $i++) {
                    if ($i < count($ubicaciones) - 1) {
                        $response = SphericalUtil::computeDistanceBetween(
                            ['lat' => $ubicaciones[$i]->lat, 'lng' =>  $ubicaciones[$i]->lng], //from array [lat, lng]
                            ['lat' =>  $ubicaciones[$i + 1]->lat, 'lng' =>  $ubicaciones[$i + 1]->lng]
                        );
                        $suma = $suma + $response;
                    }
                }
                array_push($resultado, array(
                    "recorrido" => $suma,
                    "imei" => $dispositivo->imei,
                    "color" => $dispositivo->color,
                    "id" => $dispositivo->id,
                    "cadena" => $dispositivo->cadena,
                    "lat" => $dispositivo->lat,
                    "lng" => $dispositivo->lng,
                    "fecha" => $dispositivo->fecha,
                    "placa" => $dispositivo->placa,
                    "marca" => $dispositivo->marca,
                    "modelo" => $dispositivo->modelo,
                    "nombre" => $dispositivo->nombre
                ));
            }

            return $resultado;
        } else if ($user->tipo == 'EMPRESA') {
            $empresa = DB::table('empresas')->where('user_id', $user->id)->first();
            $dispositivos = DB::select("SELECT t1.* FROM (select d.color,u.id,u.cadena,u.imei,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and c.empresa_id='" . $empresa->id . "') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 and c.empresa_id='" . $empresa->id . "' ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
            $resultado = array();

            // array_push($var,$dipositivos);
            foreach ($dispositivos as $dispositivo) {
                $ubicaciones = [];
                if ($dispositivo->nombre == "TRACKER 103B") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',2),',',-1) as bateria,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',13),',',-1) as apagado,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',15),',',-1) as prendido from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.bateria!='acc off%' and m.apagado!='0' and m.apagado!=' '"));
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $ubicaciones = DB::select(DB::raw("select * from (select *,SUBSTRING_INDEX(SUBSTRING_INDEX(t.cadena,',',4),',',-1) as evento from (select * from ubicacion) as t where t.imei='" . $dispositivo->imei . "' and t.lat!='0' and t.lng!='0' ) as m where m.evento!='41'"));
                }
                $suma = 0.0;
                for ($i = 0; $i < count($ubicaciones); $i++) {
                    if ($i < count($ubicaciones) - 1) {
                        $response = SphericalUtil::computeDistanceBetween(
                            ['lat' => $ubicaciones[$i]->lat, 'lng' =>  $ubicaciones[$i]->lng], //from array [lat, lng]
                            ['lat' =>  $ubicaciones[$i + 1]->lat, 'lng' =>  $ubicaciones[$i + 1]->lng]
                        );
                        $suma = $suma + $response;
                    }
                }
                array_push($resultado, array(
                    "recorrido" => $suma,
                    "imei" => $dispositivo->imei,
                    "color" => $dispositivo->color,
                    "id" => $dispositivo->id,
                    "cadena" => $dispositivo->cadena,
                    "lat" => $dispositivo->lat,
                    "lng" => $dispositivo->lng,
                    "fecha" => $dispositivo->fecha,
                    "placa" => $dispositivo->placa,
                    "marca" => $dispositivo->marca,
                    "modelo" => $dispositivo->modelo,
                    "nombre" => $dispositivo->nombre
                ));
            }

            return $resultado;
        }
    }
    public function gpsposicion()
    {
        $data = array();
        $dispositivos = Dispositivo::cursor()->filter(function ($dispositivo) {
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


        foreach ($dispositivos as $dispositivo) {
            $dispositivo_array = array(
                "imei" => "", "color" => "", "cadena" => "", "lat" => "", "lng" => "", "fecha" => "",
                "placa" => "", "marca" => "", "modelo" => "", "nombre" => "", "estado" => "", "velocidad" => ""
            );
            $dispositivo_array["color"] = $dispositivo->color;
            $dispositivo_array["placa"] = $dispositivo->placa;
            $dispositivo_array["marca"] = $dispositivo->marca;
            $dispositivo_array["modelo"] = $dispositivo->modelo;
            $dispositivo_array["nombre"] = $dispositivo->nombre;
            $dispositivo_array["imei"] = $dispositivo->imei;
            $consulta = DB::table('dispositivo_ubicacion')->where('imei', $dispositivo->imei);
            if ($consulta->count() == 0) {

                $dispositivo_array["estado"] = "sin data";
                array_push($data, $dispositivo_array);
            } else {
                $consulta = $consulta->first();
                $dispositivo_array["cadena"] = $consulta->cadena;
                $dispositivo_array["lat"] = $consulta->lat;
                $dispositivo_array["lng"] = $consulta->lng;
                $dispositivo_array["fecha"] = $consulta->fecha;
                $velocidad_km = "0 kph";
                if ($dispositivo->nombre == "TRACKER303") {
                    $arreglo_cadena = explode(',', $consulta->cadena);
                    if (count($arreglo_cadena) >= 11) {
                        $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                        $velocidad_km = $velocidad_km . " kph";
                    }
                } else if ($dispositivo->nombre == "MEITRACK") {
                    $arreglo_cadena = explode(',', $consulta->cadena);

                    $velocidad_km = floatval($arreglo_cadena[10]) . " kph";
                }
                $dispositivo_array["velocidad"] = $velocidad_km;
                $dispositivo_array["estado"] = "data";
                array_push($data, $dispositivo_array);
            }
        }
        return $data;
    }
    public function prueba()
    {
        $response =  \GeometryLibrary\SphericalUtil::computeHeading(
            ['lat' => -8.411392, 'lng' => -78.803548], // from array [lat, lng]
            ['lat' => -8.415631, 'lng' =>-78.789221]); // to array [lat, lng]
        echo $response;
    }
    public function gpsestado(Request $request)
    {
        $user = Auth::user();
        $arreglo = array();

        $dispositivos = dispositivo_user($user);
        foreach ($dispositivos as $dispositivo) {
            $valor = DB::table('estadodispositivo')->where('cadena', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();

            if ($valor != "") {
                $valor = DB::table('estadodispositivo')->where('imei', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();
                if ($valor->estado == "Desconectado") {
                    $arreglo[] = array('imei' => $dispositivo->imei, 'estado' => "Desconectado", 'movimiento' => "Sin Movimiento");
                } else {
                    $arreglo[] = array('imei' => $dispositivo->imei, 'estado' => $valor->estado, 'movimiento' => $valor->movimiento);
                }
            } else {
                $arreglo[] = array('imei' => $dispositivo->imei, 'estado' => "Desconectado", 'movimiento' => "Sin Movimiento");
            }
        }

        return json_encode($arreglo);
    }
    public function verificardispositivo(Request $request)
    {
        $valor = true;
        if (DB::table('ubicacion')->where('imei', $request->imei)->where('lat', '!=', '0')->where('lng', '!=', '0')->count() == 0) {
            $valor = false;
        }
        return json_encode(array("existe" => $valor));
    }
    public function movimiento(Request $request)
    {
        $user = Auth::user();
        $activos = dispositivo_activos($user);
        $inactivos = dispositivo_inactivos($user);
        $resultado = array();
        $resultado = array("activos" => $activos, "inactivos" => $inactivos);
        return $resultado;
    }
    public function ruta(Request $request)
    {
        $data = array();
        $fila = DB::table('ubicacion_recorrido as ur')->join('dispositivo as d','d.imei','=','ur.imei')
                            ->select('ur.*','d.nombre','d.placa')
                            ->where('ur.imei', $request->imei)->orderBy('ur.fecha', 'asc')->get();
        for ($i = 0; $i < count($fila); $i++) {

            $arreglo_cadena = explode(',', $fila[$i]->cadena);
            $velocidad_km="0 kph";
            $altitud="0 Metros";
            $odometro="0 Km";
            $nivelCombustible="0%";
            $volumenCombustible="0.0 gal";
            $horaDelMotor="0.0";
            $intensidadSenal="0.0";
            $estado="Sin Movimiento";

            if ($fila[$i]->nombre == "TRACKER303") {


                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $vkm=$velocidad_km;
                    $estado=($velocidad_km<=0)?$estado:"En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km). " kph";

            } else if ($fila[$i]->nombre == "MEITRACK") {

                $velocidad_km = floatval($arreglo_cadena[10]);
                $vkm=$velocidad_km;
                $estado=($velocidad_km<=0)?$estado:"En Movimiento";
                $altitud = $arreglo_cadena[13];
                $velocidad_km = sprintf("%.2f", $velocidad_km). " kph";
            }

            if($vkm>2)
            {
                array_push($data, array("placa"=>$fila[$i]->placa,
                "imei" => $fila[$i]->imei,
                "estado"=>$estado,
                "lat" => $fila[$i]->lat,
                "intensidadSenal"=>$intensidadSenal,
                "lng" => $fila[$i]->lng,
                "fecha" => $fila[$i]->fecha,
                "altitud" => $altitud,
                "velocidad"=>$velocidad_km,
                "nivelCombustible" =>$nivelCombustible,
                "volumenCombustible" =>$volumenCombustible,
                "horaDelMotor" =>$horaDelMotor,
                "direccion"=>$fila[$i]->direccion,
                "odometro"=>$odometro));
            }

        }
        return $data;
    }
}
