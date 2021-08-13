<?php

namespace App\Http\Controllers\Mantenimiento\Colaborador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mantenimiento\Colaborador\Colaborador;
use App\Mantenimiento\Persona\Persona;
use Carbon\Carbon;
use DataTables;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ColaboradorController extends Controller
{
    public function index()
    {
        return view('mantenimiento.colaboradores.index');
    }

    public function getTable()
    {
       /* $colaboradores = Colaborador::where('estado','ACTIVO')->orderBy('id','DESC')->get();
        $coleccion = collect([]);
        foreach($colaboradores as $colaborador) {
            if ($colaborador->vendedor)
                continue;
            $coleccion->push([
                'id' => $colaborador->id,
                'documento' => $colaborador->persona->getDocumento(),
                'apellidos_nombres' => $colaborador->persona->getApellidosYNombres(),
                'telefono_movil' => $colaborador->persona->telefono_movil,
                'area' => $colaborador->getArea(),
                'cargo' => $colaborador->getCargo(),
            ]);
        }
    return DataTables::of($coleccion)->toJson();*/
    $data= DB::table('colaboradores')->select('*')->where('colaboradores.estado','ACTIVO')->orderBy('colaboradores.id', 'desc')->get();
    return Datatables::of($data)->make(true);
    }

    public function create()
    {
        return view('mantenimiento.colaboradores.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($request) {

            $persona = new Persona();
            $persona->tipo_documento = $request->get('tipo_documento');
            $persona->documento = $request->get('documento');
            $persona->codigo_verificacion = $request->get('codigo_verificacion');
            $persona->nombres = $request->get('nombres');
            $persona->apellido_paterno = $request->get('apellido_paterno');
            $persona->apellido_materno = $request->get('apellido_materno');
            $persona->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_nacimiento'))->format('Y-m-d') ;
            $persona->sexo = $request->get('sexo');
            $persona->estado_civil = $request->get('estado_civil');
            $persona->departamento_id = str_pad($request->get('departamento'), 2, "0", STR_PAD_LEFT);
            $persona->provincia_id = str_pad($request->get('provincia'), 4, "0", STR_PAD_LEFT);
            $persona->distrito_id = str_pad($request->get('distrito'), 6, "0", STR_PAD_LEFT);
            $persona->direccion = $request->get('direccion');
            $persona->correo_electronico = $request->get('correo_electronico');
            $persona->telefono_movil = $request->get('telefono_movil');
            $persona->telefono_fijo = $request->get('telefono_fijo');
            $persona->estado_documento = $request->get('estado_documento');
            $persona->save();

            $colaborador = new Colaborador();
            $colaborador->persona_id = $persona->id;
            $colaborador->area = $request->get('area');
            $colaborador->profesion = $request->get('profesion');
            $colaborador->cargo = $request->get('cargo');
            $colaborador->sueldo = $request->get('sueldo');
            $colaborador->sueldo_bruto = $request->get('sueldo_bruto');
            $colaborador->sueldo_neto = $request->get('sueldo_neto');
            $colaborador->moneda_sueldo = $request->get('moneda_sueldo');
            $colaborador->tipo_banco = $request->get('tipo_banco');
            $colaborador->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $colaborador->nombre_imagen = $name;
                $colaborador->ruta_imagen = $request->file('imagen')->store('public/colaboradores/imagenes');
            }

            $colaborador->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $colaborador->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $colaborador->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $colaborador->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }
            $colaborador->save();


        });



        Session::flash('success','Colaborador creado.');
        return redirect()->route('mantenimiento.colaborador.index')->with('guardar', 'success');
    }

    public function edit($id)
    {
        $empleado = Colaborador::findOrFail($id);
        return view('mantenimiento.colaboradores.edit', [
            'empleado' => $empleado
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $colaborador = Colaborador::findOrFail($id);

        DB::transaction(function () use ($request, $colaborador) {

            $persona =  $colaborador->persona;
            $persona->tipo_documento = $request->get('tipo_documento');
            $persona->documento = $request->get('documento');
            $persona->codigo_verificacion = $request->get('codigo_verificacion');
            $persona->nombres = $request->get('nombres');
            $persona->apellido_paterno = $request->get('apellido_paterno');
            $persona->apellido_materno = $request->get('apellido_materno');
            $persona->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_nacimiento'))->format('Y-m-d') ;
            $persona->sexo = $request->get('sexo');
            $persona->estado_civil = $request->get('estado_civil');
            $persona->departamento_id = str_pad($request->get('departamento'), 2, "0", STR_PAD_LEFT);
            $persona->provincia_id = str_pad($request->get('provincia'), 4, "0", STR_PAD_LEFT);
            $persona->distrito_id = str_pad($request->get('distrito'), 6, "0", STR_PAD_LEFT);
            $persona->direccion = $request->get('direccion');
            $persona->correo_electronico = $request->get('correo_electronico');
            $persona->telefono_movil = $request->get('telefono_movil');
            $persona->telefono_fijo = $request->get('telefono_fijo');
            $persona->estado_documento = $request->get('estado_documento');
            $persona->update();

            $colaborador->persona_id = $persona->id;
            $colaborador->area = $request->get('area');
            $colaborador->profesion = $request->get('profesion');
            $colaborador->cargo = $request->get('cargo');
            $colaborador->sueldo = $request->get('sueldo');
            $colaborador->sueldo_bruto = $request->get('sueldo_bruto');
            $colaborador->sueldo_neto = $request->get('sueldo_neto');
            $colaborador->moneda_sueldo = $request->get('moneda_sueldo');
            $colaborador->tipo_banco = $request->get('tipo_banco');
            $colaborador->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                //Eliminar Archivo anterior
                Storage::delete($colaborador->ruta_imagen);
                //Agregar nuevo archivo
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $colaborador->nombre_imagen = $name;
                $colaborador->ruta_imagen = $request->file('imagen')->store('public/colaboradores/imagenes');
            }else{
                if ($colaborador->ruta_imagen) {
                    //Eliminar Archivo anterior
                    Storage::delete($colaborador->ruta_imagen);
                    $colaborador->nombre_imagen = '';
                    $colaborador->ruta_imagen = '';
                }
            }

            $colaborador->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $colaborador->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $colaborador->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $colaborador->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }
            $colaborador->update();
           
        });



        Session::flash('success','Colaborador modificado.');
        return redirect()->route('mantenimiento.colaborador.index')->with('modificar', 'success');
    }

    public function show($id)
    {
        $empleado = Colaborador::findOrFail($id);
        return view('mantenimiento.colaboradores.show', [
            'empleado' => $empleado
        ]);
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {

            $empleado = Colaborador::findOrFail($id);
            $empleado->estado = 'ANULADO';
            $empleado->update();

            $persona = $empleado->persona;
            $persona->estado = 'ANULADO';
            $persona->update();

           
        });



        Session::flash('success','Colaborador eliminado.');
        return redirect()->route('mantenimiento.colaborador.index')->with('eliminar', 'success');
    }

    public function getDni(Request $request)
    {
        $data = $request->all();
        $existe = false;
        $igualPersona = false;
        if (!is_null($data['tipo_documento']) && !is_null($data['documento'])) {
            if (!is_null($data['id'])) {
                $persona = Persona::findOrFail($data['id']);
                if ($persona->tipo_documento == $data['tipo_documento'] && $persona->documento == $data['documento']) {
                    $igualPersona = true;
                } else {
                    $persona = Persona::where([
                        ['tipo_documento', '=', $data['tipo_documento']],
                        ['documento', $data['documento']],
                        ['estado', 'ACTIVO']
                    ])->first();
                }
            } else {
                $persona = Persona::where([
                    ['tipo_documento', '=', $data['tipo_documento']],
                    ['documento', $data['documento']],
                    ['estado', 'ACTIVO']
                ])->first();
            }

            if (!is_null($persona) && !is_null($persona->empleado)) {
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
