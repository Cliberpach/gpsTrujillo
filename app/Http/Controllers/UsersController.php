<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\User;
use App\Empresa;
use App\Dispositivo;
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
        $data = array();
        $dispositivos = Dispositivo::cursor()->filter(function ($dispositivo) use ($user) {
            $resultado = false;
            if ($dispositivo->estado == "ACTIVO") {
                $resultado = true;
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
                "placa" => "", "marca" => "", "modelo" => "", "nombre" => "", "estado" => "",'estadogps'=>"", "velocidad" => "","movimiento"=>"",
            );
            $dispositivo_array["color"] = $dispositivo->color;
            $dispositivo_array["placa"] = $dispositivo->placa;
            $dispositivo_array["marca"] = $dispositivo->marca;
            $dispositivo_array["modelo"] = $dispositivo->modelo;
            $dispositivo_array["nombre"] = $dispositivo->nombre;
            $dispositivo_array["imei"] = $dispositivo->imei;
            $consulta = DB::table('dispositivo_ubicacion')->where('imei', $dispositivo->imei);
            $valor = DB::table('estadodispositivo')->where('cadena', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();
            $estadogps="Desconectado";
            $movimiento="Sin Movimiento";
            if ($valor != "") {
                $valor = DB::table('estadodispositivo')->where('imei', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();
                if ($valor->estado == "Desconectado") {
                    $estadogps="Desconectado";
                    $movimiento="Sin Movimiento";
                } else {
                    $estadogps=$valor->estado;
                    $movimiento=$valor->movimiento;
                }
            } 
            if ($consulta->count() == 0) {

                $dispositivo_array["estado"] = "sin data";
                array_push($data, $dispositivo_array);
            } else {
                $consulta = $consulta->first();
                $dispositivo_array["cadena"] = $consulta->cadena;
                $dispositivo_array["lat"] = $consulta->lat;
                $dispositivo_array["lng"] = $consulta->lng;
                $dispositivo_array["fecha"] = $consulta->fecha;
                $dispositivo_array["estadogps"] = $estadogps;
                $dispositivo_array["movimiento"] = $movimiento;
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
    public function dispositivosprueba(Request $request)
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
        $user=User::where('email','esthid_80@hotmail.com')->first();
        $data = array();
        $dispositivos = Dispositivo::cursor()->filter(function ($dispositivo) use ($user) {
            $resultado = false;
            if ($dispositivo->estado == "ACTIVO") {
                $resultado = true;
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
                "placa" => "", "marca" => "", "modelo" => "", "nombre" => "", "estado" => "",'estadogps'=>"", "velocidad" => "","movimiento"=>"",
            );
            $dispositivo_array["color"] = $dispositivo->color;
            $dispositivo_array["placa"] = $dispositivo->placa;
            $dispositivo_array["marca"] = $dispositivo->marca;
            $dispositivo_array["modelo"] = $dispositivo->modelo;
            $dispositivo_array["nombre"] = $dispositivo->nombre;
            $dispositivo_array["imei"] = $dispositivo->imei;
            $consulta = DB::table('dispositivo_ubicacion')->where('imei', $dispositivo->imei);
            $valor = DB::table('estadodispositivo')->where('cadena', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();
            $estadogps="Desconectado";
            $movimiento="Sin Movimiento";
            if ($valor != "") {
                $valor = DB::table('estadodispositivo')->where('imei', 'like', '%' . $dispositivo->imei . '%')->orderByDesc('fecha')->first();
                if ($valor->estado == "Desconectado") {
                    $estadogps="Desconectado";
                    $movimiento="Sin Movimiento";
                } else {
                    $estadogps=$valor->estado;
                    $movimiento=$valor->movimiento;
                }
            } 
            if ($consulta->count() == 0) {

                $dispositivo_array["estado"] = "sin data";
                array_push($data, $dispositivo_array);
            } else {
                $consulta = $consulta->first();
                $dispositivo_array["cadena"] = $consulta->cadena;
                $dispositivo_array["lat"] = $consulta->lat;
                $dispositivo_array["lng"] = $consulta->lng;
                $dispositivo_array["fecha"] = $consulta->fecha;
                $dispositivo_array["estadogps"] = $estadogps;
                $dispositivo_array["movimiento"] = $movimiento;
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
