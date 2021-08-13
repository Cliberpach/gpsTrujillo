@extends('layout')
@section('content')
    <div class="row" style="background:white;">
        <div class="col-lg-12" style="padding:0px;">
            <div id="map" style="height:700px;">
            </div>
        </div>
    </div>

    <div class="ibox" id="carrera" style="margin:0px !important;">
        <div class="ibox-title" style="padding: 5px 50px 8px 15px;">

            <div class="input-group">
                <input class="form-control" style="" id="myInput" type="text" placeholder="Busquedad">
                <span class="input-group-append"><a
                        style="color:black;cursor:default;background-color:white!important;border-top:1px solid rgb(229, 230, 231)!important;
                                                                    border-right:1px solid rgb(229, 230, 231)!important;border-bottom:1px solid rgb(229, 230, 231)!important;border-left:none"
                        class="btn btn-primary">
                        <i class="fa fa-search"></i></a></span>
            </div>
            <div class="ibox-tools" style="top:5px!important;right:5px!important;">
                <a class="collapse-link btn btn-primary" id="ocultar_dispositivos" data-ocultado="0">
                    <i class="fa fa-bars"></i>
                </a>

            </div>
        </div>
        <div class="ibox-content" style="padding:0px!important;">
            <div style="height:245px!important;" class="contenedor">
                <table class="table table-bordered" style="">
                    <tbody id="myTable">
                        @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))

                        @foreach (dispositivo_user(auth()->user()) as $dispositivo)
                            <tr id="tr_{{ $dispositivo->imei }}" onclick="zoom(this)"
                                data-imei="{{ $dispositivo->imei }}" data-placa="{{ $dispositivo->placa }}">
                                <td style="padding:0px 0px 0px 0px;">   
                                    <div class="padre">
                                        <div class="one">
                                            <input type="checkbox" class="i-checks" name="check_{{ $dispositivo->imei }}"
                                                    id="check_{{ $dispositivo->imei }}"data-imei="{{ $dispositivo->imei }}" checked>
                                            </div>
                                        <div class="two">
                                                  {{ $dispositivo->placa }}
                                            <br>
                                            <p style="margin:0px;color:rgb(168, 161, 161)" id="last_time">
                                                {{ultimafecha($dispositivo->imei)}}
                                            </p>
                                        </div>
                                        
                                        <div class="three">
                                           <p  id="last_velocidad">
                                                    {{last_velocidad($dispositivo->imei)}}
                                                </p>
                                        </div>

                                        <div id="estado_gps" class="four">
                                            @if (find_dispositivo($dispositivo->imei))

                                                @if (find_dispositivo_movimiento($dispositivo->imei))
                                                    <div class="circulo" style="background-color:green"></div>
                                                @else
                                                    <div class="circulo" style="background-color:yellow"></div>
                                                @endif
                                            @else
                                                <div class="circulo" style="background-color:red;"></div>
                                            @endif
                                        </div>
                                    </div> 
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="leyenda" id="leyenda">
        <div class="row">
            <div class="col-lg-2"><b>LEYENDA</b></div>
            <div class="col-lg-3"><div style="margin-top:5px;">Conectado</div><div class="circle_gps button" id="button-0"></div></div>
            <div class="col-lg-3"><div style="margin-top:5px;">Desconectado</div><div class="circle_gps_red button " id="button-0"></div></div>
            <div class="col-lg-3"><div style="margin-top:5px;">Sin Movimiento</div><div class="circle_gps_yellow button" id="button-0"></div></div>

        </div>
    </div>
@stop
@push('styles-mapas')
    <link href="{{ asset('css/velocimetro.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/init.css').'?v='.rand() }}">
@endpush
@push('scripts-mapas')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{gpsKey()}}&libraries=geometry"></script>
    <script type="text/javascript" src="{{ asset('js/info/infobox.js') }}"></script>
    <script>
        var map;
    </script>
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/mapa/init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/gps/gps.js').'?v='.rand() }}"></script>
    <script>
        @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
        iniciar('{{gpsKey()}}');
        setInterval(dispositivo, 5000);
        setInterval(dispositivo_estado, 5000);
        //setInterval(dispositivo_Movimiento, 5000);
        @endif

    </script>




@endpush
