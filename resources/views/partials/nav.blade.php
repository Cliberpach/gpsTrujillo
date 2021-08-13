<li class="nav-header" style="background-color:white !important;" >
    <div class="dropdown profile-element" style="ackground-bcolor:white !important;">
        @auth
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        @if(verificarempresaloginicon())
                    <span class="block m-t-xs font-bold">  <img src="{{Storage::url(empresacolor()->ruta_logo_icon)}}" alt="" width="40">{{" ".auth()->user()->usuario}}</span>
                    @else
                      <span class="block m-t-xs font-bold">  <img src="{{asset('img/e.png')}}" alt="" width="40">{{" ".auth()->user()->usuario}}</span>
                    @endif
        @endauth
        </a>
        <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a class="dropdown-item" href="{{route('logout')}}">Cerrar Sesión</a></li>
        </ul>
    </div>
    <div class="logo-element">
    @if(verificarempresaloginicon())
        <img src="{{Storage::url(empresacolor()->ruta_logo_icon)}}" height="45" width="45">
    @else
        <img src="{{asset('img/e.png')}}" height="45" width="45">
    @endif
    </div>
</li>
<li>
    <a href="{{route('mapa.index')}}"><i class="fa fa-th-large" style="color:rgb(37, 36, 64)!important;"></i> <span class="nav-label" style="color:rgb(37, 36, 64)!important;">MAPAS</span></a>
</li>
@if(auth()->user()->can('haveaccess','crud_cliente') or
        auth()->user()->can('haveaccess','crud_empresa') or
        auth()->user()->can('haveaccess','crud_tipoDispositivo') or
        auth()->user()->can('haveaccess','crud_dispositivo') or
        auth()->user()->can('haveaccess','crud_contrato') or
        auth()->user()->can('haveaccess','crud_reporteMovimiento') or
        auth()->user()->can('haveaccess','crud_reporteGeozona') or
        auth()->user()->can('haveaccess','crud_reporteSalida') or
        auth()->user()->can('haveaccess','crud_reporteGrupo') or
        auth()->user()->can('haveaccess','crud_reporteAlerta') or
        auth()->user()->can('haveaccess','crud_rango') )
<li class="@yield('gps-active')">
    <a href="#"><i class="fa fa-shopping-cart" style="color:rgb(37, 36, 64)!important;"></i> <span class="nav-label" style="color:rgb(37, 36, 64)!important;">GPS</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse" >
         @can('haveaccess','crud_cliente')
        <li class="@yield('clientes-active')"><a  style="color:rgb(37, 36, 64)!important;" href="{{ route('cliente.index') }}">Clientes</a></li>
        @endcan
        @can('haveaccess','crud_empresa')
        <li class="@yield('empresas-active')"><a href="{{ route('empresas.index')}}">Empresas</a></li>
        @endcan
        @can('haveaccess','crud_tipoDispositivo')
        <li class="@yield('tipodispositivo-active')"><a href="{{ route('tipodispositivo.index')}}">Tipos Dispositivos</a></li>
        @endcan
        @can('haveaccess','crud_dispositivo')
        <li class="@yield('dispositivo-active')"><a href="{{ route('dispositivo.index')}}">Dispositivos</a></li>
        @endcan
        @can('haveaccess','crud_contrato')
        <li class="@yield('contrato-active')"><a href="{{ route('contrato.index')}}">Contratos</a></li>
        @endcan
        @can('haveaccess','crud_reporteMovimiento')
        <li class="@yield('reportesmovimiento-active')"><a href="{{ route('reportes.index')}}">Reporte de Movimiento</a></li>
        @endcan
        @can('haveaccess','crud_reporteGeozona')
        <li class="@yield('reportesgeozona-active')"><a href="{{ route('reportes.geozona')}}">Reporte de Geozona</a></li>
        @endcan
        @can('haveaccess','crud_reporteSalida')
        <li class="@yield('reportesgeozonasalida-active')"><a href="{{ route('reportes.geozonasalida')}}">Reporte de Salida</a></li>
        @endcan
        @can('haveaccess','crud_reporteGrupo')
        <li class="@yield('reportesgeozonagrupo-active')"><a href="{{ route('reportes.geozonagrupo')}}">Reporte de grupo</a></li>
        @endcan
        @can('haveaccess','crud_reporteAlerta')
        <li class="@yield('reportesalerta-active')"><a href="{{ route('reportes.alerta')}}">Reporte de Alertas</a></li>
        @endcan
        @can('haveaccess','crud_rango')
        <li class="@yield('rangos-active')"><a href="{{ route('rangos.index')}}">Rangos</a></li>
        @endcan
        @can('haveaccess','crud_rango')
        <li class="@yield('sutran-active')"><a href="{{ route('sutran.index')}}">Sutran</a></li>
        @endcan
    </ul>
</li>
@endif
@if(auth()->user()->can('haveaccess','crud_tableGeneral') or
        auth()->user()->can('haveaccess','crud_colaborador') or
        auth()->user()->can('haveaccess','crud_empresaPersonal') or
        auth()->user()->can('haveaccess','crud_mensajePersonalizado') or
        auth()->user()->can('haveaccess','crud_rol') or
        auth()->user()->can('haveaccess','crud_usuario'))
<li class="@yield('mantenimiento-active')">
    <a href="#"><i class="fa fa-shopping-cart" style="color:rgb(37, 36, 64)!important;" ></i> <span class="nav-label" style="color:rgb(37, 36, 64)!important;">Mantenimiento</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        @can('haveaccess','crud_tableGeneral')
        <li class="@yield('tablas-active')"><a href="{{route('mantenimiento.tabla.general.index')}}">Tablas Generales</a></li>
        @endcan
        @can('haveaccess','crud_colaborador')
        <li class="@yield('colaboradores-active')"><a href="{{ route('mantenimiento.colaborador.index') }}">Colaboradores</a></li>
        @endcan
        @can('haveaccess','crud_empresaPersonal')
        <li class="@yield('empresa-active')"><a href="{{ route('empresa.index')}}">Empresa Personal</a></li>
        @endcan
        @can('haveaccess','crud_mensajePersonalizado')
        <li class="@yield('mensaje-active')"><a href="{{ route('mensaje.index')}}">Mensaje Personalizado</a></li>
        @endcan
        @can('haveaccess','crud_rol')
        <li class="@yield('roles-active')"><a href="{{ route('roles.index')}}">Roles</a></li>
        @endcan
        @can('haveaccess','crud_usuario')
        <li class="@yield('usuarios-active')"><a href="{{ route('usuarios.index')}}">Usuario</a></li>
        @endcan
    </ul>
</li>
@endif
