<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPS Tracker</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(verificarempresaloginicon())

    <link rel="icon" href="{{Storage::url(empresacolor()->ruta_logo_icon)}}" />
    @else
    
    <link rel="icon" href="{{asset('img/e.png')}}" />
    @endif
    <link href="{{asset('Inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/style.css')}}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{asset('Inspinia/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- Styles -->  @stack('styles')
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    @stack('styles-mapas')
        <style>
   	.contenedor {

  width: 300px;
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
<body>
    @auth
    
  
    <div id="">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <!-- Sidebar  Menu -->
                    @auth     
                    @include('partials.nav')
                    @endauth
                    <!-- /.Sidebar Menu -->
                </ul>
                <div style="width:100%; visibility: hidden;" id="leyenda_mapa">
                    <div id="legend" style="width:200px;heigth:200px;border:solid;background:white;margin:10px;border-radius: 10px;padding:10px;">
                        <div style="text-align: center;"><h3>Leyenda</h3></div> 
                             <div class="row">
                                  <div class="col-lg-12">
                                   <div class="row">
                                         <div class="col-lg-3 col-md-3">
                                           <h4 >Conectado</h4>
                                         </div>
                                         <div class="col-lg-9 col-md-9" >
                                           <div class="circle_gps button" id="button-0">
                                           </div>
                                         </div>
                                   </div>
                                   <div class="row">
                                         <div class="col-lg-3 col-md-3">
                                           <h4 >Desconectado</h4>
                                         </div>
                                         <div class="col-lg-9 col-md-9" >
                                         <div class="circle_gps_red button" id="button-0">
                                               </div>
                                         </div>
                                   </div>
                                   <div class="row">
                                         <div class="col-lg-3 col-md-3">
                                           <h4 >Movimiento</h4>
                                         </div>
                                       <div class="col-lg-9 col-md-9" >
                                       <img src="img/car-side.svg" class="filter-green" width="25px" id="button-0" style="position: absolute;left:110px;"/>
                                       </div>
                                   </div>
                                   <div class="row">
                                         <div class="col-lg-4 col-md-4">
                                           <h4 >Sin Movimiento</h4>
                                         </div>
                                       <div class="col-lg-8 col-md-8" >
                                       <img src="img/car-side_two.svg" class="filter-green" width="25px" id="button-0" style="position: absolute;left:95px;"/>
                                       </div>
                                   </div>
                                   </div>
                                   <div class="col-lg-6 col-md-6">
                                   @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
                                   <div id="activo_inactivo">
                                     <h4 >N° en Movimiento:{{dispositivo_activos(auth()->user())}}</h4>
                                     <h4 >N° sin Movimiento:{{dispositivo_inactivos(auth()->user())}}</h4>
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
                                    {{auth()->user()->usuario}}</b></span>
                            @endauth
                        </li>
		<li class="dropdown" id="notificacion_todo" data-ventana="cerrado">
                    <a class="dropdown-toggle count-info" id="notificacion_cabecera" data-toggle="dropdown" onclick="abrirnotificacion()" aria-expanded="true" >
                    </a>
                    <ul class="dropdown-menu dropdown-alerts" style="width:410px!important;" id="notificacion_cuerpo" >
                    </ul>
                </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" ><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                        <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
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
            <div class="footer">
                <div class="float-right" onkeyup="return mayus(this)">
                    DEVELOPER <strong>GPS Tracker</strong>
                </div>
		@csrf
            </div>
        </div>
    </div>
    @endauth






<script  src="{{ asset('js/app.js') }}" ></script>
<script>
  </script>
    <script src="{{asset('Inspinia/js/jquery-3.1.1.min.js')}}"></script> 
   <script>
            @if(verificarempresa())
        keyframesRule('{{ asset("/") }}css/style.css','{{empresacolor()->color}}') 
        getSetStyleRule('{{ asset("/") }}css/style.css','.select2-container--default .select2-results__option--highlighted[aria-selected]','background-color: {{empresacolor()->color}};color: white;'); 
        getSetStyleRule('{{ asset("/") }}css/style.css','.panel-primary','border-color:{{empresacolor()->color}}');
        getSetStyleRule('{{ asset("/") }}css/style.css','.wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active','background: rgb(168 176 174);;color: rgb(255, 255, 255);');
        getSetStyleRule('{{ asset("/") }}Inspinia/email_templates/style.css','.btn-primary','text-decoration: none;color: #FFF;background-color: {{empresacolor()->color}}!important;border: solid {{empresacolor()->color}}!important;border-width: 5px 10px;line-height: 2;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px;text-transform: capitalize;')
       getSetStyleRule('{{ asset("/") }}css/style.css', '.btn-primary', 'color: #fff;background-color: {{empresacolor()->color}}!important;border-color: {{empresacolor()->color}}!important;') 
       getSetStyleRule('{{ asset("/") }}css/style.css', '.nav > li.active', 'border-left: 4px solid {{empresacolor()->color}};background: #293846;') 
       getSetStyleRule('{{ asset("/") }}css/style.css', '.ldio-6fqlsp2qlpd div', 'position: absolute;width: 40px;height: 40px;background: {{empresacolor()->color}}!important;animation: ldio-6fqlsp2qlpd 1s linear infinite;') 
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.pace .pace-progress', 'background: {{empresacolor()->color}};position: fixed;z-index: 2040;top: 0;right: 100%;width: 100%;height: 2px;') 
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.panel-primary > .panel-heading','background-color: {{empresacolor()->color}}!important;border-color:{{empresacolor()->color}}!important;');
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.page-item.active .page-link', 'background-color: {{empresacolor()->color}};border-color: {{empresacolor()->color}};') 
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary', 'background-color: {{empresacolor()->color}};!important')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary.disabled, .btn-primary:disabled', 'background-color: {{empresacolor()->color}}!important;border-color: {{empresacolor()->color}}!important;')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary', 'border-color: {{empresacolor()->color}};!important')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary:hover,.btn-primary:focus,.btn-primary.focus', 'background-color: {{empresacolor()->color}}!important;border-color: {{empresacolor()->color}}!important;')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/plugins/steps/jquery.steps.css', '.wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active', 'background: {{empresacolor()->color}};')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/plugins/steps/jquery.steps.css', '.wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active', 'background: {{empresacolor()->color}};')
       @endif
       function getSetStyleRule(sheetName, selector, rule) {
                var stylesheet = document.querySelector("link[href=\"" + sheetName + "\"]");
                if( stylesheet ){
                    var rulelist=stylesheet.sheet.cssRules;
                        stylesheet = stylesheet.sheet;
                    var arreglo=[];
                        arreglo.push(rulelist);
                    for (var i=0; i < arreglo.length; i++) {
                               if(arreglo[i].selector_text===selector)
                               {
                                stylesheet.deleteRule(i);
                               }
                        }
                    //
                   stylesheet.insertRule(selector + '{ ' + rule + '}', stylesheet.cssRules.length);
                }
                return stylesheet
            }
    function keyframesRule(sheetName,color) {
                var stylesheet = document.querySelector("link[href=\"" + sheetName + "\"]");
                if( stylesheet ){
                    var rulelist=stylesheet.sheet.cssRules;
                    stylesheet = stylesheet.sheet;
                    var arreglo=[];
                    arreglo.push(rulelist);
                      var nuevovalor=color.substring((color.length)-2,color.length);
                      var valoranterior=color.substring(0,color.length-2);
                      var nuevo=(valoranterior+"0.6)");
                       arreglo[0][16].deleteRule('0%');
                       arreglo[0][16].appendRule('0% { background: '+nuevo+'; }');
                       arreglo[0][16].deleteRule('12.5%');
                       arreglo[0][16].appendRule('12.5% { background: '+nuevo+'; }');
                       arreglo[0][16].deleteRule('12.625%');
                       arreglo[0][16].appendRule('12.625% { background: '+color+'; }');
                       arreglo[0][16].deleteRule('100%');
                       arreglo[0][16].appendRule('100% { background: '+color+'; }');
                    //
                }
                return stylesheet
        }
setInterval(notificaciones, 5000);
	 var usuario="{{Auth()->user()->id}}";
		$( document ).ready(function() {
		    notificaciones();
		});
		function  notificaciones()
		{
		  $.ajax({
                        dataType : 'json',
                        type : 'POST',
                        url : '{{ route('notificacion.leer') }}',
                        data : {
                            '_token' : $('input[name=_token]').val(),
                            'user_id' : usuario
                        }
                    }).done(function (result){
                        //console.log(result);
		   if(result.length!=0)
		   {
		       var sinleer=-1;
		       var cuerpo=" ";
               var tamaño=0;
               if(result.length>5)
               {
                tamaño=5;
               }
               else
               {
                tamaño=result.length;
               }
			for (var i=0;i<tamaño;i++)
			{
               
			   if(result[i].readuser=="0")
			    {
				sinleer=sinleer+1;
			    }
                var fecha_actual = new Date()
                var fecha=new Date(result[i].creado);
                var minutos=diff_minutes(fecha,fecha_actual);
                var tiempo;
                if(minutos==0)
                {
                    tiempo="Justo ahora.";
                }
                else if(minutos>0 && minutos<60)
                {
                    if(minutos==1)
                    {
                        tiempo="hace "+minutos+" minuto."
                    }
                    else
                    {
                        tiempo="hace "+minutos+" minutos."
                    }
                    
                }
                else if(minutos>=60 && minutos<1440)
                {
                    var hora=Math.floor(minutos/60);
                    var minuto =minutos % 60;
                    if(hora==1)
                    {
                      if(minuto==1)
                      {
                        tiempo="hace "+hora+" Hora "+ minuto+" minuto";
                      }
                      else
                      {
                        tiempo="hace "+hora+" Hora "+ minuto+" minutos";
                      }
                    }
                    else
                    {
                        if(minuto==1)
                      {
                        tiempo="hace "+hora+" Horas "+ minuto+" minuto";
                      }
                      else
                      {
                        tiempo="hace "+hora+" Horas "+ minuto+" minutos";
                      }
                    }
                }
                else
                {
                    var date = fecha.getDate();
                    var month = fecha.getMonth(); 
                    var year = fecha.getFullYear();
                  //  console.log(date,month+1,year);
                    tiempo=year+"/"+(month+1)+"/"+date;
                }


                if(result[i].informacion==="Se desconecto la bateria")
                {
                    cuerpo=cuerpo+"<li><a href='#' class='dropdown-item'><div><img src='https://aseguroperu.com/img/e.png' width='40px'>"+" "+result[i].informacion+" "+result[i].placa+"  "+"<img src='https://aseguroperu.com/img/bateria.png' width='70px' style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>"+tiempo+"</a></li><li class='dropdown-divider'></li>";
                }
                else if(result[i].informacion==="Aumento de la velocidad")
                {
                    cuerpo=cuerpo+"<li><a href='#' class='dropdown-item'><div><img src='https://aseguroperu.com/img/e.png' width='40px'>"+" "+result[i].informacion+" "+result[i].placa+"  "+"<img src='https://aseguroperu.com/img/exceso.png' width='70px' style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>"+tiempo+"</a></li><li class='dropdown-divider'></li>";
                }
                else if(result[i].informacion==="Ocurrio una alerta de ayuda")
                {
                    cuerpo=cuerpo+"<li><a href='#' class='dropdown-item'><div><img src='https://aseguroperu.com/img/e.png' width='40px'>"+" "+result[i].informacion+" "+result[i].placa+"  "+"<img src='https://aseguroperu.com/img/ayuda.png' width='70px' style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>"+tiempo+"</a></li><li class='dropdown-divider'></li>";
                }
                else if(result[i].informacion==="fuera de rango")
                {
                    cuerpo=cuerpo+"<li><a href='#' class='dropdown-item'><div><img src='https://aseguroperu.com/img/e.png' width='40px'>"+" "+result[i].informacion+" "+result[i].placa+"  "+"<img src='https://aseguroperu.com/img/rango.png' width='70px'  style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>"+tiempo+"</a></li><li class='dropdown-divider'></li>";
                }
		         
                
            }
             cuerpo=cuerpo+"<div style='text-align: center;'><a href='{{ route('notificacion.index') }}'>ver todos</a></div>"
			   $('#notificacion_cuerpo').html(cuerpo);
		         $('#notificacion_cabecera').html('<i class="fa fa-bell"></i>  <span class="label label-primary" >'+(sinleer+1)+'</span>');
		   }
		   else{
		       var c="<li><a class='dropdown-item' ><div><i class='fa fa-envelope fa-fw'></i>No hay datos</div></a></li>";
			   $('#notificacion_cuerpo').html(c);
			$('#notificacion_cabecera').html('<i class="fa fa-bell"></i>  <span class="label label-primary" >0</span>');
			}
		  });
		}
        function diff_minutes(dt1,dt2) 
        {

        var diff =(dt2.getTime() - dt1.getTime()) / 1000;
        diff =diff/ 60;
        return Math.round(diff);
        
        }
		function abrirnotificacion()
		{
	         var notificacion= document.getElementById("notificacion_todo").classList.contains('show');
		if(notificacion===false)	
		{
		    $('#notificacion_cuerpo').addClass('show');
		    $('#notificacion_todo').addClass('show');
			document.getElementById("notificacion_cabecera").setAttribute("aria-expanded", "true");
		    $.ajax({
                        dataType : 'json',
                        type : 'POST',
                        url : '{{ route('notificacion.data') }}',
                        data : {
                            '_token' : $('input[name=_token]').val(),
                            'user_id' : usuario
                        }
                    }).done(function (result){
                   $('#notificacion_cabecera').html('<i class="fa fa-bell"></i>  <span class="label label-primary" >0</span>');
                  });
		}
	        else
		{
			$('#notificacion_cuerpo').removeClass('show');
		    $('#notificacion_todo').removeClass('show');
			document.getElementById("notificacion_cabecera").setAttribute("aria-expanded", "false");
		}		 
		}
       </script> 
    <script src="{{asset('Inspinia/js/popper.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/bootstrap.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{asset('Inspinia/js/inspinia.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/pace/pace.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('Inspinia/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Toastr script -->
    <script src="{{asset('Inspinia/js/plugins/toastr/toastr.min.js')}}"></script>
    <!-- Propio scripts -->
    <script src="{{ asset('Inspinia/js/scripts.js') }}"></script>
    <!-- SweetAlert -->
    <script src="{{asset('SweetAlert/sweetalert2@10.js')}}"></script>
   @stack('scripts-mapas') 
   @stack('scripts')
   <script>
        window.addEventListener("load",function(){
            @auth    
             @else    
            window.location = "{{ route('login')  }}";            
            @endauth
           $('.loader-spinner').hide();
            $("#content-system").css("display", "");
        })   
        
   </script> 
</body>
</html>
