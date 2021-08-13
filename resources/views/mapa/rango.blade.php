@extends('layout') @section('content')
@section('gps-active', 'active')
@section('rango-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Mantenimiento de Rango</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Rango</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{ route('mapas.agregar_rango') }}" method="POST">
    @csrf
    <div class="row">
  
        @csrf

        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
               
                  <div class="row">
                    <div class="col-lg-7">
                    <div class="card text-center">
                            <div class="card-header bg-primary">
                                Localizacion-Rango
                            </div>
                            <div class="card-body">
                                <div id="map" style="height:500px;">
                                </div>         
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card text-center">
                                    <div class="card-header bg-primary">
                                        Posiciones
                               
                                    </div>
                                <div class="card-body" >
                                <label class="required">Posicion</label>
                                <select id="posicion" name="posicion" class="select2_form form-control" onchange="verlatlng(this)">
                                <option></option>
                                 </select>
                                 <div class="row">
                                     <div class="col-lg-6">
                                     <label class="required">Latitud</label>
                                     <input type="text" id="lat" name="lat" class="form-control" readonly>
                                     </div>
                                     <div class="col-lg-6">
                                     <label class="required">Longitud</label>
                                     <input type="text" id="lng" name="lng" class="form-control" readonly>
                                     </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4"><button id="btncambiar" type="button" onclick="modificar()" class="btn btn-block btn-w-m btn-primary m-t-md"><i class="fa fa-plus-square"></i> Cambiar</button></div>

                                    <div class="col-lg-4"><button id="btnguardar" type="submit" class="btn btn-block btn-w-m btn-primary m-t-md">Guardar</button></div>
                                 </div>

                                </div>
                     
                             
                                </div>
                        
                      
                        
                  </div>            
                
            </div>
        </div>
        <input type="hidden" name="posiciones_guardar" id="posiciones_guardar">

     </div>
    </div>
    </form>
    @if(is_array(rangos()) || is_object(rangos()))
    <input type="hidden" name="posiciones_gps" id="posiciones_gps" value="{{rangos()}}">
    @endif
</div>
@stop
@push('styles')
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endpush 
@push('scripts')
<!-- DataTable -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script>
$(document).ready(function()
        {
          
$(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            }); 

        
        });
    var map;
    var markers=[];
    var polygon;
    function verlatlng(e)
    {
       var cbnposicion=$(e);
       if(cbnposicion.val()!="")
       {
        $("#lat").val(markers[cbnposicion.val()].getPosition().lat());
       $("#lng").val(markers[cbnposicion.val()].getPosition().lng())
        $("#lat").removeAttr("readonly");
        $("#lng").removeAttr("readonly");
       }
       else 
       {
        $("#lat").val(" ");
       $("#lng").val(" ");
       $("#lat").prop('readonly', true);
       $("#lng").prop('readonly', true);
       }
     
    }
    function modificar()
    {
        var cbnposicion=$("#posicion").val();
        if(cbnposicion!="")
        {
            var lat=$("#lat").val();
            var lng=$("#lng").val();
            markers[cbnposicion].setPosition(new google.maps.LatLng(parseFloat(lat),parseFloat(lng)));
            generar();
        }
        
      

    }
 
    function initMap() {
          polygon = new google.maps.Polygon();
          map = new google.maps.Map(document.getElementById("map"), {
                                  zoom: 12,
                                  center: { lat: -8.1092027, lng: -79.0244529 },
                                  gestureHandling: "greedy",
                                  });
           
           google.maps.event.addListener(map, 'click', function(event) {
                    startLocation = event.latLng;
                   
                        var marker=  new google.maps.Marker({
                            position: startLocation,
                            map:map,
                            draggable:true,
                            });
                            google.maps.event.addListener(marker, 'dragend', function() {
                                  var posicion = movimiento(this);
                                   generar();                       
                            });
                            markers.push(marker);
                            generar();
                            agregar();
                            
                    
                 
          });

          if($('#posiciones_gps')!=undefined)
          {
          var detalle=JSON.parse($("#posiciones_gps").val());
            for(var i=0;i<detalle.length;i++)
            {
                var marker=  new google.maps.Marker({
                            position: new google.maps.LatLng(parseFloat(detalle[i].lat),parseFloat(detalle[i].lng)),
                            map:map,
                            draggable:true,
                            });
                            google.maps.event.addListener(marker, 'dragend', function() {
                                  var posicion = movimiento(this);
                                   generar();                           
                            });
                            markers.push(marker);
                            generar();
                            agregar();
                            guardar();
            }
          }
     
	}

    function movimiento(marker)
    {   var posicion=-1;
        for(var i=0;i<markers.length;i++)
        {
            if(markers[i]===marker)
            {
                posicion=i;
                
            }
        }
        return posicion;
    }
    function agregar()
    {
        var posicion=$("#posicion");
        var html="<option></option>";
        for(var i=0;i<markers.length;i++)
        {
            html=html+"<option value='"+i+"'>"+(i+1)+"-Posicion</option>";
        }
        posicion.html(html);
    }
    function generar()
    {
        var areaCoordinates=[];
        for(var i=0;i<markers.length;i++)
        {
          var arreglo=[];
          arreglo.push(markers[i].getPosition().lat());
          arreglo.push(markers[i].getPosition().lng());
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
            fillOpacity: 0.20
        }
        
        polygon.setOptions(polygonOptions);
        polygon.setMap(map);
        guardar();
        
    }
    function guardar()
    {
         var arreglo=[];
         for(var i=0;i<markers.length;i++)
         {
             var latlng=[];
             latlng.push(markers[i].getPosition().lat());
             latlng.push(markers[i].getPosition().lng());
             arreglo.push(latlng);
         }
        $('#posiciones_guardar').val(JSON.stringify(arreglo));
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{gpsKey()}}&libraries=geometry&callback=initMap" async
></script>
@endpush