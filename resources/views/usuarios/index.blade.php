@extends('layout')
@section('content')
@section('mantenimiento-active', 'active')
@section('usuarios-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Listado de usuarios</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>usuarios</strong>
            </li>
        </ol>
    </div>
    
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables-usuarios table-striped table-bordered table-hover"  style="text-transform:uppercase">
                            <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
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
    <input type="hidden" name="roles" id="roles" value="{{roles()}}">
</div>
@stop
@push('styles')
    <!-- DataTable -->
    <link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <!-- DataTable -->
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // DataTables
            $('.dataTables-usuarios').DataTable({
                "dom": '<"html5buttons"B>lTfgitp',
                "buttons": [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'usuarios'
                    },
                    {
                        titleAttr: 'Imprimir',
                        extend: 'print',
                        text:      '<i class="fa fa-print"></i> Imprimir',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    } 
                ],
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bInfo": true,
                "bAutoWidth": false,
                "processing":true,
                "ajax": "{{ route('usuarios.getTable')}}",
                "columns": [
                    {data: 'usuario', className:"text-center"},
                    {data: 'email', className:"text-left"},
                    {
                        data: null, className:"text-center",
                        render:function(data){
                            var roles=JSON.parse($('#roles').val());
                            var html="<select id='tipo_documento_contacto' onchange='cambiorol(this)' data-user='"+data.id+"' name='tipo_documento_contacto' class='select2_form form-control'> ";
                                for (var i = 0; i < roles.length; i++) {
                                    if(data.rol===roles[i].name)
                                    {
                                        html=html+"<option value='"+roles[i].id+"' selected >"+roles[i].name+"</option>"
                                    }
                                    else{
                                        html=html+"<option  value='"+roles[i].id+"' >"+roles[i].name+"</option>"
                                    }
                     
                                }
                                html=html+"</select>"
                                return html;
                        }
                    }
                ],
                "language": {
                    "url": "{{asset('Spanish.json')}}"
                },
                "order": [],
            });
            // Eventos
            $('#btn_añadir_role').on('click', añadirRole);
        });

        //Controlar Error
        $.fn.DataTable.ext.errMode = 'throw';
        //Modal Eliminar
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        }) 
        function cambiorol(e)
        {
           var user_id=$(e).data('user');
           var rol_id=$(e).val();
            $.ajax({
              dataType : 'json',
              type : 'POST',
              url : '{{ route('usuarios.cambiarrol') }}',
              data : {
                  '_token' : $('input[name=_token]').val(),
                  'rol_id' : rol_id,
                  'user_id' : user_id
              }
          }).done(function (result){
                 
          });
        }
        // Funciones de Eventos
        function añadirRole() {
            window.location = "{{ route('usuarios.create')  }}";
        }
        function eliminar(id) {
            Swal.fire({
                title: 'Opción Eliminar',
                text: "¿Seguro que desea guardar cambios?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: 'Si, Confirmar',
                cancelButtonText: "No, Cancelar",
                allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ruta Eliminar
                    var url_eliminar = '{{ route("usuarios.destroy", ":id")}}';
                    url_eliminar = url_eliminar.replace(':id',id);
                    $(location).attr('href',url_eliminar);
                }else if (
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
