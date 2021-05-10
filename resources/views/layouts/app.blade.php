<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GPS Tracker</title>
    @if(verificarempresaloginicon())
  
  <link rel="icon" href="{{Storage::url(empresacolor()->ruta_logo_icon)}}" />
  @else
  <link rel="icon" href="{{asset('img/e.png')}}" />
  @endif
    <!-- Scripts -->
    <link href="{{asset('Inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{asset('Inspinia/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
</head>
<body>
    
                        @guest
                            @if (Route::has('register'))
                                @yield('content')
                            @endif
                        @endguest
</body>
<script src="{{asset('Inspinia/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('Inspinia/js/popper.min.js')}}"></script>
<script src="{{asset('Inspinia/js/bootstrap.js')}}"></script>
<!-- Toastr script -->
<script src="{{asset('Inspinia/js/plugins/toastr/toastr.min.js')}}"></script>
<script>
     @auth        
            window.location = "{{ route('home')  }}";            
     @endauth
    window.addEventListener("load",function(){
        $('.loader-spinner').hide();
        $("#content-system").css("display", "");
    })
</script>
<!-- Propio scripts -->
<script src="{{ asset('Inspinia/js/scripts.js') }}"></script>
</html>
