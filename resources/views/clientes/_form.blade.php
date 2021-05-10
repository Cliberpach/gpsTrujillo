<div class="wrapper wrapper-content animated fadeIn" id="contenedor" >
    <form class="wizard-big formulario" action="{{ $action }}" method="POST" id="form_registrar_cliente">
        @csrf
        <h1>Datos Del Cliente</h1>
        <fieldset  style="position: relative;">
            <div class="row">
                <div class="col-md-6 b-r">
                
                    <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Tipo de documento</label>
                            <select id="tipo_documento" name="tipo_documento" class="select2_form form-control {{ $errors->has('tipo_documento') ? ' is-invalid' : '' }}">
                                <option></option>
                                @foreach(tipos_documento() as $tipo_documento)
                                    <option value="{{ $tipo_documento->simbolo }}" {{ old('tipo_documento') ? (old('tipo_documento') == $tipo_documento->simbolo ? "selected" : "") : ($cliente->tipo_documento == $tipo_documento->simbolo ? "selected" : "") }} >{{ $tipo_documento->simbolo }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tipo_documento'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tipo_documento') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Nro. Documento</label>
                            <div class="input-group">
                                <input type="text" id="documento" name="documento" class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" value="{{old('documento')?old('documento'):$cliente->documento}}"  onkeypress="return isNumber(event)" required maxlength="25">
                                <span class="input-group-append"><a style="color:white"@if($cliente->estado != '') onclick="consultarDocumento2()" @else onclick="consultarDocumento()"@endif  class="btn btn-primary"><i class="fa fa-search"></i> <span id="entidad">Entidad</span></a></span>
                                @if ($errors->has('documento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('documento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                            <label class="" id="">Nombre Comercial</label>
                            <input type="text" id="nombre_comercial" name="nombre_comercial" class="form-control {{ $errors->has('nombre_comercial') ? ' is-invalid' : '' }}" value="{{old('nombre_comercial')?old('nombre_comercial'):$cliente->nombre_comercial}}" maxlength="191" onkeyup="return mayus(this)">
                            @if ($errors->has('nombre_comercial'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre_comercial') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="hidden" id="codigo_verificacion" name="codigo_verificacion">
                        <div class="col-lg-6 col-xs-12">
                            <label class="">Estado</label>
                            <input type="text" id="activo" name="activo" class="form-control text-center {{ $errors->has('activo') ? ' is-invalid' : '' }}" value="{{old('activo')?old('activo'):$cliente->activo}}" readonly>
                            @if ($errors->has('activo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('activo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required" id="lblNombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{old('nombre')?old('nombre'):$cliente->nombre}}" maxlength="191" onkeyup="return mayus(this)" required>
                        @if ($errors->has('nombre'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Teléfono móvil</label>
                            <input type="text" id="telefono_movil" name="telefono_movil" class="form-control {{ $errors->has('telefono_movil') ? ' is-invalid' : '' }}" value="{{old('telefono_movil') ? old('telefono_movil') : $cliente->telefono_movil}}" onkeypress="return isNumber(event)" maxlength="9" required>
                            @if ($errors->has('telefono_movil'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('telefono_movil') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">Dirección Fiscal</label>
                        <input type="text" id="direccion_fiscal" name="direccion_fiscal" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{old('direccion_fiscal')?old('direccion_fiscal'):$cliente->direccion_fiscal}}" maxlength="191" onkeyup="return mayus(this)" required>
                        @if ($errors->has('direccion_fiscal'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('direccion_fiscal') }}</strong>
                            </span>
                        @endif
                    </div>
                        <div class="form-group">
                            <label class="required">Direccion </label>
                            <input type="text" id="direccion" name="direccion" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{old('direccion_negocio') ? old('direccion_negocio') : $cliente->direccion}}" maxlength="191" onkeyup="return mayus(this)" required>
                                @if ($errors->has('direccion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                @endif
                        </div>
                    <div class="form-group">
                        <label class="required">Correo electrónico</label>
                        <input type="email" id="correo_electronico" name="correo_electronico" class="form-control {{ $errors->has('correo_electronico') ? ' is-invalid' : '' }}" value="{{old('correo_electronico') ? old('correo_electronico') : $cliente->correo_electronico}}" maxlength="100" required>
                        @if ($errors->has('correo_electronico'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('correo_electronico') }}</strong>
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
        <h1>Datos Del Cliente</h1>
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
                                        class="form-control {{ $errors->has('facebook') ? ' is-invalid' : '' }}" onkeyup="return mayus(this)"   value="{{old('facebook') ? old('facebook') : $cliente->facebook}}">
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
                                    class="form-control {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" onkeyup="return mayus(this)"  value="{{old('whatsapp') ? old('whatsapp') : $cliente->whatsapp}}" >
                                    @if ($errors->has('whatsapp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('whatsapp') }}</strong>
                                    </span>
                                    @endif
                            </div>
                    </div>
                </div>
                <div class="col-md-6 b-r">
                    <h3>Datos del Contacto</h3>
                    <div class="form-group">
                        <label class="">Nombre del Contacto</label>
                        <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control {{ $errors->has('nombre_contacto') ? ' is-invalid' : '' }}" value="{{old('nombre_contacto') ? old('nombre_contacto') : $cliente->nombre_contacto}}" maxlength="191" onkeyup="return mayus(this)">
                            @if ($errors->has('nombre_contacto'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre_contacto') }}</strong>
                                </span>
                            @endif
                      </div>
                      <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Tipo de documento</label>
                            <select id="tipo_documento_contacto" name="tipo_documento_contacto" class="select2_form form-control {{ $errors->has('tipo_documento_contacto') ? ' is-invalid' : '' }}">
                                <option></option>
                                @foreach(tipos_documento() as $tipo_documento_contacto)
                                    <option value="{{ $tipo_documento_contacto->simbolo }}" {{ old('tipo_documento_contacto') ? (old('tipo_documento_contacto') == $tipo_documento_contacto->simbolo ? "selected" : "") : ($cliente->tipo_documento_contacto == $tipo_documento_contacto->simbolo ? "selected" : "") }} >{{ $tipo_documento_contacto->simbolo }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tipo_documento_contacto'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tipo_documento_contacto') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Nro. Documento</label>
                            <div class="input-group">
                                <input type="text" id="documento_contacto" name="documento_contacto" class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" value="{{old('documento_contacto')?old('documento_contacto'):$cliente->tipo_documento_contacto}}"  onkeypress="return isNumber(event)" required>
                                @if ($errors->has('documento_conctacto'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('documento_contacto') }}</strong>
                                    </span>
                                @endif
                                <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
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
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <style>
        .logo {
            width: 190px;
            height: 190px;
            border-radius: 10%;
            position: absolute;
        }
    </style>
@endpush
@push('scripts')
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
    
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
            $('.formulario').on('submit',function()
            {
                var x = document.getElementById("contenedor");
           
                 x.style.display = "none";
                 $('.loader-spinner').show();
            });
        });
       

        function consultarDocumento() {
          var tipo_documento = $('#tipo_documento').val();
          var documento = $('#documento').val();
          $.ajax({
              dataType : 'json',
              type : 'POST',
              url : '{{ route('cliente.getDocumento') }}',
              data : {
                  '_token' : $('input[name=_token]').val(),
                  'tipo_documento' : tipo_documento,
                  'documento' : documento,
                  'id': null
              }
          }).done(function (result){
              if (result.existe) {
                  toastr.error('El '+ tipo_documento +' ingresado ya se encuentra registrado para un cliente','Error');
                  clearDatosPersona(false);
              } else {
                  if (tipo_documento === "DNI") {
                      if (documento.length === 8) {
                          consultarAPI(tipo_documento, documento);
                      } else {
                          toastr.error('El DNI debe de contar con 8 dígitos','Error');
                          clearDatosPersona(false);
                      }
                  } else if (tipo_documento === "RUC") {
                      if (documento.length === 11) {
                          consultarAPI(tipo_documento, documento);
                      } else {
                          toastr.error('El RUC debe de contar con 11 dígitos','Error');
                          clearDatosPersona(false);
                      }
                  }
              }
          });
      }
      function consultarAPI(tipo_documento, documento) {
        if (tipo_documento === 'DNI' || tipo_documento === 'RUC') {
            var url = (tipo_documento === 'DNI') ? '{{ route("getApidni", ":documento")}}' : '{{ route("getApiruc", ":documento")}}';
            url = url.replace(':documento',documento);
            var textAlert = (tipo_documento === 'DNI') ? "¿Desea consultar DNI a RENIEC?" : "¿Desea consultar RUC a SUNAT?";
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
                console.log(result);
                if (result.value !== undefined && result.isConfirmed) {
                    $('#documento').removeClass('is-invalid')
                    if (tipo_documento === 'DNI')
                        camposDNI(result);
                    else
                        camposRUC(result);
                }
            });
        }
    }
    function camposDNI(objeto) {
            if (objeto.value === undefined)
                return;
            var nombres = objeto.value.nombres;
            var apellido_paterno = objeto.value.apellidoPaterno;
            var apellido_materno = objeto.value.apellidoMaterno;
            var nombre = "";
            if (nombres !== '-' && nombres !== null ) {
                nombre += nombres;
            }
            if (apellido_paterno !== '-' && apellido_paterno !== null ) {
                nombre += (nombre.length === 0) ? apellido_paterno : ' ' + apellido_paterno
            }
            if (apellido_materno !== '-' && apellido_materno !== null) {
                nombre += (nombre.length === 0) ? apellido_materno : ' ' + apellido_materno
            }
            $("#nombre").val(nombre);
            $("#activo").val("ACTIVO");
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
        if (razonsocial!='-' && razonsocial!=null) {
            $('#nombre_comercial').val(nombre_comercial);
        }
        if (razonsocial!='-' && razonsocial!=null) {
            $('#nombre').val(razonsocial);
        }
        if (estado=="ACTIVO" ) {
            $('#activo').val(estado);
        }else{
            toastr.error('Cliente con RUC no se encuentra "Activo"','Error');
        }
        if (direccion!='-' && direccion!=null) {
            $('#direccion').val(direccion);
        }
        }
    function clearDatosPersona(limpiarDocumento) {
            if (limpiarDocumento)
                $('#documento').val("");
            $('#nombre').val("");
            $('#direccion_fiscal').val("");
            $('#direccion').val("");
            $('#nombre_comercial')
            $('#correo_electronico').val("");
            $('#telefono_movil').val("");
        }
         $("#form_registrar_cliente").steps({
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
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }
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
              /*  if(!validarDatosRedesContacto())
                {
                   toastr.error('Complete la información de los campos obligatorios (*)','Error');  
                }
                else
                {*/
                    /*    form.addEventListener('loadstart', function(e) {
                        console.log('Image load started');
                        });

                        form.addEventListener('loadend', function(e) {
                        console.log('Image load finished');
                        });*/
            //    }
            $.ajax({
              dataType : 'json',
              type : 'POST',
              async: false,
              url : '{{ route('empresas.getmensaje') }}',
              data : {
                  '_token' : $('input[name=_token]').val()
              }
          }).done(function (result){
              if (result.existemensaje) {
          
               var form = $("#form_registrar_cliente");
                    // Submit form input
                        form.submit();
           
              } 
              {
            toastr.error('Falta agregar el mensaje para registrar clientes','Error');  
              }
            
          });
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
            var tipo_documento = $("#tipo_documento").val();
            var documento = $("#documento").val();
            var nombre_comercial = $("#nombre_comercial").val();
            var nombre=$("#nombre").val();
            var direccion_fiscal=$("#direccion_fiscal").val();
            var direccion=$("#direccion").val();
            var telefono_movil = $("#telefono_movil").val();
            var correo_electronico = $("#correo_electronico").val();
            if ((tipo_documento !== null && tipo_documento.length === 0)
             || documento.length === 0
             || nombre_comercial.length === 0 
             || nombre.length===0
             || direccion_fiscal.length === 0 
             || direccion.length === 0 
             || telefono_movil.length === 0 
             || correo_electronico.length === 0) {
                toastr.error('Complete la información de los campos obligatorios (*)','Error');
                return false;
            }
            switch (tipo_documento) {
                case 'RUC':
                    if (documento.length !== 11) {
                        toastr.error('El RUC debe de contar con 11 dígitos','Error');
                        return false;
                    }
                    break;
                case 'DNI':
                    if (documento.length !== 8) {
                        toastr.error('El DNI debe de contar con 8 dígitos','Error');
                        return false;
                    }
                    break;
                case 'CARNET EXT.':
                    toastr.error('El tipo de documento no tiene entidad para consultar','Error');
                    if (documento.length !== 20) {
                        toastr.error('El CARNET DE EXTRANJERIA debe de contar con 20 dígitos','Error');
                        return false;
                    }
                    break;
                case 'PASAPORTE':
                    $('#entidad').text('Entidad')
                    toastr.error('El tipo de documento no tiene entidad para consultar','Error');
                    if (documento.length !== 20) {
                        toastr.error('El PASAPORTE debe de contar con 20 dígitos','Error');
                        return false;
                    }
                    break;
                case 'P. NAC.':
                    $('#entidad').text('Entidad')
                    toastr.error('El tipo de documento no tiene entidad para consultar','Error');
                    if (documento.length !== 25) {
                        toastr.error('La PARTIDAD DE NACIMIENTO debe de contar con 25 dígitos','Error');
                        return false;
                    }
                    break;
                default:
                    $('#entidad').text('Entidad')
                    toastr.error('El tipo de documento no tiene entidad para consultar','Error');
            }
            return true;
        }
       /* function validarDatosRedesContacto()
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
       }*/
    </script>
@endpush