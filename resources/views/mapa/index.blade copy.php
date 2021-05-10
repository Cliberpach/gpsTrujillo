@extends('layout')
 @section('content')
 <div class="row" style="background:white;">
   <div class="col-lg-12" style="padding:0px;">
   <div id="map" style="height:800px;">
   </div>
   </div>
 </div>
 <div class="gauge" id="odometro">
        <div class="gauge__body">
          <div class="gauge__fill"></div>
          <div class="gauge__cover"></div>
          <div class="dispositivo"></div>
          <div class="odometro">
            <div class="o_val1">0</div>
            <div class="o_val2">0</div>
            <div class="o_val3">0</div>
            <div class="o_val4">0</div>
            <div class="o_val5">0</div>
            <div class="o_val6">0</div>
        </div>
        </div>
      </div>
      <div class="ibox border-bottom" id="carrera" style="margin-top:0.8%;margin-right:0.8%;">
        <div class="ibox-title">
            <h5>Dispositivos</h5> <span class="label label-primary">GPS </span>
            <div class="ibox-tools">
                <a class="collapse-link" href="" id="ocultar_dispositivos" data-ocultado="0">
                    <i class="fa fa-chevron-up"></i>
                </a>
    
    
            </div>
        </div>
        <div class="ibox-content" style="display:none;">
            <div>
              <div >
                <div  class="input-group">
                    <input class="form-control" style="" id="myInput" type="text" placeholder="Search..">
                    <span class="input-group-append"><a style="color:white;cursor:default;" class="btn btn-primary"><i class="fa fa-search"></i></a></span>
                </div>	
              </div>
         <div style="height:245px!important;" class="contenedor">
          <table class="table table-bordered" style="border-spacing: 10px;border-collapse: separate;" >
         <tbody id="myTable" >
         @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
        @foreach (dispositivo_user(auth()->user()) as $dispositivo)
           <tr  id="td_{{$dispositivo->imei}}" onclick="zoom(this)" data-imei="{{$dispositivo->imei}}" data-placa="{{$dispositivo->placa}}"> 
                        <td><div class="row"  >
                          <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                              <i class="fa fa-car fa-3x circle" style="color:rgb(00, 00, 00);" aria-hidden="true">
                                </i>
                            </div>
                          <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                          <div id="estado_gps">
                          @if(find_dispositivo($dispositivo->imei))
                                  <div class="circle_gps button" id="button-0">
                                    </div>
                                    <input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Conectado">
                                    @else 
                                    <div class="circle_gps_red button" id="button-0"></div>
                                    <input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Desconectado">
                              @endif
                          </div> 
                        <div id="movimiento_gps">
                        @if(find_dispositivo_movimiento($dispositivo->imei))
                        <img src="img/car-side.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/>
                       <!-- <div  class="circle_gps_blue button" id="button-0" style="top:40px!important;">
                                    </div>-->
                        @else
                        <img src="img/car-side_two.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/>
                        <!-- <div  class="circle_gps_yellow button" id="button-0" style="top:40px!important;">
                                    </div>-->
                        @endif
                        </div>
                            <b>Placa:</b>{{$dispositivo->placa}} <br>
                            <b>Marca:</b>{{$dispositivo->marca}} <br>
                            <b>Color:</b>{{$dispositivo->color}} <br>
                          </div>
                        </div></td>
              </tr>
              @endforeach  
              @endif      
            </tbody>
          </table>
      </div>
            </div>
        </div>
     </div>
@if(is_array(rangos()) || is_object(rangos()))
    <input type="hidden" name="posiciones_gps" id="posiciones_gps" value="{{rangos()}}">
@endif
    <!-- Contenido del Sistema -->
    <!-- /.Contenido del Sistema -->
<!--<div id="map" style="height:800px;">-->
@stop
@push('styles-mapas')
<style>
.gauge {
  width: 300px;
  max-width: 250px;
  margin:0px 20px 60px 60px;
  font-family: "Roboto", sans-serif;
  font-size: 32px;
  color: #004033;
}
.gauge__body {
  width: 100%;
  height: 0;
  padding-bottom: 50%;
  background: #b4c0be;
  position: relative;
  border-top-left-radius: 100% 200%;
  border-top-right-radius: 100% 200%;
  overflow: hidden;
}
.gauge__fill {
  position: absolute;
  top: 100%;
  left: 0;
  width: inherit;
  height: 100%;
  background: #009578;
  transform-origin: center top;
  transform: rotate(0.25turn);
  transition: transform 0.2s ease-out;
}
.gauge__cover {
  width: 75%;
  height: 150%;
  background: #ffffff;
  border-radius: 50%;
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translateX(-50%);
  /* Text */
  display: flex;
  padding:17px 0px 0px 0px;
  justify-content: center;
  font-size:19px;
  box-sizing: border-box;
}
.dispositivo
{
  height:30px;
  position:absolute;
  display: grid;
  color:black;
  font-size:20px;
  border-radius: 8px;
  top:50%;
  left:34%;
}
.odometro
{
  height:25px;
  border:solid;
  position:absolute;
  display: grid;
  background-color:black;
  color:white;
  font-size:16px;
  border-radius: 8px;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 5px;
  grid-auto-rows: minmax(100px, auto);
  top:68%;
  left:30%;
}
.o_val1{
  grid-column: 1;
  grid-row: 1;
}
.o_val2{
  grid-column: 2;
  grid-row: 1;
}
.o_val3{
  grid-column: 3;
  grid-row: 1;
}
.o_val4{
  grid-column: 4;
  grid-row: 1;
}
.o_val5{
  grid-column: 5;
  grid-row: 1;
}
.o_val6{
  grid-column: 6;
  grid-row: 1;
  color:red;
}
.circle {
  display: inline-block;
  border-radius: 60px;
  box-shadow: 0px 0px 2px #888;
  padding: 0.3em 0.3em;
}
.circle_gps {
  width: 10px;
  height: 10px;
  background: green;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  position: absolute;
}
.circle_gps::before, .circle_gps::after {
  content:"";
  position:absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%, -50%);
  width: 70px;
  height: 70px;
  border: 10px solid gray;
  border-radius:100%;
  animation: latido linear 3s infinite;
}
.circle_gps::before, .circle_gps::after {
  animation: latido linear 3s infinite;
}
.circle_gps::after {
  animation-delay: -1.5s;
}
@keyframes latido {
  0% { width:15px; height:15px; border:5px solid rgb(49,222, 5); }
  100% { width:30px; height:30px; border:5px solid transparent; }
}
.circle_gps {
  width: 10px;
  height: 10px;
  background: green;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  position: absolute;
}
.circle_gps::before, .circle_gps::after {
  content:"";
  position:absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%, -50%);
  width: 70px;
  height: 70px;
  border: 10px solid gray;
  border-radius:100%;
  animation: latido linear 3s infinite;
}
.circle_gps::before, .circle_gps::after {
  animation: latido linear 3s infinite;
}
.circle_gps::after {
  animation-delay: -1.5s;
}
@keyframes latido {
  0% { width:15px; height:15px; border:5px solid rgb(49,222, 5); }
  100% { width:30px; height:30px; border:5px solid transparent; }
}
.circle_gps_red {
  width: 10px;
  height: 10px;
  background: red;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  position: absolute;
}
.circle_gps_red::before, .circle_gps_red::after {
  content:"";
  position:absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%, -50%);
  width: 70px;
  height: 70px;
  border: 10px solid gray;
  border-radius:100%;
  animation: latido_red linear 3s infinite;
}
.circle_gps_red::before, .circle_gps_red::after {
  animation: latido_red linear 3s infinite;
}
.circle_gps_red::after {
  animation-delay: -1.5s;
}
@keyframes latido_red {
  0% { width:15px; height:15px; border:5px solid rgb(222,49, 5); }
  100% { width:30px; height:30px; border:5px solid transparent; }
}
#button-0 { top: 10px; right: 28px; }
.info-box-wrap {
background:#fff;
overflow: hidden;
;
box-shadow: 5px 5px 0px rgba(0, 0, 0, 0.08);
}
.info-box-text-wrap {
height:25px !important;
text-align: center;
padding-top:5px;
font-size:9.5pt;
width:80px;
float:left;
overflow: hidden;
}
</style>

@endpush
@push('scripts-mapas')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI"></script>
<script type="text/javascript"  src="{{asset('js/info/infobox.js') }}" ></script>
<script>
      var arreglo=[];
      var info_=[];
      var map;
      var markers=[];
      var placa_velocimetro="";
      var polylines=[];
      var polygon; 
      window.onload = function() {
  initMap();
};
      $("#ocultar_dispositivos").click(function()
      {
       var ocultado= $("#ocultar_dispositivos").data("ocultado");
       if(ocultado=="0")
       {
        $("#odometro").css('margin-top','10%');
        $("#ocultar_dispositivos").data("ocultado","1");
       }
       else
       {
        $("#odometro").css('margin-top','0%');
        $("#ocultar_dispositivos").data("ocultado","0");
       }

        
      });
       var gaugeElement = document.querySelector(".gauge");
      $(document).ready(function() {
        $("#leyenda_mapa").css("visibility", "visible");
  setGaugeValue(gaugeElement, 0,0,"",0);
      });
      $("#ocultar").click(function(){
        var ocultar = $("#ocultar").data("ocultar");
        if(ocultar=="0")
        {
          $("#leyenda_mapa").css("visibility", "hidden");
          $("#ocultar").data("ocultar","1");
        }
        else
        {
          $("#leyenda_mapa").css("visibility", "visible");
          $("#ocultar").data("ocultar","0");
        }
      });
      function setGaugeValue(gauge, value,km,dispositivo,kmr) {
          if (value < 0 || value > 1) {
            return;
          }
          gauge.querySelector(".gauge__fill").style.transform = `rotate(${
            value / 2
          }turn)`;
          gauge.querySelector(".gauge__cover").textContent = `${
            km
          } Km/h`;
          gauge.querySelector(".dispositivo").textContent = dispositivo;
          var kmre=kmr;
          var residuo;
          var division;
          var decimal=parseInt((kmre*10)%10);
          gauge.querySelector(".o_val6").textContent="."+decimal;
          for(var i=5;i>=1;i--)
          {
            residuo=parseInt(kmre%10);
            kmre=kmre/10;
            gauge.querySelector(".o_val"+i).textContent =residuo;
          }
}
    function initMap() {
      polygon = new google.maps.Polygon();
          map = new google.maps.Map(document.getElementById("map"), {
                                  zoom: 12,
                                  center: { lat: -8.1092027, lng: -79.0244529 },
                                  gestureHandling: "greedy",
                                  zoomControl: false,
                                  streetViewControl: false,
                                  fullscreenControl:false
                                  });
                                  const carrera= document.getElementById("carrera");
                    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(carrera);
      const odometro = document.getElementById("odometro");
      map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(odometro);
	    const image ={
                    url:"https://aseguroperu.com/img/e.png",
                    // This marker is 20 pixels wide by 32 pixels high.
                    scaledSize: new google.maps.Size(50, 50),
                    // The origin for this image is (0, 0).
                    };
                    @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
	@foreach (dispositivogps_user(auth()->user()) as $dispositivo)
	  var cadena='{{$dispositivo["cadena"]}}';
	  var velocidad = cadena.split(',');
    var mph=(parseFloat(velocidad[11])*1.15078)*1.61;
	  var geocoder=new google.maps.Geocoder();
  	var marker = new google.maps.Marker({ position: new google.maps.LatLng({{$dispositivo["lat"]}},
                                        {{$dispositivo["lng"]}}),
                                        map: map,
                                        icon: image,
                                        title: '{{$dispositivo["placa"]}}'
                                        });
        marker.setMap(map);
google.maps.event.clearInstanceListeners(marker);
		google.maps.event.addListener(marker, 'click', function() {
	  var direccion="Sin direccion";
    $.ajax({
                                          url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng={{$dispositivo["lat"]}},{{$dispositivo["lng"]}}&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI', 
                                          type: 'GET',
                                          async    : false,
                                          success: function(res) {
                                          direccion=res.results[0].formatted_address;
                                          }
                                      });
      var contentString = '<div>Placa:'+'{{$dispositivo["placa"]}}'+'<br>Marca:'+'{{$dispositivo["marca"]}}'+'<br>Color:{{$dispositivo["color"]}}'+'<br>Direccion:'+direccion+'</div>';
          var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                               });
                                            infowindow.open(map,this);
                                            info_.push(infowindow);
  },false);
//apartado para la placa --start
  var myOptions = {
    		disableAutoPan: false
    		,maxWidth: 0
    		,pixelOffset: new google.maps.Size(-40, -40)
    		,zIndex: null,
        closeBoxURL : "",
        position:new google.maps.LatLng({{$dispositivo["lat"]}}, {{$dispositivo["lng"]}}),
        infoBoxClearance: new google.maps.Size(1, 1),
    		isHidden: false,
    		pane: "floatPane",
    		enableEventPropagation: false
        
    	};
myOptions.content='<div class="info-box-wrap"><div class="info-box-text-wrap">{{$dispositivo["placa"]}}</div></div>';

var ibLabel = new InfoBox(myOptions);
ibLabel.open(map);
//apartado para la placa --end
           arreglo.push({'lat':{{$dispositivo["lat"]}},'infow':ibLabel,'lng':{{$dispositivo["lng"]}},'imei':{{$dispositivo["imei"]}},'marker':marker,'marca':'{{$dispositivo["marca"]}}','color':'{{$dispositivo["color"]}}','placa':'{{$dispositivo["placa"]}}','velocidad':mph,'recorrido':'{{$dispositivo["recorrido"]}}'});
        @endforeach	
        generar();
        @endif
  // parte de prueba




	}
  function generar()
  {
    if($('#posiciones_gps')!=undefined)
          {
                  var detalle=JSON.parse($("#posiciones_gps").val());
                  var areaCoordinates=[];
                for(var i=0;i<detalle.length;i++)
                {
                  var arreglo=[];
                  arreglo.push(detalle[i].lat);
                  arreglo.push(detalle[i].lng);
                  areaCoordinates.push(arreglo);
                }
                var pointCount = areaCoordinates.length;
                var areaPath = [];
                for (var i=0; i < pointCount; i++) {
                    var tempLatLng = new google.maps.LatLng(
                    areaCoordinates[i][0] , areaCoordinates[i][1]);
                    areaPath.push(tempLatLng);
                }
                var polygonOptions = 
                {
                    paths: areaPath,
                    strokeColor: '#FFFF00',
                    strokeOpacity: 0.9,
                    strokeWeight: 1,
                    fillColor: '#FFFF00',
                    fillOpacity: 0.09
                }
                polygon.setOptions(polygonOptions);
                polygon.setMap(map);
          }
  }
  @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
        setInterval(dispositivo, 5000);
       setInterval(dispositivo_estado, 5000);
       setInterval(dispositivo_Movimiento, 5000);
  @endif
        function dispositivo_Movimiento()
        {
          $.ajax({
                dataType : 'json',
                type     : 'POST', 
                url      : '{{ route('gpsmovimiento') }}',
                data : {
                  '_token' : $('input[name=_token]').val()
                  }
            }).done(function (result){
              //console.log(result);
              $("#activo_inactivo").html("<h4 >N° en Movimiento:"+result.activos+"</h4>"+"<h4 >N° sin Movimiento:"+result.inactivos+"</h4>");
            });
        }
        function dispositivo_estado()
        {
          $.ajax({
                dataType : 'json',
                type     : 'POST',
                url      : '{{ route('gpsestado') }}'
            }).done(function (result){
              for(var i=0;i<result.length;i++)
              {
                if(result[i].estado=="Conectado")
                {
                  $('#td_'+result[i].imei+' #estado_gps').html('<div class="circle_gps button" id="button-0"> </div><input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Conectado">');
                }
                else
                {
                  $('#td_'+result[i].imei+' #estado_gps').html('<div class="circle_gps_red button" id="button-0"> </div><input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Desconectado">');
                }
                if(result[i].movimiento=="Movimiento")
                {
                  $('#td_'+result[i].imei+' #movimiento_gps').html(' <img src="img/car-side.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/> ');
                }
                else
                {
                  $('#td_'+result[i].imei+' #movimiento_gps').html(' <img src="img/car-side_two.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/> ');
                }
              }
            });
        }
 	 //dispositivo();
	 function dispositivo()
       {
          $.ajax({
                dataType : 'json',
                type     : 'POST',
                url      : '{{ route('gps') }}'
            }).done(function (result){
		var i=0;	
		for(i=0;i<result.length;i++)
		{
	           var latlng = new google.maps.LatLng(result[i].lat,result[i].lng);
                   var indice=buscar(arreglo,parseInt(result[i].imei));
		   var cadena=result[i].cadena;
		   var velocidad = cadena.split(',');
        		var mph=(parseFloat(velocidad[11])*1.15078)*1.61;
	   	          arreglo[indice].marker.setPosition(latlng);
		         var placa=result[i].placa;
			  var  marca=result[i].marca;
		          var  modelo=result[i].modelo;
               arreglo[indice].placa=placa;
	       arreglo[indice].marca=marca;
	       arreglo[indice].color=result[i].color;
	       arreglo[indice].velocidad=mph;
	       arreglo[indice].lat=result[i].lat;
	       arreglo[indice].lng=result[i].lng;
         arreglo[indice].recorrido=result[i].recorrido;
         arreglo[indice].infow.setOptions({position: new google.maps.LatLng(result[i].lat,result[i].lng)});
         if(placa===placa_velocimetro)
         {
          ruta(result[i].imei,result[i].lat,result[i].lng,"1");
          document.querySelector(".gauge").querySelector(".gauge__fill").style.transform = `rotate(${
            (((mph*100)/200)/100) / 2
          }turn)`;
          document.querySelector(".gauge").querySelector(".gauge__cover").textContent = `${
            mph.toFixed(1)
          } Km/h`;
          document.querySelector(".gauge").querySelector(".dispositivo").textContent = placa;
          var kmre=(result[i].recorrido)/1000;
          var residuo;
          var division;
          var decimal=parseInt((kmre*10)%10);
          document.querySelector(".gauge").querySelector(".o_val6").textContent="."+decimal;
          for(var u=5;u>=1;u--)
          {
            residuo=parseInt(kmre%10);
            kmre=kmre/10;
            document.querySelector(".gauge").querySelector(".o_val"+u).textContent =residuo;
          }
         }
      google.maps.event.clearInstanceListeners(arreglo[indice].marker);
			google.maps.event.addListener(arreglo[indice].marker, 'click', function() {
                        var  nindice=buscarmarker(this)
				  var direccion="Sin direccion";
                                   $.ajax({
                                          url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+arreglo[nindice].lat+','
                                                +arreglo[nindice].lng+'&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI', 
                                          type: 'GET',
                                          async    : false,
                                          success: function(res) {
                                          direccion=res.results[0].formatted_address;
                                          }
                                      });
//console.log(markerposition);
//Direccion antes por evento
        /* var  geocoder=new google.maps.Geocoder(); 
                    var markerposition={
            lat: parseFloat(arreglo[nindice].lat),
            lng: parseFloat(arreglo[nindice].lng),
          };
        geocoder.geocode({'latLng':markerposition},function(results,status){
                if(status===google.maps.GeocoderStatus.OK)
                {
                 if(results){
                        arreglo[nindice].direccion=results[0].formatted_address;
        		//console.log("si lo encontro"+arreglo[nindice].imei);
			                    }
                  else 
                  {
                    console.log("no se  encontro");
                  }
                }
                else 
                {
                  console.log("fallo al buscar");
                }
		});
    */
      //var contentString = '<div>Placa:'+arreglo[nindice].placa+'<br>Marca:'+arreglo[nindice].marca+'<br>Color:'+arreglo[nindice].color+'<br>velocidad:'+arreglo[nindice].velocidad+'<br>Direccion:'+direccion+'</div>'
      var contentString = '<div>Placa:'+arreglo[nindice].placa+'<br>Marca:'+arreglo[nindice].marca+'<br>Color:'+arreglo[nindice].color+'<br>Direccion:'+direccion+'</div>'
          var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                               });
                                            infowindow.open(map,this);
                                            info_.push(infowindow);
  },false);
                   //console.log('imei'+result[i].imei+' posicion:'+indice);
		}
            });
       }
function buscarmarker(marker)
{
          var position=-1;
          var i=0;
          for( i=0;i<arreglo.length;i++)
          {
              if(_.isEqual(marker, arreglo[i].marker))
              {
                position=i;
              //  break;
              }
          }
          return position;
}
function buscar(data,elemento)
        {
          var position=-1;
          var i=0;
          for( i=0;i<data.length;i++)
          {
              if(data[i].imei===elemento)
              {
                position=i;
              //  break;
              }
          }
          return position;
        }
 	$("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
        function zoom(e){
          var existe;
          var imei=$(e).data('imei');
          var placa=$(e).data('placa');
          $.ajax({
                dataType : 'json',
                type     : 'POST',
                async    : false,
                url      : '{{ route('verificardispositivo') }}',
                data : {
                  '_token' : $('input[name=_token]').val(),
                  'imei' : imei
              }
            }).done(function (result){
              existe=result.existe;
            });
           var conexion= $('#td_'+imei+' #estado_dispositivo').val();
         if(conexion=="Conectado")
         {
                if(existe)
              {
                for(var t=0;t<info_.length;t++)
                {
                  info_[t].close();
                }
                var nindice=buscar(arreglo,parseInt($(e).data('imei')));
                var posicion=arreglo[nindice].marker.getPosition();
                var direccion="sin direccion";
                placa_velocimetro=placa;
                $.ajax({
                                          url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+arreglo[nindice].lat+','
                                                +arreglo[nindice].lng+'&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI', 
                                          type: 'GET',
                                          async    : false,
                                          success: function(res) {
                                          direccion=res.results[0].formatted_address;
                                          }
                                      });
                //var contentString = '<div>Placa:'+arreglo[nindice].placa+'<br>Marca:'+arreglo[nindice].marca+'<br>Color:'+arreglo[nindice].color+'<br>velocidad:'+arreglo[nindice].velocidad+'<br>Direccion:'+direccion+'</div>'
                var contentString = '<div>Placa:'+arreglo[nindice].placa+'<br>Marca:'+arreglo[nindice].marca+'<br>Color:'+arreglo[nindice].color+'<br>Direccion:'+direccion+'</div>'
          var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                               });
                                            infowindow.open(map,arreglo[nindice].marker);
                                            info_.push(infowindow);
              //  myLatlng = { lat: parseFloat($(e).data('lat')), lng: parseFloat($(e).data('lng'))};
                map.setZoom(16);
                map.setCenter(posicion);
                setGaugeValue(gaugeElement, (((arreglo[nindice].velocidad*100)/200)/100),arreglo[nindice].velocidad.toFixed(1),placa,(arreglo[nindice].recorrido/1000));
                ruta(arreglo[nindice].imei,arreglo[nindice].lat,arreglo[nindice].lng,"0");
              }
              else
              {
                toastr.warning('El Dispositivo se encuentra conectado pero su ubicacion estan en blanco', 'Mensaje');
              }
         }
        /*var indice=buscar(arreglo,parseInt($(e).data('imei')));
		    var posicion=arreglo[indice].marker.getPosition();
        //  myLatlng = { lat: parseFloat($(e).data('lat')), lng: parseFloat($(e).data('lng'))};
          map.setZoom(16);
          map.setCenter(posicion);*/
        }
        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        function eliminaruta(map) {
            for (let i = 0; i < polylines.length; i++) {
                polylines[i].setMap(map);
            }
        }
        function tiempo_format(fecha_actual)
        {
            var año=fecha_actual.getFullYear();
            var mes=(fecha_actual.getMonth()+1)<10 ? "0"+(fecha_actual.getMonth()+1):fecha_actual.getMonth();
            var dia=(fecha_actual.getDate())<10 ? "0"+(fecha_actual.getDate()):fecha_actual.getDate();
            var hora=(fecha_actual.getHours())<10 ? "0"+(fecha_actual.getHours()):fecha_actual.getHours();
            var minutos=(fecha_actual.getMinutes())<10 ? "0"+(fecha_actual.getMinutes()):fecha_actual.getMinutes();
            var segundos=(fecha_actual.getSeconds())<10 ? "0"+(fecha_actual.getSeconds()):fecha_actual.getSeconds();
            return año+"-"+mes+"-"+dia+" "+hora+":"+minutos+":"+segundos;
        }
        function addPolyline (lineCoordinates) {
                var pointCount = lineCoordinates.length;
                var linePath = [];
                for (var i=0; i < pointCount; i++) {
                      var tempLatLng = new google.maps.LatLng( lineCoordinates[i][0] , lineCoordinates[i][1]);
                          linePath.push(tempLatLng);
                }
              /*  var arrowSymbol = {
                      strokeColor: 'white',
                      fillOpacity: 1,
                      fillColor: '#404040',
                      scale: 0.9,
                      anchor: new google.maps.Point(10, 25),
                      path: "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0,5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729,0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417,10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018,37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328,35.805v-7.872l2.729-0.355v10.048L19.328,35.805z"
                    };*/
                var lineOptions = {
                      path: linePath,
                     /* icons: [{
                            icon: arrowSymbol,
                            offset: '100%'
                      }],*/
                      strokeWeight: 7,
                      strokeColor: '#FF0000',
                      strokeOpacity: 0.8
                }
                var polyline = new google.maps.Polyline(lineOptions);
                    polyline.setMap(map);
                    polylines.push(polyline);
               /* var counter = 0;
                var accessVar = window.setInterval(function() {
                    counter = (counter + 1) % 200;
                var arrows = polyline.get('icons');
                    arrows[0].offset = (counter / 2) + '%';
                    polyline.set('icons', arrows);
                }, 50);*/
        }
        function ruta(imei,lat,lng,envio_socket)
    {
      setMapOnAll(null);
      eliminaruta(null);
       // arreglo=[];
        markers=[];
        var fecha_actual=new Date();
        var fecha=tiempo_format(fecha_actual);
        var fecha_pasada=tiempo_format( new Date(fecha_actual.getTime() - 5*60000));
        $.ajax({
                dataType : 'json',
                type     : 'POST', 
                async    : false,
                url      : '{{ route('rmapa.dispositivoruta') }}',
                data : {
                  '_token' : $('input[name=_token]').val(),
                  'fecha_actual': fecha,
                  'fecha_pasada': fecha_pasada,
                  'imei': imei
                  }
            }).done(function (result){
                if(result.length!=0)
                { 
                    var arregloruta=[];
                    for(var i=0;i<(result.length-1);i++)
                    {
                        var cadena=result[i].cadena;
                        var velocidad = cadena.split(',');
                        var mph=(parseFloat(velocidad[11])*1.15078)*1.61;
                        var latlng=[];
                            latlng.push(result[i].lat);
                            latlng.push(result[i].lng);
                            arregloruta.push(latlng);
                        var marker = new google.maps.Marker({ position: new google.maps.LatLng(result[i].lat,result[i].lng),
                                        map: map,
                                        title:result[i].placa,
                                        });
                           /* arreglo.push({'lat':result[i].lat,
                                          'lng':result[i].lng,
                                          'marker':marker,
                                          'marca':result[i].marca,
                                          'color':result[i].color,
                                          'placa':result[i].placa,
                                          'velocidad':mph });
                            google.maps.event.addListener(marker, 'click', function() 
                              {
                                  var direccion="sin Direccion";
                                  var indice=buscarmarker(this);
                                      $.ajax({
                                          url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+arreglo[indice].lat+','
                                                +arreglo[indice].lng+'&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI', 
                                          type: 'GET',
                                          async    : false,
                                          success: function(res) {
                                          direccion=res.results[0].formatted_address;
                                          }
                                      });
                                  var contentString = '<div>Placa:'+arreglo[indice].placa+'<br>Marca:'+arreglo[indice].marca+'<br>Color:'+arreglo[indice].color+'<br>Direccion:'+direccion+'<br>Velocidad:'+arreglo[indice].velocidad+'</div>';
                                  var infowindow = new google.maps.InfoWindow({
                                                                  content: contentString,
                                                                  width:192,
                                                                  height:100
                                                              });
                                              infowindow.open(map,this);
                              },false);*/
                              markers.push(marker);
                    }      
                    var latlng=[];
                            latlng.push(lat);
                            latlng.push(lng);
                            arregloruta.push(latlng);  
                            var marker = new google.maps.Marker({ position: new google.maps.LatLng(result[i].lat,result[i].lng)});
                                        markers.push(marker);
                    var kmre=0;
                    for(var j=0;j<markers.length;j++)
                    {
                        if(j!=markers.length-1)
                        {
                           // console.log(markers[j].getIcon().path);
                          var heading = google.maps.geometry.spherical.computeHeading(markers[j].getPosition(),markers[j+1].getPosition());
                              kmre =kmre+ google.maps.geometry.spherical.computeDistanceBetween(markers[j].getPosition(),markers[j+1].getPosition());
                          var image;
                            if(heading==0)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_0.png",
                                            };
                            }
                            else if(heading>0 && heading<45)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_22.png",
                                        };
                            }
                            else if(heading==45)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_45.png",
                                        };
                            }
                            else if(heading>45 && heading<90)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_67.png",
                                        };
                            }
                            else if(heading==90)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_90.png",
                                        };
                            }
                            else if(heading>90 && heading<135)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_112.png",
                                        };
                            }
                            else if(heading==135)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_135.png",
                                        };
                            }
                            else if(heading>135 && heading<180)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_157.png",
                                        };
                            }
                            else if(heading==180 || heading==-180)
                            {
                                image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_180.png",
                                        };
                            }
                            else if(heading<0 && heading>-45)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_N22.png",
                                        };
                            }
                            else if(heading==-45)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_N45.png",
                                        };
                            }
                            else if(heading<-45 && heading>-90)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_N67.png",
                                        };
                            }
                            else if(heading==-90)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_N90.png",
                                        };
                            }
                            else if(heading<90 && heading>-135)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_N112.png",
                                        };
                            }
                            else if(heading==-135)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_N135.png",
                                        };
                            }
                            else if(heading<-135 && heading>-180)
                            {
                                 image ={
                                    url:"https://aseguroperu.com/img/rotation/gpa_prueba_N157.png",
                                        };
                            }
                            image.scaledSize= new google.maps.Size(40, 40);
                            image.origin=new google.maps.Point(0,0);
                             markers[j].setIcon(image);
                         }
                    }
                   /* if(((arregloruta.length)%2)==0)
                    { 
                        //console.log((arregloruta.length)/2);
                    map.setCenter(new google.maps.LatLng(arregloruta[(arregloruta.length)/2][0],
                        arregloruta[(arregloruta.length)/2][1]));
                        map.setZoom(18);
                    }
                    else
                    {
                        map.setCenter(new google.maps.LatLng(arregloruta[(((arregloruta.length)/2)+0.5)][0],
                        arregloruta[(((arregloruta.length)/2)+0.5)][1]));
                        map.setZoom(18);
                    }*/
                    addPolyline (arregloruta);
                  /*  var suma=0.0;
                    for(var t=0;t<arreglo.length;t++)
                    {
                      suma=suma+parseFloat(arreglo[t].velocidad);
                    }
                    kmre=kmre/1000;
                 document.querySelector(".gauge").querySelector(".gauge__fill").style.transform = `rotate(${
                              (((suma*100)/200)/100) / 2
                            }turn)`;
                            document.querySelector(".gauge__cover").textContent = `${
                              suma.toFixed(1)
                            } Km/h`;
                  var residuo;
                  var division;
                  var decimal=parseInt((kmre*10)%10);
                  document.querySelector(".gauge").querySelector(".o_val4").textContent="."+decimal;
                  for(var i=3;i>=1;i--)
                  {
                    residuo=parseInt(kmre%10);
                    kmre=kmre/10;
                    document.querySelector(".gauge").querySelector(".o_val"+i).textContent =residuo;
                  }*/
                }
                else
                {
                  if(envio_socket=="0")
                  {
                     toastr.warning('El dispositivo no se ha movido desde 5 minutos', 'Mensaje');
                  }
                }
            });
    }
  </script>

@endpush
