@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('reportesgeozonasalida-active', 'active')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 col-md-10">
            <h2 style="text-transform:uppercase"><b>Reportes Geozona Salida</b></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Reportes Geozona Salida</strong>
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
                                        Movimientos
                                    </div>
                                    <div class="card-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div id="map2" style="height:300px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-lg-12">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input type="text" name="datetimes" id="datetimes"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>



                                                        <!--<div class="col-lg-4 col-xs-12">
                                                                            <div style="text-align:left;"><label class="required" >Fecha de Inicio</label></div>
                                                                            <div class="input-group date">
                                                                                <span class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </span>
                                                                                <input type="text" id="fecha" name="fecha"  class="form-control"  >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-xs-12">
                                                                            <div style="text-align:left;"><label class="required" >Hora Inicio</label></div>
                                                                            <div class="input-group clockpicker" data-autoclose="true">
                                                                                <input type="text" class="form-control" id="hinicio" name="hinicio" readonly>
                                                                                <span class="input-group-addon">
                                                                                    <span class="fa fa-clock-o"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-xs-12">
                                                                            <div style="text-align:left;"><label class="required" >Hora final</label></div>
                                                                            <div class="input-group clockpicker" data-autoclose="true">
                                                                                <input type="text" class="form-control" id="hfinal" name="hfinal" readonly >
                                                                                <span class="input-group-addon">
                                                                                    <span class="fa fa-clock-o"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-4 col-xs-12">
                                                                            <div style="text-align:left;"><label class="required" >Fecha Final</label></div>
                                                                            <div class="input-group date">
                                                                                <span class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </span>
                                                                                <input type="text" id="fecha" name="fecha"  class="form-control"  >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-xs-12">
                                                                            <div style="text-align:left;"><label class="required" >Hora Inicio</label></div>
                                                                            <div class="input-group clockpicker" data-autoclose="true">
                                                                                <input type="text" class="form-control" id="hinicio" name="hinicio" readonly>
                                                                                <span class="input-group-addon">
                                                                                    <span class="fa fa-clock-o"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-xs-12">
                                                                            <div style="text-align:left;"><label class="required" >Hora final</label></div>
                                                                            <div class="input-group clockpicker" data-autoclose="true">
                                                                                <input type="text" class="form-control" id="hfinal" name="hfinal" readonly >
                                                                                <span class="input-group-addon">
                                                                                    <span class="fa fa-clock-o"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>-->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-6 col-xs-12">
                                                            <div style="text-align:left;"><label
                                                                    class="required">Dispositivo</label></div>
                                                            <select class="select2_form form-control"
                                                                style="text-transform: uppercase; width:100%"
                                                                name="dispositivo" id="dispositivo"
                                                                onchange="getGeozona(this)">
                                                                <option></option>
                                                                @foreach (dispositivos() as $dispositivo)
                                                                    <option value="{{ $dispositivo->id }}">
                                                                        {{ $dispositivo->placa }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 col-xs-12">
                                                            <div style="text-align:left;"><label
                                                                    class="required">Geozona</label></div>
                                                            <select class="select2_form form-control"
                                                                style="text-transform: uppercase; width:100%" name="geozona"
                                                                id="geozona">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <!--  <div class="col-lg-6">
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
                                                    <div class="form-group row">
                                                        <div class="col-lg-3">
                                                            <button id="btn_reporte"
                                                                class="btn btn-block btn-w-m btn-primary m-t-md"
                                                                onclick="consultar()">
                                                                <i class="fa fa-plus-square"></i>Consultar
                                                            </button>
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
                                                            <th class="text-center" style="font-size: 10.5px;">Estado</th>
                                                            <th class="text-center" style="font-size: 10.5px;">Latitud</th>
                                                            <th class="text-center" style="font-size: 10.5px;">Longitud</th>
                                                            <th class="text-center" style="font-size: 10.5px;">Marcador</th>
                                                            <th class="text-center" style="font-size: 10.5px;">Altitud</th>
                                                            <th class="text-center" style="font-size: 10.5px;">Velocidad
                                                            </th>
                                                            <th class="text-center" style="font-size: 10.5px;">Evento</th>
                                                            <th class="text-center" style="font-size: 10.5px;">fecha</th>
                                                            <th class="text-center" style="font-size: 10.5px;">Direccion
                                                            </th>
                                                            <th class="text-center" style="font-size: 10.5px;">Posicion
                                                            </th>
                                                            <th style="font-size: 10.5px;">Opciones</th>
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
    @include('reportes.modal')


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
            map2 = new google.maps.Map(document.getElementById("map2"), {
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
            /*
            $('.input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "yyyy/mm/dd"
            });*/
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
                        "targets": [0],
                        "visible": false,
                        "searchable": false
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
                        data: null,
                        render: function(data, type, row) {
                            return "hola";
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
                        "targets": [8],
                    },
                    {
                        "targets": [9],
                    },
                    {
                        searchable: false,
                        "targets": [10],
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
                        sWidth: '20%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },

                    {
                        sWidth: '20%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
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

            var fecha = $("#datetimes").val().split(" - ");
            var fechainicio = fecha[0];
            var fechafinal = fecha[1];
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1); //January is 0!
            var yyyy = today.getFullYear();

            var fechanow = yyyy + '/' + mm + '/' + dd;
            var enviar = true;
            var fecha = $("#fecha").val();
            var dispositivo = $("#dispositivo").val();
            var geozona = $("#geozona").val();
            if (!(dispositivo.length != 0 && geozona.length != 0)) {
                toastr.error('Complete la información de los campos obligatorios (*)', 'Error');
                enviar = false;
            }

            if (enviar == true) {
                datos = [];
                setMapOnAll(null);
                setMapOnAll_ruta(null);
                //$("#cargando").addClass("loader");
                //console.log("lleg");
                axios.get('{{ route('reportes.dispositivogeozonasalida') }}', {
                        params: {
                            _token: $('input[name=_token]').val(),
                            dispositivo: dispositivo,
                            geozona: geozona,
                            fechainicio: fechainicio,
                            fechafinal: fechafinal + ":59",
                            fechanow: fechanow
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
                /* $.ajax({
                     dataType: 'json',
                     type: 'GET',
                     timeout: 7200000,
                     url: '{{ route('reportes.dispositivogeozona') }}',
                     data: {
                         '_token': $('input[name=_token]').val(),
                         'dispositivo': dispositivo,
                         'geozona': geozona,
                         'fechainicio': fechainicio,
                         'fechafinal': fechafinal,
                         'fechanow': fechanow
                     },

                 }).done(function(returnValue) {
                     //console.log(result);
                     agregar(returnValue);



                 });*/

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
                var cadena = returnValue[i].cadena.split(',');
                /* var latlng = [];
                 latlng.push(returnValue[i].lat);
                 latlng.push(returnValue[i].lng);
                 arregloruta.push(latlng);*/
                /*var image;
                if (returnValue[i].posicion == "Fuera de la Geozona") {
                    image = {
                        url: "{{ asset('/') }}img/gps_fuerazona.png",
                        // This marker is 20 pixels wide by 32 pixels high.
                        scaledSize: new google.maps.Size(50, 50),
                    };
                } else {
                    image = {
                        url: "{{ asset('/') }}img/gps.png",
                        // This marker is 20 pixels wide by 32 pixels high.
                        scaledSize: new google.maps.Size(50, 50),
                    };
                }
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(returnValue[i].lat, returnValue[i].lng),
                    map: map2,
                    icon: image
                });
                markers_ruta.push(marker);*/

                var direccion = returnValue[i].direccion;
                if (returnValue[i].direccion == null) {
                    direccion="-";
                    /*
                    direccion = await axios.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' +
                        returnValue[i].lat + ',' +
                        returnValue[i].lng + '&key={{ gpsKey() }}');
                    direccion = direccion.data.results[0].address_components[1].long_name + " " + direccion.data
                        .results[0]
                        .address_components[0].long_name;*/
                }


                data_reporte.push([
                    i,
                    returnValue[i].estado,
                    returnValue[i].lat,
                    returnValue[i].lng,
                    returnValue[i].marcador,
                    returnValue[i].altitud,
                    returnValue[i].velocidad,
                    returnValue[i].evento,
                    returnValue[i].fecha,
                    direccion,
                    returnValue[i].posicion,
                    '',
                ]);

            }
            t.destroy();
            iniciartabla(data_reporte);
            //eliminaruta(null);
            //addPolyline(arregloruta);
            //marker_ruta(arregloruta)
        }

        $(document).on('click', '.btn-ubicacion', function(event) {
            setMapOnAll(null);
            var table = $('.dataTables-reporte').DataTable();
            var data = table.row($(this).parents('tr')).data();
            const image = {
                url: window.location.origin + "/img/gps.png",
                // This marker is 20 pixels wide by 32 pixels high.
                scaledSize: new google.maps.Size(50, 50),
                // The origin for this image is (0, 0).
            };
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(data[2],
                    data[3]),
                map: map,
                icon: image,
            });
            markers.push(marker);
            marker.setMap(map);
            map.setZoom(18);
            map.setCenter(marker.getPosition());
            google.maps.event.addListener(marker, 'click', function() {
                var geocoder = new google.maps.Geocoder();
                var marcador = this;
                geocoder.geocode({
                    'latLng': this.getPosition()
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results) {
                            direccion_gps(marcador, results[0].formatted_address)
                        }
                    }
                });
            });
            $("#modal_ver_mapa").modal("show");
        });

        function addPolyline(lineCoordinates) {
            var pointCount = lineCoordinates.length;
            var linePath = [];
            for (var i = 0; i < pointCount; i++) {
                var tempLatLng = new google.maps.LatLng(
                    lineCoordinates[i][0], lineCoordinates[i][1]
                );
                linePath.push(tempLatLng);
            }
            var lineOptions = {
                path: linePath,
                strokeWeight: 7,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8
            }
            var polyline = new google.maps.Polyline(lineOptions);
            polyline.setMap(map2);
            polylines.push(polyline);
        }

        function direccion_gps(marker, direccion) {
            var contentString = '<div><br>Direccion:' + direccion + '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                width: 192,
                height: 100
            });
            infowindow.open(map, marker);
        }

        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function setMapOnAll_ruta(map) {
            for (let i = 0; i < markers_ruta.length; i++) {
                markers_ruta[i].setMap(map);
            }
        }

        function eliminaruta(map) {
            for (let i = 0; i < polylines.length; i++) {
                polylines[i].setMap(map);
            }
        }

        function getGeozona(e) {
            var dispositivo = $("#dispositivo").val();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '{{ route('reportes.datageozona') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'dispositivo': dispositivo
                },

            }).done(function(returnValue) {
                //console.log(result);
                var html = "<option></option>";
                for (let i = 0; i < returnValue.length; i++) {
                    html = html + "<option value='" + returnValue[i].id + "' >" + returnValue[i].nombre +
                        "</option>"
                }
                $("#geozona").html(html);


            });
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
                        "targets": [0],
                        "visible": false,
                        "searchable": false
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
                        data: null,
                        render: function(data, type, row) {
                            var html;

                            if (data[1] === "Sin movimiento") {
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
                        "targets": [8],
                    },
                    {
                        "targets": [9],
                    },
                    {
                        "targets": [10],
                    },
                    {
                        searchable: false,
                        "targets": [11],
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
                        sWidth: '8%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '8%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '8%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '8%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
                    },

                    {
                        sWidth: '20%',
                        sClass: 'text-center',
                        sClass: 'letracolumnapequeña'
                    },
                    {
                        sWidth: '10%',
                        sClass: 'text-center',
                        sClass: 'letracolumna'
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
        }


        function setValue(value) {
            const progressValue = document.querySelector('.Progressbar__value');
            const progress = document.querySelector('progress');
            progressValue.style.width = `${value}%`;
            progress.value = value;
        }

        function angulomarcador(heading) {
            if (heading == 0) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_0.png";

            } else if (heading > 0 && heading < 45) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_22.png";

            } else if (heading == 45) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_45.png";

            } else if (heading > 45 && heading < 90) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_67.png";

            } else if (heading == 90) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_90.png";

            } else if (heading > 90 && heading < 135) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_112.png";

            } else if (heading == 135) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_135.png";

            } else if (heading > 135 && heading < 180) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_157.png";

            } else if (heading == 180 || heading == -180) {
                url = "{{ asset('/') }}img/rotation/gpa_prueba_180.png";

            } else if (heading < 0 && heading > -45) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_N22.png";

            } else if (heading == -45) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_N45.png";

            } else if (heading < -45 && heading > -90) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_N67.png";

            } else if (heading == -90) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_N90.png";

            } else if (heading < 90 && heading > -135) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_N112.png";

            } else if (heading == -135) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_N135.png";

            } else if (heading < -135 && heading > -180) {

                url = "{{ asset('/') }}img/rotation/gpa_prueba_N157.png";

            }
            return url;
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ gpsKey() }}&libraries=geometry&callback=initMap"
        async></script>
@endpush
