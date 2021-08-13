<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPS Tracker</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (verificarempresaloginicon())
        <link rel="icon" href="{{ Storage::url(empresacolor()->ruta_logo_icon) }}" />
    @else
        <link rel="icon" href="{{ asset('img/e.png') }}" />
    @endif
    <link href="{{ asset('Inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/style.css') }}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('Inspinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    @stack('styles')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles-mapas')
    <style>
        .contenedor {

            width: 100%;
            height: 400px;
            background-color: #fff;
            border-radius: 0.25rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            color: #333;
            font-family: sans-serif;
            text-align: justify;
            line-height: 1.3;
            overflow: auto;
        }

        /* Tamaño del scroll */
        .contenedor::-webkit-scrollbar {
            width: 8px;
        }

        /* Estilos barra (thumb) de scroll */
        .contenedor::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .contenedor::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        .contenedor::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        /* Estilos track de scroll */
        .contenedor::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }

        .contenedor::-webkit-scrollbar-track:hover,
        .contenedor::-webkit-scrollbar-track:active {
            background: #d4d4d4;
        }

    </style>
</head>

<body style="background-color:white !important;color:rgb(37, 36, 64);">
    @auth
        <div id="">
            <nav class="navbar-default navbar-static-side"  role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        @auth
                            @include('partials.nav')
                        @endauth
                    </ul>
                    <div style="width:100%; visibility: hidden;" id="leyenda_mapa">
                        <div id="legend"
                            style="width:200px;heigth:200px;border:solid;background:white;margin:10px;border-radius: 10px;padding:10px;">
                            <div style="text-align: center;">
                                <h3>Leyenda</h3>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <h4>Conectado</h4>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="circle_gps button" id="button-0"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <h4>Desconectado</h4>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="circle_gps_red button" id="button-0"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <h4>Movimiento</h4>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <img src="{{ asset('img/car-side.svg') }}" class="filter-green" width="25px"
                                                id="button-0" style="position: absolute;left:110px;" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <h4>Sin Movimiento</h4>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <img src="{{ asset('img/car-side_two.svg') }}" class="filter-green"
                                                width="25px" id="button-0" style="position: absolute;left:95px;" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    @if(is_array(dispositivo_user(auth()->user())) ||
                                    is_object(dispositivo_user(auth()->user())))
                                    <div id="activo_inactivo">
                                        <h4>N° en Movimiento:{{ dispositivo_activos(auth()->user()) }}</h4>
                                        <h4>N° sin Movimiento:{{ dispositivo_inactivos(auth()->user()) }}</h4>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            </nav>
        </div>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2" href="#" id="ocultar" data-ocultar="0"><i
                                class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            @auth
                                <span class="m-r-sm text-muted welcome-message">Bienvenido <b>
                                        {{ auth()->user()->usuario }}</b></span>
                            @endauth
                        </li>
                        <li class="dropdown" id="notificacion_todo" data-ventana="cerrado">
                            <a class="dropdown-toggle count-info" id="notificacion_cabecera" data-toggle="dropdown"
                                onclick="abrirnotificacion()" aria-expanded="true">
                            </a>
                            <ul class="dropdown-menu dropdown-alerts" style="width:410px!important;"
                                id="notificacion_cuerpo">
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Cerrar
                                Sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="loader-spinner">
                <div class="centrado" id="onload">
                    <div class="loadingio-spinner-blocks-zcepr5tohl">
                        <div class="ldio-6fqlsp2qlpd">
                            <div style='left:38px;top:38px;animation-delay:0s'>
                            </div>
                            <div style='left:80px;top:38px;animation-delay:0.125s'></div>
                            <div style='left:122px;top:38px;animation-delay:0.25s'></div>
                            <div style='left:38px;top:80px;animation-delay:0.875s'></div>
                            <div style='left:122px;top:80px;animation-delay:0.375s'></div>
                            <div style='left:38px;top:122px;animation-delay:0.75s'></div>
                            <div style='left:80px;top:122px;animation-delay:0.625s'></div>
                            <div style='left:122px;top:122px;animation-delay:0.5s'></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="content-system" style="">
                <!-- Contenido del Sistema -->
                @auth
                    @yield('content')
                @endauth
                <!-- /.Contenido del Sistema -->
            </div>
            @csrf
        </div>
        </div>
    @endauth
    <script  src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('Inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/PageInit/color.js') }}"></script>

    <script>
        var url_notificacion_data = '{{ route('notificacion.data') }}';

    </script>
    <script src="{{ asset('js/PageInit/notificaciones.js') }}"></script>
    <script>
        var url_leer = '{{ route('notificacion.leer') }}';

        @if (verificarempresa())
            cambioColor('{{ asset('/') }}','{{ empresacolor()->color }}')
        @endif

        setInterval(notificaciones, 5000, url_leer);
        $(document).ready(function() {
            notificaciones(url_leer);
        });

    </script>

    <script src="{{ asset('Inspinia/js/popper.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/bootstrap.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/scripts.js') }}"></script>
    <script src="{{ asset('SweetAlert/sweetalert2@10.js') }}"></script>
    @stack('scripts-mapas')
    @stack('scripts')
    <script>
        window.addEventListener("load", function() {
            @auth
            @else
                window.location = "{{ route('login') }}";
            @endauth
            $('.loader-spinner').hide();
            $("#content-system").css("display", "");
        })

    </script>
</body>

</html>
