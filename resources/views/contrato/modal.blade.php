<div class="modal inmodal" id="modal_editar_detalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Detalle del Contrato</h4>
                <small class="font-bold">Editar detalle</small>
            </div>
            <div class="modal-body">
                <input type="hidden" id="indice" name="indice">
                <div class="form-group">
                    <label class="">Dispositivos</label>
                    <select id="dispositivo" name="dispositivo" class="select2_form form-control" disabled>
                        <option></option>
                        @foreach (dispositivos() as $dispositivo)
                                <option value="{{$dispositivo->id}}">{{$dispositivo->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6 col-xs-12">
                        <label class="required">Pago</label>
                        <input type="text" id="pago" name="pago" class="form-control" maxlength="15" onkeypress="return filterFloat(event, this, true);" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6 col-xs-12">
                        <label class="required">Costo Instalacion</label>
                        <input type="text" id="costo_instalacion" name="costo_instalacion" class="form-control" maxlength="15" onkeypress="return filterFloat(event, this, true);" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-6 text-left">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" id="btn_editar" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
                    <button type="button"  class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
//Validacion al ingresar tablas
$("#btn_editar").click(function() {
    // limpiarErrores()
    var enviar = false;
    if ($('#modal_editar_detalle #pago').val() == '') {
        toastr.error('Ingrese el precio del Dispositivo.', 'Error');
        enviar = true;
    }
    if (enviar != true) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
                container: 'my-swal',
            },
            buttonsStyling: false
        })
        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Modificar',
            text: "¿Seguro que desea Modificar Dispositivo?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                actualizarTabla($('#modal_editar_detalle #indice').val());
            } else if (
                //Read more about handling dismissals below
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
})
function actualizarTabla(i) {
    var table = $('.dataTables-detalle-contrato').DataTable();
    table.row(i).remove().draw();
    var detalle = {
                    producto_id: $('#modal_editar_detalle #dispositivo').val(),
                    presentacion: $( "#modal_editar_detalle #dispositivo option:selected" ).text(),
                    precio: $('#modal_editar_detalle #pago').val(),
                    costo:$('#modal_editar_detalle #costo_instalacion').val(),
                }
    agregarTabla(detalle);
}
</script>
@endpush
