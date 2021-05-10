<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Empresa;
use App\EmpresaPersonal;
use App\Parametro;
use Illuminate\Support\Facades\Storage;

class EmpresaPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activo=true;
        if(DB::table('empresa')->where('empresa.estado','ACTIVO')->count()==0)
        {
            $activo=false;
        }
        return view('empresa.index')->with(compact('activo'));
    }

    public function getTable()
    {
        return datatables()->query(DB::table('empresa')->select('empresa.*')->where('empresa.estado','ACTIVO')->orderBy('empresa.id', 'desc')    )->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('empresa.store');
        $empresa= new EmpresaPersonal();
        $dni=Parametro::findOrFail(2);
        $ruc=Parametro::findOrFail(1);
        $mapa=Parametro::findOrFail(3);
        return view('empresa.create')->with(compact('action','empresa','ruc','dni','mapa'));
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
            
            'ruc' => 'required',
            'nombre_comercial' => 'required',
            'razon_social'=>'required',
            'telefono_movil' => 'required|numeric',
            'direccion_fiscal' => 'required',
            'direccion' => 'required',
            'correo_electronico' => 'required',
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000|required_if:estado_fe,==,on',
            'facebook' => 'required',
            'contraseña' => 'required',
            'whatsapp' => 'required',
            
            
        ];
        $message = [
            'ruc.required' => 'El ruc es obligatorio',
            'nombre_comercial.required' => 'El nombre comercial es obligatorio',
            'razon_social.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion_fiscal.required'=>'El campo direccion es obligatorio',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
            'facebook.required'=>'El campo facebook es Obligatorio',
            'contraseña.required'=>'El campo contraseña es Obligatorio',
            'whatsapp.required'=>'El campo whatsapp es Obligatorio',
            'logo.image' => 'El campo Logo no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Logo para cargar es de 40 MB.',
            

        ];

        Validator::make($data, $rules, $message)->validate();
       
        $empresa = new EmpresaPersonal();
        $empresa->ruc= $request->ruc;
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre_comercial = $request->nombre_comercial;
        $empresa->direccion_fiscal = $request->direccion_fiscal;
        $empresa->direccion=$request->direccion;
        $empresa->telefono_movil = $request->telefono_movil; 
        $empresa->correo_electronico=$request->correo_electronico;
        $empresa->contraseña=$request->contraseña;
        $empresa->facebook=$request->facebook;
        $empresa->whatsapp=$request->whatsapp;
        $empresa->color=$request->color;

        if($request->hasFile('logo')){    
                     
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo = $name;
            $empresa->ruta_logo = $request->file('logo')->store('public/empresas/logos');
            $empresa->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        if($request->hasFile('logo_large')){    
                     
            $file = $request->file('logo_large');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo_large = $name;
            $empresa->ruta_logo_large = $request->file('logo_large')->store('public/empresas/logos');
            $empresa->base64_logo_large = base64_encode( file_get_contents($request->file('logo_large')));
        }
        if($request->hasFile('logo_icon')){    
                     
            $file = $request->file('logo_icon');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo_icon = $name;
            $empresa->ruta_logo_icon = $request->file('logo_icon')->store('public/empresas/logos');
            $empresa->base64_logo_icon = base64_encode( file_get_contents($request->file('logo_icon')));
        }
        

        $empresa->save();

        $dni=Parametro::findOrFail(2);
        $ruc=Parametro::findOrFail(1);
        $mapa=Parametro::findOrFail(3);
        $dni->token=$request->token_dni;
        $ruc->token=$request->token_ruc;
        $mapa->token=$request->token_mapa;
        $dni->update();
        $ruc->update();
        $mapa->update();


        //Registro de actividad

        Session::flash('success','empresa creado.');
        return redirect()->route('empresa.index')->with('guardar', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa= EmpresaPersonal::findOrFail($id);
        return view('empresa.show', [
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
        $empresa= EmpresaPersonal::findOrFail($id);
        
        $put = True;
        $action = route('empresa.update', $id);
        $dni=Parametro::findOrFail(2);
        $ruc=Parametro::findOrFail(1);
        $mapa=Parametro::findOrFail(3);

        return view('empresa.edit', [
            'empresa' => $empresa,
            'dni'=>$dni,
            'ruc'=>$ruc,
            'mapa'=>$mapa,
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
            
            'ruc' => 'required',
            'nombre_comercial' => 'required',
            'razon_social'=>'required',
            'telefono_movil' => 'required|numeric',
            'direccion_fiscal' => 'required',
            'direccion' => 'required',
            'correo_electronico' => 'required',
            'facebook' => 'required',
            'contraseña' => 'required',
            'whatsapp' => 'required',
            
        ];
        $message = [
            'ruc.required' => 'El ruc es obligatorio',
            'nombre_comercial.required' => 'El nombre comercial es obligatorio',
            'razon_social.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion_fiscal.required'=>'El campo direccion es obligatorio',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
            'facebook.required'=>'El campo facebook es Obligatorio',
            'contraseña.required'=>'El campo contraseña es Obligatorio',
            'whatsapp.required'=>'El campo whatsapp es Obligatorio',

            

        ];

        Validator::make($data, $rules, $message)->validate();
       
        $empresa =EmpresaPersonal::findOrFail($id);
        $empresa->ruc= $request->ruc;
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre_comercial = $request->nombre_comercial;
        $empresa->direccion_fiscal = $request->direccion_fiscal;
        $empresa->direccion=$request->direccion;
      
        $empresa->telefono_movil = $request->telefono_movil; 

        $empresa->correo_electronico=$request->correo_electronico;
        $empresa->facebook=$request->facebook;
        $empresa->contraseña=$request->contraseña;
        $empresa->whatsapp=$request->whatsapp;
        $empresa->color=$request->color;

        if($request->hasFile('logo')){ 
            Storage::delete($empresa->ruta_logo);                   
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo = $name;
            $empresa->ruta_logo = $request->file('logo')->store('public/empresas/logos');
            $empresa->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        if($request->hasFile('logo_large')){    
            Storage::delete($empresa->ruta_logo_large);  
            $file = $request->file('logo_large');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo_large = $name;
            $empresa->ruta_logo_large = $request->file('logo_large')->store('public/empresas/logos');
            $empresa->base64_logo_large = base64_encode( file_get_contents($request->file('logo_large')));
        }
        if($request->hasFile('logo_icon')){    
            Storage::delete($empresa->ruta_logo_icon);  
            $file = $request->file('logo_icon');
            $name = $file->getClientOriginalName();
            $empresa->nombre_logo_icon = $name;
            $empresa->ruta_logo_icon = $request->file('logo_icon')->store('public/empresas/logos');
            $empresa->base64_logo_icon = base64_encode( file_get_contents($request->file('logo_icon')));
        }
        

        $empresa->save();
        $dni=Parametro::findOrFail(2);
        $ruc=Parametro::findOrFail(1);
        $mapa=Parametro::findOrFail(3);

        $dni->token=$request->token_dni;
        $ruc->token=$request->token_ruc;
        $mapa->token=$request->token_mapa;
        $dni->update();
        $ruc->update();
        $mapa->update();
        //Registro de actividad

        Session::flash('success','empresa creado.');
        return redirect()->route('empresa.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = EmpresaPersonal::findOrFail($id);
        $empresa->estado = 'ANULADO';
        $empresa->update();

        //Registro de actividad
       

        Session::flash('success','Empresa eliminada.');
        return redirect()->route('empresa.index')->with('eliminar', 'success');
    }
}
