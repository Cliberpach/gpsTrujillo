@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('reportesmovimiento-active', 'active')
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
                                                    <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required">Fecha de
                                                            Inicio</label></div>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" id="fecha" name="fecha" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required">Hora
                                                            Inicio</label></div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hinicio" name="hinicio"
                                                            readonly>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xs-12">
                                                    <div style="text-align:left;"><label class="required">Hora final</label>
                                                    </div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hfinal" name="hfinal"
                                                            readonly>
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                        <!-- <div class="col-lg-12">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input type="text" name="datetimes" id="datetimes"
                                                                    class="form-control" />
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-6 col-xs-12">
                                                            <div style="text-align:left;"><label
                                                                    class="required">Dispositivo</label></div>
                                                            <select class="select2_form form-control"
                                                                style="text-transform: uppercase; width:100%"
                                                                name="dispositivo" id="dispositivo">
                                                                <option></option>
                                                                @foreach (dispositivos() as $dispositivo)
                                                                    <option value="{{ $dispositivo->id }}">
                                                                        {{ $dispositivo->placa }}
                                                                    </option>
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
                                                <div>
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
    <div id="buttonRuta"
        style="background-color:white;width:40px;height:40px;border-radius:3px;
                                                        display:none; margin:10px 10px 0px 10px;padding:5px;cursor: pointer;"
        onclick="rutahour()">
        <i class="fa fa-google-wallet fa-2x" aria-hidden="true"></i>
    </div>
    @include('reportes.modalhour')
    @include('reportes.modal')

@stop
@push('styles')
    <!-- DataTable -->
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
        rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
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
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
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
                    format: 'Y/M/DD H:mm',
                    monthNames: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]
                }

            });
            $('.input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "yyyy/mm/dd"
            });
            $('.clockpicker').clockpicker();
            $('#timeHour').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10),
                locale: {
                    format: 'Y/M/DD H:mm',
                    monthNames: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]
                }
            });
        });
        var map;
        var map2;
        var markers = [];
        var polylines = [];
        var markers_ruta = [];
        var markers_hour = [];
        var data;

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
                fullscreenControl: true
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
                            return "";
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
            var enviar = true;
            var fecha = $("#fecha").val();
            var hinicio = $("#hinicio").val();
            var hfinal = $("#hfinal").val();
            var dispositivo = $("#dispositivo").val();
            if (fecha.length === 0 ||
                hinicio.length === 0 ||
                hfinal.length === 0 ||
                dispositivo.length === 0) {
                toastr.error('Complete la información de los campos obligatorios (*)', 'Error');
                enviar = false;
            }
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            var fechanow = yyyy + '/' + mm + '/' + dd;

            var fecha1 = new Date('1/1/1990 ' + hinicio);
            var fecha2 = new Date('1/1/1990 ' + hfinal);
            var fechainicio = fecha + " " + hinicio + ":00";
            var fechafinal = fecha + " " + hfinal + ":59";
            if (fecha1 > fecha2) {
                toastr.error('Error de fechas', 'Error');
                enviar = false;
            }
            if (enviar == true) {
                setMapOnAll(null);
                setMapOnAll_ruta(null);
                axios.get('{{ route('reportes.data') }}', {
                        params: {
                            _token: $('input[name=_token]').val(),
                            dispositivo: dispositivo,
                            fechainicio: fechainicio,
                            fechafinal: fechafinal ,
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
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        }

        function marker_ruta(arregloruta) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(arregloruta[0][0]),
                    parseFloat(arregloruta[0][1])),
                map: map2,
            });
            markers_ruta.push(marker);
            marker.setMap(map2);
            const image1 = {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                scaledSize: new google.maps.Size(50, 50),
            };
            var marker1 = new google.maps.Marker({
                position: new google.maps.LatLng(arregloruta[arregloruta.length - 1][0],
                    arregloruta[arregloruta.length - 1][1]),
                map: map2,
                icon: image1
            });
            markers_ruta.push(marker1);
            marker1.setMap(map2);
            map2.setZoom(15);
            if (((arregloruta.length) % 2) == 0) {
                map2.setCenter(new google.maps.LatLng(arregloruta[(arregloruta.length) / 2][0],
                    arregloruta[(arregloruta.length) / 2][1]));
            } else {
                map2.setCenter(new google.maps.LatLng(arregloruta[(((arregloruta.length) / 2) + 0.5)][0],
                    arregloruta[(((arregloruta.length) / 2) + 0.5)][1]));
            }
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
        async function agregar(returnValue) {
            $("#buttonRuta").css("display", "block");
            map2.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById("buttonRuta"));

            data = returnValue;
            var data_reporte = [];
            var t = $('.dataTables-reporte').DataTable();
            var arregloruta = [];
            for (var i = 0; i < returnValue.length; i++) {
                var porcentaje = (i + 1) / returnValue.length;
                setValue((porcentaje * 100).toFixed(0));
                var cadena = returnValue[i].cadena.split(',');
                arregloruta.push([returnValue[i].lat, returnValue[i].lng]);
                var direccion = returnValue[i].direccion;
                if (returnValue[i].direccion == null) {

                    direccion=await axios.get('https://apis.siscomfac.com/api/posicion?lat1='+returnValue[i].lat+'&lng='+returnValue[i].lng);
                    if(direccion.data[0].direccion==null){
                        try{
                            direccion = await axios.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' +
                            returnValue[i].lat + ',' +
                            returnValue[i].lng + '&key=AIzaSyB3oElOKZsIKTL2eB8peIQCTm6P77bJO1Q');
                           
                            var json_direccion=JSON.stringify(direccion.data).toString()
                            direccion = direccion.data.results[0].address_components[1].long_name + " " + direccion.data.results[0].address_components[0].long_name;
                            axios.post('https://apis.siscomfac.com/api/posicion',
                                {
                                    lat:returnValue[i].lat,
                                    lng:returnValue[i].lng,
                                    direccion:direccion,
                                    json:json_direccion
                                })
                                .then(function (response) {
                                })
                                .catch(function (error) {
                                    // handle error
                                    console.log(error);
                                })
                                .then(function () {
                                    // always executed
                                })
                        }
                        catch(error)
                        {
                          direccion="-";
                        }
                    }
                    else{
                        direccion=direccion.data[0].direccion;
                    }
                  
                   
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
                    '',
                ]);
            }
            t.destroy();
            iniciartabla(data_reporte);
            eliminaruta(null);
            addPolyline(arregloruta);
            marker_ruta(arregloruta)
        }

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
        function setMapOnAll_markerHour(map) {
            for (let i = 0; i < markers_hour.length; i++) {
                markers_hour[i].marker.setMap(map);
            }
        }

        function eliminaruta(map) {
            for (let i = 0; i < polylines.length; i++) {
                polylines[i].setMap(map);
            }
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
                "pagingType": "full_numbers"
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

        function rutahour() {
            $("#modal_hour").modal("show");
        }

        function generarRuta() {
            /*data.sort(function(a, b) {
                if (a.fecha < b.fecha) {
                    return 1;
                }
                if (a.fecha > b.fecha) {
                    return -1;
                }
                return 0;
            });*/
            var tiempoHora = $("#timeHour").val();
            var fechaFinal = new Date(tiempoHora);
            var fechaInicio = new Date(tiempoHora);
            fechaInicio.setHours(fechaFinal.getHours() - 1);


            var datahour = [];
            for (let index = 0; index < data.length; index++) {
                var fecha = new Date(data[index].fecha);
                if (fecha >= fechaInicio && fecha <= fechaFinal) {
                    datahour.push(data[index]);
                }
            }
            $("#modal_hour").modal("hide");
            if (datahour.length == 0) {
                toastr.error("No hay datos");
            } else {
                ruta(datahour);
            }
            // ruta(datahour);
        }

        function buscarmarker(marker) {
            var position = -1;
            for (let index = 0; index < markers_hour.length; index++) {
                if (markers_hour[index].marker === marker) {
                    position = index;
                }
            }
            return position;
        }

        function ruta(result) {
            setMapOnAll_ruta(null);
            setMapOnAll_markerHour(null);
            eliminaruta(null);
            var arregloruta = [];
            var latlng = [];
            for (var i = 0; i < result.length - 1; i++) {
                latlng = [];
                latlng.push(result[i].lat);
                latlng.push(result[i].lng);
                arregloruta.push(latlng);
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(result[i].lat, result[i].lng),
                    map: map2
                });

                markers_hour.push({
                    marker: marker,
                    imei: result[i].imei,
                    estado: result[i].estado,
                    lat: result[i].lat,
                    lng: result[i].lng,
                    fecha: result[i].fecha,
                    altitud: result[i].altitud,
                    direccion: result[i].direccion,
                    velocidad: result[i].velocidad
                });
                google.maps.event.addListener(marker, "click", async function() {
                    var position = buscarmarker(this);
                    var marker_ruta = markers_hour[position];

                    /*  var contentString =
                          "<div>" +marker_ruta.placa+"//"+marker_ruta.estado+
                          "<br>Fecha:"+marker_ruta.fecha+
                          "<br>Velocidad:"+marker_ruta.velocidad+
                          "<br>Altitud:" +marker_ruta.altitud+
                          "<br>Direccion:"+direccion+
                          "<br>Intensidad de la señal:"+marker_ruta.intensidadSenal+
                          "<br>Odometro:" +marker_ruta.odometro+
                          "<br>Nivel de Combustible:" +marker_ruta.nivelCombustible+
                          "<br>Volumen de Combustible:" +marker_ruta.volumenCombustible+
                          "<br>Horas del motor:" +marker_ruta.horaDelMotor+
                          "</div>";*/
                    var contentString =
                        "<div><p style='font-weight:bold;margin:0px;padding;0px;'>" + "//" + marker_ruta
                        .estado + "</p>" +
                        "Fecha:" + marker_ruta.fecha +
                        "<br>Velocidad:" + marker_ruta.velocidad +
                        "<br>Altitud:" + marker_ruta.altitud +
                        "<br>Direccion:" + marker_ruta.direccion +
                        "</div>";
                    var infowindow = new google.maps.InfoWindow({
                        content: contentString,
                        width: 200,
                        height: 400
                    });
                    infowindow.open(map, this);
                });
            }
            latlng = [];
            latlng.push(result[result.length - 1].lat);
            latlng.push(result[result.length - 1].lng);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(
                    result[result.length - 1].lat,
                    result[result.length - 1].lng
                )
            });
            arregloruta.push(latlng);
            markers_hour.push({
                marker: marker
            });

            for (var j = 0; j < markers_hour.length; j++) {
                if (j != markers_hour.length - 1) {
                    var heading = google.maps.geometry.spherical.computeHeading(
                        markers_hour[j].marker.getPosition(),
                        markers_hour[j + 1].marker.getPosition()
                    );
                    var image;
                    if (heading == 0) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_0.png"
                        };
                    } else if (heading > 0 && heading < 45) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_22.png"
                        };
                    } else if (heading == 45) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_45.png"
                        };
                    } else if (heading > 45 && heading < 90) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_67.png"
                        };
                    } else if (heading == 90) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_90.png"
                        };
                    } else if (heading > 90 && heading < 135) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_112.png"
                        };
                    } else if (heading == 135) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_135.png"
                        };
                    } else if (heading > 135 && heading < 180) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_157.png"
                        };
                    } else if (heading == 180 || heading == -180) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_180.png"
                        };
                    } else if (heading < 0 && heading > -45) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_N22.png"
                        };
                    } else if (heading == -45) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_N45.png"
                        };
                    } else if (heading < -45 && heading > -90) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_N67.png"
                        };
                    } else if (heading == -90) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_N90.png"
                        };
                    } else if (heading < 90 && heading > -135) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_N112.png"
                        };
                    } else if (heading == -135) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_N135.png"
                        };
                    } else if (heading < -135 && heading > -180) {
                        image = {
                            url: window.location.origin +
                                "/img/rotation/gpa_prueba_N157.png"
                        };
                    }
                    image.scaledSize = new google.maps.Size(40, 40);
                    image.origin = new google.maps.Point(0, 0);
                    markers_hour[j].marker.setIcon(image);
                }
            }
            addPolyline(arregloruta);



        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ gpsKey() }}&libraries=geometry&callback=initMap"
        async></script>
@endpush
