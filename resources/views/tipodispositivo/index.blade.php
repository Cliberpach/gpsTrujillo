@extends('layout') @section('content')
@include('tipodispositivo.create')
@include('tipodispositivo.edit')
@section('gps-active', 'active')
@section('tipodispositivo-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Tipo Dispositivo</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('tipodispositivo.index') }}">Tipos Dispositivos</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <a data-toggle="modal" data-target="#modal_crear_tipodispositivo" onclick="limpiarcampos()" id="btn_añadir_tipodispositivo" class="btn btn-block btn-w-m btn-primary m-t-md" href="#">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </a>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table dataTables-tipodispositivo table-striped table-bordered table-hover"  style="text-transform:uppercase">
                    <thead>
                        <tr>
                            <th class="text-cener">Nombre</th>
                            <th class="text-cener">Precio</th>
                            <th class="text-center">Activo</th>
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
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<style>
    .my-swal {
        z-index: 3000 !important;
    }
        .logo {
            width: 190px;
            height: 190px;
            border-radius: 10%;
        }
</style>
@endpush 
@push('scripts')
<!-- DataTable -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
@if ($errors->has('nombre') || $errors->has('activo') || $errors->has('precio'))
$("#modal_crear_tipodispositivo").modal("show");             
@endif
@if ($errors->has('nombre_editar') || $errors->has('activo_editar') || $errors->has('precio_editar'))
$("#modal_editar_tipodispositivo").modal("show");             
@endif

function limpiarcampos()
{
    $("#modal_crear_tipodispositivo #nombre").val(" ");
    $("#modal_crear_tipodispositivo #precio").val(" ");
    $("#modal_crear_tipodispositivo #precio").removeClass("is-invalid");
    $("#modal_crear_tipodispositivo #nombre").removeClass("is-invalid");
    $("#modal_crear_tipodispositivo #activo_error").html(" ");
    $("#modal_crear_tipodispositivo #precio_error").html(" ");
    $("#modal_crear_tipodispositivo #nombre_error").html(" ");
}
function limpiarcamposeditar()
{
    $("#modal_editar_tipodispositivo #precio_editar").removeClass("is-invalid");
    $("#modal_editar_tipodispositivo #nombre_editar").removeClass("is-invalid");
    $("#modal_editar_tipodispositivo #activo_editar_error").html(" ");
    $("#modal_editar_tipodispositivo #precio_editar_error").html(" " );
    $("#modal_editar_tipodispositivo #nombre_editar_error").html(" " );
}
function limpiar() {
            console.log("ff");
            $('.logo').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
            var fileName = "Seleccionar"
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#logo').val('')
        }
        function limpiareditada() {
            console.log("ff");
            $('#modal_editar_tipodispositivo .logo').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
            var fileName = "Seleccionar"
            $('#modal_editar_tipodispositivo .custom-file-label').addClass("selected").html(fileName);
            $('#modal_editar_tipodispositivo #logo').val('')
        }
function seleccionarimagen()
     { 
        console.log("ffdd");
            var fileInput = document.getElementById('logo');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            $imagenPrevisualizacion = document.querySelector(".logo");
            if (allowedExtensions.exec(filePath)) {
                var userFile = document.getElementById('logo');
                userFile.src = URL.createObjectURL(event.target.files[0]);
                var data = userFile.src;
                $imagenPrevisualizacion.src = data
                let fileName =$('#logo').val().split('\\').pop();
                $('#logo').next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
                $('.logo').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
            }
     }
     function seleccionarimageneditada()
     { 
            var filePath = $("#modal_editar_tipodispositivo #logo").val();
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            if (allowedExtensions.exec(filePath)) {
                $("#modal_editar_tipodispositivo #logo").attr("src",URL.createObjectURL(event.target.files[0]));
                $("#modal_editar_tipodispositivo .logo").attr("src",  URL.createObjectURL(event.target.files[0]));
                let fileName =$("#modal_editar_tipodispositivo #logo").val().split('\\').pop();
                $('#modal_editar_tipodispositivo #logo').next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
                $('#modal_editar_tipodispositivo .logo').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
            }
     }
 $(document).ready(function()
        {
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            }); 
        })
        $('.dataTables-tipodispositivo').DataTable({
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
            "ajax": '{{ route("tipodispositivo.getTable")}}',
            "columns": [
                //Empresa
                {data: 'nombre', className:"text-center"},
                {data: 'precio', className:"text-center"},
                {data: 'activo', className:"text-center" },
                {
                    data: null,
                    className:"text-center",
                    render: function (data) {
                        //Ruta Modificar
                        return "<div class='btn-group'><button class='btn btn-warning btn-sm modificarDetalle' onclick='obtenerData("+data.id+")' type='button' title='Modificar'><i class='fa fa-edit'></i></button><a class='btn btn-danger btn-sm' href='#' onclick='eliminar("+data.id+")' title='Eliminar'><i class='fa fa-trash'></i></a></div>"
                    }
                }
            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [],
        });
        function obtenerData($id) {
            limpiarcamposeditar();
        var table = $('.dataTables-tipodispositivo').DataTable();
        $("#modal_editar_tipodispositivo #activo_editar_error").html(" ");
        var data = table.rows().data();
        data.each(function (value, index) {
            if (value.id == $id) {
                $('#nombre_editar').select2("val", value.nombre);
                $('#precio_editar').val(value.precio);
                $('#modal_editar_tipodispositivo #activo_editar').select2("val", value.activo);
                $('#modal_editar_tipodispositivo #id').val(value.id);
                $('#modal_editar_tipodispositivo #logo_txt').html(value.nombre_logo);
                var url_detalle = '{{Storage::url(":id")}}';
                    var str = value.ruta_logo; 
                    if(str!=null)
                    {
                       var n = str.indexOf("/");
                    url_detalle = url_detalle.replace(':id',str.substring(n+1,str.length));
                $("#modal_editar_tipodispositivo .logo").attr("src", url_detalle);
                $("#modal_editar_tipodispositivo #logo").attr("src", url_detalle);  
                    }
                   
            }  
        });
        $('#modal_editar_tipodispositivo').modal('show');
    }
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
                var url_eliminar = '{{ route("tipodispositivo.destroy", ":id")}}';
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
</script>
@endpush