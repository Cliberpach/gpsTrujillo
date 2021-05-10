@extends('layout') @section('content')
@include('mantenimiento.tablas.detalle.create')
@include('mantenimiento.tablas.detalle.edit')
@section('mantenimiento-active', 'active')
@section('tablas-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Tabla Detalle: {{$tabla->descripcion}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('mantenimiento.tabla.general.index') }}">Tablas Generales</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{$tabla->descripcion}}</strong>
            </li>
        </ol>
    </div>
    @if($tabla->editable != 1)
    <div class="col-lg-2 col-md-2">
        <a data-toggle="modal" data-target="#modal_crear_tabla_detalle"  id="btn_añadir_empleado" class="btn btn-block btn-w-m btn-primary m-t-md" href="#">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </a>
    </div>
    @endif
</div>
<input type="hidden" id="id_tabla" value="{{$tabla->id}}">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table dataTables-tabla-detalle table-striped table-bordered table-hover"  style="text-transform:uppercase">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">DESCRIPCION</th>
                            <th class="text-center">SIMBOLO</th>
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
<style>
    .my-swal {
        z-index: 3000 !important;
    }
</style>
@endpush 
@push('scripts')
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        //Enviar ID al controlador
        var tabla_id = $('#id_tabla').val();
        var url = '{{ route("getTableDetalle", ":id")}}';
        url = url.replace(':id',tabla_id);
        $('.dataTables-tabla-detalle').DataTable({
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
            "ajax": url,
            "columns": [
                //Tabla General
                {data: 'id', className:"text-center", "visible":false},
                {data: 'descripcion', className:"text-center"},
                {data: 'simbolo', className:"text-center"},
                {data: 'fecha_creacion', className:"text-center"},
                {data: 'fecha_actualizacion', className:"text-center"},
                {
                    data: null,
                    className:"text-center",
                    render: function (data) {
                        if (data.editable != 1) {
                            return "<div class='btn-group'><button class='btn btn-warning btn-sm modificarDetalle' onclick='obtenerData("+data.id+")' type='button' title='Modificar'><i class='fa fa-edit'></i></button><a class='btn btn-danger btn-sm' href='#' onclick='eliminar("+data.id+")' title='Eliminar'><i class='fa fa-trash'></i></a></div>"
                        }else{
                            return " - "
                        }
                    }
                }
            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [[ 0, "desc" ]],
        });
    });
    //Controlar Error
    $.fn.DataTable.ext.errMode = 'throw';
    function obtenerData($id) {
        var table = $('.dataTables-tabla-detalle').DataTable();
        var data = table.rows().data();
        limpiarError()
        data.each(function (value, index) {
            if (value.id == $id) {
                $('#tabla_id_editar').val(value.id);
                $('#descripcion_editar').val(value.descripcion);
                $('#simbolo_editar').val(value.simbolo);
            }  
        });
        $('#modal_editar_tabla_detalle').modal('show');
    }
    //Old Modal Editar
    @if ($errors->has('simbolo')  ||  $errors->has('descripcion') )
        $('#modal_editar_tabla_detalle').modal({ show: true });
    @endif
    function limpiarError() {
        $('#descripcion_editar').removeClass( "is-invalid" )
        $('#error-descripcion').text('')
        $('#simbolo_editar').removeClass( "is-invalid" )
        $('#error-simbolo').text('')
    }
    $('#modal_editar_tabla').on('hidden.bs.modal', function(e) { 
        limpiarError() 
    });
    //Old Modal Crear
    @if ($errors->has('simbolo_guardar')  ||  $errors->has('descripcion_guardar') )
        $('#modal_crear_tabla_detalle').modal({ show: true });
    @endif
    function guardarError() {
        $('#descripcion_guardar').removeClass( "is-invalid" )
        $('#error-descripcion-guardar').text('')
        $('#simbolo_guardar').removeClass( "is-invalid" )
        $('#error-simbolo-guardar').text('')
    }
    $('#modal_crear_tabla_detalle').on('hidden.bs.modal', function(e) { 
        guardarError()
        $('#descripcion_guardar').val('')
        $('#simbolo_guardar').val('')
    });
    const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })
    function eliminar(id) {
        Swal.fire({
            title: 'Opción Eliminar',
            text: "¿Seguro que desea eliminar registro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                //Ruta Eliminar
                var url_eliminar = '{{ route("mantenimiento.tabla.detalle.destroy", ":id")}}';
                url_eliminar = url_eliminar.replace(':id',id);
                $(location).attr('href',url_eliminar);
                }else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                'La Solicitud se ha cancelado.',
                'error'
                )
            }
        })
    }
    $('#editar_tabla_detalle').submit(function(e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                container: 'my-swal',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })
        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Modificar',
            text: "¿Seguro que desea modificar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                    this.submit();
                }else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                'La Solicitud se ha cancelado.',
                'error'
                )
            }
            })
    })
    $('#enviar_tabla').submit(function(e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                container: 'my-swal',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })
        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Guardar',
            text: "¿Seguro que desea guardar cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                    this.submit();
                }else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                'La Solicitud se ha cancelado.',
                'error'
                )
            }
            })
    })
</script>
@endpush