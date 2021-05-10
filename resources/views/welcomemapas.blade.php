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
      
       Echo.channel('dispositivo{{auth()->user()->id}}')
           .listen('WebsocketDemoEvent', (e) => {
              console.log(e)
           });
          
  </script>

@endpush
@section('s-mapa')
<script>
    window.PUSHER_APP_KEY = '{{ config('broadcasting.connections.pusher.key') }}';
    window.APP_DEBUG = {{ config('app.debug') ? 'true' : 'false' }};
</script>
<script  src="{{ asset('js/app.js') }}" ></script>
@endsection
