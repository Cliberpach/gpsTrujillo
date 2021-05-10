@extends('layout')
 @section('content')
 <div class="row" style="background:white;">
   <div class="col-lg-3" style="padding:0px;">
    <div style="margin:10px;">
      <input class="form-control" id="myInput" type="text" placeholder="Search..">
    </div>
    <table class="table table-bordered">
      <thead>
    
      </thead>

      <tbody id="myTable">
        @foreach (dispositivo_user(auth()->user()) as $dispositivo)
        <tr  data-lat="{{$dispositivo->lat}}" data-lng="{{$dispositivo->lng}}" onclick="zoom(this)">
          <td id=""><div class="row">
            <div class="col-lg-3">
                <i class="fa fa-car fa-3x circle" style="color:rgb(82, 83, 87);" aria-hidden="true">
                  </i>
              </div>
            <div class="col-lg-9">
              <b>Placa:</b>{{$dispositivo->placa}} <br>
              <b>Marca:</b>{{$dispositivo->marca}} <br>
              <b>Modelo:</b>{{$dispositivo->modelo}} <br>
            </div>
          </div></td>
        </tr>
        @endforeach

      </tbody>
    </table>
   </div>
   <div class="col-lg-9" style="padding:0px;">
<div id="map" style="height:800px;">
   </div>
 </div>
    <!-- Contenido del Sistema -->
    <!-- /.Contenido del Sistema -->
<!--<div id="map" style="height:800px;">-->
@stop
@push('styles-mapas')
<style>
.circle {
  display: inline-block;
  border-radius: 60px;
  box-shadow: 0px 0px 2px #888;
  padding: 0.3em 0.3em;
}
</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endpush
@push('scripts-mapas')
<script>
      var map;
    function initMap() {
     map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: { lat: -8.1092027, lng: -79.0244529 },
        gestureHandling: "greedy",
      });
    
    /*  if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
          function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
          //Creating LatLng object with latitude and 
          //longitude.
          var devCenter = new google.maps.LatLng(lat, lng);
          map.setCenter(devCenter);
          map.setZoom(10);
          });
        }*/
        const image = {
                    url:
                      "img/markerg.png",
                    // This marker is 20 pixels wide by 32 pixels high.
                    size: new google.maps.Size(40, 32),
                    // The origin for this image is (0, 0).
                    origin: new google.maps.Point(0, 0),
                    // The anchor for this image is the base of the flagpole at (0, 32).
                    anchor: new google.maps.Point(0, 32),
                    };
        @foreach (dispositivo_user(auth()->user()) as $dispositivo)
       
          var marker = new google.maps.Marker({
          position: new google.maps.LatLng({{$dispositivo->lat}}, {{$dispositivo->lng}}),
          map: map,
          icon: image,
          title: '{{$dispositivo->nombre}}'
          });
          marker.setMap(map);

          google.maps.event.addListener(marker, 'click', function() {
            var contentString = '<div>Dispotivo'+'{{$dispositivo->nombre}}'+'</div>';
          var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                               });
		                            infowindow.open(map,this);
     	                                 });
          
        @endforeach
    }
    
        $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
        function zoom(e){
        
          myLatlng = { lat: parseFloat($(e).data('lat')), lng: parseFloat($(e).data('lng'))};
          map.setZoom(16);
          map.setCenter(myLatlng);
        }

  </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&callback=initMap" async
></script>

@endpush
@section('s-mapa')
<script>
    window.PUSHER_APP_KEY = '{{ config('broadcasting.connections.pusher.key') }}';
    window.APP_DEBUG = {{ config('app.debug') ? 'true' : 'false' }};
</script>
<script  src="{{ asset('js/app.js') }}" ></script>
<script>
   
   Echo.channel('home')
.listen('StockDisponibleEvent', (e) => {
console.log(window.Echo);
});
   
</script>
@endsection
