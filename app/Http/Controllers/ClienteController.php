<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use App\User;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('clientes.index');
    }

    /**
     * Show the form for creating a new resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('cliente.store');
        $cliente = new Cliente();
        return view('clientes.create')->with(compact('action','cliente'));
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
            'tipo_documento' => 'required',
            'documento' => ['required','numeric', Rule::unique('clientes','documento')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'nombre_comercial' => 'required',
            'activo' => 'required',
            'nombre' => 'required',
            'telefono_movil' => 'required|numeric',
            'direccion_fiscal' => 'required',
            'direccion' => 'required',
            'correo_electronico' => 'required',
            
        ];
        $message = [
            'tipo_documento.required' => 'El campo Tipo de documento es obligatorio.',
            'documento.required' => 'El campo Nro. Documento es obligatorio',
            'documento.unique' => 'El campo Nro. Documento debe ser único',
            'documento.numeric' => 'El campo Nro. Documento debe ser numérico',
            'nombre_comercial.required' => 'El nombre comercial es obligatorio',
            'activo.required' => 'El campo Estado es obligatorio',
            'nombre.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion_fiscal.required'=>'El campo direccion es obligatorio',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $cliente = new Cliente();
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->documento = $request->documento;
        $cliente->nombre = $request->nombre;
        $cliente->nombre_comercial = $request->nombre_comercial;
        $cliente->activo = $request->activo;
        $cliente->telefono_movil = $request->telefono_movil;
        $cliente->direccion_fiscal = $request->direccion_fiscal;
        $cliente->direccion=$request->direccion;
        $cliente->correo_electronico=$request->correo_electronico;
        $cliente->facebook=$request->facebook;
        $cliente->whatsapp=$request->whatsapp;
        $cliente->nombre_contacto=$request->nombre_contacto;
        $cliente->tipo_documento_contacto=$request->tipo_documento_contacto;
        $cliente->documento_contacto=$request->documento_contacto;

       

       // config(['mail.username' => 'cs3604302@gmail.com']);
        //config(['mail.password' => 'xxxredtyciquzaja']);
    
        $parametros=DB::table('empresa')->where('estado','ACTIVO')->first();
        Config::set('mail.mailers.smtp.username', $parametros->correo_electronico);
        Config::set('mail.mailers.smtp.password', $parametros->contraseña);
        $contraseñagenerada=generarcontraseñacliente($cliente);

        $mensaje=DB::table('mensaje')->where('estado','ACTIVO')->first();
      
         $data=array('mensaje'=>$mensaje->mensaje,'path'=>$mensaje->ruta_logo,'user'=>$request->correo_electronico,'contraseña'=>$contraseñagenerada);
        Mail::send('emails.mensaje',$data,function($message) use ($request,$mensaje,$parametros){
            $message->to($request->correo_electronico, $request->nombre)
            ->subject($mensaje->asunto);
            $message->from($parametros->correo_electronico,$parametros->nombre_comercial);
        });
        $usuario=User::create([
            'usuario'=> $request->nombre,
            'email'=>$request->correo_electronico,
            'password'=>bcrypt($contraseñagenerada),
            'tipo'=>'CLIENTE'
        ]);
        $usuario->roles()->sync([2]);
        $cliente->user_id=$usuario->id;

        $cliente->save();

        Session::flash('success','Cliente creado.');
        return redirect()->route('cliente.index')->with('guardar', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.show', [
            'cliente' => $cliente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        
        $put = True;
        $action = route('cliente.update', $id);

        return view('clientes.edit', [
            'cliente' => $cliente,
            'action' => $action,
            'put' => $put,
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
            'tipo_documento' => 'required',
            'documento' => ['required','numeric', Rule::unique('clientes','documento')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })->ignore($id)],
            'nombre_comercial' => 'required',
            'activo' => 'required',
            'nombre' => 'required',
            'telefono_movil' => 'required|numeric',
            'direccion_fiscal' => 'required',
            'direccion' => 'required',
            'correo_electronico' => 'required',
            
        ];
        $message = [
            'tipo_documento.required' => 'El campo Tipo de documento es obligatorio.',
            'documento.required' => 'El campo Nro. Documento es obligatorio',
            'documento.unique' => 'El campo Nro. Documento debe ser único',
            'documento.numeric' => 'El campo Nro. Documento debe ser numérico',
            'nombre_comercial.required' => 'El nombre comercial es obligatorio',
            'activo.required' => 'El campo Estado es obligatorio',
            'nombre.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion_fiscal.required'=>'El campo direccion es obligatorio',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
        
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $cliente = Cliente::findOrFail($id);
        $correo=$cliente->correo_electronico;
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->documento = $request->documento;
        $cliente->nombre = $request->nombre;
        $cliente->nombre_comercial = $request->nombre_comercial;
        $cliente->activo = $request->activo;
        $cliente->telefono_movil = $request->telefono_movil;
        $cliente->direccion_fiscal = $request->direccion_fiscal;
        $cliente->direccion=$request->direccion;
        $cliente->correo_electronico=$request->correo_electronico;
        $cliente->facebook=$request->facebook;
        $cliente->whatsapp=$request->whatsapp;
        $cliente->nombre_contacto=$request->nombre_contacto;
        $cliente->tipo_documento_contacto=$request->tipo_documento_contacto;
        $cliente->documento_contacto=$request->documento_contacto;

      
        if($correo!=$request->correo_electronico)
        {
            $parametros=DB::table('empresa')->where('estado','ACTIVO')->first();
            Config::set('mail.mailers.smtp.username', $parametros->correo_electronico);
            Config::set('mail.mailers.smtp.password', $parametros->contraseña);
            $contraseñagenerada=generarcontraseñacliente($cliente);
    
            $mensaje=DB::table('mensaje')->where('estado','ACTIVO')->first();

          
            $idusuario=DB::table('users')->where('id',$cliente->user_id)->first();
            $usuario=User::findOrFail($idusuario->id);
            $usuario->usuario=$request->nombre;
            $usuario->email=$request->correo_electronico;
            $usuario->password=bcrypt($contraseñagenerada);
            $usuario->tipo='CLIENTE';
            $usuario->update();
            
    
             $data=array('mensaje'=>$mensaje->mensaje,'path'=>$mensaje->ruta_logo,'user'=>$request->correo_electronico,'contraseña'=>$contraseñagenerada);
            Mail::send('emails.mensaje',$data,function($message) use ($request,$mensaje,$parametros){
                $message->to($request->correo_electronico, $request->nombre)
                ->subject($mensaje->asunto);
                $message->from($parametros->correo_electronico,$parametros->nombre_comercial);
            });
        }
        $cliente->save();
       

        //Registro de actividad

        Session::flash('success','Cliente modificado.');
        return redirect()->route('cliente.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->estado = 'ANULADO';
        $cliente->update();

        //Registro de actividad
       

        Session::flash('success','Cliente eliminado.');
        return redirect()->route('cliente.index')->with('eliminar', 'success');
    }
    
    public function getTable()
    {
       /* $clientes=Cliente::where('estado','activo')->orderBy('clientes.id','desc')->get();
        $coleccion= collect([]);
        foreach($clientes as $cliente)
        {
            $coleccion->push(['id'=>$cliente->id,
                              'tipo_documento'=>$cliente->tipo_documento,
                              'documento '=>$cliente->documento,
                              'nombre'=>$cliente->nombre,
                              'nombre_comercial'=>$cliente->nombre_comercial,
                              'direccion_fiscal'=>$cliente->direccion_fiscal,
                              'direccion'=>$cliente->direccion
                           ]);
        }
        return DataTables::of($coleccion)->toJson();*/
        $data= DB::table('clientes')->select('*')->where('clientes.estado','ACTIVO')->orderBy('clientes.id', 'desc')->get();
        return Datatables::of($data)->make(true);
    }
    public function getTable_dispositivo(Request $request,$id)
    {
       // return datatables()->query(DB::table('dispositivo')->select('*')->where('dispositivo.estado','ACTIVO')->orderBy('dispositivo.id', 'desc')    )->toJson();
       $data= DB::table('detallecontrato as dc')
       ->join('contrato as c','c.id','=','dc.contrato_id')
       ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
       ->select('d.*')
       ->where('c.cliente_id',$id)
       ->where('d.estado','ACTIVO')
       ->orderBy('d.id', 'desc')
       ->get();
       return Datatables::of($data)->make(true);
    }
    public function getDocumento(Request $request)
    {
        $data = $request->all();
        $existe = false;
        $igualPersona = false;
        if (!is_null($data['tipo_documento']) && !is_null($data['documento'])) {
            if (!is_null($data['id'])) {
                $cliente = Cliente::findOrFail($data['id']);
                if ($cliente->tipo_documento == $data['tipo_documento'] && $cliente->documento == $data['documento']) {
                    $igualPersona = true;
                } else {
                    $cliente = Cliente::where([
                        ['tipo_documento', '=', $data['tipo_documento']],
                        ['documento', $data['documento']],
                        ['estado', 'ACTIVO']
                    ])->first();
                }
            } else {
                $cliente = Cliente::where([
                    ['tipo_documento', '=', $data['tipo_documento']],
                    ['documento', $data['documento']],
                    ['estado', 'ACTIVO']
                ])->first();
            }

            if (!is_null($cliente)) {
                $existe = true;
            }
        }

        $result = [
            'existe' => $existe,
            'igual_persona' => $igualPersona
        ];

        return response()->json($result);
    }
}
