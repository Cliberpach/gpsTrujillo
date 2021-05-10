<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dispositivo;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade;

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
	     $dispositivo=Dispositivo::findOrFail($request->dispositivo);
         return DB::select("select m.* from  dispositivo as d inner join (select * from historial union select * from ubicacion) as m on m.imei=d.imei where d.estado='ACTIVO' and m.lat!='0' and m.lng!='0' and d.id='".$dispositivo->id."' and (m.fecha between '".$request->fechainicio."' and  '".$request->fechafinal."')");
    }
    public function alerta()
    {
        return view('reportes.alerta');
    }
    public function reportemovimiento(Request $request)
    {
        $arreglo=json_decode($request->arreglo_reporte);
        $cliente=DB::table('contrato as c')
                ->join('detallecontrato as dc','c.id','=','dc.contrato_id')
                ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
                ->join('clientes as cl','cl.id','=','c.cliente_id')
                ->select('d.nombre as ndispositivo','cl.nombre','d.placa','d.color')
                ->where('d.id','=',$request->dispositivo_reporte)->first();
        $pdf =Facade::loadview('reportes.pdf.pdfmovimiento',['fecha' => $request->fecha_reporte,
            'hinicio' => $request->hinicio_reporte,
            'hfinal' => $request->hfinal_reporte,
            'dispositivo' => $cliente->ndispositivo,
            'placa' => $cliente->placa,
            'color' => $cliente->color,
            'cliente'=>$cliente->nombre,
            'arreglodispositivo' =>$arreglo,
            ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
    public function reportealerta(Request $request)
    {
        $arreglo=json_decode($request->arreglo_reporte);
        $cliente=DB::table('contrato as c')
                ->join('detallecontrato as dc','c.id','=','dc.contrato_id')
                ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
                ->join('clientes as cl','cl.id','=','c.cliente_id')
                ->select('d.nombre as ndispositivo','cl.nombre','d.placa','d.color')
                ->where('d.id','=',$request->dispositivo_reporte)->first();
        $pdf =Facade::loadview('reportes.pdf.pdfalerta',['fecha' => $request->fecha_reporte,
            'hinicio' => $request->hinicio_reporte,
            'hfinal' => $request->hfinal_reporte,
            'dispositivo' => $cliente->ndispositivo,
            'placa' => $cliente->placa,
            'color' => $cliente->color,
            'alerta' => $request->alerta,
            'cliente'=>$cliente->nombre,
            'arreglodispositivo' =>$arreglo,
            ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
    public function datalerta(Request $request)
    { 
        
        $dispositivo=Dispositivo::findOrFail($request->dispositivo);
        $fecha_inicio=$request->fechainicio;
        $fecha_final=$request->fechafinal;
        $alerta=$request->alerta;

        if($fecha_inicio!="")
        {  

            if($alerta!="")
            {
                return DB::table('notificaciones as n')
                ->join('alertas as a','a.informacionalerta','=','n.informacion')
                ->select('n.*')
                ->where('a.id',$alerta)
                ->where('n.extra',$dispositivo->imei)->whereBetween('n.creado', [$fecha_inicio,$fecha_final])->get();
            }else
            {
                return DB::table('notificaciones')->where('extra',$dispositivo->imei)->whereBetween('creado', [$fecha_inicio,$fecha_final])->get();
            }
            
            

        
        }
        else
        {
            if($alerta!="")
            {
                return DB::table('notificaciones as n')
                ->join('alertas as a','a.informacionalerta','=','n.informacion')
                ->select('n.*')
                ->where('a.id',$alerta)
                ->where('n.extra',$dispositivo->imei)->get();
            }else
            {
            
            return DB::table('notificaciones')->where('extra',$dispositivo->imei)->get();
            }
        }

    }
}
