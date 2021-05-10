<div class="wrapper wrapper-content animated fadeIn" id="contenedor">
    <form class="wizard-big formulario" action="{{ $action }}" method="POST" id="form_registrar_empresa" enctype="multipart/form-data">
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
                                <span class="input-group-append"><a style="color:white" onclick="consultarDocumento()" class="btn btn-primary"><i class="fa fa-search"></i> <span id="entidad">Entidad</span></a></span>
                                @if ($errors->has('ruc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ruc') }}</strong>
                                    </span>
                                @endif 
                                <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="">Estado</label>
                            <input type="text" id="activo" name="activo" class="form-control text-center {{ $errors->has('activo') ? ' is-invalid' : '' }}" value="{{old('activo')?old('activo'):$empresa->activo}}" readonly>
                            @if ($errors->has('activo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('activo') }}</strong>
                                </span>
                            @endif
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
                    <div class="form-group">
                        <label class="required">Correo electrónico</label>
                        <input type="email" id="correo_electronico" name="correo_electronico" class="form-control {{ $errors->has('correo_electronico') ? ' is-invalid' : '' }}" value="{{old('correo_electronico') ? old('correo_electronico') : $empresa->correo_electronico}}" maxlength="100" required>
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
                </div>
                <div class="col-md-6 b-r">
                    <h3>Datos del Contacto</h3>
                    <div class="form-group">
                        <label class="">Nombre del Contacto</label>
                        <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control {{ $errors->has('nombre_contacto') ? ' is-invalid' : '' }}" value="{{old('nombre_contacto') ? old('nombre_contacto') : $empresa->nombre_contacto}}" maxlength="191" onkeyup="return mayus(this)">
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
                                    <option value="{{ $tipo_documento_contacto->simbolo }}" {{ old('tipo_documento_contacto') ? (old('tipo_documento_contacto') == $tipo_documento_contacto->simbolo ? "selected" : "") : ($empresa->tipo_documento_contacto == $tipo_documento_contacto->simbolo ? "selected" : "") }} >{{ $tipo_documento_contacto->simbolo }}</option>
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
                                <input type="text" id="documento_contacto" name="documento_contacto" class="form-control {{ $errors->has('documento') ? ' is-invalid' : '' }}" value="{{old('documento_contacto')?old('documento_contacto'):$empresa->tipo_documento_contacto}}"  onkeypress="return isNumber(event)" required>
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
        <h1>Dispositivos de la Empresa</h1>
        <fieldset  style="position: relative;">
            <div class="row">
                <div class="col-lg-12">
                     <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class=""><b>Agregar Dispositivos de la Empresa</b></h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <label class="col-form-label required">Tipo de Dispositivos:</label>
                                <select id="dispositivo" name="dispositivo" class="select2_form form-control {{ $errors->has('dispositivo') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    @foreach(tiposdispositivos() as $tipo_dispositivo)
                                        <option value="{{ $tipo_dispositivo->id }}">{{ $tipo_dispositivo->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('dispositivo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dispositivo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="amount">&nbsp;</label>
                                    <a class="btn btn-block btn-warning" style='color:white;' id="btn_agregar_detalle" onclick="agregar()"> <i class="fa fa-plus"></i> AGREGAR</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table
                                class="table dataTables-detalle-dispositivo table-striped table-bordered table-hover"
                                style="text-transform:uppercase">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-center">ACCIONES</th>
                                        <th class="text-center">DESCRIPCION DEL DISPOSITIVO</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                
                            </table>
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
            <input type="hidden" name="dispositivo_tabla" id="dispositivo_tabla"> 
        </fieldset>
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
        @endif
    </form>
    @if (!empty($detalle))
    <input id="detalle" value="{{$detallecontrato}}" type="hidden">
@endif
</div> 
@push('styles')
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <style>
        .logo {
            width: 190px;
            height: 190px;
            border-radius: 10%;
        }
    </style>
@endpush
@push('scripts')
<script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
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
            if ($("#activo").val() == ''){ 
                $("#activo").val("SIN VERIFICAR");
            }
            $('.formulario').on('submit',function()
            {   var x = document.getElementById("contenedor");
           
           x.style.display = "none";
                $('.loader-spinner').show();
            });
            $('.dataTables-detalle-dispositivo').DataTable({
                "dom": 'lTfgitp',
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        searchable: false,
                        "targets": [1],
                        data: null,
                        render: function(data, type, row) {
                                return  "<div class='btn-group'>" +
                                        "<a class='btn btn-sm btn-danger btn-delete' onclick='eliminardispositivo(this)' style='color:white'>"+"<i class='fa fa-trash'></i>"+"</a>"+ 
                                        "</div>";
                        }
                    },
                    {
                        "targets": [2],
                    },
                    
                ],
                'bAutoWidth': false,
                'aoColumns': [
                    { sWidth: '0%' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },

                ],
                "language": {
                    url: "{{asset('Spanish.json')}}"
                },
                "order": [[ 0, "desc" ]],
            });

            if(!($("#detalle").val()=== undefined))
            {
               var detalle=JSON.parse($("#detalle").val());
    
              
               var t = $('.dataTables-detalle-dispositivo').DataTable();
               for (var i = 0; i < detalle.length; i++) {
                  t.row.add([
                    detalle[i].tipodispositivo_id,
                    '',
                    detalle[i].nombre,
                   
                   ]).draw(false);
                }
               
             
               
                 guardardispositivos();
            }

        });
           function eliminardispositivo(e) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })
                Swal.fire({
                    title: 'Opción Eliminar',
                    text: "¿Seguro que desea eliminar Producto?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var table = $('.dataTables-detalle-dispositivo').DataTable();
                        table.row($(e).parents('tr')).remove().draw();
                        guardardispositivos();
                        // sumaTotal()
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La Solicitud se ha cancelado.',
                            'error'
                        )
                    }
                })
            }
        function limpiarErrores() {
            $('#dispositivo').removeClass("is-invalid")
            $('#error-dispositivo').text('')
            }
            function buscardispositivo(id) {
                    var existe = false;
                    var t = $('.dataTables-detalle-dispositivo').DataTable();
                    t.rows().data().each(function(el, index) {
                        if (el[0] == id) {
                            existe = true
                        }
                    });
                    return existe
            }
            function agregar() {
                limpiarErrores()
                var enviar = false;
                if ($('#dispositivo').val() == '') {
                    toastr.error('Seleccione dispositivo.', 'Error');
                    enviar = true;
                    $('#dispositivo').addClass("is-invalid")
                    $('#error-dispositivo').text('El campo Dispositivo es obligatorio.')
                } 
                else {
                    var existe = buscardispositivo($('#dispositivo').val())
                    if (existe == true) {
                        toastr.error('dispositivo ya se encuentra ingresado.', 'Error');
                        enviar = true;
                    }
                }
                
                if (enviar != true) {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger',
                        },
                        buttonsStyling: false
                    })
                    Swal.fire({
                        title: 'Opción Agregar',
                        text: "¿Seguro que desea agregar Dispositivo?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: 'Si, Confirmar',
                        cancelButtonText: "No, Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            llegarDatos();
                        } else if (
                            // Read more about handling dismissals below 
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                                'Cancelado',
                                'La Solicitud se ha cancelado.',
                                'error'
                            )
                        }
                    })
                }
            }
            function llegarDatos() {
                var detalle = {
                    dispositivo_id: $('#dispositivo').val(),
                    presentacion: $( "#dispositivo option:selected" ).text(),
                }
                agregarTabla(detalle);
            }
            function agregarTabla($detalle) {
                var t = $('.dataTables-detalle-dispositivo').DataTable();
                t.row.add([
                    $detalle.dispositivo_id,
                    '',
                    $detalle.presentacion,
                    
                ]).draw(false);
                 guardardispositivos();
            }
            function guardardispositivos()
          {
            var dispositivo = [];
            var table = $('.dataTables-detalle-dispositivo').DataTable();
            var data = table.rows().data();
            data.each(function(value, index) {
                let fila = {
                    dispositivo_id: value[0],
                };
                dispositivo.push(fila);
            });
            $('#dispositivo_tabla').val(JSON.stringify(dispositivo));
            
          }
         
        /* Limpiar imagen */
     function limpiar() {
            $('.logo').attr("src", "{{asset('storage/empresas/logos/default.jpg')}}")
            var fileName = "Seleccionar"
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#logo').val('')
        }
     function seleccionarimagen()
     {
          console.log("ff");
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
                console.log(result);
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
               /* if(!validarDatosRedesContacto())
                {
                   toastr.error('Complete la información de los campos obligatorios (*)','Error');  
                }
                else
                {
                 var form = $(this);
                // Submit form input
                 form.submit();
                }*/
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
          
               var form = $("#form_registrar_empresa");
                    // Submit form input
                        form.submit();
           
              } 
              else
              {
             
            toastr.error('Falta agregar el mensaje para registrar empresas','Error');  
              }
            
          });
             
            }
        });
        function validarDatos(paso) {
            //console.log("paso: " + paso);
            switch (paso) {
                case 1:
                    return validarDatosPersonales();
                case 2:
                    return validarDatosRedesContacto();
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
            if ( ruc.length === 0
             || nombre_comercial.length === 0 
             || razon_social.length===0
             || direccion_fiscal.length === 0 
             || direccion.length === 0 
             || telefono_movil.length === 0 
             || correo_electronico.length === 0) {
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
                toastr.error('Complete la información de los campos obligatorios (*)','Error');
                return false;
            }
            return true;
        }
    </script>
@endpush