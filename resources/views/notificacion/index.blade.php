@extends('layout') @section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Notificaciones</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Notificaciones</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
             
                <table class="table dataTables-empresas" style="text-transform:uppercase">
                    <thead>
                        <tr>
                            <th  style="visibility:hidden;"></th>
                            <th  style="visibility:hidden;"></th>
                            <th  style="visibility:hidden;"></th>
                            <th  style="visibility:hidden;"></th>
                         

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
@stop
@push('styles')
<!-- DataTable -->
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush 
@push('scripts')
<!-- DataTable -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
 $(document).ready(function() {
        $('buttons-html5').removeClass('.btn-default');
        $('#table_empresas_wrapper').removeClass('');
        $('.dataTables-empresas').DataTable({
            "dom": '<"html5buttons"B>lTfgitp',
            "buttons": [ ],
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false,
            "serverSide":true,
            "processing":true,
            "ajax": '{{ route("notificacion.getTable")}}',
            "columns": [
                //Empresa
                {
                    data: 'informacion',
                    "visible": false
                },
                {
                    data: 'creado',
                    "visible": false
                },
                {
                    data: 'placa',
                    "visible": false
                },
                {
                    data: null, 
                    "width": "10%",
                    searchable: false,
                    render: function (data) {
                        //Ruta Detalle
                        //var url_detalle = '{{ route("mensaje.show", ":id")}}';
                        //url_detalle = url_detalle.replace(':id',data.id);
                        //Ruta Modificar
                        var html="";
                        if(data.informacion==="Se desconecto la bateria")
                {
                   html="<div><img src='https://aseguroperu.com/img/bateria.png' width='80px' style='border-radius: 10%;'></div>";
                  
                }
                else if(data.informacion==="Aumento de la velocidad")
                {
                    html="<div><img src='https://aseguroperu.com/img/exceso.png' width='80px' style='border-radius: 10%;'></div>";
                   
                }
                else if(data.informacion==="Ocurrio una alerta de ayuda")
                {
                    html="<div><img src='https://aseguroperu.com/img/ayuda.png' width='80px' style='border-radius: 10%;'></div>";
                   
                }
                else if(data.informacion==="fuera de rango")
                {
                    html="<div><img src='https://aseguroperu.com/img/rango.png' width='80px' style='border-radius: 10%;'></div>";
                }
                 
                        return html;
                    }
                },
                {
                    data: null, 
                    searchable: false,
                    render: function (data) {
                        //Ruta Detalle
                        //var url_detalle = '{{ route("mensaje.show", ":id")}}';
                        //url_detalle = url_detalle.replace(':id',data.id);
                        //Ruta Modificar
                      return '<div class="widget red-bg " style=""> <i class="fa fa-bell fa-1x"></i>'+' '+data.informacion+'</div>';
                    }
                },
                {
                    data: null, 
                    searchable: false,
                    render: function (data) {
                        //Ruta Detalle
                        //var url_detalle = '{{ route("mensaje.show", ":id")}}';
                        //url_detalle = url_detalle.replace(':id',data.id);
                        //Ruta Modificar
                      return '<div class="widget"  style="!important;background:#23c6c8;color:white;padding:5px;"> <i class="fa fa-car fa-1x"></i>'+' '+data.placa+'</div>';
                    }
                },
                {
                    data: null, 
                    searchable: false,
                    render: function (data) {
                        //Ruta Detalle
                        //var url_detalle = '{{ route("mensaje.show", ":id")}}';
                        //url_detalle = url_detalle.replace(':id',data.id);
                        //Ruta Modificar
                      return '<div class="widget"  style="!important;background:#1ab394;color:white;padding:5px;"> <i class="fa fa-calendar-o fa-1x"></i>'+' '+data.creado+'</div>';
                    }
                }
            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [],
        });
    });
</script>
@endpush
