@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('empresas-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Datos de la Empresa: {{ $empresa->nombre_comercial }}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('empresas.index') }}">Empresas</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Datos</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div>
                        <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning btn-xs float-right">
                            <i class="fa fa-edit"></i>EDITAR EMPLEADO
                        </a>
                       <h2  style="text-transform:uppercase">{{ $empresa->nombre_comercial }}</h2>
                    </div>
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-personales"> DATOS DE LA EMPRESA  </a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-personales2"> DATOS DE LA EMPRESA</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-personales" class="tab-pane active">
                                <div class="panel-body">
                                    <h4><b><i class="fa fa-caret-right"></i> DATOS DE LA EMPRESA</b></h4><br>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-xs-12">
                                            <label><strong>DOCUMENTO</strong></label>
                                            <p>{{ $empresa->documento }}</p>
                                        </div>
                                        <div class="form-group col-lg-6 col-xs-12">
                                            <label><strong>ESTADO</strong></label>
                                            <p>{{ ($empresa->activo == 1) ? 'ACTIVO' : 'INACTIVO' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>NOMBRE COMERCIAL</strong></label>
                                            <p>{{ $empresa->nombre_comercial }}</p>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>RAZON SOCIAL</strong></label>
                                            <p>{{ $empresa->razon_social }}</p>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>DIRECCION</strong></label>
                                            <p>{{ $empresa->direccion }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>DIRECCION FISCAL</strong></label>
                                            <p>{{ $empresa->direccion_fiscal }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>TELÉFONO MÓVIL</strong></label>
                                            <p>{{ $empresa->telefono_movil }}</p>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>CORREO ELECTRÓNICO</strong></label>
                                            <p>{{ ($empresa->correo_electronico) ? $empresa->correo_electronico : '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-personales2" class="tab-pane">
                                <div class="panel-body">
                                    <h4><b><i class="fa fa-caret-right"></i> DATOS DE LA EMPRESA</b></h4><br>
                                    <div class="row">
                                            <div class="col-md-6 b-r">
                                            <h4><b><i class="fa fa-caret-right"></i> REDES SOCIALES</b></h4><br>
                                                <div class="form-group">
                                                    <label><strong>FACEBOOK: </strong></label>
                                                    @if($empresa->facebook != "")
                                                        <p>{{$empresa->facebook}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label><strong>WHATSAPP: </strong></label>
                                                    @if($empresa->whatsapp != "")
                                                        <p>{{$empresa->whatsapp}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <h4><b><i class="fa fa-caret-right"></i> Datos del Contacto</b></h4><br>
                                            <div class="row">
                                                <div class="form-group col-lg-4 col-xs-12">
                                                    <label><strong>TIPO DE DOCUMENTO CONTACTO</strong></label>
                                                    @if($empresa->tipo_documento_contacto != "")
                                                    <p>{{$empresa->tipo_documento_contacto}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                                <div class="form-group col-lg-3 col-xs-12">
                                                    <label><strong>DOCUMENTO CONTACTO</strong></label>
                                                      @if($empresa->documento_contacto != "")
                                                            <p>{{$empresa->documento_contacto}}</p>
                                                        @else
                                                            <p>-</p>
                                                        @endif
                                                </div>
                                                <div class="form-group col-lg-2 col-xs-12">
                                                    <label><strong>NOMBRE CONTACTO</strong></label>
                                                    @if($empresa->nombre_contacto != "")
                                                    <p>{{$empresa->nombre_contacto}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
@stop
@push('scripts')
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
@endpush
