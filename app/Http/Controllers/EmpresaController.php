<?php

namespace App\Http\Controllers;

use App\DispositivoEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Empresa;
use App\User;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('empresas.index');
    } 

    public function getTable()
    {
        return datatables()->query(DB::table('empresas')->select('empresas.*')->where('empresas.estado','ACTIVO')->orderBy('empresas.id', 'desc')    )->toJson();
    }
     

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('empresas.store');
        $empresa= new Empresa();
        return view('empresas.create')->with(compact('action','empresa'));
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
            
            'ruc' => ['required','numeric', Rule::unique('empresas','ruc')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'activo' => 'required',
            'nombre_comercial' => 'required',
            'razon_social'=>'required',
            'telefono_movil' => 'required|numeric',
            'direccion_fiscal' => 'required',
            'direccion' => 'required',
            'correo_electronico' => ['required', Rule::unique('users','email')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000|required_if:estado_fe,==,on',
            'facebook' => 'required',
            'whatsapp' => 'required',
            
        ];
        $message = [
            'ruc.required' => 'El ruc es obligatorio',
            'ruc.unique' => 'El ruc debe ser único',
            'ruc.numeric' => 'El ruc debe ser numérico',
            'activo.required' => 'El campo Estado es obligatorio',
            'nombre_comercial.required' => 'El nombre comercial es obligatorio',
            'razon_social.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion_fiscal.required'=>'El campo direccion es obligatorio',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
            'correo_electronico.unique' => 'El campo Correo debe ser unico',
            'facebook.required'=>'El campo facebook es Obligatorio',
            'whatsapp.required'=>'El campo whatsapp es Obligatorio',
            'logo.image' => 'El campo Logo no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Logo para cargar es de 40 MB.',
            

        ];

        Validator::make($data, $rules, $message)->validate();
       
        $empresa = new Empresa();
        $empresa->ruc= $request->ruc;
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre_comercial = $request->nombre_comercial;
        $empresa->direccion_fiscal = $request->direccion_fiscal;
        $empresa->direccion=$request->direccion;
        $empresa->tipo_documento_contacto=$request->tipo_documento_contacto;
        $empresa->documento_contacto=$request->documento_contacto;
        $empresa->telefono_movil = $request->telefono_movil; 
        $empresa->nombre_contacto=$request->nombre_contacto;
        $empresa->correo_electronico=$request->correo_electronico;
        $empresa->facebook=$request->facebook;
        $empresa->whatsapp=$request->whatsapp;
        $empresa->activo = $request->activo;
     
        $parametros=DB::table('empresa')->where('estado','ACTIVO')->first();
        Config::set('mail.mailers.smtp.username', $parametros->correo_electronico);
        Config::set('mail.mailers.smtp.password', $parametros->contraseña);
        $contraseñagenerada=generarcontraseñaempresa($empresa);
       $mensaje=DB::table('mensaje')->where('estado','ACTIVO')->first();
        $usuario=User::create([
            'usuario'=> $request->nombre_comercial,
            'email'=>$request->correo_electronico,
            'password'=>bcrypt($contraseñagenerada),
            'tipo'=>'EMPRESA'
        ]);
        $usuario->roles()->sync([3]);
        $empresa->user_id=$usuario->id;

         $data=array('mensaje'=>$mensaje->mensaje,'path'=>$mensaje->ruta_logo,'user'=>$request->correo_electronico,'contraseña'=>$contraseñagenerada);
        Mail::send('emails.mensaje',$data,function($message) use ($request,$mensaje,$parametros){
            $message->to($request->correo_electronico, $request->nombre_comercial)
            ->subject($mensaje->asunto);
            $message->from($parametros->correo_electronico,$parametros->nombre_comercial);
        });

        if($request->hasFile('logo')){    
                     
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo = $name;
            $empresa->ruta_logo = $request->file('logo')->store('public/empresas/logos');
            $empresa->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        

        $empresa->save();

        if($request->dispositivo_tabla!=null)
        {
            $var=json_decode($request->dispositivo_tabla);
         for($i = 0; $i < count($var); $i++) {
            DispositivoEmpresa::create([
                'empresa_id' => $empresa->id,
                'tipodispositivo_id' => $var[$i]->dispositivo_id,
            ]);
            }
        }
        


        //Registro de actividad

        Session::flash('success','empresa creado.');
        return redirect()->route('empresas.index')->with('guardar', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $empresa= Empresa::findOrFail($id);
        return view('empresas.show', [
            'empresa' => $empresa
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
        $empresa= Empresa::findOrFail($id);
        
        $put = True;
        $action = route('empresas.update', $id);
        $detalle=True;
        $detalledispositivo=DB::table('dispositivoempresa')
        ->join('tipodispositivo','tipodispositivo.id','=','dispositivoempresa.tipodispositivo_id')
        ->select('dispositivoempresa.*','tipodispositivo.nombre')
        ->where('empresa_id',$id)
        ->where('dispositivoempresa.estado','ACTIVO')->get();

        return view('empresas.edit', [
            'empresa' => $empresa,
            'action' => $action,
            'put' => $put,
            'detalle'=>$detalle,
            'detallecontrato'=>json_encode($detalledispositivo)
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
            
            'ruc' => ['required','numeric', Rule::unique('empresas','ruc')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })->ignore($id)],
            'activo' => 'required',
            'nombre_comercial' => 'required',
            'razon_social'=>'required',
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000|required_if:estado_fe,==,on',
            'telefono_movil' => 'required|numeric',
            'direccion_fiscal' => 'required',
            'direccion' => 'required',
            'correo_electronico' => 'required',
            'facebook' => 'required',
            'whatsapp' => 'required',
            
        ];
        $message = [
            'ruc.required' => 'El ruc es obligatorio',
            'ruc.unique' => 'El ruc debe ser único',
            'ruc.numeric' => 'El ruc debe ser numérico',
            'activo.required' => 'El campo Estado es obligatorio',
            'nombre_comercial.required' => 'El nombre comercial es obligatorio',
            'razon_social.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'logo.image' => 'El campo Logo no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Logo para cargar es de 40 MB.',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion_fiscal.required'=>'El campo direccion es obligatorio',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
            'correo_electronico.unique' => 'El Correo ya esta registrado',
            'facebook.required'=>'El campo facebook es Obligatorio',
            'whatsapp.required'=>'El campo whatsapp es Obligatorio',
            

        ];

        Validator::make($data, $rules, $message)->validate();
       
        $empresa =Empresa::findOrFail($id);
        $correo=$empresa->correo_electronico;
        $empresa->ruc= $request->ruc;
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre_comercial = $request->nombre_comercial;
        $empresa->direccion_fiscal = $request->direccion_fiscal;
        $empresa->direccion=$request->direccion;
        $empresa->tipo_documento_contacto=$request->tipo_documento_contacto;
        $empresa->documento_contacto=$request->documento_contacto;
        $empresa->telefono_movil = $request->telefono_movil; 
        $empresa->nombre_contacto=$request->nombre_contacto;
        $empresa->correo_electronico=$request->correo_electronico;
        $empresa->facebook=$request->facebook;
        $empresa->whatsapp=$request->whatsapp;
        $empresa->activo = $request->activo;
        if($correo!=$request->correo_electronico)
        {
            $parametros=DB::table('empresa')->where('estado','ACTIVO')->first();
            Config::set('mail.mailers.smtp.username', $parametros->correo_electronico);
            Config::set('mail.mailers.smtp.password', $parametros->contraseña);
            $contraseñagenerada=generarcontraseñaempresa($empresa);
    
            $mensaje=DB::table('mensaje')->where('estado','ACTIVO')->first();

          
            $idusuario=DB::table('users')->where('id',$empresa->user_id)->first();
            $usuario=User::findOrFail($idusuario->id);
            $usuario->usuario=$request->nombre_comercial;
            $usuario->email=$request->correo_electronico;
            $usuario->password=bcrypt($contraseñagenerada);
            $usuario->tipo='EMPRESA';
            $usuario->update();
            
    
             $data=array('mensaje'=>$mensaje->mensaje,'path'=>$mensaje->ruta_logo,'user'=>$request->correo_electronico,'contraseña'=>$contraseñagenerada);
            Mail::send('emails.mensaje',$data,function($message) use ($request,$mensaje,$parametros){
                $message->to($request->correo_electronico, $request->nombre)
                ->subject($mensaje->asunto);
                $message->from($parametros->correo_electronico,$parametros->nombre_comercial);
            });
        }


        if($request->hasFile('logo')){ 
            Storage::delete($empresa->ruta_logo);                   
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo = $name;
            $empresa->ruta_logo = $request->file('logo')->store('public/empresas/logos');
            $empresa->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        

        $empresa->save(); 
        
        if($request->dispositivo_tabla!="[]")
        {
            DispositivoEmpresa::where('empresa_id', $id)->delete();
     
            $var=json_decode($request->dispositivo_tabla);
            for($i = 0; $i < count($var); $i++) {
                DispositivoEmpresa::create([
                    'empresa_id' => $empresa->id,
                    'tipodispositivo_id' => $var[$i]->dispositivo_id,
                ]);
            }
        }
        
        //Registro de actividad

        Session::flash('success','empresa creado.');
        return redirect()->route('empresas.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->estado = 'ANULADO';
        $empresa->update();

        //Registro de actividad
       

        Session::flash('success','Empresa eliminada.');
        return redirect()->route('empresas.index')->with('eliminar', 'success');
    }
    public function getDocumento(Request $request)
    {
        $data = $request->all();
        $existe = false;
        if (!is_null($data['ruc'])) {
            if (!is_null($data['id'])) {
                 if(Empresa::where('ruc',$data['ruc'])->where('id','!=',$data['id'])->count()!=0)
                 {
                     $existe=true;
                 }
            } else {
                if(Empresa::where('ruc',$data['ruc'])->count()!=0)
                {
                    $existe=true;
                }
            }

        }

        $result = [
            'existe' => $existe
        
        ];

        return response()->json($result);
    }
    public function getmensaje(Request $request)
    {
        $resultado=array();
        if(DB::table("mensaje")->count()==0)
        {

            return $resultado=array("existemensaje"=>false);
        }
        else
        {
            return $resultado=array("existemensaje"=>true);
        }

        
    }
}
