@extends('layout')
@section('content')
@section('mantenimiento-active', 'active')
@section('colaboradores-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Modificar Colaborador</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('mantenimiento.colaborador.index') }}">Colaboradores</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Modificar</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <form class="wizard-big" action="{{ route('mantenimiento.colaborador.update', $empleado->id) }}" method="POST" enctype="multipart/form-data" id="form_registrar_empleado">
        @csrf @method('PUT')
        <h1>Datos Personales</h1>
        <fieldset>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Tipo de documento</label>
                    <select id="tipo_documento" name="tipo_documento" class="select2_form form-control {{ $errors->has('tipo_documento') ? ' is-invalid' : '' }}">
                        <option></option>
                        @foreach(tipos_documento() as $tipo_documento)
                            @if ($tipo_documento->simbolo != 'RUC')
                                <option value="{{ $tipo_documento->simbolo }}" {{ (old('tipo_documento', $empleado->persona->tipo_documento) == $tipo_documento->simbolo ? "selected" : "") }} >{{ $tipo_documento->descripcion }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4 col-xs-12" id="documento_requerido">
                    <label class="required">Nro. Documento</label>
                    <div class="input-group">
                        <input type="text" id="documento" name="documento" class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" value="{{old('documento', $empleado->persona->documento)}}" maxlength="8" onkeypress="return isNumber(event)" required onchange="cambiaDocumento();">
                        <span class="input-group-append"><a style="color:white" onclick="consultarDocumento()" class="btn btn-primary"><i class="fa fa-search"></i> Reniec</a></span>
                        @if ($errors->has('documento'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('documento') }}</strong>
                            </span>
                            @endif
                        <div class="invalid-feedback"><b><span id="error-documento"></span></b></div>
                    </div>
                </div>
                <input type="hidden" id="codigo_verificacion" name="codigo_verificacion">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="">Estado: </label>
                    <input type="text" id="estado_documento"
                        class="form-control text-center {{ $errors->has('estado_documento') ? ' is-invalid' : '' }}"
                        name="estado_documento" value="{{$empleado->persona->estado_documento}}"
                        onkeyup="return mayus(this)" disabled>
                    @if ($errors->has('estado_documento'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('estado_documento') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Nombre(s)</label>
                    <input type="text" id="nombres" name="nombres" class="form-control {{ $errors->has('nombres') ? ' is-invalid' : '' }}" value="{{old('nombres', $empleado->persona->nombres)}}" maxlength="100" onkeyup="return mayus(this)" required>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Apellido paterno</label>
                    <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control {{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" value="{{old('apellido_paterno', $empleado->persona->apellido_paterno)}}" onkeyup="return mayus(this)" maxlength="100" required>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Apellido materno</label>
                    <input type="text" id="apellido_materno" name="apellido_materno" class="form-control {{ $errors->has('apellido_materno') ? ' is-invalid' : '' }}" value="{{old('apellido_materno', $empleado->persona->apellido_materno)}}" onkeyup="return mayus(this)" maxlength="100" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12" id="fecha_nacimiento">
                    <label class="required">Fecha de Nacimiento</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control {{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}" value="{{old('fecha_nacimiento', getFechaFormato($empleado->persona->fecha_nacimiento, 'd/m/Y'))}}" readonly required >
                    </div>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Sexo</label>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="radio">
                                <input type="radio" name="sexo" id="sexo_hombre" value="H" {{ ($empleado->persona->sexo == 'H') ? "checked" : "" }}>
                                <label for="sexo_hombre">
                                    Hombre
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="radio">
                                <input type="radio" name="sexo" id="sexo_mujer" value="M" {{ ($empleado->persona->sexo == 'M') ? "checked" : "" }}>
                                <label for="sexo_mujer">
                                    Mujer
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label>Estado Civil</label>
                    <select id="estado_civil" name="estado_civil" class="select2_form form-control {{ $errors->has('estado_civil') ? ' is-invalid' : '' }}">
                        <option></option>
                        @foreach(estados_civiles() as $estado_civil)
                            <option value="{{ $estado_civil->simbolo }}" {{ (old('estado_civil', $empleado->persona->estado_civil) == $estado_civil->simbolo ? "selected" : "") }}>{{ $estado_civil->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
        </fieldset>
        <h1>Datos de Contacto</h1>
        <fieldset>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Departamento</label>
                    <select id="departamento" name="departamento" class="select2_form form-control {{ $errors->has('departamento') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(departamentos() as $departamento)
                            <option value="{{ $departamento->id }}" {{ (old('departamento', $empleado->persona->departamento_id) == $departamento->id ? "selected" : "") }} >{{ $departamento->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Provincia</label>
                    <select id="provincia" name="provincia" class="select2_form form-control {{ $errors->has('provincia') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(getProvinciasByDepartamento($empleado->persona->departamento_id) as $provincia)
                            <option value="{{ $provincia->id }}" {{ (old('provincia', $empleado->persona->provincia_id) == $provincia->id ? "selected" : "") }} >{{ $provincia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Distrito</label>
                    <select id="distrito" name="distrito" class="select2_form form-control {{ $errors->has('distrito') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(getDistritosByProvincia($empleado->persona->provincia_id) as $distrito)
                            <option value="{{ $distrito->id }}" {{ (old('distrito', $empleado->persona->distrito_id) == $distrito->id ? "selected" : "") }} >{{ $distrito->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-12 col-xs-12">
                    <label class="required">Dirección completa</label>
                    <input type="text" id="direccion" name="direccion" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{old('direccion', $empleado->persona->direccion)}}" maxlength="191" onkeyup="return mayus(this)" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Correo electrónico</label>
                    <input type="correo_electronico" id="correo_electronico" name="correo_electronico" class="form-control {{ $errors->has('correo_electronico') ? ' is-invalid' : '' }}" value="{{old('correo_electronico', $empleado->persona->correo_electronico)}}" maxlength="100" onkeyup="return mayus(this)" required>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Teléfono móvil</label>
                    <input type="text" id="telefono_movil" name="telefono_movil" class="form-control {{ $errors->has('telefono_movil') ? ' is-invalid' : '' }}" value="{{old('telefono_movil', $empleado->persona->telefono_movil)}}" onkeypress="return isNumber(event)" maxlength="9" required>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label>Teléfono fijo</label>
                    <input type="text" id="telefono_fijo" name="telefono_fijo" class="form-control {{ $errors->has('telefono_fijo') ? ' is-invalid' : '' }}" value="{{old('telefono_fijo', $empleado->persona->telefono_fijo)}}" onkeypress="return isNumber(event)" maxlength="10">
                </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
        </fieldset>
        <h1>Datos Laborales</h1>
        <fieldset style="position: relative;">
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Área</label>
                    <select id="area" name="area" class="select2_form form-control {{ $errors->has('area') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(areas() as $area)
                            <option value="{{ $area->simbolo }}" {{ (old('area', $empleado->area) == $area->simbolo ? "selected" : "") }} >{{ $area->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Profesión</label>
                    <select id="profesion" name="profesion" class="select2_form form-control {{ $errors->has('profesion') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(profesiones() as $profesion)
                            <option value="{{ $profesion->simbolo }}" {{ (old('profesion', $empleado->profesion) == $profesion->simbolo ? "selected" : "") }} >{{ $profesion->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Cargo</label>
                    <select id="cargo" name="cargo" class="select2_form form-control {{ $errors->has('cargo') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(cargos() as $cargo)
                            <option value="{{ $cargo->simbolo }}" {{ (old('cargo', $empleado->cargo) == $cargo->simbolo ? "selected" : "") }} >{{ $cargo->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Sueldo</label>
                    <input type="text" id="sueldo" name="sueldo" class="form-control {{ $errors->has('sueldo') ? ' is-invalid' : '' }}" value="{{old('sueldo', $empleado->sueldo)}}" maxlength="15" onkeypress="return filterFloat(event,this);" required>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Sueldo bruto</label>
                    <input type="text" id="sueldo_bruto" name="sueldo_bruto" class="form-control {{ $errors->has('sueldo_bruto') ? ' is-invalid' : '' }}" value="{{old('sueldo_bruto', $empleado->sueldo_bruto)}}" onkeypress="return filterFloat(event,this);" maxlength="15" required>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Sueldo neto</label>
                    <input type="text" id="sueldo_neto" name="sueldo_neto" class="form-control {{ $errors->has('sueldo_neto') ? ' is-invalid' : '' }}" value="{{old('sueldo_neto', $empleado->sueldo_neto)}}" onkeypress="return filterFloat(event,this);" maxlength="15" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12">
                    <label class="required">Moneda sueldo</label>
                    <select id="moneda_sueldo" name="moneda_sueldo" class="select2_form form-control {{ $errors->has('moneda_sueldo') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(tipos_moneda() as $moneda)
                            <option value="{{ $moneda->simbolo }}" {{ (old('moneda_sueldo', $empleado->moneda_sueldo) == $moneda->simbolo ? "selected" : "") }}>{{ $moneda->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label>Banco</label>
                    <select id="tipo_banco" name="tipo_banco" class="select2_form form-control {{ $errors->has('tipo_banco') ? ' is-invalid' : '' }}" style="width: 100%">
                        <option></option>
                        @foreach(bancos() as $banco)
                            <option value="{{ $banco->simbolo }}" {{ (old('tipo_banco', $empleado->tipo_banco) == $banco->simbolo ? "selected" : "") }} >{{ $banco->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4 col-xs-12">
                    <label>Número de cuenta</label>
                    <input type="text" id="numero_cuenta" name="numero_cuenta" class="form-control {{ $errors->has('numero_cuenta') ? ' is-invalid' : '' }}" value="{{old('numero_cuenta', $empleado->numero_cuenta)}}" maxlength="20" onkeypress="return isNumber(event)" onkeyup="return mayus(this)">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12" id="fecha_inicio_actividad">
                    <label class="required">Fecha inicio actividad</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" id="fecha_inicio_actividad" name="fecha_inicio_actividad" class="form-control {{ $errors->has('fecha_inicio_actividad') ? ' is-invalid' : '' }}" value="{{old('fecha_inicio_actividad', getFechaFormato($empleado->fecha_inicio_actividad, 'd/m/Y'))}}" readonly required >
                    </div>
                </div>
                <div class="form-group col-lg-4 col-xs-12" id="fecha_fin_actividad">
                    <label>Fecha fin actividad</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" id="fecha_fin_actividad" name="fecha_fin_actividad" class="form-control {{ $errors->has('fecha_fin_actividad') ? ' is-invalid' : '' }}" value="{{old('fecha_fin_actividad', (!empty($empleado->fecha_fin_actividad)) ? getFechaFormato($empleado->fecha_fin_actividad, 'd/m/Y') : "")}}" readonly >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4 col-xs-12" id="fecha_inicio_planilla">
                    <label class="required">Fecha inicio planilla</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" id="fecha_inicio_planilla" name="fecha_inicio_planilla" class="form-control {{ $errors->has('fecha_inicio_planilla') ? ' is-invalid' : '' }}" value="{{old('fecha_inicio_planilla', (!empty($empleado->fecha_inicio_planilla)) ? getFechaFormato($empleado->fecha_inicio_planilla, 'd/m/Y') : "")}}" readonly >
                    </div>
                </div>
                <div class="form-group col-lg-4 col-xs-12" id="fecha_fin_planilla">
                    <label>Fecha fin planilla</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" id="fecha_fin_planilla" name="fecha_fin_planilla" class="form-control {{ $errors->has('fecha_fin_planilla') ? ' is-invalid' : '' }}" value="{{old('fecha_fin_planilla', (!empty($empleado->fecha_fin_planilla)) ? getFechaFormato($empleado->fecha_fin_planilla, 'd/m/Y') : "")}}" readonly >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
        </fieldset>
        <h1>Datos Adicionales</h1>
        <fieldset>
            <div class="row">
                <div class="col-lg-8 col-xs-12">
                    <div class="row">
                        <div class="form-group col-lg-6 col-xs-12">
                            <label>Teléfono de referencia</label>
                            <input type="text" id="telefono_referencia" name="telefono_referencia" class="form-control {{ $errors->has('telefono_referencia') ? ' is-invalid' : '' }}" value="{{old('telefono_referencia', $empleado->telefono_referencia)}}" maxlength="50" onkeyup="return mayus(this)">
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">
                            <label>Contacto de referencia</label>
                            <input type="text" id="contacto_referencia" name="contacto_referencia" class="form-control {{ $errors->has('contacto_referencia') ? ' is-invalid' : '' }}" value="{{old('contacto_referencia', $empleado->contacto_referencia)}}" maxlength="191" onkeyup="return mayus(this)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-xs-12">
                            <label>Número de hijos</label>
                            <input type="text" id="numero_hijos" name="numero_hijos" class="form-control {{ $errors->has('numero_hijos') ? ' is-invalid' : '' }}" value="{{old('numero_hijos', $empleado->numero_hijos)}}" onkeypress="return isNumber(event)" maxlength="2" >
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">
                            <label>Grupo sanguíneo</label>
                            <select id="grupo_sanguineo" name="grupo_sanguineo" class="select2_form form-control {{ $errors->has('grupo_sanguineo') ? ' is-invalid' : '' }}" style="width: 100%">
                                <option></option>
                                @foreach(grupos_sanguineos() as $grupo_sanguineo)
                                    <option value="{{ $grupo_sanguineo->simbolo }}" {{ (old('grupo_sanguineo', $empleado->grupo_sanguineo) == $grupo_sanguineo->simbolo ? "selected" : "") }} >{{ $grupo_sanguineo->descripcion }} ({{ $grupo_sanguineo->simbolo }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12 col-xs-12">
                            <label>Alergias</label>
                            <textarea type="text" id="alergias" name="alergias" class="form-control {{ $errors->has('alergias') ? ' is-invalid' : '' }}" value="{{old('alergias', $empleado->alergias)}}" rows="3" onkeyup="return mayus(this)">{{old('alergias', $empleado->alergias)}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Imagen:</label>
                                <div class="custom-file">
                                    <input id="imagen" type="file" name="imagen" class="custom-file-input {{ $errors->has('imagen') ? ' is-invalid' : '' }}"  accept="image/*" src="{{ Storage::url($empleado->ruta_imagen)}}">
                                    <label for="imagen" id="ruta_imagen" class="custom-file-label selected {{ $errors->has('ruta_imagen') ? ' is-invalid' : '' }}">
                                        @if($empleado->nombre_imagen) {{$empleado->nombre_imagen}} @else Seleccionar @endif
                                    </label>
                                    @if ($errors->has('imagen'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('imagen') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group justify-content-center">
                            <div class="col-6 align-content-center">
                                <div class="row justify-content-end">
                                    <a href="javascript:void(0);" id="limpiar_logo">
                                        <span class="badge badge-danger">x</span>
                                    </a>
                                </div>
                                <div class="row justify-content-center">
                                    <p>
                                        @if($empleado->ruta_imagen)
                                            <img class="logo" src="{{Storage::url($empleado->ruta_imagen)}}" alt="">
                                            <input id="url_logo" name="url_logo" type="hidden" value="{{$empleado->ruta_imagen}}">
                                        @else
                                            <img class="logo"  src="{{asset('storage/empresas/logos/default.png')}}" alt="">
                                            <input id="url_logo" name="url_logo" type="hidden" value="">
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
        </fieldset>
    </form>
</div>
@stop
@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <style>
        .logo {
            width: 190px;
            height: 190px;
            border-radius: 10%;
            position: absolute;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            });
            $("#tipo_documento").on('change', setLongitudDocumento);
            $("#departamento").on("change", function (e) {
                var departamento_id = this.value;
                if (departamento_id !== "" || departamento_id.length > 0) {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: $('input[name=_token]').val(),
                            departamento_id: departamento_id
                        },
                        url: "{{ route('mantenimiento.ubigeo.provincias') }}",
                        success: function (data) {
                            $("#provincia,#distrito").empty();
                            if (!data.error) {
                                if (data.provincias != null) {
                                    $("#provincia").select2({
                                        data: data.provincias
                                    }).val($('#provincia').find(':selected').val()).trigger('change');
                                }
                            } else {
                                toastr.error(data.message, 'Mensaje de Error', {
                                    "closeButton": true,
                                    positionClass: 'toast-bottom-right'
                                });
                            }
                        }
                    });
                }
            });
            $('#provincia').on("change", function (e) {
                var provincia_id = this.value;
                if (provincia_id !== "" || provincia_id.length > 0) {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: $('input[name=_token]').val(),
                            provincia_id: provincia_id
                        },
                        url: "{{ route('mantenimiento.ubigeo.distritos') }}",
                        success: function (data) {
                            $("#distrito").empty();
                            if (!data.error) {
                                if (data.distritos != null) {
                                    $("#distrito").select2({
                                        data: data.distritos
                                    });
                                }
                            } else {
                                toastr.error(data.message, 'Mensaje de Error', {
                                    "closeButton": true,
                                    positionClass: 'toast-bottom-right'
                                });
                            }
                        }
                    });
                }
            });
            $("#correo_electronico").on('change', validarEmail);
            $('#fecha_nacimiento .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "dd/mm/yyyy"
            });
            $('#fecha_inicio_actividad .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "dd/mm/yyyy"
            });
            $('#fecha_fin_actividad .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "dd/mm/yyyy"
            });
            $('#fecha_inicio_planilla .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "dd/mm/yyyy"
            });
            $('#fecha_fin_planilla .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "dd/mm/yyyy"
            });
        })
        function setLongitudDocumento() {
            var tipo_documento = $('#tipo_documento').val();
            if (tipo_documento !== undefined && tipo_documento !== null && tipo_documento !== "" && tipo_documento.length > 0) {
                clearDatosPersona();
                switch (tipo_documento) {
                    case 'DNI':
                        $("#documento").attr('maxlength', 8);
                        break;
                    case 'CARNET EXT.':
                        $("#documento").attr('maxlength', 20);
                        break;
                    case 'PASAPORTE':
                        $("#documento").attr('maxlength', 20);
                        break;
                    case 'P. NAC.':
                        $("#documento").attr('maxlength', 25);
                        break;
                }
            }
        }
        function consultarDocumento() {
            var tipo_documento = $('#tipo_documento').val();
            var documento = $('#documento').val();
            // Consultamos nuestra BBDD
            $.ajax({
                dataType : 'json',
                type : 'post',
                url : '{{ route('mantenimiento.colaborador.getDni') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'tipo_documento' : tipo_documento,
                    'documento' : documento,
                    'id': {{ $empleado->id }}
                }
            }).done(function (result){
                if (result.existe) {
                    if (!result.igual_persona) {
                        toastr.error('El DNI ingresado ya se encuentra registrado para un colaborador','Error');
                        $('#documento').focus();
                    }
                } else {
                    if (tipo_documento === "DNI") {
                        if (documento.length === 8) {
                            consultarAPI(documento);
                        } else {
                            toastr.error('El DNI debe de contar con 8 dígitos','Error');
                            $('#documento').focus();
                        }
                    }else{
                        toastr.error('La consulta Reniec solo aplica para Tipo Documento DNI','Error');
                    }
                }
            });
        }
        function consultarAPI(documento) {
            Swal.fire({
                title: 'Consultar',
                text: "¿Desea consultar DNI a RENIEC?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: 'Si, Confirmar',
                cancelButtonText: "No, Cancelar",
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    var url= '{{ route("getApidni", ":dni")}}';
                    url = url.replace(':dni',documento);
                    return fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            $('#estado_documento').val('SIN VERIFICAR')
                            Swal.showValidationMessage(
                                `Ruc erróneo: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.value !== undefined && result.isConfirmed) {
                    $('#documento').removeClass('is-invalid')
                    camposDNI(result);
                    consultaExitosa();
                }
            });
        }
        function camposDNI(objeto) {
            if (objeto.value === undefined)
                return;
            var nombres = objeto.value.nombres;
            var apellido_paterno = objeto.value.apellidoPaterno;
            var apellido_materno = objeto.value.apellidoMaterno;
            var codigo_verificacion = objeto.value.codVerifica;
            if (nombres !== '-' && nombres !== "NULL" ) {
                $('#nombres').val(nombres);
            }
            if (apellido_paterno !== '-' && apellido_paterno !== "NULL" ) {
                $('#apellido_paterno').val(apellido_paterno);
            }
            if (apellido_materno !== '-' && apellido_materno !== "NULL" ) {
                $('#apellido_materno').val(apellido_materno);
            }
            if (codigo_verificacion !== '-' && codigo_verificacion !== "NULL" ) {
                $('#codigo_verificacion').val(codigo_verificacion);
            }
            $('#estado_documento').val('ACTIVO')
        }
        function clearDatosPersona() {
            $('#documento').val("");
            $('#nombres').val("");
            $('#apellido_paterno').val("");
            $('#apellido_materno').val("");
            $('#codigo_verificacion').val("");
        }
        $("#form_registrar_empleado").steps({
            bodyTag: "fieldset",
            transitionEffect: "fade",
            labels: {
                current: "actual paso:",
                pagination: "Paginación",
                finish: "Finalizar",
                next: "Siguiente",
                previous: "Anterior",
                loading: "Cargando ..."
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                var form = $(this);
                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }
                // Start validation; Prevent going forward if false
                return validarDatos(currentIndex + 1);
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);
                // Start validation; Prevent form submission if false
                return true;
            },
            onFinished: function (event, currentIndex)
            {
                var form = $(this);
                $("#estado_documento").prop('disabled', false);
                // Submit form input
                form.submit();
            }
        });
        function validarDatos(paso) {
            console.log("paso: " + paso);
            switch (paso) {
                case 1:
                    return validarDatosPersonales();
                case 2:
                    return validarDatosContacto();
                case 3:
                    return validarDatosLaborales();
                case 4:
                    return validarDatosAdicionales();
                default:
                    return false;
            }
        }
        function validarDatosPersonales() {
            var tipo_documento = $("#tipo_documento").val();
            var documento = $("#documento").val();
            var nombres = $("#nombres").val();
            var apellido_paterno = $("#apellido_paterno").val();
            var apellido_materno = $("#apellido_materno").val();
            var fecha_nacimiento = $("#fecha_nacimiento").find("input").val();
            $('.datepicker-days').removeAttr("style").hide();
            var sexo = $("#sexo_hombre").is(':checked') ? 'H' : 'M';
            if ((tipo_documento !== null && tipo_documento.length === 0) || documento.length === 0 || nombres.length === 0 || apellido_paterno.length === 0
                || apellido_materno.length === 0 || sexo.length === 0 || fecha_nacimiento.length === 0 ) {
                toastr.error('Complete la información de los campos obligatorios (*)','Error');
                return false;
            }
            switch (tipo_documento) {
                case 'DNI':
                    if (documento.length !== 8) {
                        toastr.error('El DNI debe de contar con 8 dígitos','Error');
                        return false;
                    }
                    break;
                case 'CARNET EXT.':
                    if (documento.length !== 20) {
                        toastr.error('El CARNET DE EXTRANJERIA debe de contar con 20 dígitos','Error');
                        return false;
                    }
                    break;
                case 'PASAPORTE':
                    if (documento.length !== 20) {
                        toastr.error('El PASAPORTE debe de contar con 20 dígitos','Error');
                        return false;
                    }
                    break;
                case 'P. NAC.':
                    if (documento.length !== 25) {
                        toastr.error('La PARTIDAD DE NACIMIENTO debe de contar con 25 dígitos','Error');
                        return false;
                    }
                    break;
            }
            return true;
        }
        function validarDatosContacto() {
            var departamento = $("#departamento").val();
            var provincia = $("#provincia").val();
            var distrito = $("#distrito").val();
            var direccion = $("#direccion").val();
            var correo_electronico = $("#correo_electronico").val();
            var telefono_movil = $("#telefono_movil").val();
            if ((departamento === null || departamento.length === 0) || (provincia === null || provincia.length === 0)
                || (distrito === null || distrito.length === 0)  || direccion.length === 0
                || correo_electronico.length === 0 || telefono_movil.length === 0) {
                toastr.error('Complete la información de los campos obligatorios (*)','Error');
                return false;
            }
            return true;
        }
        function validarDatosLaborales() {
            var area = $("#area").val();
            var profesion = $("#profesion").val();
            var cargo = $("#cargo").val();
            var sueldo = $("#sueldo").val();
            var sueldo_bruto = $("#sueldo_bruto").val();
            var sueldo_neto = $("#sueldo_neto").val();
            var moneda_sueldo = $("#moneda_sueldo").val();
            var tipo_banco = $("#tipo_banco").val();
            var numero_cuenta = $("#numero_cuenta").val();
            var fecha_inicio_actividad = $("#fecha_inicio_actividad").find("input").val();
            var fecha_fin_actividad = $("#fecha_fin_actividad").find("input").val();
            var fecha_inicio_planilla = $("#fecha_inicio_planilla").find("input").val();
            var fecha_fin_planilla = $("#fecha_fin_planilla").find("input").val();
            $('.datepicker-days').removeAttr("style").hide();
            if ((area === null || area.length === 0) || (profesion === null || profesion.length === 0) || (cargo === null || cargo.length === 0)
                || sueldo.length === 0 || sueldo_bruto.length === 0 || sueldo_neto.length === 0 || (moneda_sueldo === null || moneda_sueldo.length === 0)
                || fecha_inicio_actividad.length === 0) {
                toastr.error('Complete la información de los campos obligatorios (*)','Error');
                return false;
            }
            return true;
        }
        function validarEmail() {
            if (!emailIsValid($('#correo_electronico').val())) {
                toastr.error('El formato del email es incorrecto','Error');
                $('#correo_electronico').focus();
            }
        }
        /* Limpiar imagen */
        $('#limpiar_logo').click(function () {
            $('.logo').attr("src", "{{asset('storage/empresas/logos/default.png')}}")
            var fileName="Seleccionar"
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#imagen').val('')
        })
        $('.custom-file-input').on('change', function() {
            var fileInput = document.getElementById('imagen');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            $imagenPrevisualizacion = document.querySelector(".logo");
            if(allowedExtensions.exec(filePath)){
                var userFile = document.getElementById('imagen');
                userFile.src = URL.createObjectURL(event.target.files[0]);
                var data = userFile.src;
                $imagenPrevisualizacion.src = data
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }else{
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)','Error');
                $('.logo').attr("src", "{{asset('storage/empresas/logos/default.png')}}")
            }
        });
        function cambiaDocumento(){
            $('#estado_documento').val('SIN VERIFICAR')
        }
    </script>
@endpush
