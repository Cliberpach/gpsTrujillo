<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\DetalleContrato;
use App\Estadodispositivo;
use App\Contratorango;
use App\DetalleContratoRango;
use App\Rango;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contrato.index');
    }
    public function getTable()
    {
        // $contratos = Contrato::where('estado', 'activo')->get();
        // $coleccion = collect([]);
        // foreach ($contratos as $contrato) {
        //     $arreglo = array();
        //     if ($contrato->empresa_id == 0) {
        //         $cliente = DB::table('clientes')->where('id', $contrato->cliente_id)->first();
        //         $arreglo = array('nombre' => $cliente->nombre);
        //     } else {
        //         $empresa = DB::table('empresas')->where('id', $contrato->empresa_id)->first();
        //         if ($contrato->cliente_id == 0) {
        //             $arreglo = array('nombre' => "Vacio");
        //         } else {

        //             $cliente = DB::table('clientes')->where('id', $contrato->cliente_id)->first();
        //             $arreglo = array('nombre' => $cliente->nombre);
        //         }
        //     }
        //     $arreglo = $arreglo + array(
        //         'id' => $contrato->id,
        //         'nombre_comercial' => $empresa->nombre_comercial,
        //         'fecha_inicio' => $contrato->fecha_inicio,
        //         'fecha_fin' => $contrato->fecha_fin,
        //         'pago_total' => $contrato->pago_total,
        //         'costo_contrato' => $contrato->costo_contrato
        //     );
        //     $coleccion->push($arreglo);
        // }
        // return DataTables::of($coleccion)->toJson();
        $contratos=Contrato::where('estado','activo')->get();
        $coleccion= collect([]);
        foreach($contratos as $contrato)
        {
            if($contrato->empresa_id==0)
            {
              $cliente=DB::table('clientes')->where('id',$contrato->cliente_id)->first();
              $coleccion->push(['id'=>$contrato->id,
                              'nombre_comercial'=>"Vacio",
                              'nombre'=>$cliente->nombre,
                              'fecha_inicio'=>$contrato->fecha_inicio,
                              'fecha_fin'=>$contrato->fecha_fin,
                              'pago_total'=>$contrato->pago_total,
                              'costo_contrato'=>$contrato->costo_contrato
                             
                           ]);
          
            }
            else{
                $empresa=DB::table('empresas')->where('id',$contrato->empresa_id)->first();
                if($contrato->cliente_id==0)
                {
              
                  $coleccion->push(['id'=>$contrato->id,
                                  'nombre_comercial'=>$empresa->nombre_comercial,
                                  'nombre'=>"Vacio",
                                  'fecha_inicio'=>$contrato->fecha_inicio,
                                  'fecha_fin'=>$contrato->fecha_fin,
                                  'pago_total'=>$contrato->pago_total,
                                  'costo_contrato'=>$contrato->costo_contrato
                               ]);
              
                }
                else{
                   
                    $cliente=DB::table('clientes')->where('id',$contrato->cliente_id)->first();
                    $coleccion->push(['id'=>$contrato->id,
                          'nombre_comercial'=>$empresa->nombre_comercial,
                          'nombre'=>$cliente->nombre,
                          'fecha_inicio'=>$contrato->fecha_inicio,
                          'fecha_fin'=>$contrato->fecha_fin,
                          'pago_total'=>$contrato->pago_total,
                          'costo_contrato'=>$contrato->costo_contrato
                    ]);
                }
            }
            
            
        }
        return DataTables::of($coleccion)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('contrato.store');
        $contrato = new Contrato();
        return view('contrato.create')->with(compact('action', 'contrato'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //  Log::info(count($vv));
        //return json_decode($request->posiciones_guardar);
        $data = $request->all();

        $rules = [
            'empresa' => 'required_without:cliente',
            'cliente' => 'required_without:empresa',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'dispositivo_tabla' => 'required',


        ];
        $message = [
            'cliente.required_without' => 'ingrese el campo cliente',
            'empresa.required_without' => "ingrese el campo empresa",
            'fecha_inicio.required' => 'El campo fecha inicio es obligatorio',
            'fecha_fin.required' => 'El campo fecha fin  es Obligatorio',
            'dispositivo_tabla.required' => 'No hay dispositivos',
        ];

        Validator::make($data, $rules, $message)->validate();

        $contrato = new Contrato();
        $contrato->fecha_inicio = Carbon::createFromFormat('Y/m/d', $request->fecha_inicio)->format('Y-m-d');
        $contrato->fecha_fin = Carbon::createFromFormat('Y/m/d', $request->fecha_fin)->format('Y-m-d');
         $contrato->empresa_id = $request->empresa;
         $contrato->cliente_id = $request->cliente;
        if ($request->empresa == null) {
            $contrato->empresa_id = '0';
        }
        if ($request->cliente == null) {
            $contrato->cliente_id = '0';
        }
        $contrato->costo_contrato = 0;
        $contrato->pago_total = 0;
        $contrato->save();

        $var = json_decode($request->dispositivo_tabla);
        $pago_total = 0;
        $costo_contrato = 0;
        for ($i = 0; $i < count($var); $i++) {
            $pago_total = $pago_total + $var[$i]->pago;
            $costo_contrato = $costo_contrato + $var[$i]->costo;
            Detallecontrato::create([
                'contrato_id' => $contrato->id,
                'dispositivo_id' => $var[$i]->dispositivo_id,
                'pago' => $var[$i]->pago,
                'costo_instalacion' => $var[$i]->costo,

            ]);
            $imei = DB::table('dispositivo')->where('id', $var[$i]->dispositivo_id)->first();
            if (DB::table('estadodispositivo')->where('imei', $imei->imei)->count() == 0) {
                Estadodispositivo::create([
                    'imei' => $imei->imei,
                    'estado' => "Desconectado",
                    'fecha' =>  date('Y-m-d H:i:s'),
                    'movimiento' => "Sin Movimiento",
                    'cadena' => $imei->imei,

                ]);
            }
        }
        $contrato->pago_total = $pago_total;
        $contrato->costo_contrato = $costo_contrato;
        $contrato->save();

        if ($request->posiciones_guardar != "[]" && $request->posiciones_guardar != "") {
            $cl = DB::table("clientes")->where('id', $request->cliente)->first();
            $emp = DB::table("empresas")->where('id', $request->empresa)->first();

            $rango = new Rango();
            if ($cl->nombre == "") {
                $rango->nombre = "Rango" . "_" . $emp->nombre_comercial;
            } else if ($emp->nombre_comercial == "") {
                $rango->nombre = "Rango" . "_" . $cl->nombre . "_";
            } else {
                $rango->nombre = "Rango" . "_" . $cl->nombre . "_" . $emp->nombre_comercial;
            }
            $rango->save();

            $vv = json_decode($request->posiciones_guardar);

            for ($i = 0; $i < count($vv); $i++) {

                $contratorango = new Contratorango();
                $contratorango->rango_id = $rango->id;
                $contratorango->contrato_id = $contrato->id;
                $contratorango->nombre = $vv[$i]->nombre;
                $contratorango->save();
                for ($j = 0; $j < count($vv[$i]->geocerca); $j++) {
                    $detalle_contratorango = new DetalleContratoRango();
                    $detalle_contratorango->contratorango_id = $contratorango->id;
                    $detalle_contratorango->lat = $vv[$i]->geocerca[$j][0];
                    $detalle_contratorango->lng = $vv[$i]->geocerca[$j][1];
                    $detalle_contratorango->save();
                }
            }
        }



        //Registro de actividad

        Session::flash('success', 'Cliente creado.');
        return redirect()->route('contrato.index')->with('guardar', 'success');
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
        $contrato = Contrato::findOrFail($id);

        $put = True;
        $action = route('contrato.update', $id);
        $detalle = True;
        // $detalle_gps=DB::table('contratorango')->where('contrato_id',$id)->get();
        $detallecontrato = DB::table('detallecontrato')
            ->join('dispositivo', 'dispositivo.id', '=', 'detallecontrato.dispositivo_id')
            ->select('detallecontrato.*', 'dispositivo.nombre', 'dispositivo.placa')
            ->where('contrato_id', $id)
            ->where('detallecontrato.estado', 'ACTIVO')->get();
        $detalle_gps = array();
        $contrato_rango = DB::table('contratorango')->where('contrato_id', $id)->get();

        $rangoid = 0;
        if (DB::table('contratorango')->where('contrato_id', $id)->count() != 0) {
            $rangoid = DB::table('contratorango')->where('contrato_id', $id)->first()->rango_id;
        }

        foreach ($contrato_rango as $cr) {
            $detalle_contrato = DB::table('detalle_contratorango')->where('contratorango_id', $cr->id)->get();
            $detalle_array = array();
            foreach ($detalle_contrato as $dc) {
                array_push($detalle_array, array($dc->lat, $dc->lng));
            }
            array_push($detalle_gps, array("geocerca" => $detalle_array, "nombre" => $cr->nombre));
        }

        return view('contrato.edit', [
            'contrato' => $contrato,
            'action' => $action,
            'put' => $put,
            'detalle' => $detalle,
            'detalle_gps' => json_encode($detalle_gps),
            'detallecontrato' => json_encode($detallecontrato),
            'rango_id' => $rangoid
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
            'empresa' => 'required_without:cliente',
            'cliente' => 'required_without:empresa',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'dispositivo_tabla' => 'required',


        ];
        $message = [
            'cliente.required_without' => 'ingrese el campo cliente',
            'empresa.required_without' => "ingrese el campo empresa",
            'fecha_inicio.required' => 'El campo fecha inicio es obligatorio',
            'fecha_fin.required' => 'El campo fecha fin  es Obligatorio',
            'dispositivo_tabla.required' => 'No hay dispositivos',
        ];

        Validator::make($data, $rules, $message)->validate();

        $contrato = Contrato::findOrFail($id);
        $contrato->fecha_inicio = Carbon::createFromFormat('Y/m/d', $request->fecha_inicio)->format('Y-m-d');
        $contrato->fecha_fin = Carbon::createFromFormat('Y/m/d', $request->fecha_fin)->format('Y-m-d');
        $contrato->empresa_id = $request->empresa;
        $contrato->cliente_id = $request->cliente;
        if ($request->empresa == null) {
            $contrato->empresa_id = '0';
        }

        if ($request->cliente == null) {
            $contrato->cliente_id = '0';
        }
        $contrato->costo_contrato = 0;
        $contrato->pago_total = 0;
        $contrato->save();


        //  $dispositivosJSON = $request->get('dispositivo_tabla');
        //$dispositivotabla = json_decode($dispositivosJSON[0]);

        // return $var;
        Detallecontrato::where('contrato_id', $id)->delete();
        $var = json_decode($request->dispositivo_tabla);
        $pago_total = 0;
        $costo_contrato = 0;
        for ($i = 0; $i < count($var); $i++) {
            $pago_total = $pago_total + $var[$i]->pago;
            $costo_contrato = $costo_contrato + $var[$i]->costo;
            Detallecontrato::create([
                'contrato_id' => $contrato->id,
                'dispositivo_id' => $var[$i]->dispositivo_id,
                'pago' => $var[$i]->pago,
                'costo_instalacion' => $var[$i]->costo,

            ]);
            $imei = DB::table('dispositivo')->where('id', $var[$i]->dispositivo_id)->first();
            if (DB::table('estadodispositivo')->where('imei', $imei->imei)->count() == 0) {
                Estadodispositivo::create([
                    'imei' => $imei->imei,
                    'estado' => "Desconectado",
                    'fecha' =>  date('Y-m-d H:i:s'),
                    'movimiento' => "Sin Movimiento",
                    'cadena' => $imei->imei,

                ]);
            }
        }
        $contrato->pago_total = $pago_total;
        $contrato->costo_contrato = $costo_contrato;
        $contrato->save();

        $cl = DB::table("clientes")->where('id', $request->cliente)->first();
        $emp = DB::table("empresas")->where('id', $request->empresa)->first();

        if ($request->posiciones_guardar != "[]" && $request->posiciones_guardar != "") {
            if ($request->rango_id == 0) {
                $rango = new Rango();
                if ($cl->nombre == "") {
                    $rango->nombre = "Rango" . "_" . $emp->nombre_comercial;
                } else if ($emp->nombre_comercial == "") {
                    $rango->nombre = "Rango" . "_" . $cl->nombre . "_";
                } else {
                    $rango->nombre = "Rango" . "_" . $cl->nombre . "_" . $emp->nombre_comercial;
                }
                $rango->save();
            } else {
                $rango = Rango::findOrFail($request->rango_id);
                if ($cl->nombre == "") {
                    $rango->nombre = "Rango" . "_" . $emp->nombre_comercial;
                } else if ($emp->nombre_comercial == "") {
                    $rango->nombre = "Rango" . "_" . $cl->nombre . "_";
                } else {
                    $rango->nombre = "Rango" . "_" . $cl->nombre . "_" . $emp->nombre_comercial;
                }
                $rango->save();
            }


            Contratorango::where('contrato_id', $id)->delete();
            $vv = json_decode($request->posiciones_guardar);

            for ($i = 0; $i < count($vv); $i++) {

                $contratorango = new Contratorango();
                $contratorango->rango_id = $rango->id;
                $contratorango->contrato_id = $contrato->id;
                $contratorango->nombre = $vv[$i]->nombre;
                $contratorango->save();
                for ($j = 0; $j < count($vv[$i]->geocerca); $j++) {
                    $detalle_contratorango = new DetalleContratoRango();
                    $detalle_contratorango->contratorango_id = $contratorango->id;
                    $detalle_contratorango->lat = $vv[$i]->geocerca[$j][0];
                    $detalle_contratorango->lng = $vv[$i]->geocerca[$j][1];
                    $detalle_contratorango->save();
                }
            }
        } else if ($request->posiciones_guardar == "[]") {

            $contratorango = Contratorango::where('contrato_id', $id);
            Rango::where('id', $contratorango->first()->rango_id)->delete();
            $contratorango->delete();
        }

        return redirect()->route('contrato.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contrato = Contrato::findOrFail($id);
        $contrato->estado = 'ANULADO';
        $contrato->save();
        return redirect()->route('contrato.index')->with('guardar', 'success');
    }
    public function rangospuntos(Request $request)
    {
        return  DB::table("rangospuntos")->where("rango_id", $request->id)->get();
    }
}
