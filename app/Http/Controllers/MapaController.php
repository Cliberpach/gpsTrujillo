<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notificacion;
use App\Rango;

class MapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mapa.index');
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
        $user= $request->user();
        return DB::table('notificaciones')->where('user_id',$user->id)->orderByDesc('creado')
        ->limit(7)->get();
    }
    public function notificacion_vista(Request $request)
    {
        $user= $request->user();
        Notificacion::where('user_id', $user->id)
        ->update(['read_user' => "1"]);
        return "Exito";
    }
    public function agregar_rango(Request $request)
    {
        DB::table('rango')->truncate();
        $var=json_decode($request->posiciones_guardar);
        for($i = 0; $i < count($var); $i++) {
            $rango=new Rango();
            $rango->nombre=($i+1)."-posicion";
            $rango->lat=$var[$i][0];
            $rango->lng=$var[$i][1];
            $rango->save();
        }
        return redirect()->route('mapas.rango');
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

            } elseif ($fila[$i]->nombre == "MEITRACK") {

                $velocidad_km = floatval($arreglo_cadena[10]);
                $vkm=$velocidad_km;
                $estado=($velocidad_km<=0)?$estado:"En Movimiento";
                $altitud = $arreglo_cadena[13];
                $velocidad_km = sprintf("%.2f", $velocidad_km). " kph";
            }
            elseif ($fila[$i]->nombre == "TELTONIKA12O") {
                $velocidad_km = floatval($arreglo_cadena[3]);
                $vkm=$velocidad_km;
                $estado=($velocidad_km<=0)?$estado:"En Movimiento";
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
