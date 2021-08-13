@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('clientes-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Datos del Cliente: {{ $cliente->nombre }}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('cliente.index') }}">Clientes</a>
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
                        <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-warning btn-xs float-right">
                            <i class="fa fa-edit"></i>EDITAR CLIENTE
                        </a>
                       <h2  style="text-transform:uppercase">{{ $cliente->nombre }}</h2>
                    </div>
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-personales"> DATOS DEL CLIENTE  </a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-personales2"> DATOS DEL CLIENTE </a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-personales3"> DISPOSITIVOS DEL CLIENTE </a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-personales" class="tab-pane active">
                                <div class="panel-body">
                                    <h4><b><i class="fa fa-caret-right"></i> DATOS DEL CLIENTE</b></h4><br>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>TIPO DE DOCUMENTO</strong></label>
                                            <p>{{ $cliente->tipo_documento }}</p>
                                        </div>
                                        <div class="form-group col-lg-3 col-xs-12">
                                            <label><strong>DOCUMENTO</strong></label>
                                            <p>{{ $cliente->documento }}</p>
                                        </div>
                                        <div class="form-group col-lg-2 col-xs-12">
                                            <label><strong>ESTADO</strong></label>
                                            <p>{{ ($cliente->activo == 1) ? 'ACTIVO' : 'INACTIVO' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>NOMBRE</strong></label>
                                            <p>{{ $cliente->nombre }}</p>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>NOMBRE COMERCIAL</strong></label>
                                            <p>{{ $cliente->nombre_comercial }}</p>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>DIRECCION</strong></label>
                                            <p>{{ $cliente->direccion }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>DIRECCION FISCAL</strong></label>
                                            <p>{{ $cliente->direccion_fiscal }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>TELÉFONO MÓVIL</strong></label>
                                            <p>{{ $cliente->telefono_movil }}</p>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>CORREO ELECTRÓNICO</strong></label>
                                            <p>{{ ($cliente->correo_electronico) ? $cliente->correo_electronico : '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-personales2" class="tab-pane">
                                <div class="panel-body">
                                    <h4><b><i class="fa fa-caret-right"></i> DATOS DEL CLIENTE</b></h4><br>
                                    <div class="row">
                                            <div class="col-md-6 b-r">
                                            <h4><b><i class="fa fa-caret-right"></i> REDES SOCIALES</b></h4><br>
                                                <div class="form-group">
                                                    <label><strong>FACEBOOK: </strong></label>
                                                    @if($cliente->facebook != "")
                                                        <p>{{$cliente->facebook}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label><strong>WHATSAPP: </strong></label>
                                                    @if($cliente->whatsapp != "")
                                                        <p>{{$cliente->whatsapp}}</p>
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
                                                    @if($cliente->tipo_documento_contacto != "")
                                                    <p>{{$cliente->tipo_documento_contacto}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                                <div class="form-group col-lg-3 col-xs-12">
                                                    <label><strong>DOCUMENTO CONTACTO</strong></label>
                                                      @if($cliente->documento_contacto != "")
                                                            <p>{{$cliente->documento_contacto}}</p>
                                                        @else
                                                            <p>-</p>
                                                        @endif
                                                </div>
                                                <div class="form-group col-lg-2 col-xs-12">
                                                    <label><strong>NOMBRE CONTACTO</strong></label>
                                                    @if($cliente->nombre_contacto != "")
                                                    <p>{{$cliente->nombre_contacto}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-personales3" class="tab-pane">
                                <div class="panel-body">
                                    <h4><b><i class="fa fa-caret-right"></i> DISPOSITIVOS DEL CLIENTE</b></h4><br>
                                    <table class="table dataTables-empresas table-striped table-bordered table-hover"  style="text-transform:uppercase">
                                    <thead>
                                        <tr>
                                            <th class="text-center">TELEFONO</th>
                                            <th class="text-center">PLACA</th>
                                            <th class="text-center">MARCA</th>
                                            <th class="text-center">COLOR</th>
                                            <th class="text-center">PAGO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>
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
@push('styles')
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush 
@push('scripts')
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('buttons-html5').removeClass('.btn-default');
        $('#table_empresas_wrapper').removeClass('');
        $('.dataTables-empresas').DataTable({
            "dom": '<"html5buttons"B>lTfgitp',
            "buttons": [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'Empresas'
                },
                {   
                    titleAttr: 'Imprimir',
                    extend: 'print',
                    text:      '<i class="fa fa-print"></i> Imprimir',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
                ],
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": false,
            "serverSide":true,
            "processing":true,
            "searching": true,
            "ajax": '{{ route("cliente.getTabledispositivo", "$cliente->id")}}',
            "columns": [
                //Empresa
                {data: 'nrotelefono', className:"text-center"},
                {data: 'placa', className:"text-center" },
                {data: 'marca', className:"text-center" },
                {data: 'color', className:"text-center" },
                {data: 'pago', className:"text-center" }
            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [],
        });
    });
    </script>
@endpush
