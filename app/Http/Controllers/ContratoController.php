<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\DetalleContrato;
use App\Estadodispositivo;
use App\Contratorango;
use App\Rango;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
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
      /*  return datatables()->query(
            DB::table('contrato')
            ->join('empresas','empresas.id','=','empresa_id')
            ->join('clientes','clientes.id','=','cliente_id')
            ->select('contrato.*','empresas.nombre_comercial','clientes.nombre')
            ->where('contrato.estado','ACTIVO')
            ->orderBy('contrato.id', 'desc')  
              )->toJson();*/
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
        return view('contrato.create')->with(compact('action','contrato'));
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
            'empresa'=>'required_without:cliente',
            'cliente'=>'required_without:empresa',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'dispositivo_tabla'=>'required',
        
            
        ];
        $message = [
            'cliente.required_without'=>'ingrese el campo cliente',
            'empresa.required_without'=>"ingrese el campo empresa",
            'fecha_inicio.required'=>'El campo fecha inicio es obligatorio',
            'fecha_fin.required' => 'El campo fecha fin  es Obligatorio',
            'dispositivo_tabla.required'=>'No hay dispositivos',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $contrato = new Contrato();
        $contrato->fecha_inicio = Carbon::createFromFormat('Y/m/d', $request->fecha_inicio)->format('Y-m-d');
        $contrato->fecha_fin= Carbon::createFromFormat('Y/m/d', $request->fecha_fin)->format('Y-m-d');
        
        if($request->empresa==null)
        {
          $contrato->empresa_id = '0';
        }
        else{
            $contrato->empresa_id = $request->empresa;
            
        }

        if($request->cliente==null)
        {
          $contrato->cliente_id = '0';
        }
        else{
            $contrato->cliente_id = $request->cliente;
            
        }
        $contrato->costo_contrato = 0;
        $contrato->pago_total=0;
        $contrato->save();

        
      //  $dispositivosJSON = $request->get('dispositivo_tabla');
        //$dispositivotabla = json_decode($dispositivosJSON[0]);
        
        // return $var;
    
        $var=json_decode($request->dispositivo_tabla);
        $pago_total=0;
        $costo_contrato=0;
         for($i = 0; $i < count($var); $i++) {
            $pago_total= $pago_total+$var[$i]->pago;
            $costo_contrato= $costo_contrato+$var[$i]->costo;
            Detallecontrato::create([
                'contrato_id' => $contrato->id,
                'dispositivo_id' => $var[$i]->dispositivo_id,
                'pago' => $var[$i]->pago,
                'costo_instalacion' => $var[$i]->costo,
                
            ]);
            $imei=DB::table('dispositivo')->where('id',$var[$i]->dispositivo_id)->first();
            if(DB::table('estadodispositivo')->where('imei',$imei->imei)->count()==0)
            {
                Estadodispositivo::create([
                    'imei' => $imei->imei,
                    'estado' => "Desconectado",
                    'fecha' =>  date('Y-m-d H:i:s'),
                    'movimiento' => "Sin Movimiento",
                    'cadena'=>$imei->imei,
                    
                ]);
            }
        }
        $contrato->pago_total=$pago_total;
        $contrato->costo_contrato = $costo_contrato;
        $contrato->save();

        if($request->posiciones_guardar!="[]" && $request->posiciones_guardar!="")
        {
            $cl=DB::table("clientes")->where('id',$request->cliente)->first();
            $emp=DB::table("empresas")->where('id',$request->empresa)->first();
              
            $rango=new Rango();
            if($cl->nombre=="")
            {
                $rango->nombre="Rango"."_".$emp->nombre_comercial;
            }
            else if($emp->nombre_comercial==""){
                $rango->nombre="Rango"."_".$cl->nombre."_";
            }
            else
            {
                $rango->nombre="Rango"."_".$cl->nombre."_".$emp->nombre_comercial;
            }
            $rango->save();
    
            $var=json_decode($request->posiciones_guardar);
            for($i = 0; $i < count($var); $i++) {
                $contratorango=new Contratorango();
                $contratorango->rango_id=$rango->id;
                $contratorango->contrato_id=$contrato->id;
                $contratorango->lat=$var[$i][0];
                $contratorango->lng=$var[$i][1];
                $contratorango->save();
            }
        }
       
        

        //Registro de actividad

        Session::flash('success','Cliente creado.');
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
        $detalle=True;
        $detalle_gps=DB::table('contratorango')->where('contrato_id',$id)->get();
        $detallecontrato=DB::table('detallecontrato')
        ->join('dispositivo','dispositivo.id','=','detallecontrato.dispositivo_id')
        ->select('detallecontrato.*','dispositivo.nombre','dispositivo.placa')
        ->where('contrato_id',$id)
        ->where('detallecontrato.estado','ACTIVO')->get();

        return view('contrato.edit', [
            'contrato' => $contrato,
            'action' => $action,
            'put' => $put,
            'detalle'=>$detalle,
            'detalle_gps'=>$detalle_gps,
            'detallecontrato'=>json_encode($detallecontrato)
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
            'empresa'=>'required_without:cliente',
            'cliente'=>'required_without:empresa',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'dispositivo_tabla'=>'required',
        
            
        ];
        $message = [
            'cliente.required_without'=>'ingrese el campo cliente',
            'empresa.required_without'=>"ingrese el campo empresa",
            'fecha_inicio.required'=>'El campo fecha inicio es obligatorio',
            'fecha_fin.required' => 'El campo fecha fin  es Obligatorio',
            'dispositivo_tabla.required'=>'No hay dispositivos',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $contrato = Contrato::findOrFail($id);
        $contrato->fecha_inicio = Carbon::createFromFormat('Y/m/d', $request->fecha_inicio)->format('Y-m-d');
        $contrato->fecha_fin= Carbon::createFromFormat('Y/m/d', $request->fecha_fin)->format('Y-m-d');
        
        if($request->empresa==null)
        {
          $contrato->empresa_id = '0';
        }
        else{
            $contrato->empresa_id = $request->empresa;
            
        }

        if($request->cliente==null)
        {
          $contrato->cliente_id = '0';
        }
        else{
            $contrato->cliente_id = $request->cliente;
            
        }
        $contrato->costo_contrato =0;
        $contrato->pago_total=0;
        $contrato->save();

        
      //  $dispositivosJSON = $request->get('dispositivo_tabla');
        //$dispositivotabla = json_decode($dispositivosJSON[0]);
        
        // return $var;
        Detallecontrato::where('contrato_id', $id)->delete();
        $var=json_decode($request->dispositivo_tabla);
        $pago_total=0;
        $costo_contrato=0;
         for($i = 0; $i < count($var); $i++) {
            $pago_total= $pago_total+$var[$i]->pago;
            $costo_contrato= $costo_contrato+$var[$i]->costo;
            Detallecontrato::create([
                'contrato_id' => $contrato->id,
                'dispositivo_id' => $var[$i]->dispositivo_id,
                'pago' => $var[$i]->pago,
                'costo_instalacion' => $var[$i]->costo,
                
            ]);
            $imei=DB::table('dispositivo')->where('id',$var[$i]->dispositivo_id)->first();
            if(DB::table('estadodispositivo')->where('imei',$imei->imei)->count()==0)
            {
                Estadodispositivo::create([
                    'imei' => $imei->imei,
                    'estado' => "Desconectado",
                    'fecha' =>  date('Y-m-d H:i:s'),
                    'movimiento' => "Sin Movimiento",
                    'cadena'=>$imei->imei,
                    
                ]);
            }
        }
        $contrato->pago_total=$pago_total;
        $contrato->costo_contrato = $costo_contrato;
        $contrato->save();
        
        $cl=DB::table("clientes")->where('id',$request->cliente)->first();
        $emp=DB::table("empresas")->where('id',$request->empresa)->first();
          
        if($request->rango_id!="")
        {
            $rango=Rango::findOrFail($request->rango_id);
            if($cl->nombre=="")
            {
                $rango->nombre="Rango"."_".$emp->nombre_comercial;
            }
            else if($emp->nombre_comercial==""){
                $rango->nombre="Rango"."_".$cl->nombre."_";
            }
            else
            {
                $rango->nombre="Rango"."_".$cl->nombre."_".$emp->nombre_comercial;
            }
            $rango->save();
                    Contratorango::where('contrato_id', $id)->delete();
                $var=json_decode($request->posiciones_guardar);
                for($i = 0; $i < count($var); $i++) {
                    $contratorango=new Contratorango();
                    $contratorango->rango_id=$rango->id;
                    $contratorango->contrato_id=$contrato->id;
                    $contratorango->lat=$var[$i][0];
                    $contratorango->lng=$var[$i][1];
                    $contratorango->save();
                }
        }
        
       

        

        //Registro de actividad

        return redirect()->route('contrato.index')->with('guardar', 'success');
      
    }
    /*public function getdispositivos(Request $request){
            $empresa_id=$request->empresa;
            $cliente_id=$request->cliente;
            $data=array();
            if($empresa_id!=null)
            {
                 if($cliente_id!=null)
                 {


                 }
                 else
                 {
                    DB::table('empresas')
                    ->join('dispositivoempresa','dispositivoempresa.empresa_id','=','empresas.id')
                    ->join('tipodispositivo','tipodispositivo.id','=','dispositivoempresa.tipodispositivo_id')
                    ->select()
                    ->where('empresas.id',$empresa_id)
                    ->get();  
                 }
            

            }
            else{
            }
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contrato = Contrato::findOrFail($id);
        $contrato->estado='ANULADO';
        $contrato->save();
        return redirect()->route('contrato.index')->with('guardar', 'success');
    }
    public function rangospuntos(Request $request)
    {
        return  DB::table("rangospuntos")->where("rango_id",$request->id)->get();
    }
}
