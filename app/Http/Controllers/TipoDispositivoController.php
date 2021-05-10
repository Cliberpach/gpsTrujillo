<?php

namespace App\Http\Controllers;

use App\TipoDispositivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TipoDispositivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        return view('tipodispositivo.index');
    }

    public function getTable()
    {
        return datatables()->query(DB::table('tipodispositivo')->select('tipodispositivo.*')->where('tipodispositivo.estado','ACTIVO')->orderBy('tipodispositivo.id', 'desc')    )->toJson();
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

        $data = $request->all();

        $rules = [
            'nombre' => ['required', Rule::unique('tipodispositivo','nombre')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'activo' => 'required',
            'precio' => 'required|numeric|min:0|not_in:0',
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000|required_if:estado_fe,==,on',
        ];

        $message = [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique'=>"El campo ya esta en uso",
            'activo.required' => 'El campo activo es obligatorio.',
            'precio.required' => 'El campo precio es obligatorio.',
            'precio.numeric' => 'El campo precio debe ser numerico',
            'precio.min:0' => 'El campo precio no puede ser negativo',
            'precio.not_in:0' => 'El campo precio no puede ser 0.',
            'logo.image' => 'El campo Logo no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Logo para cargar es de 40 MB.',
        ];

        Validator::make($data, $rules, $message)->validate();

        $tipodispositivo = new TipoDispositivo();
        $tipodispositivo->nombre = $request->nombre;
        $tipodispositivo->activo = $request->activo;
        $tipodispositivo->precio = $request->precio;
        if($request->hasFile('logo')){    
                     
            $file = $request->file('logo');
            $name = $file->getClientOriginalName(); 
            $tipodispositivo->nombre_logo = $name;
            $tipodispositivo->ruta_logo = $request->file('logo')->store('public/tipodispositivo/logos');
            $tipodispositivo->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        $tipodispositivo->save();
        
      

        Session::flash('success','Detalle creado.');
        return redirect()->route('tipodispositivo.index')->with('guardar', 'success');
         
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
    public function update(Request $request)
    {
     
        $data = $request->all();

        $rules = [
            'nombre_editar' => ['required', Rule::unique('tipodispositivo','nombre')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })->ignore($request->id)],
            'activo_editar' => 'required',
            'precio_editar'=> 'required|numeric|min:0|not_in:0',
        ];

        $message = [
            'nombre_editar.required' => 'El campo nombre es obligatorio.',
            'nombre_editar.unique' => 'El campo nombre ya esta en uso',
            'activo_editar.required' => 'El campo activo es obligatorio.',
            'precio_editar.required' => 'El campo precio es obligatorio.',
            'precio_editar.numeric' => 'El campo precio debe ser numerico',
            'precio_editar.min:0' => 'El campo precio no puede ser negativo',
            'precio_editar.not_in:0' => 'El campo precio no puede ser 0.',
        ];

        Validator::make($data, $rules, $message)->validate();

        $tipodispositivo = TipoDispositivo::findOrFail($request->id);
        $tipodispositivo->nombre = $request->nombre_editar;
        $tipodispositivo->activo = $request->activo_editar;
        $tipodispositivo->precio = $request->precio_editar;
        if($request->hasFile('logo')){ 
            Storage::delete($tipodispositivo->ruta_logo);                   
                     
            $file = $request->file('logo');
            $name = $file->getClientOriginalName(); 
            $tipodispositivo->nombre_logo = $name;
            $tipodispositivo->ruta_logo = $request->file('logo')->store('public/tipodispositivo/logos');
            $tipodispositivo->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        $tipodispositivo->update();
        
      

        Session::flash('success','Tipo Dispositivo actualizado.');
        return redirect()->route('tipodispositivo.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipodispositivo = TipoDispositivo::findOrFail($id);
        $tipodispositivo->estado = 'ANULADO';
        $tipodispositivo->update();

        //Registro de actividad
       

        Session::flash('success','Cliente eliminado.');
        return redirect()->route('tipodispositivo.index')->with('guardar', 'success');
    }
}
