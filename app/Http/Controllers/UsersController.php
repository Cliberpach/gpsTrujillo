<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\User;
use App\Empresa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
class UsersController extends Controller
{
    public function login()
    {
        if (\Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = \Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;
           //After successfull authentication, notice how I return json parameters
            return response()->json([
              'success' => true,
              'token' => $success,
              'user' => $user
          ]);
        } else {
       //if authentication is unsuccessfull, notice how I return json parameters
          return response()->json([
            'success' => false,
            'message' => 'Invalid Email or Password',
        ], 401);
        }
    }
    public function clientes(Request $request)
    {
        $user= $request->user();
        $id= $user->id;
        $cliente="";
        if(DB::table('clientes')->where('user_id',$id)->count()!=0)
        {
            $cliente= DB::table('clientes')->where('user_id',$id)->first();
            return Cliente::findOrFail($cliente->id);
        }
        else
        {
            $cliente= DB::table('empresas')->where('user_id',$id)->first();
            return Empresa::findOrFail($cliente->id);
        }
        
    }
    public function dispositivos_prueba(Request $request)
    {
        $user= $request->user();
        $id= $user->id;
        $arreglo=array();
        if(DB::table('clientes')->where('user_id',$id)->count()!=0)
        {
            $cliente= DB::table('clientes')->where('user_id',$id)->first();
            $dispositivos=DB::table('detallecontrato as dc')
            ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
            ->join('contrato as c','c.id','=','dc.contrato_id')
            ->select('d.*')
            ->where('c.cliente_id',$cliente->id)
            ->get(); 
       
           
            foreach($dispositivos as $dispositivo)
            {
                if(DB::table('ubicacion')->where('imei',$dispositivo->imei)->count()!=0)
                {
                   /*$ubicacion=DB::table('ubicacion')
                    ->selectRaw('imei,max(fecha)')
                    ->where('imei',$dispositivo->imei)
                    ->groupBy('imei')
                    ->first();*/
                    $ubicacion=DB::select(DB::raw('select u.lat,u.lng from (select imei,max(fecha) as fecha  from ubicacion where imei="'.$dispositivo->imei.'" and lat!=0 and lng!=0 group by imei) as ubi inner join ubicacion u on u.imei=ubi.imei where ubi.fecha=u.fecha'))[0];
                  $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                 $arreglo[]=array("id"=>$dispositivo->id,
                                "nombre"=>$dispositivo->nombre,
                                "imei"=>$dispositivo->imei,
                                "nrotelefono"=>$dispositivo->nrotelefono,
                                "operador"=>$dispositivo->operador,
                                "placa"=>$dispositivo->placa,
                                 "cliente_id"=>$dispositivo->cliente_id,
                                "modelo"=>$dispositivo->modelo,
                                "marca"=>$dispositivo->marca,
                                "pago"=>$dispositivo->pago,
                                "lat"=>$ubicacion->lat,
                                "lng"=>$ubicacion->lng,
                                "estado"=>$estado->estado,
                                "movimiento"=>$estado->movimiento);
                }
                else
                {
                    $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                                    
                    $arreglo[]=array("id"=>$dispositivo->id,
                    "nombre"=>$dispositivo->nombre,
                    "imei"=>$dispositivo->imei,
                    "nrotelefono"=>$dispositivo->nrotelefono,
                    "operador"=>$dispositivo->operador,
                    "placa"=>$dispositivo->placa,
                     "cliente_id"=>$dispositivo->cliente_id,
                    "modelo"=>$dispositivo->modelo,
                    "marca"=>$dispositivo->marca,
                    "pago"=>$dispositivo->pago,
                    "lat"=>"0",
                    "lng"=>"0",
                    "estado"=>$estado->estado,
                    "movimiento"=>$estado->movimiento);
                }
            }
            
            //return DB::select('select d.*,ubi.fecha,u.lat,u.lng from (select u.imei,max(u.fecha) as fecha from detallecontrato as dc inner join contrato as c on dc.contrato_id=c.id inner join dispositivo as d on d.id=dc.dispositivo_id inner join clientes as cli on cli.id=c.cliente_id inner join ubicacion as u on u.imei=d.imei where cli.id="'.$cliente->id.'" group by u.imei) as ubi inner join dispositivo d on d.imei=ubi.imei inner join ubicacion u on u.imei=ubi.imei where u.fecha=ubi.fecha');
        }
        else
        {
            $empresa= DB::table('empresas')->where('user_id',$id)->first();
            $dispositivos=DB::table('detallecontrato as dc')
            ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
            ->join('contrato as c','c.id','=','dc.contrato_id')
            ->select('d.*')
            ->where('c.empresa_id',$empresa->id)
            ->get(); 
       
           
            foreach($dispositivos as $dispositivo)
            {
                if(DB::table('ubicacion')->where('imei',$dispositivo->imei)->count()!=0)
                {
                   /*$ubicacion=DB::table('ubicacion')
                    ->selectRaw('imei,max(fecha)')
                    ->where('imei',$dispositivo->imei)
                    ->groupBy('imei')
                    ->first();*/
                    $ubicacion=DB::select(DB::raw('select u.lat,u.lng from (select imei,max(fecha) as fecha  from ubicacion where imei="'.$dispositivo->imei.'" and lat!=0 and lng!=0 group by imei) as ubi inner join ubicacion u on u.imei=ubi.imei where ubi.fecha=u.fecha'))[0];
                  $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                 $arreglo[]=array("id"=>$dispositivo->id,
                                "nombre"=>$dispositivo->nombre,
                                "imei"=>$dispositivo->imei,
                                "nrotelefono"=>$dispositivo->nrotelefono,
                                "operador"=>$dispositivo->operador,
                                "placa"=>$dispositivo->placa,
                                 "empresa_id"=>$dispositivo->empresa_id,
                                "modelo"=>$dispositivo->modelo,
                                "marca"=>$dispositivo->marca,
                                "pago"=>$dispositivo->pago,
                                "lat"=>$ubicacion->lat,
                                "lng"=>$ubicacion->lng,
                                "estado"=>$estado->estado,
                                "movimiento"=>$estado->movimiento);
                }
                else
                {
                    $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                                    
                    $arreglo[]=array("id"=>$dispositivo->id,
                    "nombre"=>$dispositivo->nombre,
                    "imei"=>$dispositivo->imei,
                    "nrotelefono"=>$dispositivo->nrotelefono,
                    "operador"=>$dispositivo->operador,
                    "placa"=>$dispositivo->placa,
                     "empresa_id"=>$dispositivo->empresa_id,
                    "modelo"=>$dispositivo->modelo,
                    "marca"=>$dispositivo->marca,
                    "pago"=>$dispositivo->pago,
                    "lat"=>"0.0",
                    "lng"=>"0.0",
                    "estado"=>$estado->estado,
                    "movimiento"=>$estado->movimiento);
                }
            }
            
        }
        return $arreglo;
        
    }
    public function dispositivos(Request $request)
    {
       /* $user= $request->user();
        $id= $user->id;

        if(DB::table('clientes')->where('user_id',$id)->count()!=0)
        {
            $cliente= DB::table('clientes')->where('user_id',$id)->first();
            return DB::select('select d.*,ubi.fecha,u.lat,u.lng from (select u.imei,max(u.fecha) as fecha from detallecontrato as dc inner join contrato as c on dc.contrato_id=c.id inner join dispositivo as d on d.id=dc.dispositivo_id inner join clientes as cli on cli.id=c.cliente_id inner join ubicacion as u on u.imei=d.imei where cli.id="'.$cliente->id.'" group by u.imei) as ubi inner join dispositivo d on d.imei=ubi.imei inner join ubicacion u on u.imei=ubi.imei where u.fecha=ubi.fecha');
        }
        else
        {
            $cliente= DB::table('empresas')->where('user_id',$id)->first();
            return DB::select('select d.*,ubi.fecha,u.lat,u.lng  from (select u.imei,max(u.fecha) as fecha from detallecontrato as dc inner join contrato as c on dc.contrato_id=c.id inner join dispositivo as d on d.id=dc.dispositivo_id inner join empresas as emp on emp.id=c.empresa_id inner join ubicacion as u on u.imei=d.imei where emp.id="'.$cliente->id.'" group by u.imei) as ubi inner join dispositivo d on d.imei=ubi.imei inner join ubicacion u on u.imei=ubi.imei where u.fecha=ubi.fecha');
        }*/
        $user= $request->user();
        $id= $user->id;
        $arreglo=array();
        if(DB::table('clientes')->where('user_id',$id)->count()!=0)
        {
            $cliente= DB::table('clientes')->where('user_id',$id)->first();
            $dispositivos=DB::table('detallecontrato as dc')
            ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
            ->join('contrato as c','c.id','=','dc.contrato_id')
            ->select('d.*')
            ->where('c.cliente_id',$cliente->id)
            ->get(); 
       
           
            foreach($dispositivos as $dispositivo)
            {
                if(DB::table('ubicacion')->where('imei',$dispositivo->imei)->count()!=0)
                {
                   /*$ubicacion=DB::table('ubicacion')
                    ->selectRaw('imei,max(fecha)')
                    ->where('imei',$dispositivo->imei)
                    ->groupBy('imei')
                    ->first();*/

                  $val=DB::select(DB::raw('select u.lat,u.lng from (select imei,max(fecha) as fecha  from ubicacion where imei="'.$dispositivo->imei.'" and lat!=0 and lng!=0 group by imei) as ubi inner join ubicacion u on u.imei=ubi.imei where ubi.fecha=u.fecha'));
                  if(count($val)!=0)
                  {
                      $ubicacion=DB::select(DB::raw('select u.lat,u.lng from (select imei,max(fecha) as fecha  from ubicacion where imei="'.$dispositivo->imei.'" and lat!=0 and lng!=0 group by imei) as ubi inner join ubicacion u on u.imei=ubi.imei where ubi.fecha=u.fecha'))[0];
                  $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                 $arreglo[]=array("id"=>$dispositivo->id,
                                "nombre"=>$dispositivo->nombre,
                                "imei"=>$dispositivo->imei,
                                "nrotelefono"=>$dispositivo->nrotelefono,
                                "operador"=>$dispositivo->operador,
                                "placa"=>$dispositivo->placa,
                                 "cliente_id"=>$dispositivo->cliente_id,
                                "modelo"=>$dispositivo->modelo,
                                "color"=>$dispositivo->color,
                                "marca"=>$dispositivo->marca,
                                "pago"=>$dispositivo->pago,
                                "lat"=>$ubicacion->lat,
                                "lng"=>$ubicacion->lng,
                                "estado"=>$estado->estado,
                                "movimiento"=>$estado->movimiento); 
                  }
                  else
                  {
                    $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                                    
                    $arreglo[]=array("id"=>$dispositivo->id,
                    "nombre"=>$dispositivo->nombre,
                    "imei"=>$dispositivo->imei,
                    "nrotelefono"=>$dispositivo->nrotelefono,
                    "operador"=>$dispositivo->operador,
                    "placa"=>$dispositivo->placa,
                     "cliente_id"=>$dispositivo->cliente_id,
                    "modelo"=>$dispositivo->modelo,
                    "color"=>$dispositivo->color,
                    "marca"=>$dispositivo->marca,
                    "pago"=>$dispositivo->pago,
                    "lat"=>"0",
                    "lng"=>"0",
                    "estado"=>$estado->estado,
                    "movimiento"=>$estado->movimiento);  
                  }
                 
                }
                else
                {
                   
                    $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                                    
                    $arreglo[]=array("id"=>$dispositivo->id,
                    "nombre"=>$dispositivo->nombre,
                    "imei"=>$dispositivo->imei,
                    "nrotelefono"=>$dispositivo->nrotelefono,
                    "operador"=>$dispositivo->operador,
                    "placa"=>$dispositivo->placa,
                     "cliente_id"=>$dispositivo->cliente_id,
                    "modelo"=>$dispositivo->modelo,
                    "color"=>$dispositivo->color,
                    "marca"=>$dispositivo->marca,
                    "pago"=>$dispositivo->pago,
                    "lat"=>"0",
                    "lng"=>"0",
                    "estado"=>$estado->estado,
                    "movimiento"=>$estado->movimiento);
                }
            }
            
            //return DB::select('select d.*,ubi.fecha,u.lat,u.lng from (select u.imei,max(u.fecha) as fecha from detallecontrato as dc inner join contrato as c on dc.contrato_id=c.id inner join dispositivo as d on d.id=dc.dispositivo_id inner join clientes as cli on cli.id=c.cliente_id inner join ubicacion as u on u.imei=d.imei where cli.id="'.$cliente->id.'" group by u.imei) as ubi inner join dispositivo d on d.imei=ubi.imei inner join ubicacion u on u.imei=ubi.imei where u.fecha=ubi.fecha');
        }
        else
        {
            $empresa= DB::table('empresas')->where('user_id',$id)->first();
            $dispositivos=DB::table('detallecontrato as dc')
            ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
            ->join('contrato as c','c.id','=','dc.contrato_id')
            ->select('d.*')
            ->where('c.empresa_id',$empresa->id)
            ->get(); 
       
           
            foreach($dispositivos as $dispositivo)
            {
                if(DB::table('ubicacion')->where('imei',$dispositivo->imei)->count()!=0)
                {
                   /*$ubicacion=DB::table('ubicacion')
                    ->selectRaw('imei,max(fecha)')
                    ->where('imei',$dispositivo->imei)
                    ->groupBy('imei')
                    ->first();*/
                    $val=DB::select(DB::raw('select u.lat,u.lng from (select imei,max(fecha) as fecha  from ubicacion where imei="'.$dispositivo->imei.'" and lat!=0 and lng!=0 group by imei) as ubi inner join ubicacion u on u.imei=ubi.imei where ubi.fecha=u.fecha'));
                    if(count($val)!=0)
                    {
                    $ubicacion=DB::select(DB::raw('select u.lat,u.lng from (select imei,max(fecha) as fecha  from ubicacion where imei="'.$dispositivo->imei.'" and lat!=0 and lng!=0 group by imei) as ubi inner join ubicacion u on u.imei=ubi.imei where ubi.fecha=u.fecha'))[0];
                  $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                 $arreglo[]=array("id"=>$dispositivo->id,
                                "nombre"=>$dispositivo->nombre,
                                "imei"=>$dispositivo->imei,
                                "nrotelefono"=>$dispositivo->nrotelefono,
                                "operador"=>$dispositivo->operador,
                                "placa"=>$dispositivo->placa,
                                 "empresa_id"=>$dispositivo->empresa_id,
                                "modelo"=>$dispositivo->modelo,
                                "color"=>$dispositivo->color,
                                "marca"=>$dispositivo->marca,
                                "pago"=>$dispositivo->pago,
                                "lat"=>$ubicacion->lat,
                                "lng"=>$ubicacion->lng,
                                "estado"=>$estado->estado,
                                "movimiento"=>$estado->movimiento);
                    }
                    else
                    {
                        $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                                    
                    $arreglo[]=array("id"=>$dispositivo->id,
                    "nombre"=>$dispositivo->nombre,
                    "imei"=>$dispositivo->imei,
                    "nrotelefono"=>$dispositivo->nrotelefono,
                    "operador"=>$dispositivo->operador,
                    "placa"=>$dispositivo->placa,
                     "empresa_id"=>$dispositivo->empresa_id,
                    "modelo"=>$dispositivo->modelo,
                    "color"=>$dispositivo->color,
                    "marca"=>$dispositivo->marca,
                    "pago"=>$dispositivo->pago,
                    "lat"=>"0.0",
                    "lng"=>"0.0",
                    "estado"=>$estado->estado,
                    "movimiento"=>$estado->movimiento);
                    }
                }
                else
                {
                    $estado=DB::table('estadodispositivo')->where('imei',$dispositivo->imei)->first();
                                    
                    $arreglo[]=array("id"=>$dispositivo->id,
                    "nombre"=>$dispositivo->nombre,
                    "imei"=>$dispositivo->imei,
                    "nrotelefono"=>$dispositivo->nrotelefono,
                    "operador"=>$dispositivo->operador,
                    "placa"=>$dispositivo->placa,
                     "empresa_id"=>$dispositivo->empresa_id,
                    "modelo"=>$dispositivo->modelo,
                    "color"=>$dispositivo->color,
                    "marca"=>$dispositivo->marca,
                    "pago"=>$dispositivo->pago,
                    "lat"=>"0.0",
                    "lng"=>"0.0",
                    "estado"=>$estado->estado,
                    "movimiento"=>$estado->movimiento);
                }
            }
            
        }
        return $arreglo;
        
    }
    public function usertoken(Request $request)
    {
        $user= $request->user();
        $usuario=User::findOrFail($user->id);
        $usuario->Token=$request->Token;
        $usuario->save();
        return "cambio con exito";

    }
    public function prueba()
    {
        $usuario=User::create([
            'usuario'=> "pablo",
            'email'=>"pablo@hotmail.com",
            'password'=>bcrypt("hola"),
            'tipo'=>'EMPRESA'
        ]);
        return $usuario;
        
    }
  
}
