<div class="wrapper wrapper-content animated fadeIn" id="contenedor" >
    <form class="wizard-big formulario" action="{{ $action }}" method="POST" id="form_registrar_rango">
        @csrf
        <h1>Contrato Geocerca</h1> 
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
        @endif
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
                                        <div class="col-lg-6">
                                            <label class="required">Nombre</label>
                                            <input type="text" id="nombre" name="nombre" class="form-control" value="{{old('nombre')?old('nombre'):$rangos->nombre}}" required>
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

            });
            $("#form_registrar_rango").steps({
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
                var nombre=$("#nombre").val();

               if(markers.length==0 || nombre.length==0)
                {
                   toastr.error('Complete la información de los campos obligatorios (*)','Error');  
                }
                else if(markers.length<4)
                {
                    toastr.error('por lo menos son 4 posiciones (*)','Error'); 
                }
                else
                {
                var form = $(this);
                // Submit form input
             form.submit();
                }
               /* var form = $(this);
                // Submit form input
                 form.submit();*/
            }
        });
           
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

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&libraries=geometry&callback=initMap" async
    ></script>
@endpush