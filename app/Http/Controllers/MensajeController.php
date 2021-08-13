<?php
namespace App\Http\Controllers;
use App\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activo=true;
        if(DB::table('mensaje')->where('mensaje.estado','ACTIVO')->count()==0)
        {
            $activo=false;
        }
        return view('mensaje.index')->with(compact('activo')); 
    }
    public function getTable()
    {
        $mensajes=Mensaje::where('estado','activo')->get(); 
        $coleccion= collect([]);
        foreach($mensajes as $mensaje)
        {
            if(strlen($mensaje->asunto)<=12)
            {
                if(strlen($mensaje->mensaje)>=12)
                {
                    $coleccion->push(['id'=>$mensaje->id,
                    'asunto'=>$mensaje->asunto,
                    'mensaje'=>substr($mensaje->mensaje,0,8)."...."]);
                }
                else
                {
                    $coleccion->push(['id'=>$mensaje->id,
                    'asunto'=>$mensaje->asunto,
                    'mensaje'=>substr($mensaje->mensaje,0,8)."...."]);
                }
            }
            else
            {
                if(strlen($mensaje->mensaje)>=12)
                {
                    $coleccion->push(['id'=>$mensaje->id,
                    'asunto'=>substr($mensaje->asunto,0,8)."....",
                    'mensaje'=>substr($mensaje->mensaje,0,8)."...."]);
                }
                else
                {
                    $coleccion->push(['id'=>$mensaje->id,
                    'asunto'=>substr($mensaje->asunto,0,8)."....",
                    'mensaje'=>$mensaje->mensaje]);
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
        $action = route('mensaje.store');
        $mensaje= new Mensaje();
        return view('mensaje.create')->with(compact('action','mensaje'));
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
            'asunto' => 'required',
            'mensaje'=>'required',
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000|required_if:estado_fe,==,on',
        ];
        $message = [
            'asunto.required' => 'El asunto es obligatorio',
            'logo.image' => 'El campo Logo no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Logo para cargar es de 40 MB.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $mensaje = new Mensaje();
        $mensaje->asunto= $request->asunto;
        $mensaje->mensaje = $request->mensaje;
        if($request->hasFile('logo')){    
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $mensaje->nombre_logo = $name;
            $mensaje->ruta_logo = $request->file('logo')->store('public/mensaje/logos');
            $mensaje->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        $mensaje->save();
        //Registro de actividad

        return redirect()->route('mensaje.index')->with('guardar', 'success');  
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mensaje = Mensaje::findOrFail($id);
        return view('mensaje.show', [
            'mensaje' => $mensaje
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
        $mensaje= Mensaje::findOrFail($id);
        
        $put = True;
        $action = route('mensaje.update', $id);
        return view('mensaje.edit', [
            'mensaje' => $mensaje,
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
            'asunto' => 'required',
            'mensaje'=>'required',
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000|required_if:estado_fe,==,on',
        ];
        $message = [
            'asunto.required' => 'El asunto es obligatorio',
            'logo.image' => 'El campo Logo no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Logo para cargar es de 40 MB.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $mensaje =Mensaje::findOrFail($id);
        $mensaje->asunto= $request->asunto;
        $mensaje->mensaje = $request->mensaje;
        if($request->hasFile('logo')){     
            Storage::delete($mensaje->ruta_logo);                   
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $mensaje->nombre_logo = $name;
            $mensaje->ruta_logo = $request->file('logo')->store('public/mensa$mensaje/logos');
            $mensaje->base64_logo = base64_encode( file_get_contents($request->file('logo')));
        }
        

        $mensaje->save();
        
        //Registro de actividad


        return redirect()->route('mensaje.index')->with('guardar', 'success');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->estado = 'ANULADO';
        $mensaje->update();

        //Registro de actividad
       


        return redirect()->route('mensaje.index')->with('eliminar', 'success');
    }
}
