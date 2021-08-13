<div class="wrapper wrapper-content animated fadeIn" id="contenedor">
    <form class="wizard-big formulario" action="{{ $action }}" method="POST" id="form_registrar_contrato">
        @csrf
        <h1>Datos De La Empresa</h1>
        <fieldset style="position: relative;">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <h4 class=""><b>Documento de venta</b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Registrar datos del documento de venta:</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-xs-12">
                                    <label class="">Fecha de Inicio</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_inicio" name="fecha_inicio"
                                            onchange="fechafinal(this)"
                                            class="form-control {{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}"
                                            value="{{ old('fecha_inicio') ? old('fecha_inicio') : getFechaFormato($contrato->fecha_inicio, 'Y/m/d') }}"
                                            readonly>
                                        @if ($errors->has('fecha_inicio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_inicio') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-12">
                                    <label class="">Fecha de fin</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_fin" name="fecha_fin"
                                            class="form-control {{ $errors->has('fecha_fin') ? ' is-invalid' : '' }}"
                                            value="{{ old('fecha_fin') ? old('fecha_fin') : getFechaFormato($contrato->fecha_fin, 'Y/m/d') }}"
                                            readonly>
                                        @if ($errors->has('fecha_fin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_fin') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-lg-12 col-xs-12">
                                    <label class="required">Empresa</label>
                                    <select id="empresa" name="empresa"
                                        class="select2_form form-control {{ $errors->has('empresa') ? ' is-invalid' : '' }}">
                                        <option></option>
                                        @foreach (empresas() as $empresa)
                                            <option value="{{ $empresa->id }}"
                                                {{ old('empresa') ? (old('empresa') == $empresa->id ? 'selected' : '') : ($empresa->id == $contrato->empresa_id ? 'selected' : '') }}>
                                                {{ $empresa->nombre_comercial }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('empresa'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('empresa') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12 col-xs-12">
                                    <label class="required">Cliente</label>
                                    <select id="cliente" name="cliente"
                                        class="select2_form form-control {{ $errors->has('cliente') ? ' is-invalid' : '' }}">
                                        <option></option>
                                        @foreach (clientes() as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                {{ old('cliente') ? (old('cliente') == $cliente->id ? 'selected' : '') : ($cliente->id == $contrato->cliente_id ? 'selected' : '') }}>
                                                {{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cliente'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cliente') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class=""><b>Detalle del Contrato</b></h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-xs-12">
                                            <label class="col-form-label required">Placa:</label>
                                            <select class="select2_form form-control" onchange="dispositivoprecio(this)"
                                                style="text-transform: uppercase; width:100%" name="dispositivo"
                                                id="dispositivo">
                                                <option></option>
                                                @foreach (dispositivos() as $dispositivo)
                                                    <option value="{{ $dispositivo->id }}"
                                                        data-precio="{{ $dispositivo->precio }}">
                                                        {{ $dispositivo->placa }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"><b><span id="error-dispositivo"></span></b>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label required" for="amount">Pago :</label>
                                                <input type="text" id="pago" class="form-control">
                                                <div class="invalid-feedback"><b><span id="error-pago"></span></b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label required" for="amount">Costo
                                                    Instalacion:</label>
                                                <input type="text" id="costo_instalacion" class="form-control">
                                                <div class="invalid-feedback"><b><span
                                                            id="error-costo_instalacion"></span></b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="amount">&nbsp;</label>
                                                <a class="btn btn-block btn-warning" style='color:white;'
                                                    id="btn_agregar_detalle"> <i class="fa fa-plus"></i> AGREGAR</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                        @if ($errors->has('dispositivo_tabla'))
                                            <h5 style="color:rgb(220,54,70);">
                                                {{ $errors->first('dispositivo_tabla') }}</h5>
                                        @endif
                                        <table
                                            class="table dataTables-detalle-contrato table-striped table-bordered table-hover"
                                            style="text-transform:uppercase">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-center">ACCIONES</th>
                                                    <th class="text-center">PLACA</th>
                                                    <th class="text-center">PAGO</th>
                                                    <th class="text-center">COSTO INSTALACION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" style="text-align:right">Total:</th>
                                                    <th><span id="total">0.0</span></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (!empty($put))
                <input type="hidden" name="_method" value="PUT">
                <input name="rango_id" id="rango_id" value="{{ $rango_id }}" type="hidden">
            @endif
            <input type="hidden" name="dispositivo_tabla" id="dispositivo_tabla">
        </fieldset>
        <h1>Contrato Geocerca</h1>
        <fieldset style="position: relative;">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card text-center">
                                <div class="card-header bg-primary">
                                    Localizacion-Rango
                                </div>
                                <div class="card-body">
                                    <div id="map" style="height:500px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card text-center">
                                <div class="card-header bg-primary">
                                    Posiciones
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="col-lg-12 col-xs-12">
                                            <label class="required">Rangos</label>
                                            <select id="rangos_gps" name="rangos_gps" class="select2_form form-control"
                                                onchange="rangoelegido(this)">
                                                <option></option>
                                                @foreach (rangoscontrato() as $rango)
                                                    <option value="{{ $rango->id }}">{{ $rango->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-xs-12">
                                            <label class="required">Nombre Geocerca</label>
                                            <input type="text" name="nombre_contrato_rango" id="nombre_contrato_rango"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12"><button id="btnguardar" type="button"
                                                class="btn btn-block btn-w-m btn-primary m-t-md">Agregar</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="table-responsive" style="margin-top:5%;">
                        <table class="table dataTables-detalle-geocerca table-striped table-bordered table-hover"
                            style="text-transform:uppercase">
                            <thead>
                                <tr>

                                    <th class="text-center">ACCIONES</th>
                                    <th class="text-center">GEOCERCA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" name="posiciones_guardar" id="posiciones_guardar">

            </div>
        </fieldset>
    </form>
    @include('contrato.modal')
    @include('contrato.modalgeocerca')
    @if (!empty($detalle))
        <input id="detalle" value="{{ $detallecontrato }}" type="hidden">
        <input id="posiciones_gps" id="posiciones_gps" value="{{ $detalle_gps }}" type="hidden">

    @endif

</div>
@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
        rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
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
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ gpsKey() }}&libraries=geometry">
    </script>
    <script>
        var polygon;
        var map;
        var map_geocerca;
        var markers = [];
        var markers_geocerca = [];

    </script>
    <script type="text/javascript" src="{{ asset('js/contrato/init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/contrato/contrato.js') }}"></script>


@endpush
