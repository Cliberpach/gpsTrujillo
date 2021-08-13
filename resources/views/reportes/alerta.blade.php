@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('reportesalerta-active', 'active')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 col-md-10">
            <h2 style="text-transform:uppercase"><b>Reportes</b></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Reportes</strong>
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
                                        Alertas
                                    </div>
                                    <div class="card-body">
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <div class="col-lg-4">
                                                    <div id="map" style="height:300px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="form-group row">
                                                        <div class="col-lg-8">
                                                            <div style="text-align:left;"><label
                                                                    class="required">Fecha</label></div>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input type="text" name="datetimes" id="datetimes"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-xs-12">
                                                            <div style="text-align:left;"><label
                                                                    class="required">Dispositivo</label></div>
                                                            <select class="select2_form form-control"
                                                                style="text-transform: uppercase; width:100%"
                                                                name="dispositivo" id="dispositivo">
                                                                <option></option>
                                                                @foreach (dispositivos() as $dispositivo)
                                                                    <option value="{{ $dispositivo->id }}">
                                                                        {{ $dispositivo->placa }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 col-xs-12">
                                                            <div style="text-align:left;"><label class="required">Alerta
                                                                </label></div>
                                                            <select class="select2_form form-control"
                                                                style="text-transform: uppercase; width:100%" name="alerta"
                                                                id="alerta">
                                                                <option></option>
                                                                @foreach (alertas_all() as $alerta)
                                                                    <option value="{{ $alerta->id }}">
                                                                        {{ $alerta->alerta }}</option>
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
                                                        <div class="col-lg-3">
                                                            <form action="{{ route('reportes.alertapdf') }}" method="POST"
                                                                id="frm_pdf">
                                                                @csrf
                                                                <!-- <button  type="button" id="btn_reporte_pdf" class="btn btn-block btn-w-m btn-primary m-t-md" onclick="descargarpdf()">
                                                                                <i class="fa fa-file-pdf-o"></i>PDF
                                                                            </button>-->
                                                                <input type="hidden" id="arreglo_reporte"
                                                                    name="arreglo_reporte">
                                                                <input type="hidden" id="fecha_reporte"
                                                                    name="fecha_reporte">
                                                                <input type="hidden" id="hinicio_reporte"
                                                                    name="hinicio_reporte">
                                                                <input type="hidden" id="hfinal_reporte"
                                                                    name="hfinal_reporte">
                                                                <input type="hidden" id="alerta_reporte"
                                                                    name="alerta_reporte">
                                                                <input type="hidden" id="dispositivo_reporte"
                                                                    name="dispositivo_reporte">
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-12">
                                                            <div id="cargando">
                                                                <div class="Progressbar">
                                                                    <div class="Progressbar__value"></div>
                                                                    <progress value="10" max="10">10%</progress>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-lg-3">
                                                                <button id="btn_reporte" class="btn btn-block btn-w-m btn-primary m-t-md">
                                                                    <i class="fa fa-plus-square"></i>Exportar
                                                                </button>
                                                            </div>-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table
                                                    class="table dataTables-reporte table-striped table-bordered table-hover"
                                                    style="text-transform:uppercase">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-center">Fecha</th>
                                                            <th class="text-center">Movimiento</th>
                                                            <th>Marcador</th>
                                                            <th class="text-center">Lat/Long</th>
                                                            <th class="text-center">Direccion</th>
                                                            <th class="text-center">Velocidad</th>
                                                            <th>Opciones</th>
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
                        @csrf
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

        var map;
        var markers = [];
        var markers_ruta = [];
        var datos = [];
        var pdf = [];
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
        function descargarpdf() {
            if (pdf.length == 0) {
                toastr.error('No hay datos para generar reporte', 'Error');
            } else {
                $('#arreglo_reporte').val(JSON.stringify(pdf));
                $('#fecha_reporte').val($('#fecha').val());
                $('#hinicio_reporte').val($('#hinicio').val());
                $('#hfinal_reporte').val($('#hfinal').val());
                $('#alerta_reporte').val($('#alerta').val());
                $('#dispositivo_reporte').val($('#dispositivo').val());
                document.getElementById('frm_pdf').submit();
            }
        }
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: {
                    lat: -8.1092027,
                    lng: -79.0244529
                },
                gestureHandling: "greedy",
                mapTypeControl: false,
                fullscreenControl: false
            });
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
                        title: 'Reporte de Alertas',
                        exportOptions: {
                            columns: [2, 3, 4, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'PdF',
                        title: 'Reporte de Alertas',
                        exportOptions: {
                            columns: [2, 3, 4, 6, 7, 8]
                        }
                    }
                ],
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [1],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [2],
                    },
                    {
                        "targets": [3],
                    },
                    {
                        "targets": [4],
                        data: null,
                        render: function(data, type, row) {
                            var html;
                            if (data[3] === "Sin movimiento") {
                                html = "<img src='{{ asset('/') }}img/gpa_red.png' width='32'>";
                            } else {
                                if (data[4] == "final") {
                                    html = "<img src='{{ asset('/') }}img/gps.png' width='32'>";
                                } else {
                                    url = angulomarcador(data[4]);
                                    html = "<img src='" + url + "' width='32'>"
                                }
                            }
                            return html;
                        }
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
                        searchable: false,
                        "targets": [8],
                        data: null,
                        render: function(data, type, row) {
                            return "<div class='btn-group'>" +
                                "<a class='btn btn-sm btn-warning btn-ubicacion' style='color:white'>" +
                                "<i class='fa fa-location-arrow'></i>" + "</a>" +
                                "</div>";
                        }
                    },
                ],
                'bAutoWidth': false,
                'aoColumns': [{
                        sWidth: '0%'
                    },
                    {
                        sWidth: '0%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '20%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '30%',
                        sClass: 'text-center'
                    },
                    {
                        sWidth: '30%',
                        sClass: 'text-center'
                    },
                    {
                        sWidth: '30%',
                        sClass: 'text-center'
                    },
                    {
                        sWidth: '0%'
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
            setValue(0);
            var fecha = $("#datetimes").val().split(" - ");
            var fechainicio = fecha[0];
            var fechafinal = fecha[1];
            var alerta = $("#alerta").val();
            if (alerta.length === 0) {
                alerta = " ";
            }
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1);
            var yyyy = today.getFullYear();
            var fechanow = yyyy + '/' + mm + '/' + dd;
            var enviar = true;
            var dispositivo = $("#dispositivo").val();
            if (dispositivo.length === 0) {
                toastr.error('Complete la información de los campos obligatorios (*)', 'Error');
                enviar = false;
            }
            if (enviar == true) {
                datos = [];
                setMapOnAll(null);
                console.log("de");
                axios.get('{{ route('reportes.datalerta') }}', {
                        params: {
                            _token: $('input[name=_token]').val(),
                            dispositivo: dispositivo,
                            fechainicio: fechainicio,
                            fechafinal: fechafinal+":59",
                            fechanow: fechanow,
                            alerta: alerta
                        }
                    })
                    .then(function(response) {
                        if (response.data.length != 0) {
                            $("#cargando").css("visibility", "visible");
                            datalerta(response.data);
                        } else {
                            toastr.warning("No hay data", "Advertencia");
                            $("#cargando").css("visibility", "hidden");
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    })
                    .then(function() {
                    });
            }
        }
        async function datalerta(returnValue) {
            var t = $('.dataTables-reporte').DataTable();
            t.clear().draw();
            for (var i = 0; i < returnValue.length; i++) {
                var porcentaje = (i + 1) / returnValue.length;
                setValue((porcentaje * 100).toFixed(0));
                var direccion=returnValue[i].direccion;
                if (returnValue[i].direccion==null)
                    {
                        direccion="-";
                        /*
                            direccion = await axios.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' +
                            returnValue[i].lat + ',' +
                            returnValue[i].lng + '&key={{gpsKey()}}');
                            direccion = direccion.data.results[0].address_components[1].long_name + " " + direccion.data.results[0]
                            .address_components[0].long_name; */
                    }
                t.row.add([
                    returnValue[i].lat,
                    returnValue[i].lng,
                    returnValue[i].fecha,
                    returnValue[i].estado,
                    returnValue[i].marcador,
                    returnValue[i].lat + "/" +returnValue[i].lng,
                    direccion,
                    returnValue[i].velocidad,
                    '',
                ]).draw(false);
            }
        }
        $(document).on('click', '.btn-ubicacion', function(event) {
            setMapOnAll(null);
            var table = $('.dataTables-reporte').DataTable();
            var data = table.row($(this).parents('tr')).data();
            const image = {
                url: "https://aseguroperu.com/img/e.png",
                // This marker is 20 pixels wide by 32 pixels high.
                scaledSize: new google.maps.Size(50, 50),
                // The origin for this image is (0, 0).
            };
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(data[0],
                    data[1]),
                map: map,
                icon: image,
            });
            markers.push(marker);
            marker.setMap(map);
            map.setZoom(18);
            map.setCenter(marker.getPosition());
        });
        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        function setValue(value) {
            const progressValue = document.querySelector('.Progressbar__value');
            const progress = document.querySelector('progress');
            progressValue.style.width = `${value}%`;
            progress.value = value;
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{gpsKey()}}&callback=initMap"
        async></script>
@endpush
