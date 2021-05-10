<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RMapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rmapa.index');
    }
    public function dispositivoruta(Request $request)
    {
        $fecha_inicio=$request->fecha_pasada;
        $fecha_final=$request->fecha_actual;
        $data=DB::table('ubicacion as u')
        ->join('dispositivo as d','d.imei','=','u.imei')
        ->select('u.*','d.placa','d.marca','d.color')
        ->where('u.lat','!=','0')
        ->where('u.lng','!=','0')
        ->where('d.imei',$request->imei)->whereBetween('fecha', [$fecha_inicio,$fecha_final])
        ->get();
        return $data;
    }
    public function dispositivos(Request $request)
    {    $user=\Auth::user();
        return json_encode(dispositivo_user($user));
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

}
