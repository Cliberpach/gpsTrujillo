<div class="wrapper wrapper-content animated fadeIn">
    <form class="wizard-big" action="{{ $action }}" method="POST" id="form_registrar_empresa" enctype="multipart/form-data">
        @csrf
        <h1>Datos De La Empresa</h1>
        <fieldset  style="position: relative;">
            <div class="row">
                <div class="col-md-6 b-r">
                    <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Ruc</label>
                            <div class="input-group">
                                <input type="text" id="ruc" name="ruc" class="form-control {{ $errors->has('ruc') ? ' is-invalid' : '' }}" value="{{old('ruc')?old('documento'):$empresa->ruc}}"  onkeypress="return isNumber(event)" required>
                                @if ($errors->has('ruc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ruc') }}</strong>
                                    </span>
                                @endif
                                <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 col-xs-12">
                            <label class="" id="">Nombre Comercial</label>
                            <input type="text" id="nombre_comercial" name="nombre_comercial" class="form-control {{ $errors->has('nombre_comercial') ? ' is-invalid' : '' }}" value="{{old('nombre_comercial')?old('nombre_comercial'):$empresa->nombre_comercial}}" maxlength="191" onkeyup="return mayus(this)">
                            @if ($errors->has('nombre_comercial'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre_comercial') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="hidden" id="codigo_verificacion" name="codigo_verificacion">
                    </div>
                    <div class="form-group">
                        <label class="required" id="lblNombre">Razon Social</label>
                        <input type="text" id="razon_social" name="razon_social" class="form-control {{ $errors->has('razon_social') ? ' is-invalid' : '' }}" value="{{old('razon_social')?old('razon_social'):$empresa->razon_social}}" maxlength="191" onkeyup="return mayus(this)" required>
                        @if ($errors->has('razon_social'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('razon_social') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Teléfono móvil</label>
                            <input type="text" id="telefono_movil" name="telefono_movil" class="form-control {{ $errors->has('telefono_movil') ? ' is-invalid' : '' }}" value="{{old('telefono_movil') ? old('telefono_movil') : $empresa->telefono_movil}}" onkeypress="return isNumber(event)" maxlength="9" required>
                            @if ($errors->has('telefono_movil'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('telefono_movil') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                 <div class="form-group">
                        <label class="required">Dirección Fiscal</label>
                        <input type="text" id="direccion_fiscal" name="direccion_fiscal" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{old('direccion_fiscal')?old('direccion_fiscal'):$empresa->direccion_fiscal}}" maxlength="191" onkeyup="return mayus(this)" required>
                        @if ($errors->has('direccion_fiscal'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('direccion_fiscal') }}</strong>
                            </span>
                        @endif
                    </div>
                        <div class="form-group">
                            <label class="required">Direccion </label>
                            <input type="text" id="direccion" name="direccion" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{old('direccion') ? old('direccion') : $empresa->direccion}}" maxlength="191" onkeyup="return mayus(this)" required>
                                @if ($errors->has('direccion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                @endif  
                        </div>

                        <div class="form-group">
                   
                           <div class="row">
                               <div class="col-lg-3">
                                      <input type="hidden" name="color" id="color" value="{{ $empresa->color==null ? ('rgba(26,179,148,1)'): $empresa->color}}">
                                     <button type="button" class="btn btn-primary" id="btn-color">Cambiar color</button>   
                                 
                               </div>
                               <div class="col-lg-1">
                               <div class="color-pickers"> </div>
                            </div>
                           </div>
                                
                     
                                 
                      
                        </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group row">
                        <div class="col-md-12">
                            <label id="logo_label">Logo:</label>
                            <div class="custom-file">
                                <input id="logo" type="file" name="logo" onchange="seleccionarimagen()"
                                    class="custom-file-input {{ $errors->has('logo') ? ' is-invalid' : '' }}"
                                    accept="image/*" {{$empresa->ruta_logo ?   'src='.Storage::url($empresa->ruta_logo).'': ''}}>
                                <label for="logo" id="logo_txt" name="logo_txt"
                                    class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}">{{$empresa->nombre_logo ? $empresa->nombre_logo : 'Seleccionar'}}</label>
                                @if ($errors->has('logo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                                @endif
                                <div class="invalid-feedback"><b><span id="error-logo_empresa"></span></b></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a href="javascript:void(0);" id="limpiar_logo" onclick="limpiar()">
                                    <span class="badge badge-danger">x</span>
                                </a>
                            </div>
                            <div class="row justify-content-center">
                                <p>
                                    @if($empresa->ruta_logo)
                                    <img class="logo" src="{{Storage::url($empresa->ruta_logo)}}" alt="">
                                    <input id="url_logo" name="url_logo" type="hidden"
                                        value="{{$empresa->ruta_logo}}">
                                    @else
                                    <img class="logo" src="{{asset('storage/empresas/logos/default.jpg')}}"
                                        alt="">
                                    <input id="url_logo" name="url_logo" type="hidden" value="">
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="required">Correo electrónico</label>
                        <input type="email" id="correo_electronico" name="correo_electronico" class="form-control {{ $errors->has('correo_electronico') ? ' is-invalid' : '' }}" value="{{old('correo_electronico') ? old('correo_electronico') : $empresa->correo_electronico}}" maxlength="100" required>
                        @if ($errors->has('correo_electronico'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('correo_electronico') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row col-lg-6">

                        <label class="required">Contaseña</label>
                        <input type="email" id="contraseña" name="contraseña" class="form-control {{ $errors->has('contraseña') ? ' is-invalid' : '' }}" value="{{old('contraseña') ? old('contraseña') : $empresa->contraseña}}" maxlength="100" required>
                        @if ($errors->has('contraseña'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('contraseña') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
        </fieldset>
        <h1>Datos De la Empresa</h1>
        <fieldset  style="position: relative;">
            <div class="row">
                <div class="col-md-6 b-r">
                    <h3>REDES SOCIALES</h3>
                    <div class="form-group">
                            <label class="">Facebook:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-facebook"></i>
                                    </span>
                                    <input type="text" id="facebook" name="facebook"
                                        class="form-control {{ $errors->has('facebook') ? ' is-invalid' : '' }}" onkeyup="return mayus(this)"   value="{{old('facebook') ? old('facebook') : $empresa->facebook}}">
                                        @if ($errors->has('facebook'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('facebook') }}</strong>
                                        </span>
                                        @endif
                                </div>
                    </div>
                    <div class="form-group">
                            <label class="">Whatsapp:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-whatsapp"></i>
                                </span>
                                <input type="text" id="whatsapp" name="whatsapp"
                                    class="form-control {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" onkeyup="return mayus(this)"  value="{{old('whatsapp') ? old('whatsapp') : $empresa->whatsapp}}" >
                                    @if ($errors->has('whatsapp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('whatsapp') }}</strong>
                                    </span>
                                    @endif
                            </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label id="logo_label">Logo login:</label>
                            <div class="custom-file">
                                <input id="logo_large" type="file" name="logo_large" onchange="seleccionarimagen_large()"
                                    class="custom-file-input {{ $errors->has('logo_large') ? ' is-invalid' : '' }}"
                                    accept="image/*" {{$empresa->ruta_logo_large ?   'src='.Storage::url($empresa->ruta_logo_large).'': ''}}>
                                <label for="logo_large" id="logo_large_txt" name="logo_large_txt"
                                    class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}">{{$empresa->nombre_logo_large ? $empresa->nombre_logo_large : 'Seleccionar'}}</label>
                                @if ($errors->has('logo_large'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('logo_large') }}</strong>
                                </span>
                                @endif
                                <div class="invalid-feedback"><b><span id="error-logo_empresa"></span></b></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a href="javascript:void(0);" id="limpiar_logo_large" onclick="limpiar_large()">
                                    <span class="badge badge-danger">x</span>
                                </a>
                            </div>
                            <div class="row justify-content-center">
                                <p>
                                    @if($empresa->ruta_logo_large)
                                    <img class="logo_large" src="{{Storage::url($empresa->ruta_logo_large)}}" alt="">
                                    <input id="url_logo_large" name="url_logo_large" type="hidden"
                                        value="{{$empresa->ruta_logo_large}}">
                                    @else
                                    <img class="logo_large" src="{{asset('storage/empresas/logos/default.jpg')}}"
                                        alt="">
                                    <input id="url_logo_large" name="url_logo_large" type="hidden" value="">
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 b-r">
                    <h3>Datos de la api</h3>
                    <div class="form-group">
                        <label class="">api dni</label>
                        <input type="text" id="token_dni" name="token_dni" class="form-control {{ $errors->has('token_dni') ? ' is-invalid' : '' }}" value="{{old('token_dni') ? old('token_dni') : $dni->token}}" maxlength="191" onkeyup="return mayus(this)">
                            @if ($errors->has('token_dni'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('token_dni') }}</strong>
                                </span>
                            @endif
                      </div>
                      <div class="form-group row">
                        <div class="col-lg-12 col-xs-12">
                            <label class="required">api ruc</label>
                            <div class="input-group">
                                <input type="text" id="token_ruc" name="token_ruc" class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" value="{{old('token_ruc')?old('token_ruc'):$ruc->token}}"  onkeypress="return isNumber(event)" required>
                                @if ($errors->has('token_ruc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('token_ruc') }}</strong>
                                    </span>
                                @endif
                                <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12 col-xs-12">
                            <label class="required">api mapa</label>
                            <div class="input-group">
                                <input type="text" id="token_mapa" name="token_mapa" class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" value="{{old('token_mapa')?old('token_mapa'):$mapa->token}}"  required>
                                @if ($errors->has('token_mapa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('token_mapa') }}</strong>
                                    </span>
                                @endif
                                <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label id="logo_label">Login logo icon:</label>
                            <div class="custom-file">
                                <input id="logo_icon" type="file" name="logo_icon" onchange="seleccionarimagen_icon()"
                                    class="custom-file-input {{ $errors->has('logo_icon') ? ' is-invalid' : '' }}"
                                    accept="image/*" {{$empresa->ruta_logo_icon ?   'src='.Storage::url($empresa->ruta_logo_icon).'': ''}}>
                                <label for="logo_icon" id="logo_icon_txt" name="logo_icon_txt"
                                    class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}">{{$empresa->nombre_logo_icon ? $empresa->nombre_logo_icon : 'Seleccionar'}}</label>
                                @if ($errors->has('logo_icon'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('logo_icon') }}</strong>
                                </span>
                                @endif
                                <div class="invalid-feedback"><b><span id="error-logo_icon_empresa"></span></b></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a href="javascript:void(0);" id="limpiar_logo" onclick="limpiar_icon()">
                                    <span class="badge badge-danger">x</span>
                                </a>
                            </div>
                            <div class="row justify-content-center">
                                <p>
                                    @if($empresa->ruta_logo_icon)
                                    <img class="logo_icon" src="{{Storage::url($empresa->ruta_logo_icon)}}" alt="">
                                    <input id="url_logo_icon" name="url_logo_icon" type="hidden"
                                        value="{{$empresa->ruta_logo_icon}}">
                                    @else
                                    <img class="logo_icon" src="{{asset('storage/empresas/logos/default.jpg')}}"
                                        alt="">
                                    <input id="url_logo_icon" name="url_logo_icon" type="hidden" value="">
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
        </fieldset>
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
        @endif
    </form>
</div>
@push('styles')
<link href="{{asset('Inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<!-- iCheck -->
<link href="{{asset('Inspinia/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

<!-- iCambio de colores-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/> <!-- 'classic' theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css"/> <!-- 'monolith' theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"/> 
    <style>
        .logo_large,.logo,.logo_icon{
            width: 190px;
            height: 190px;
            border-radius: 10%;
        }
    </style>

@endpush
@push('scripts')
<script src="{{asset('Inspinia/js/plugins/select2/select2.full.min.js')}}"></script>
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('Inspinia/js/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- Steps -->
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>

    <!-- Modern or es5 bundle -->
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>
    <script>
        $(document).ready(function()
        {
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            }); 
            if ($("#activo").val() == ''){ 
                $("#activo").val("SIN VERIFICAR");
            }
            const container = document.querySelector('.color-pickers');
        //   const inputElement = document.querySelector('.pickr');
            const btn = document.getElementById('btn-color');
            btn.addEventListener('click', () => {

            
                btn.disabled=true;
                const pickr = new Pickr({
                    el: container,
                    default: '#42445A',
                    theme: 'classic',

                    swatches: [
                    'rgba(244, 67, 54, 1)',
                    'rgba(233, 30, 99, 0.95)',
                    'rgba(156, 39, 176, 0.9)',
                    'rgba(103, 58, 183, 0.85)',
                    'rgba(63, 81, 181, 0.8)',
                    'rgba(33, 150, 243, 0.75)',
                    'rgba(3, 169, 244, 0.7)',
                    'rgba(0, 188, 212, 0.7)',
                    'rgba(0, 150, 136, 0.75)',
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(139, 195, 74, 0.85)',
                    'rgba(205, 220, 57, 0.9)',
                    'rgba(255, 235, 59, 0.95)',
                    'rgba(255, 193, 7, 1)'
                    ],

                    components: {
                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        hex: true,
                        rgba: true,
                        hsva: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                    }
                }).on('init', pickr => {

                }).on('save', color => {
                        $('#color').val(color.toRGBA().toString(3));
                        pickr.hide();
                        });
                });
                

        });
        /* Limpiar imagen */
     function limpiar() {

            $('.logo').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
            var fileName = "Seleccionar"
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#logo').val('')
        }
        /*Limpiar imagen large */
        function limpiar_large() {

                    $('.logo_large').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
                    var fileName = "Seleccionar"
                    $('#logo_large_txt').addClass("selected").html(fileName);
                    $('#logo_large').val('')
                }
                function limpiar_icon() {

$('.logo_icon').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
var fileName = "Seleccionar"
$('#logo_icon_txt').addClass("selected").html(fileName);
$('#logo_icon').val('')
}
     function seleccionarimagen()
     {
            var fileInput = document.getElementById('logo');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            $imagenPrevisualizacion = document.querySelector(".logo");
            if (allowedExtensions.exec(filePath)) {
                var userFile = document.getElementById('logo');
                userFile.src = URL.createObjectURL(event.target.files[0]);
                var data = userFile.src;
                $imagenPrevisualizacion.src = data
                let fileName =$('#logo').val().split('\\').pop();
                $('#logo').next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
                $('.logo').attr("src", "{{asset('storage/empresas/logos/default.png')}}")
            }
     }
     function seleccionarimagen_large()
     {
            var fileInput = document.getElementById('logo_large');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            $imagenPrevisualizacion = document.querySelector(".logo_large");
            if (allowedExtensions.exec(filePath)) {
                var userFile = document.getElementById('logo_large');
                userFile.src = URL.createObjectURL(event.target.files[0]);
                var data = userFile.src;
                $imagenPrevisualizacion.src = data
                let fileName =$('#logo_large').val().split('\\').pop();
                $('#logo_large').next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
                $('.logo_large').attr("src", "{{asset('storage/empresas/logos/default.png')}}")
            }
     }
     function seleccionarimagen_icon()
     {
            var fileInput = document.getElementById('logo_icon');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            $imagenPrevisualizacion = document.querySelector(".logo_icon");
            if (allowedExtensions.exec(filePath)) {
                var userFile = document.getElementById('logo_icon');
                userFile.src = URL.createObjectURL(event.target.files[0]);
                var data = userFile.src;
                $imagenPrevisualizacion.src = data
                let fileName =$('#logo_icon').val().split('\\').pop();
                $('#logo_icon').next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
                $('.logo_icon').attr("src", "{{asset('storage/empresas/logos/default.png')}}")
            }
     }
        function consultarDocumento() {
          var ruc= $('#ruc').val();
          var id='{{isset($empresa->id)? $empresa->id:null}}';
          $.ajax({
              dataType : 'json',
              type : 'POST',
              url : '{{ route('empresas.getDocumento') }}',
              data : {
                  '_token' : $('input[name=_token]').val(),
                  'ruc' : ruc,
                  'id': id
              }
          }).done(function (result){
              if (result.existe) {
                  toastr.error('El ruc ingresado ya se encuentra registrado para una empresa','Error');
              } else {
                      if (ruc.length === 11) {
                          consultarAPI(ruc);
                      } else {
                          toastr.error('El RUC debe de contar con 11 dígitos','Error');
                          clearDatosPersona(false);
                      }
              }
          });
      }
      function consultarAPI(documento) {
            var url = '{{ route("getApiruc", ":documento")}}';
            url = url.replace(':documento',documento);
            var textAlert = "¿Desea consultar RUC a SUNAT?";
            Swal.fire({
                title: 'Consultar',
                text: textAlert,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: 'Si, Confirmar',
                cancelButtonText: "No, Cancelar",
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            else
                            { 
                              return response.json()  
                            }
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                'ocurrio un problema'
                            );
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.value !== undefined && result.isConfirmed) {
                        camposRUC(result);                 
                }
            });
    }
    function clearDatosPersona(limpiarDocumento) {
            if (limpiarDocumento)
                $('#ruc').val("");
            $('#nombre').val("");
            $('#direccion_fiscal').val("");
            $('#direccion').val("");
            $('#nombre_comercial')
            $('#correo_electronico').val("");
            $('#cotraseña').val("");
            $('#telefono_movil').val("");
        }
        function camposRUC(objeto) {
            if (objeto.value === undefined)
                return;
            var razonsocial = objeto.value.razonSocial;
            var direccion = objeto.value.direccion;
            var estado = objeto.value.estado;
            var nombre_comercial=objeto.value.nombreComercial
            var telefono_movil=objeto.value.telefonos
            if(telefono_movil.length!=0)
            {
                $('#telefono_movil').val(telefono_movil[0]);
            }
            if (razonsocial!='-' && razonsocial!=null ) {
                $('#razon_social').val(razonsocial);
            }
            if (nombre_comercial!='-' && nombre_comercial!=null ) {
                $('#nombre_comercial').val(nombre_comercial);
                console.log("llego");
            }
            if (estado=="ACTIVO" ) {
                $('#activo').val(estado);
            }else{
                toastr.error('RUC no se encuentra "Activo"','Error');
            }
            if (direccion!='-' && direccion!=null ) {
                $('#direccion').val(direccion);
            }
            }
         $("#form_registrar_empresa").steps({
            bodyTag: "fieldset",
            transitionEffect: "fade",
            labels: {
                current: "actual paso:",
                pagination: "Paginación",
                finish: "Finalizar",
                next: "Siguiente",
                previous: "Anterior",
                loading: "Cargando ..."
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
               if (currentIndex > newIndex)
                {
                    return true;
                }
                var form = $(this);
                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }
                // Start validation; Prevent going forward if false
                return validarDatos(currentIndex + 1);
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);
                // Start validation; Prevent form submission if false
                return true;
            },
            onFinished: function (event, currentIndex)
            {    
        
                if(!validarDatosRedesContacto())
                {
                   toastr.error('Complete la información de los campos obligatorios (*)','Error');  
                }
                else
                {
                 var form = $(this);
           // Submit form input
               form.submit();
                }
            }
        });
        function validarDatos(paso) {
            //console.log("paso: " + paso);
            switch (paso) {
                case 1:
                    return validarDatosPersonales();
                    //return validarDatosContacto();
                default:
                    return false;
            }
        }
        function validarDatosPersonales()
        {
            var ruc = $("#ruc").val();
            var nombre_comercial = $("#nombre_comercial").val();
            var razon_social=$("#razon_social")
            var direccion_fiscal=$("#direccion_fiscal").val();
            var direccion=$("#direccion").val();
            var telefono_movil = $("#telefono_movil").val();
            var correo_electronico = $("#correo_electronico").val();
            var contraseña = $("#contraseña").val();
            if ( ruc.length === 0
             || nombre_comercial.length === 0 
             || razon_social.length===0
             || direccion_fiscal.length === 0 
             || direccion.length === 0 
             || telefono_movil.length === 0 
             || correo_electronico.length === 0
             || contraseña.length === 0) {
                toastr.error('Complete la información de los campos obligatorios (*)','Error');
                return false;
            }
            return true;
        }
        function validarDatosRedesContacto()
        {
            var facebook=$("#facebook").val();
            var whatsapp=$("#whatsapp").val();
            var nombre_contacto=$("#nombre_contacto").val();
            var tipo_documento_contacto=$("#tipo_documento_contacto").val();
            var documento_contacto=$("#documento_contacto").val();      
            if ( facebook.length === 0
             || whatsapp.length === 0 
             ) {
                return false;
            }
            return true;
       }
      

// Usage example

    </script>
@endpush