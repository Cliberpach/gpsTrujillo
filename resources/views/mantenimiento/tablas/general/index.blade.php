@extends('layout') @section('content')
@include('mantenimiento.tablas.general.edit')
@section('mantenimiento-active', 'active')
@section('tablas-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12 col-md-12">
       <h2  style="text-transform:uppercase"><b>Mantenimiento de Tablas Generales</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Tablas Generales</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table dataTables-tabla-general table-striped table-bordered table-hover"  style="text-transform:uppercase">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">DESCRIPCION</th>
                            <th class="text-center">SIGLA</th>
                            <th class="text-center">CREADO</th>
                            <th class="text-center">ACTUALIZADO</th>
                            <th class="text-center">ACCIONES</th>
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
@stop
@push('styles')
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush 
@push('scripts')
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.dataTables-tabla-general').DataTable({
            "dom": '<"html5buttons"B>lTfgitp',
            "buttons": [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'Tablas Generales'
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
            "processing":true,
            "ajax": "{{route ('getTable')}}",
            "columns": [
                //Tabla General
                {data: 'id', className:"text-center" , "visible": false},
                {data: 'descripcion', className:"text-center"},
                {data: 'sigla', className:"text-center"},
                {data: 'creado', className:"text-center"},
                {data: 'fecha_actualizacion', className:"text-center"},
                {
                    data: null,
                    className:"text-center",
                    render: function (data) 
                        {
                        var url = '{{ route("mantenimiento.tabla.detalle.index", ":id")}}';
                        url = url.replace(':id',data.id);
                        return "<div class='btn-group'><a class='btn btn-info btn-sm' href='"+url+"' title='Examinar'><i class='fa fa-eye'></i></a></div>"
                    }
                }
            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [[ 0, "desc" ]],
        });
    });
    function obtenerData($id) {
        var table = $('.dataTables-tabla-general').DataTable();
        var data = table.rows().data();
        limpiarError()
        data.each(function (value, index) {
            if (value.id == $id) {
                $('#tabla_id_editar').val(value.id);
                $('#descripcion_editar').val(value.descripcion);
                $('#sigla_editar').val(value.sigla);
            }  
        });
        $('#modal_editar_tabla').modal('show');
    }
    //Old Modal Editar
    @if ($errors->has('sigla')  ||  $errors->has('descripcion') )
        $('#modal_editar_tabla').modal({ show: true });
    @endif
    function limpiarError() {
        $('#descripcion_editar').removeClass( "is-invalid" )
        $('#error-descripcion').text('')
        $('#sigla_editar').removeClass( "is-invalid" )
        $('#error-sigla').text('')
    }
    $('#modal_editar_tabla').on('hidden.bs.modal', function(e) { 
        limpiarError() 
    });
</script>
@endpush