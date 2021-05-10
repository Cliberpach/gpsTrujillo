<?php

namespace App\Http\Controllers;

use App\Rangos;
use App\Rangoscarateristicas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RangoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rangos.index');
    }
    public function getTable()
    {
        $data=DB::table('rangos')->where('estado','ACTIVO')->get();
        return Datatables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('rangos.store');
        $rangos= new Rangos();
        return view('rangos.create')->with(compact('action','rangos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $rango=new Rangos();
            $rango->nombre=$request->nombre;
            $rango->save();
       
                $var=json_decode($request->posiciones_guardar);
                for($i = 0; $i < count($var); $i++) {
                    $contratorango=new Rangoscarateristicas();
                    $contratorango->rango_id=$rango->id;
                    $contratorango->lat=$var[$i][0];
                    $contratorango->lng=$var[$i][1];
                    $contratorango->save();
                }
                return redirect()->route('rangos.index')->with('guardar', 'success');
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
       
        $rangos = Rangos::findOrFail($id);
        
        $put = True;
        $action = route('rangos.update', $id);
        $detalle=True;
        $detalle_gps=DB::table('rangospuntos')->where('rango_id',$id)->get();


        return view('rangos.edit', [
            'rangos' => $rangos,
            'action' => $action,
            'put' => $put,
            'detalle'=>$detalle,
            'detalle_gps'=>$detalle_gps,
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
        $rango=Rangos::findOrFail($request->rango_id);
        $rango->nombre=$request->nombre;
        $rango->save();
   
            Rangoscarateristicas::where('rango_id', $id)->delete();
            $var=json_decode($request->posiciones_guardar);
            for($i = 0; $i < count($var); $i++) {
                $contratorango=new Rangoscarateristicas();
                $contratorango->rango_id=$rango->id;
                $contratorango->lat=$var[$i][0];
                $contratorango->lng=$var[$i][1];
                $contratorango->save();
            }
            return redirect()->route('rangos.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rango = Rangos::findOrFail($id);
        $rango->estado='ANULADO';
        $rango->save();
        return redirect()->route('rangos.index')->with('guardar', 'success');
    }
}
