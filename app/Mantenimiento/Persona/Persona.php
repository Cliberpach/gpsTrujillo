<?php

namespace App\Mantenimiento\Persona;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable =[
        'tipo_documento',
        'documento',
        'codigo_verificacion',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'sexo',
        'estado_civil',
        'departamento_id',
        'provincia_id',
        'distrito_id',
        'direccion',
        'correo_electronico',
        'telefono_movil',
        'telefono_fijo',
        'estado_documento',
        'estado'
    ];

    public function empleado()
    {
        return $this->hasOne('App\Mantenimiento\Colaborador\Colaborador');
    }

    public function getDocumento(): string
    {
        return $this->tipo_documento . ': ' . $this->documento;
    }

    public function getApellidosYNombres(): string
    {
        return $this->apellido_paterno . ' ' . $this->apellido_materno . ', ' . $this->nombres;
    }

    public function getTipoDocumento(): string
    {
        return tipos_documento()->where('simbolo', $this->tipo_documento)->first()->descripcion;
    }

    public function getSexo(): string
    {
        return tipos_sexo()->where('simbolo', $this->sexo)->first()->descripcion;
    }

    public function getEstadoCivil(): string
    {
        if(estados_civiles()->where('simbolo', $this->estado_civil)->first()){
            return estados_civiles()->where('simbolo', $this->estado_civil)->first()->descripcion;
        }else{
            return '';
        }
    }

    public function getDepartamento(): string
    {
        return departamentos()->where('id', $this->departamento_id)->first()->nombre;
    }

    public function getProvincia(): string
    {
        return provincias($this->provincia_id)->first()->nombre;
    }

    public function getDistrito(): string
    {
        return distritos($this->distrito_id)->first()->nombre;
    }


}
