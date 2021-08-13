<?php

namespace App\Mantenimiento\Colaborador;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'colaboradores';
    protected $fillable =[
        'persona_id',
        'area',
        'profesion',
        'cargo',
        'telefono_referencia',
        'contacto_referencia',
        'grupo_sanguineo',
        'alergias',
        'numero_hijos',
        'sueldo',
        'sueldo_bruto',
        'sueldo_neto',
        'moneda_sueldo',
        'tipo_banco',
        'numero_cuenta',
        'fecha_inicio_actividad',
        'fecha_fin_actividad',
        'fecha_inicio_planilla',
        'fecha_fin_planilla',
        'ruta_imagen',
        'estado'
    ];

    public function persona()
    {
        return $this->belongsTo('App\Mantenimiento\Persona\Persona');
    }

    public function vendedor()
    {
        return $this->hasOne('App\Mantenimiento\Vendedor\Vendedor');
    }

    public function getBanco(): string
    {
        $banco = bancos()->where('simbolo', $this->tipo_banco)->first();
        if (is_null($banco))
            return "-";
        else
            return $banco->descripcion;
    }

    public function getArea(): string
    {
        $area = areas()->where('simbolo', $this->area)->first();
        if (is_null($area))
            return "-";
        else
            return $area->descripcion;
    }

    public function getCargo(): string
    {
        $cargo = cargos()->where('simbolo', $this->cargo)->first();
        if (is_null($cargo))
            return "-";
        else
            return $cargo->descripcion;
    }
}
