@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('sutran-active', 'active')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 col-md-10">
            <h2 style="text-transform:uppercase"><b>Reporte Sutran</b></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Reporte Sutran</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card text-center">
                                    <div class="card-header bg-primary">
                                        Sutran
                                    </div>
                                    <div class="card-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-lg-6">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input type="text" name="datetimes" id="datetimes"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-3 col-xs-12">
                                                            <div style="text-align:left;"><label
                                                                    class="required">Dispositivo</label></div>
                                                            <select class="select2_form form-control"
                                                                style="text-transform: uppercase; width:100%"
                                                                name="dispositivo" id="dispositivo"
                                                                >
                                                                <option></option>
                                                                @foreach (dispositivosSutran() as $dispositivo)
                                                                    <option value="{{ $dispositivo->id }}">
                                                                        {{ $dispositivo->placa }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <button id="btn_reporte"
                                                                class="btn btn-block btn-w-m btn-primary m-t-md"
                                                                onclick="consultar()">
                                                                <i class="fa fa-plus-square"></i>Consultar
                                                            </button>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div id="cargando">
                                                                <div class="Progressbar">
                                                                    <div class="Progressbar__value"></div>
                                                                    <progress value="10" max="10">10%</progress>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-lg-6">
                                                                <div style="text-align:left;"><label
                                                                        class="required">Kilometraje</label></div>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="kilometraje"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        -->
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <form action="{{ route('reportes.movimientopdf') }}" method="POST"
                                                            id="frm_pdf">
                                                            @csrf
                                                            <!--<button  type="button" id="btn_reporte_pdf" class="btn btn-block btn-w-m btn-primary m-t-md" onclick="descargarpdf()">
                                                                                <i class="fa fa-file-pdf-o"></i>PDF-->
                                                            </button>
                                                            <input type="hidden" id="arreglo_reporte"
                                                                name="arreglo_reporte">
                                                            <input type="hidden" id="fecha_reporte" name="fecha_reporte">
                                                            <input type="hidden" id="hinicio_reporte"
                                                                name="hinicio_reporte">
                                                            <input type="hidden" id="hfinal_reporte" name="hfinal_reporte">
                                                            <input type="hidden" id="dispositivo_reporte"
                                                                name="dispositivo_reporte">
                                                        </form>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table
                                                    class="table dataTables-reporte table-striped table-bordered table-hover"
                                                    style="text-transform:uppercase">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="font-size: 10.5px;">ID</th>
                                                            <th class="text-center" style="font-size: 10.5px;">FECHA</th>
                                                            <th class="text-center" style="font-size: 10.5px;">IMEI</th>
                                                            <th class="text-center" style="font-size: 10.5px;">PLACA</th>
                                                            <th class="text-center" style="font-size: 10.5px;">LATITUD</th>
                                                            <th class="text-center" style="font-size: 10.5px;">LONGITUD
                                                            </th>
                                                            <th class="text-center" style="font-size: 10.5px;">VELOC</th>
                                                            <th class="text-center" style="font-size: 10.5px;">RUMBO</th>
                                                            <th class="text-center" style="font-size: 10.5px;">EVENTO
                                                            </th>
                                                            <th class="text-center" style="font-size: 10.5px;">ESTADO</th>
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
        </div>
    </div>


@stop
@push('styles')
    <!-- DataTable -->
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
        rel="stylesheet">

    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <style>
        .loader {
            border: 13px solid #f3f3f3;
            border-radius: 50%;
            border-top: 13px solid #3498db;
            margin: 20px 0px 0px 0px;
            width: 40px;
            height: 40px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .Progressbar {
            position: relative;
            height: 20px;
            border-radius: 1000px;
            background-color: #484848;
            clip-path: inset(0 0 0 0 round 1000px);
        }

        .Progressbar__value {
            height: 20px;
            transition: width 0.4s ease-in-out;
            border-radius: 1000px 0 0 1000px;
            background-color: rgb(236, 62, 14);
            will-change: width;
        }

        .Progressbar>progress {
            opacity: 0;
            width: 1px;
            height: 1px;
            position: absolute;
            pointer-events: none;
        }

        .letracolumna {
            font-size: 12px;
        }

        .letracolumnapequeña {
            font-size: 9px;
        }

    </style>
@endpush
@push('scripts')
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- DataTable -->
    <script src="{{ asset('Inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/clockpicker/clockpicker.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
    $.fn.DataTable.ext.pager.numbers_length = 16;

        $(function() {
            $('input[name="datetimes"]').daterangepicker({
                "timePicker": true,
                "timePicker24Hour": true,
                "showDropdowns": true,

                locale: {
                    format: 'Y/M/DD H:mm'
                }
            });
        });
        var map;
        var map2;
        var markers = [];
        var markers_ruta = [];
        var polylines = [];
        var datos = [];
        var pdf = [];
        var ls5;

        function descargarpdf() {
            if (pdf.length == 0) {
                toastr.error('No hay datos para generar reporte', 'Error');
            } else {
                $('#arreglo_reporte').val(JSON.stringify(pdf));
                $('#fecha_reporte').val($('#fecha').val());
                $('#hinicio_reporte').val($('#hinicio').val());
                $('#hfinal_reporte').val($('#hfinal').val());
                $('#dispositivo_reporte').val($('#dispositivo').val());
                document.getElementById('frm_pdf').submit();


            }
        }

        $(document).ready(function() {
            $("#cargando").css("visibility", "hidden");
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            });
            $('.clockpicker').clockpicker();
            $('.dataTables-reporte').DataTable({
                "dom": '<"html5buttons"B>lTfgitp',
                "buttons": [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'Reporte de movimiento',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'PdF',
                        title: 'Reporte de movimiento',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ],
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [{
                        "targets": [0]
                    },
                    {
                        "targets": [1],

                    },
                    {
                        "targets": [2],

                    },
                    {
                        "targets": [3],

                    },
                    {
                        "targets": [4],

                    },
                    {
                        "targets": [5],
                    },
                    {
                        "targets": [6],
                    },
                    {
                        "targets": [7],
                    },
                    {
                        "targets": [8],
                    },
                    {
                        "targets": [9],
                    },
                ],
                'bAutoWidth': false,
                'aoColumns': [{
                    sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },

                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                ],
                "language": {
                    url: "{{ asset('Spanish.json') }}"
                },
                "order": [
                    [0, "desc"]
                ],
            });
        });

        function consultar() {

            var fecha = $("#datetimes").val().split(" - ");
            var fechainicio = fecha[0];
            var fechafinal = fecha[1];

            var enviar = true;
            var fecha = $("#fecha").val();
            var dispositivo = $("#dispositivo").val();
            if (!(dispositivo.length != 0)) {
                toastr.error('Complete la información de los campos obligatorios (*)', 'Error');
                enviar = false;
            }

            if (enviar == true) {
                axios.get('{{ route('sutran.reporte') }}', {
                        params: {
                            _token: $('input[name=_token]').val(),
                            dispositivo: dispositivo,
                            fechainicio: fechainicio,
                            fechafinal: fechafinal+":59"
                        }
                    })
                    .then(function(response) {
                        // handle success
                        if (response.data.length != 0) {
                            $("#cargando").css("visibility", "visible");
                            agregar(response.data);


                        } else {
                            toastr.warning("No hay data", "Advertencia");
                            $("#cargando").css("visibility", "hidden");
                            // $("#cargando").removeClass("loader");
                        }

                    })
                    .catch(function(error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function() {
                        // always executed
                    });
            }
        }


        async function agregar(returnValue) {
            // pdf=returnValue;
            $("#cargando").removeClass("loader");
            var data_reporte = [];
            var t = $('.dataTables-reporte').DataTable();
            //t.clear().draw();
            var arregloruta = [];
            //var kmre=0;
            for (var i = 0; i < returnValue.length; i++) {

                var porcentaje = (i + 1) / returnValue.length;
                setValue((porcentaje * 100).toFixed(0));
                data_reporte.push([
                    returnValue[i].id,
                    returnValue[i].fecha,
                    returnValue[i].imei,
                    returnValue[i].placa,
                    returnValue[i].latitud,
                    returnValue[i].longitud,
                    returnValue[i].velocidad,
                    returnValue[i].rumbo,
                    returnValue[i].evento,
                    returnValue[i].estado,
                ]);
                /*if(i!=returnValue.length-1)
                 {
                    kmre =kmre+ google.maps.geometry.spherical.computeDistanceBetween( new google.maps.LatLng(returnValue[i].lat,  returnValue[i].lng), new google.maps.LatLng(returnValue[i+1].lat,  returnValue[i+1].lng));
                 }*/

                var fila = {
                    "lat": returnValue[i].lat,
                    "lng": returnValue[i].lng,
                    "velocidad": returnValue[i].velocidad,
                    "fecha": returnValue[i].fecha
                };
                pdf.push(fila);
                if (i + 1 == returnValue.length) {
                    $("#cargando").removeClass("loader");
                }
            }
            t.destroy();
            iniciartabla(data_reporte);
            ls5=setInterval(listen, 5000);
        }

        function listen(){
            var t = $('.dataTables-reporte').DataTable();
            //t.row(index).remove().draw();
            var data = t.rows().data();
            var idlast;
            var rowlast;
            var placa;
            var datos=[];
            var imei;
            data.each(function(value, index) {
    
                    let fila = {
                        id: value[0],
                        placa:value[3],
                        rumbo:value[7],
                        imei:value[2],
                        row:index
                    };
                    datos.push(fila);
            });
            var filaLast=datos.find(last);
            idlast=filaLast!=undefined ? filaLast.id : datos[datos.length-1].id;
            placa=filaLast!=undefined ? filaLast.placa : datos[datos.length-1].placa;
            rowlast=filaLast!=undefined ? filaLast.row : datos[datos.length-1].row;
            imei=filaLast!=undefined ? filaLast.imei : datos[datos.length-1].imei;

            axios.get('{{ route('sutran.reporte.listen') }}',{
               params:{ 
                placa:placa,
                idlast:idlast
               }
            }).then((respuesta) => {
                if(respuesta.data.length>1)
                {
           
                    var t1 = $('.dataTables-reporte').DataTable();
                    var data1 = t1.rows().data();
                    data1.each(function(value, index) {
                        if(index>=rowlast){
                            t1.row(index).remove().draw();
                        }
                    });
                    for(var i=0;i<respuesta.data.length;i++){
                        t1.row
                        .add([
                            respuesta.data[i].id,
                            respuesta.data[i].fecha,
                            imei,
                            respuesta.data[i].placa,
                            respuesta.data[i].latitud,
                            respuesta.data[i].longitud,
                            respuesta.data[i].velocidad,
                            respuesta.data[i].rumbo,
                            respuesta.data[i].evento,
                            respuesta.data[i].estado,
                        ])
                        .draw(false);
                    }
                }
            }).catch((value) => {
                console.log(value);
            })
        }
        function last(element)
        {
            return element.rumbo=="-1";
        }

        function iniciartabla(datos) {
            $('.dataTables-reporte').DataTable({
                "data": datos,
                "dom": 'Bfrtip',
                "buttons": [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'Reporte de movimiento',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'PdF',
                        title: 'Reporte de movimiento',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 6, 7, 8, 9, 10]
                        }
                    }
                ],
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [{
                        "targets": [0]
                    },
                    {
                        "targets": [1],

                    },
                    {
                        "targets": [2],

                    },
                    {
                        "targets": [3],

                    },
                    {
                        "targets": [4],

                    },
                    {
                        "targets": [5],
                    },
                    {
                        "targets": [6],
                    },
                    {
                        "targets": [7],
                    },
                    {
                        "targets": [8],
                    },
                    {
                        "targets": [9],
                    },
                ],
                'bAutoWidth': false,
                'aoColumns': [{
                    sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna',
                        data: null,
                        render: function(data, type, row) {
                            var html=data[7];
                            if(html==-1)
                            {
                                html="-";
                            }
                            return html;
                        }
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna',
                        data: null,
                        render: function(data, type, row) {
                            var html=data[8];
                            if(data[8]==-1)
                            {
                                html="-";;
                            }
                            return html;
                        }
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna',
                        data: null,
                        render: function(data, type, row) {
                            var html="Transmitido";
                            if(data[9]==0)
                            {
                                html="En espera";
                            }
                            return html;
                        }
                    },
                ],
                "language": {
                    url: "{{ asset('Spanish.json') }}"
                },
                "order": [
                    [0, "desc"]
                ],
            });
        }


        function setValue(value) {
            const progressValue = document.querySelector('.Progressbar__value');
            const progress = document.querySelector('progress');
            progressValue.style.width = `${value}%`;
            progress.value = value;
        }


    </script>

@endpush
