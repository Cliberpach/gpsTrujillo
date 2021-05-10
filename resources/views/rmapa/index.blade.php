@extends('layout')
 @section('content')
 @section('gps-active', 'active')
@section('reportesruta-active', 'active')
    <div id="map" style="height:800px;">
   </div>
      <div id="legend" style="margin:20px;">
        <div class="wrapper">
          <div class="search-input">
            <input type="text" placeholder="Escriba Placa....">
                <div class="autocom-box">
                  <!-- here list are inserted from javascript -->
                </div>
                <div class="icon"><i class="fa fa-search"></i></div>
              </div>
        </div> 
      </div>
            <div class="gauge" id="odometro">
        <div class="gauge__body">
          <div class="gauge__fill"></div>
          <div class="gauge__cover"></div>
          <div class="odometro">
              <div class="o_val1">0</div>
              <div class="o_val2">0</div>
              <div class="o_val3">0</div>
              <div class="o_val4">.0</div>
          </div>
        </div>
      </div>
     <!-- Contenido del Sistema -->
    <!-- /.Contenido del Sistema -->
<!--<div id="map" style="height:800px;">-->
@stop
@push('styles-mapas')
<style>
/* 
 */
.gauge {
  width: 200px;
  max-width: 250px;
  margin:0px 0px 60px 0px;
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
  top: 25%;
  left: 50%;
  transform: translateX(-50%);
  /* Text */
  display: flex;
  padding:14px 0px 0px 0px;
  justify-content: center;
  font-size:20px;
  box-sizing: border-box;
}
.odometro
{
  height:30px;
  border:solid;
  position:absolute;
  display: grid;
  background-color:black;
  color:white;
  font-size:20px;
  border-radius: 8px;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 10px;
  grid-auto-rows: minmax(100px, auto);
  top:66%;
  left:29%;
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


::selection{
  color: #fff;
  background: #664AFF;
}
 .wrapper{
  max-width: 450px;
 }
 .wrapper .search-input{
  background: #fff;
  width: 100%;
  border-radius: 5px;
  position: relative;
  box-shadow: 0px 1px 5px 3px rgba(0,0,0,0.12);
}
 .search-input input{
  height: 40px;
  width: 100%;
  outline: none;
  border: none;
  border-radius: 5px;
  padding: 0 60px 0 20px;
  font-size: 18px;
  box-shadow: 0px 1px 5px rgba(0,0,0,0.1);
}
 .search-input.active input{
  border-radius: 5px 5px 0 0;
}
 .search-input .autocom-box{
  padding: 0;
  opacity: 0;
  pointer-events: none;
  max-height: 280px;
  overflow-y: auto;
}
 .search-input.active .autocom-box{
  padding: 10px 8px;
  opacity: 1;
  pointer-events: auto;
}
 .autocom-box li{
  list-style: none;
  color:black;
  font-size:18px;
  padding: 8px 12px;
  display: none;
  width: 100%;
  cursor: default;
  border-radius: 3px;
}
 .search-input.active .autocom-box li{
  display: block;
}
.autocom-box li:hover{
  background: #efefef;
}
 .search-input .icon{
  position: absolute;
  right: 0px;
  top: 0px;
  height: 40px;
  width: 40px;
  text-align: center;
  line-height: 40px;
  font-size: 20px;
  color: #644bff;
  cursor: pointer;
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
</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endpush
@push('scripts-mapas')
<script>
let suggestions =[];
var polylines=[];
var arreglo=[];

$(document).ready(function() {
  var gaugeElement = document.querySelector(".gauge");
  setGaugeValue(gaugeElement, 0,0,0);
    $.ajax({
                dataType : 'json',
                type     : 'POST', 
                async    : false,
                url      : '{{ route('rmapa.dispositivos') }}',
                data : {
                  '_token' : $('input[name=_token]').val(),
                  }
            }).done(function (result){
                for(var i=0;i<result.length;i++)
                {
                    suggestions.push(result[i].placa);
                }
            });
});

 const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");
const icon = searchWrapper.querySelector(".icon");
 // if user press any key and release
inputBox.onkeyup = (e)=>{
    let userData = e.target.value; //user enetered data
    let emptyArray = [];
    if(userData){
        icon.onclick = ()=>{
            ruta();
        }
        emptyArray = suggestions.filter((data)=>{
            //filtering array value and user characters to lowercase and return only those words which are start with user enetered chars
            return data.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase()); 
        });
        emptyArray = emptyArray.map((data)=>{
            // passing return data inside li tag
            return data = '<li>'+ data +'</li>';
        });
        searchWrapper.classList.add("active"); //show autocomplete box
        showSuggestions(emptyArray);
        let allList = suggBox.querySelectorAll("li");
        for (let i = 0; i < allList.length; i++) {
            //adding onclick attribute in all li tag
            allList[i].setAttribute("onclick", "select(this)");
        }
    }else{
        searchWrapper.classList.remove("active"); //hide autocomplete box
    }
}
 function select(element){
    let selectData = element.textContent;
    inputBox.value = selectData;
    icon.onclick = ()=>{
        ruta();
    }
    searchWrapper.classList.remove("active");
}
 function showSuggestions(list){
    let listData;
    if(!list.length){
        userValue = inputBox.value;
        listData = '<li>'+ userValue +'</li>';
    }else{
        listData = list.join('');
    }
    suggBox.innerHTML = listData;
}
      var arreglo=[];
      var map;
      var markers=[];
      var polygon;
    function initMap() {
      polygon = new google.maps.Polygon();
          map = new google.maps.Map(document.getElementById("map"), {
                                  zoom: 12,
                                  center: { lat: -8.1092027, lng: -79.0244529 },
                                  gestureHandling: "greedy",
                                  });
                                  const legend = document.getElementById("legend");
      map.controls[google.maps.ControlPosition.TOP_CENTER].push(legend);
      const odometro = document.getElementById("odometro");
      map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(odometro);
    }
    function ruta()
    {
        arreglo=[];
        var fecha_actual=new Date();
        var fecha=tiempo_format(fecha_actual);
        var placa=inputBox.value;
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
                  'placa': placa
                  }
            }).done(function (result){
                if(result.length!=0)
                { 
                    var arregloruta=[];
                    setMapOnAll(null);
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
                            arreglo.push({'lat':result[i].lat,
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
                              },false);
                              markers.push(marker);
                    }
                    var latlng=[];
                    var imagen ={url:"https://aseguroperu.com/img/e.png",scaledSize: new google.maps.Size(50, 50)};
                        latlng.push(result[result.length-1].lat);
                        latlng.push(result[result.length-1].lng);
                        arregloruta.push(latlng);
                    var marker = new google.maps.Marker({ position: new google.maps.LatLng(result[result.length-1].lat,result[result.length-1].lng),
                                        map: map,
                                        icon:imagen
                                        });
                    var contentString = '<div>Placa:'+result[result.length-1].placa+'</div>';
                    var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                               });
                        infowindow.open(map,marker);
                        google.maps.event.addListener(marker, 'click', function()
                           {
                            var contentString = '<div>Placa:'+result[result.length-1].placa+'</div>';
                            var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                              });
                                infowindow.open(map,this);
                            });
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
                    eliminaruta(null);
                    if(((arregloruta.length)%2)==0)
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
                    }
                    addPolyline (arregloruta);
                    var suma=0.0;
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
                  }
                }
                else
                {
                    toastr.warning('Datos Vacios', 'Mensaje');
                }
            });
    }
function setGaugeValue(gauge, value,km,kmr) {
  if (value < 0 || value > 1) {
    return;
  }
  gauge.querySelector(".gauge__fill").style.transform = `rotate(${
    value / 2
  }turn)`;
  gauge.querySelector(".gauge__cover").textContent = `${
    km
  } Km/h`;
  var kmre=kmr;
  var residuo;
  var division;
  var decimal=parseInt((kmre*10)%10);
  gauge.querySelector(".o_val4").textContent="."+decimal;
  for(var i=3;i>=1;i--)
  {
  	residuo=parseInt(kmre%10);
    kmre=kmre/10;
    gauge.querySelector(".o_val"+i).textContent =residuo;
  }
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
    function addPolyline (lineCoordinates) {
                var pointCount = lineCoordinates.length;
                var linePath = [];
                for (var i=0; i < pointCount; i++) {
                var tempLatLng = new google.maps.LatLng( 
                lineCoordinates[i][0] , lineCoordinates[i][1]
                );
                linePath.push(tempLatLng);
                }
            var arrowSymbol = {
                strokeColor: 'white',
                fillOpacity: 1,
                fillColor: '#404040',
                scale: 0.9,
                anchor: new google.maps.Point(10, 25),
                path: "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0,5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729,0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417,10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018,37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328,35.805v-7.872l2.729-0.355v10.048L19.328,35.805z"
                 };
                var lineOptions = {
                path: linePath,
                icons: [{
                icon: arrowSymbol,
                offset: '100%'
                }],
                strokeWeight: 7,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8
                }
                var polyline = new google.maps.Polyline(lineOptions);
                polyline.setMap(map);
                polylines.push(polyline);
               var counter = 0;
                var accessVar = window.setInterval(function() {
                counter = (counter + 1) % 200;
                var arrows = polyline.get('icons');
                arrows[0].offset = (counter / 2) + '%';
                polyline.set('icons', arrows);
                }, 50);
        }
   </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&libraries=geometry&callback=initMap" async
></script>
@endpush
