<div class="wrapper wrapper-content animated fadeIn" id="contenedor" >
    <form class="wizard-big formulario" action="{{ $action }}" method="POST" id="form_registrar_contrato">
        @csrf
        <h1>Datos De La Empresa</h1>
        <fieldset  style="position: relative;" >
            <div class="ibox">
                <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-6 b-r">
                        <h4 class=""><b>Documento de venta</b></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <p>Registrar datos del documento de venta:</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12">
                                <label class="">Fecha de Inicio</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_inicio" name="fecha_inicio" onchange="fechafinal(this)" class="form-control {{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}" value="{{old('fecha_inicio')?old('fecha_inicio'):getFechaFormato($contrato->fecha_inicio, 'Y/m/d')}}" readonly>
                                        @if ($errors->has('fecha_inicio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_inicio') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <label class="">Fecha de fin</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_fin" name="fecha_fin" class="form-control {{ $errors->has('fecha_fin') ? ' is-invalid' : '' }}" value="{{old('fecha_fin')?old('fecha_fin'):getFechaFormato($contrato->fecha_fin, 'Y/m/d')}}" readonly>
                                        @if ($errors->has('fecha_fin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_fin') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-lg-12 col-xs-12">
                                <label class="required">Empresa</label>
                                <select id="empresa" name="empresa" class="select2_form form-control {{ $errors->has('empresa') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    @foreach(empresas() as $empresa)
                                        <option value="{{ $empresa->id }}" {{ old('empresa') ? (old('empresa') == $empresa->id ? "selected" : "") : ($empresa->id== $contrato->empresa_id ? "selected" : "") }} >{{ $empresa->nombre_comercial }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('empresa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('empresa') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 col-xs-12">
                                <label class="required">Cliente</label>
                                <select id="cliente" name="cliente" class="select2_form form-control {{ $errors->has('cliente') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    @foreach(clientes() as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente') ? (old('cliente') == $cliente->id ? "selected" : "") : ($cliente->id== $contrato->cliente_id ? "selected" : "") }} >{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('cliente'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cliente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class=""><b>Detalle del Contrato</b></h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="col-form-label required">Placa:</label>
                                        <select class="select2_form form-control" onchange="dispositivoprecio(this)"
                                            style="text-transform: uppercase; width:100%" name="dispositivo"
                                            id="dispositivo" >
                                            <option></option>
                                            @foreach (dispositivos() as $dispositivo)
                                            <option value="{{$dispositivo->id}}" data-precio="{{$dispositivo->precio}}">{{$dispositivo->placa}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"><b><span id="error-dispositivo"></span></b>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label required" for="amount">Pago :</label>
                                            <input type="text" id="pago" class="form-control"  >
                                            <div class="invalid-feedback"><b><span id="error-pago"></span></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label required" for="amount">Costo Instalacion:</label>
                                            <input type="text" id="costo_instalacion" class="form-control"  >
                                            <div class="invalid-feedback"><b><span id="error-costo_instalacion"></span></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="amount">&nbsp;</label>
                                            <a class="btn btn-block btn-warning" style='color:white;' id="btn_agregar_detalle"> <i class="fa fa-plus"></i> AGREGAR</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                @if ($errors->has('dispositivo_tabla'))
                                    <h5 style="color:rgb(220,54,70);">{{ $errors->first('dispositivo_tabla') }}</h5>
                                @endif
                                    <table
                                        class="table dataTables-detalle-contrato table-striped table-bordered table-hover"
                                        style="text-transform:uppercase">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">ACCIONES</th>
                                                <th class="text-center">PLACA</th>
                                                <th class="text-center">PAGO</th>
                                                <th class="text-center">COSTO INSTALACION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:right">Total:</th>
                                                <th><span id="total">0.0</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
        @endif
            <input type="hidden" name="dispositivo_tabla" id="dispositivo_tabla"> 
        </fieldset>
        <h1>Contrato Geocerca</h1>
        <fieldset style="position: relative;">
            <div class="ibox">
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
                                        <div class="form-group">
                                            <div class="col-lg-12 col-xs-12">
                                                <label class="required">Rangos</label>
                                                <select id="rangos_gps" name="rangos_gps" class="select2_form form-control" onchange="rangoelegido(this)">
                                                    <option></option>
                                                    @foreach(rangoscontrato() as $rango)
                                                        <option value="{{ $rango->id }}"   >{{ $rango->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
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
            <input type="hidden" name="rango_id" id="rango_id">
         </div>
        </fieldset>
    </form>
    @include('contrato.modal')
    @if (!empty($detalle))
            <input id="detalle" value="{{$detallecontrato}}" type="hidden"> 
             <input id="posiciones_gps" id="posiciones_gps" value="{{$detalle_gps}}" type="hidden">
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
         var map;
    var markers=[];
    var polygon;
         $(document).ready(function() {
                $(".select2_form").select2({
                    placeholder: "SELECCIONAR",
                    allowClear: true,
                    height: '200px',
                    width: '100%',
                });
                $('.input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    language: 'es',
                    format: "yyyy/mm/dd"
                });
                $('.formulario').on('submit',function()
            {   var x = document.getElementById("contenedor");
           x.style.display = "none";
                $('.loader-spinner').show();
            });
                if($('#fecha_inicio').val()==="-")
                {
                $('#fecha_inicio').val(" ");
                $('#fecha_fin').val(" ");
                }
                $('.dataTables-detalle-contrato').DataTable({
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
                                        "<a class='btn btn-sm btn-warning btn-edit' style='color:white'>"+ "<i class='fa fa-pencil'></i>"+"</a>" +
                                        "<a class='btn btn-sm btn-danger btn-delete' style='color:white'>"+"<i class='fa fa-trash'></i>"+"</a>"+ 
                                        "</div>";
                        }
                    },
                    {
                        "targets": [2],
                    },
                    {
                        "targets": [3],
                    },
                    {
                        "targets": [4],
                    },
                ],
                'bAutoWidth': false,
                'aoColumns': [
                    { sWidth: '0%' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },
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
               var t = $('.dataTables-detalle-contrato').DataTable();
               for (var i = 0; i < detalle.length; i++) {
                  t.row.add([
                    detalle[i].dispositivo_id,
                    '',
                    detalle[i].placa,
                    detalle[i].pago,
                    detalle[i].costo_instalacion,
                    detalle[i].costo_instalacion,
                   ]).draw(false);
                }
                 guardardispositivos();
            }
            });
            $("#form_registrar_contrato").steps({
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
             /*  if (currentIndex > newIndex)
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
                return validarDatos(currentIndex + 1);*/
                return true;
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
                var form = $(this);
                // Submit form input
                 form.submit();
            }
        });
            function fechafinal(e)
            {
                var start= new Date($(e).val());
                start.setFullYear(start.getFullYear()+1);
                var final = start.toISOString().slice(0,10).replace(/-/g,"/");
                $('#fecha_fin').val( final);
            }
            function limpiarErrores() {
            $('#pago').removeClass("is-invalid")
            $('#error-precio').text('')
            $('#dispositivo').removeClass("is-invalid")
            $('#error-dispositivo').text('')
            $('#costo_instalacion').removeClass("is-invalid")
            $('#erro-costo_instalacion').removeClass("is-invalid")
            }
            function buscardispositivo(id) {
                    var existe = false;
                    var t = $('.dataTables-detalle-contrato').DataTable();
                    t.rows().data().each(function(el, index) {
                        if (el[0] == id) {
                            existe = true
                        }
                    });
                    return existe
            }
            $("#btn_agregar_detalle").click(function() {
                limpiarErrores()
                var enviar = false;
                if ($('#dispositivo').val() == '') {
                    toastr.error('Seleccione dispositivo.', 'Error');
                    enviar = true;
                    $('#dispositivo').addClass("is-invalid")
                    $('#error-dispositivo').text('El campo Dispositivo es obligatorio.')
                } else {
                    var existe = buscardispositivo($('#dispositivo').val())
                    if (existe == true) {
                        toastr.error('dispositivo ya se encuentra ingresado.', 'Error');
                        enviar = true;
                    }
                }
                if ($('#pago').val() == '') {
                    toastr.error('Ingrese el precio del despositivo.', 'Error');
                    enviar = true;
                    $("#pago").addClass("is-invalid");
                    $('#error-precio').text('El campo Precio es obligatorio.')
                }
                if ($('#costo_instalacion').val() == '') {
                    toastr.error('Ingrese el costo instalacion del despositivo.', 'Error');
                    enviar = true;
                    $("#costo_instalacion").addClass("is-invalid");
                    $('#error-costo_instalacion').text('El campo costo instalacion es obligatorio.')
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
            });
            function llegarDatos() {
                var detalle = {
                    producto_id: $('#dispositivo').val(),
                    presentacion: $( "#dispositivo option:selected" ).text(),
                    precio: $('#pago').val(),
                    costo:$('#costo_instalacion').val(),
                }
                agregarTabla(detalle);
            }
            function agregarTabla($detalle) {
                var t = $('.dataTables-detalle-contrato').DataTable();
                t.row.add([
                    $detalle.producto_id,
                    '',
                    $detalle.presentacion,
                    $detalle.precio,
                    $detalle.costo,
                ]).draw(false);
                 guardardispositivos();
            }
            $(document).on('click', '.btn-edit', function(event) {
            var table = $('.dataTables-detalle-contrato').DataTable();
            var data = table.row($(this).parents('tr')).data();
            $('#modal_editar_detalle #indice').val(table.row($(this).parents('tr')).index());
            $("#modal_editar_detalle #dispositivo").val(data[0]).trigger('change');
            $('#modal_editar_detalle #pago').val(data[3]);
            $('#modal_editar_detalle #costo_instalacion').val(data[4]);
            $('#modal_editar_detalle').modal('show');
            });
          function guardardispositivos()
          {
            var dispositivo = [];
            var table = $('.dataTables-detalle-contrato').DataTable();
            var data = table.rows().data();
            var total=0;
            data.each(function(value, index) {
                total=total+parseFloat(value[4]);
                let fila = {
                    dispositivo_id: value[0],
                    pago: value[3],
                    costo:value[4],
                };
                dispositivo.push(fila);
            });
            $('#dispositivo_tabla').val(JSON.stringify(dispositivo));
            $('#total').html(total);
          }
          $(document).on('click', '.btn-delete', function(event) {
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
                        var table = $('.dataTables-detalle-contrato').DataTable();
                        table.row($(this).parents('tr')).remove().draw();
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
            });
            function dispositivoprecio(e)
            {
               $('#pago').val($(e).find(':selected').data('precio'));
            }
            function initMap() {
          polygon = new google.maps.Polygon();
          map = new google.maps.Map(document.getElementById("map"), {
                                  zoom: 12,
                                  center: { lat: -8.1092027, lng: -79.0244529 },
                                  gestureHandling: "greedy",
                                  draggableCursor: "default"
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
          if($('#posiciones_gps').val()!=undefined)
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
                        $("#rango_id").val(detalle[i].rango_id);
            }
            //
            centrar();
            //
          }
	}
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
    function rangoelegido(e)
    {
        var id= $(e).val();
          $.ajax({
              dataType : 'json',
              type : 'POST',
              url : '{{ route('contrato.rangospuntos') }}',
              data : {
                  '_token' : $('input[name=_token]').val(),
                  'id': id
              }
          }).done(function (detalle){
        
              for(var j=0;j<markers.length;j++)
              {
                  markers[j].setMap(null);
              }     
               markers=[];
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
            centrar();
          });
      
    }
    function centrar()
    {
        var bounds = new google.maps.LatLngBounds();
                for (i = 0; i < markers.length; i++) {
                bounds.extend(markers[i].getPosition());
                }
                map.setCenter({lat: bounds.getCenter().lat(), lng: bounds.getCenter().lng()});
    }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&libraries=geometry&callback=initMap" async
    ></script>
@endpush