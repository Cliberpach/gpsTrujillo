@extends('layouts.app')
@section('content')
<div class="loader-spinner">
    <div class="centrado" id="onload">
        <div class="loadingio-spinner-blocks-zcepr5tohl">
            <div class="ldio-6fqlsp2qlpd">
                <div style='left:38px;top:38px;animation-delay:0s'></div>
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
<div id="content-system" style="display:none;">
    <div class="container-fluid">
        <div class="row" style="background-color: white">
            @if(verificarempresaloginlarge())
            <div class="col-lg-6 col-md-6 d-none d-md-block" style="height:100vh;background: url('{{Storage::url(empresacolor()->ruta_logo_large)}}');
            background-size: cover;"></div>
            @else

            <div class="col-lg-6 col-md-6 d-none d-md-block" style="height:100vh;background: url('/img/banner_ecovalle.jpeg');
            background-size: cover;">
            </div>
            @endif
            <div class="col-lg-6 col-md-6 form-container" style="background-color: white">
                <div class="login">
                    <div class="text-center">
                        @if(verificarempresaloginicon())
                        <img src="{{Storage::url(empresacolor()->ruta_logo_icon)}}" width="200" class="img-responsive m-b">
                        @else
                          <img src="{{asset('img/e.png')}}" width="200" class="img-responsive m-b">
                        @endif

                    </div>



                    <h3>SISTEMA GPS TRACKER</h3>

                    <p>
                        Ingresa tus datos para Iniciar Sesión.
                    </p>
                    <form class="m-t container form-login" role="form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group input_login">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo Electrónico"  >
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group input_login">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="btn-iniciar input_login">
                            <button type="submit" class="btn btn-primary block full-width m-b btn-margin-sesion">Iniciar Sesión</button>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" ><small>¿Olvidaste tu Contraseña?</small></a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
