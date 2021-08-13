<div class="wrapper wrapper-content animated fadeIn">
    <form class="wizard-big" action="{{ $action }}" method="POST" id="form_registrar_dispositivo">
        @csrf
        <h1>Datos Del Dispositivo</h1>
        <fieldset  style="position: relative;">
            <div class="row">
                <div class="col-md-6 b-r">
                    <div class="form-group row">
                        <div class="col-lg-12 col-xs-12">
                            <label class="required">Nombre</label>
                            <select id="nombre" name="nombre" class="select2_form form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}">
                                <option></option>
                                @foreach(tiposdispositivos() as $tipo_dispositivo)
                                    <option value="{{ $tipo_dispositivo->id }}" {{ old('tipo_dispositivo') ? (old('tipo_dispositivo') == $tipo_dispositivo->id ? "selected" : "") : ($dispositivo->tipodispositivo_id== $tipo_dispositivo->id ? "selected" : "") }} >{{ $tipo_dispositivo->nombre }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tipo_dispositivo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tipo_dispositivo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                            <label class="" id="">Nro Telefono</label>
                            <input type="number" id="nrotelefono" name="nrotelefono" class="form-control {{ $errors->has('nrotelefono') ? ' is-invalid' : '' }}" value="{{old('nrotelefono')?old('nrotelefono'):$dispositivo->nrotelefono}}" maxlength="9" onkeyup="return mayus(this)">
                            @if ($errors->has('nrotelefono'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nrotelefono') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Operador</label>
                            <select id="operador" name="operador" class="select2_form form-control {{ $errors->has('operador') ? ' is-invalid' : '' }}">
                                <option></option>
                                @foreach(operadores() as $operador)
                                    <option value="{{ $operador->simbolo }}" {{ old('operador') ? (old('operador') == $operador->simbolo ? "selected" : "") : ($operador->simbolo== $dispositivo->operador ? "selected" : "") }} >{{ $operador->simbolo }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('operador'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('operador') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Placa</label>
                            <input type="text" id="placa" name="placa" class="form-control {{ $errors->has('placa') ? ' is-invalid' : '' }}" value="{{old('placa') ? old('placa') : $dispositivo->placa}}"  placeholder="XXX-XXX" required >
                            @if ($errors->has('placa'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('placa') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Color</label>
                            <input type="text" id="color" name="color" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{old('color')?old('color'):$dispositivo->color}}" maxlength="191" onkeyup="return mayus(this)" required>
                            @if ($errors->has('color'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Estado</label>
                            <select id="activo" name="activo" class="select2_form form-control {{ $errors->has('activo') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    <option value="VIGENTE" {{ old('activo') ? (old('activo') == "VIGENTE" ? 'selected' : '' ) : ("VIGENTE"== $dispositivo->activo ? "selected" : "") }} >VIGENTE</option>
                                    <option value="NO VIGENTE" {{ old('activo') ? (old('activo') == "NO VIGENTE" ? 'selected' : '' ) : ("NO VIGENTE"== $dispositivo->activo ? "selected" : "") }} >NO VIGENTE</option>
                            </select>
                            @if ($errors->has('activo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('activo') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Sutran</label>
                            <select id="sutran" name="sutran" class="select2_form form-control">
                                    <option></option>
                                    <option value="SI" {{ old('sutran') ? (old('sutran') == "SI" ? 'selected' : '' ) : ("SI"== $dispositivo->sutran ? "selected" : "") }} >SI</option>
                                    <option value="NO" {{ old('sutran') ? (old('sutran') == "NO" ? 'selected' : '' ) : ("NO"== $dispositivo->sutran ? "selected" : "") }} >NO</option>
                            </select>
                        </div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-lg-12 col-xs-12">
                            <label class="required">Cliente</label>
                            <select id="cliente" name="cliente" class="select2_form form-control {{ $errors->has('cliente') ? ' is-invalid' : '' }}">
                                <option></option>
                                @foreach(clientes() as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente') ? (old('cliente') == $cliente->id ? "selected" : "") : ($cliente->id== $dispositivo->cliente_id ? "selected" : "") }} >{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('cliente'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cliente') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12">
                                <label class="required">Modelo</label>
                                <select id="modelo" name="modelo" class="select2_form form-control {{ $errors->has('modelo') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    @foreach(modelos() as $modelo)
                                        <option value="{{ $modelo->simbolo }}" {{ old('modelo') ? (old('modelo') == $modelo->simbolo ? "selected" : "") : ($dispositivo->modelo == $modelo->simbolo ? "selected" : "") }} >{{ $modelo->simbolo }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('modelo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('modelo') }}</strong>
                                    </span>
                                @endif
                            </div>
                                <div class="col-lg-6 col-xs-12">
                                    <label class="required">IMEI</label>
                                    <div class="input-group">
                                        <input type="text" id="imei" name="imei" class="form-control {{ $errors->has('imei') ? ' is-invalid' : '' }}" value="{{old('imei')?old('imei'):$dispositivo->imei}}"  pattern="\d*"  required maxlength="15">
                                        @if ($errors->has('imei'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('imei') }}</strong>
                                            </span>
                                        @endif
                                        <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
                                    </div>
                                </div>
                        </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">marca</label>
                            <select id="marca" name="marca" class="select2_form form-control {{ $errors->has('marca') ? ' is-invalid' : '' }}">
                                <option></option>
                                @foreach(marcas() as $marca)
                                    <option value="{{ $marca->simbolo }}" {{ old('marca') ? (old('marca') == $marca->simbolo ? "selected" : "") : ($dispositivo->marca == $marca->simbolo ? "selected" : "") }} >{{ $marca->simbolo }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('marca'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('marca') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Estado de Pago</label>
                            <select id="pago" name="pago" class="select2_form form-control {{ $errors->has('pago') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    <option value="Al DIA" {{ old('pago') ? (old('pago') == 'AL DIA' ? 'selected' : '' ) : ('AL DIA'== $dispositivo->pago ? 'selected' : '') }} >AL DIA</option>
                                    <option value="DEUDA" {{ old('pago') ? (old('pago') == 'DEUDA' ? 'selected' : '' ) : ('DEUDA'== $dispositivo->pago ? 'selected' : '') }} >DEUDA</option>
                                    <option value="CORTE" {{ old('pago') ? (old('pago') == 'CORTE' ? 'selected' : '' ) : ('CORTE'== $dispositivo->pago ? 'selected' : '') }} >CORTE</option>
                            </select>
                            @if ($errors->has('pago'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pago') }}</strong>
                                </span>
                            @endif
                    </div>
                    
                </div>
                <div class="form-group row">
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Km-Inicial</label>
                            <input type="text" name="km_inicial" id="km_inicial" class="form-control" value="{{old('km_inicial')?old('km_inicial'):$dispositivo->km_inicial}}">
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label class="required">Km-Aumento</label>
                            <input type="text" name="km_aumento" id="km_aumento" class="form-control" value="{{old('km_aumento')?old('km_aumento'):$dispositivo->km_aumento}}">
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
        </fieldset>
        <h1>Alertas</h1>
        <fieldset  style="position: relative;">
            <div class="row">
                <div class="col-lg-12">
                     <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class=""><b>Agregar</b></h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <label class="col-form-label required">Tipo de arleta:</label>
                                <select id="alerta" name="alerta" class="select2_form form-control">
                                    <option></option>
                                    @foreach(alertas() as $alerta)
                                        <option value="{{ $alerta->id }}">{{ $alerta->alerta }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('alerta'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alerta') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="amount">&nbsp;</label>
                                    <a class="btn btn-block btn-warning" style='color:white;' id="btn_agregar_detalle" onclick="agregarAlerta()"> <i class="fa fa-plus"></i> AGREGAR</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table
                                class="table dataTables-detalle-alerta table-striped table-bordered table-hover"
                                style="text-transform:uppercase">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-center">ACCIONES</th>
                                        <th class="text-center">ALERTAS</th>
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
            <input type="hidden" name="alerta_tabla" id="alerta_tabla">
        </fieldset>
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="dispositivo_id" value="{{$dispositivo->id}}" id="dispositivo_id" >
            <input type="hidden" name="alertas_dispositivos" value="{{$detalle_alerta}}" id="alertas_dispositivos" >
        @endif
    </form>
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
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function()
        {
            $('.dataTables-detalle-alerta').DataTable({
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
                                        "<a class='btn btn-sm btn-danger btn-delete' onclick='eliminaralerta(this)' style='color:white'>"+"<i class='fa fa-trash'></i>"+"</a>"+
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
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            });
            if(!($("#alertas_dispositivos").val()=== undefined))
            {
               var detalle=JSON.parse($("#alertas_dispositivos").val());
               var t = $('.dataTables-detalle-alerta').DataTable();
               for (var i = 0; i < detalle.length; i++) {
                  t.row.add([
                    detalle[i].alerta_id,
                    '',
                    detalle[i].alerta,
                   ]).draw(false);
                }
             guardaralertas();
            }
        })
     $("#form_registrar_dispositivo").steps({
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
                return validarDatos_form(currentIndex + 1);
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
              //  if(validarDatos())
               // {
                  var form = $(this);
                // Submit form input
                 form.submit();
                //}
            }
        });
        function validarDatos_form(paso) {
            //console.log("paso: " + paso);
            switch (paso) {
                case 1:
                    return validarDatos();
                    //return validarDatosContacto();
                default:
                    return false;
            }
        }
        function validarDatos()
        {
            var nombre=$("#nombre").val();
            var nrotelefono=$("#nrotelefono").val();
            var operador=$("#operador").val();
            var placa=$("#placa").val();
            var color=$("#color").val();
            var cliente=$("#cliente").val();
            var modelo=$("#modelo").val();
            var imei=$("#imei").val();
            var marca=$("#marca").val();
            var activo=$("#activo").val();
            var pago=$("#pago").val();
            var sutran=$("#sutran").val();
            var km_inicial=$("#km_inicial").val();
            var km_aumento=$("#km_aumento").val();
            if ( nombre.length === 0
             || nrotelefono.length === 0
             || operador.length === 0
             || color.length === 0
             || cliente.length === 0
             || activo.length === 0
             || pago.length === 0
             || modelo.length === 0
             || imei.length === 0
             || marca.length === 0
             || sutran.length === 0
             || km_inicial.length === 0
             || km_aumento.length === 0
             ) {
                 toastr.error('Complete la información de los campos obligatorios (*)','Error');
                return false;
            }
            else if(imei.length<15|| imei.length>15)
            {
                toastr.error('El imei no cumple','Error');
                return false;
            }
            if (isNaN(imei)) {
                toastr.error('El imei no cumple debe ser numerico','Error');
                return false;
            }
            else if(verificarvalores(placa,imei))
            {
                return false;
            }
            return true;
       }
       function verificarvalores(placa,imei)
       {
           var valor=false;
           var id=$("#dispositivo_id").val();
           if(id=== undefined)
           {
            id=0;
           }
        $.ajax({
              dataType : 'json',
              type : 'POST',
              async: false,
              url : '{{ route('dispositivo.getvalores') }}',
              data : {
                  '_token' : $('input[name=_token]').val(),
                  'placa' : placa,
                  'id':id,
                  'imei':imei
              }
          }).done(function (result){
              if (result.existeplaca) {
                toastr.error('La placa ya existe','Error');
               valor=true;
              }
              else if (result.existeimei) {
                toastr.error('el imei ya existe','Error');
                valor=true;
              }
          });
          return valor;
       }
      function verificarplaca(placa)
      {
          if(placa[3]==="-")
          {
            return false;
          }
          else
          {
              return true;
          }
      }
      function agregarAlerta() {
                var enviar = false;
                if ($('#alerta').val() == '') {
                    toastr.error('Seleccione Alerta.', 'Error');
                    enviar = true;
                    $('#alerta').addClass("is-invalid")
                    $('#error-alerta').text('El campo Alerta es obligatorio.')
                }
                else {
                    var existe = buscaralerta($('#alerta').val())
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
                        text: "¿Seguro que desea agregar esta Alerta?",
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
    function buscaralerta(id) {
                    var existe = false;
                    var t = $('.dataTables-detalle-alerta').DataTable();
                    t.rows().data().each(function(el, index) {
                        if (el[0] == id) {
                            existe = true
                        }
                    });
                    return existe
            }
            function llegarDatos() {
                var detalle = {
                    alerta_id: $('#alerta').val(),
                    presentacion: $( "#alerta option:selected" ).text(),
                }
                agregarTabla(detalle);
            }
            function agregarTabla($detalle) {
                var t = $('.dataTables-detalle-alerta').DataTable();
                t.row.add([
                    $detalle.alerta_id,
                    '',
                    $detalle.presentacion,
                ]).draw(false);
             guardaralertas();
            }
            function guardaralertas()
          {
            var alerta = [];
            var table = $('.dataTables-detalle-alerta').DataTable();
            var data = table.rows().data();
            data.each(function(value, index) {
                let fila = {
                    alerta_id: value[0],
                };
                alerta.push(fila);
            });
            $('#alerta_tabla').val(JSON.stringify(alerta));
          }
          function eliminaralerta(e) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })
                Swal.fire({
                    title: 'Opción Eliminar',
                    text: "¿Seguro que desea eliminar Alerta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var table = $('.dataTables-detalle-alerta').DataTable();
                        table.row($(e).parents('tr')).remove().draw();
                        guardaralertas();
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
    </script>
@endpush
