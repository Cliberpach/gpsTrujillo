<div class="wrapper wrapper-content animated fadeIn">
    <form class="wizard-big" action="{{ $action }}" method="POST" id="form_registrar_mensaje" enctype="multipart/form-data">
        @csrf
        <h1>Datos Del Mensaje</h1>
        <fieldset  style="position: relative;">
            <div class="card" style="background:rgb(233, 231, 231)">
                <div class="card-header">
                  Creacion del Mensaje de Bienvenida
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                          <label class="required">Asunto</label>
                          <div class="input-group">
                              <input type="text" id="asunto" name="asunto" class="form-control {{ $errors->has('asunto') ? ' is-invalid' : '' }}" value="{{old('asunto') ? old('asunto'):$mensaje->asunto}}"  required>
                              @if ($errors->has('asunto'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('asunto') }}</strong>
                                  </span>
                              @endif
                              <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
                          </div>
                        </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-1"></div>
                      <div class="col-lg-10">
                              <label class="" id="">Mensaje</label>
                              <div class="input-group">
                              <textarea rows="5" cols="50" type="text" id="mensaje" name="mensaje" class="form-control {{ $errors->has('mensaje') ? ' is-invalid' : '' }}"  >{{old('mensaje')?old('mensaje'):$mensaje->mensaje}}
                              </textarea>
                              @if ($errors->has('mensaje'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('mensaje') }}</strong>
                                  </span>
                              @endif
                              </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-2"></div>
                      <div class="col-lg-8">
                          <div>
                            <label id="logo_label">Logo:</label>
                                  <div class="custom-file">
                                      <input id="logo" type="file" name="logo" onchange="seleccionarimagen()"
                                          class="custom-file-input {{ $errors->has('logo') ? ' is-invalid' : '' }}"
                                          accept="image/*" {{$mensaje->ruta_logo ?   'src='.Storage::url($mensaje->ruta_logo).'': ''}}>
                                      <label for="logo" id="logo_txt" name="logo_txt"
                                          class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}">{{$mensaje->nombre_logo ? $mensaje->nombre_logo : 'Seleccionar'}}</label>
                                      @if ($errors->has('logo'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('logo') }}</strong>
                                      </span>
                                      @endif
                                      <div class="invalid-feedback"><b><span id="error-logo_mensaje"></span></b></div>
                                  </div>   
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="row">
                      <div class="col-lg-2">
                      </div>
                      <div class="col-lg-7">
                         <div class="row  justify-content-end">
                          <a href="javascript:void(0);" id="limpiar_logo" onclick="limpiar()">
                              <span class="badge badge-danger">x</span>
                          </a>
                          </div> 
                      </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="col-lg-2">
                      </div>
                      <div class="col-lg-7">
                              <p>
                                  @if($mensaje->ruta_logo)
                                  <img class="logo" src="{{Storage::url($mensaje->ruta_logo)}}" alt="">
                                  <input id="url_logo" name="url_logo" type="hidden"
                                      value="{{$mensaje->ruta_logo}}">
                                  @else
                                  <img class="logo" src="{{asset('storage/empresas/logos/default.jpg')}}"
                                      alt="">
                                  <input id="url_logo" name="url_logo" type="hidden" value="">
                                  @endif
                              </p>
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
    <style>
        .logo {
            width: 100%;
            height:300px;
            border-radius: 1%;
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
    <script>
        /* Limpiar imagen */
     function limpiar() {
            $('.logo').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
            var fileName = "Seleccionar"
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#logo').val('')
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
         $("#form_registrar_mensaje").steps({
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
                if(!validarDatosInicio())
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
        }
        function validarDatosInicio()
        {
            var asunto=$("#asunto").val();
            var mensaje=$("#mensaje").val();     
            if ( asunto.length === 0
             || mensaje.length === 0 
             ) {
                return false;
            }
            return true;
       }
    </script>
@endpush