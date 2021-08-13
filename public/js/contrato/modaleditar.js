$("#btn_editar").on("click", function() {
    if ($("#modal_editar_detalle #pago").val() == "") {
        toastr.error("Ingrese el precio del Dispositivo.", "Error");
    }
    else {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
                container: "my-swal"
            },
            buttonsStyling: false
        });
        Swal.fire({
            customClass: {
                container: "my-swal"
            },
            title: "Opción Modificar",
            text: "¿Seguro que desea Modificar Dispositivo?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: "Si, Confirmar",
            cancelButtonText: "No, Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                actualizarTabla($("#modal_editar_detalle #indice").val());
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    "Cancelado",
                    "La Solicitud se ha cancelado.",
                    "error"
                );
            }
        });
    }
});
function actualizarTabla(i) {
    var table = $(".dataTables-detalle-contrato").DataTable();
    table
        .row(i)
        .remove()
        .draw();
    agregarTabla({
        producto_id: $("#modal_editar_detalle #dispositivo").val(),
        presentacion: $(
            "#modal_editar_detalle #dispositivo option:selected"
        ).text(),
        precio: $("#modal_editar_detalle #pago").val(),
        costo: $("#modal_editar_detalle #costo_instalacion").val()
    });
    $("#modal_editar_detalle").modal("hide")
}
