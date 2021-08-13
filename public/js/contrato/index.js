$(function() {
    $(".dataTables-cliente").DataTable({
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                titleAttr: "Excel",
                title: "Clientes"
            },
            {
                titleAttr: "Imprimir",
                extend: "print",
                text: '<i class="fa fa-print"></i> Imprimir',
                customize: function(win) {
                    $(win.document.body).addClass("white-bg");
                    $(win.document.body).css("font-size", "10px");
                    $(win.document.body)
                        .find("table")
                        .addClass("compact")
                        .css("font-size", "inherit");
                }
            }
        ],
        bPaginate: true,
        bLengthChange: true,
        bFilter: true,
        bInfo: true,
        bAutoWidth: false,
        processing: true,
        ajax: window.location.origin + "/contratos/getTable",
        columns: [
            { data: "nombre_comercial", className: "text-center" },
            { data: "nombre", className: "text-left" },
            { data: "fecha_inicio", className: "text-center" },
            { data: "fecha_fin", className: "text-center" },
            { data: "costo_contrato", className: "text-center" },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                    var url_editar =
                        window.location.origin +
                        "/contratos/actualizar/" +
                        data.id;
                    return (
                        "<div class='btn-group'>" +
                        "<a class='btn btn-warning btn-sm modificarDetalle' href='" +
                        url_editar +
                        "' title='Modificar'><i class='fa fa-edit'></i></a>" +
                        "<a class='btn btn-danger btn-sm' href='#' onclick='eliminar(" +
                        data.id +
                        ")' title='Eliminar'><i class='fa fa-trash'></i></a>" +
                        "</div>"
                    );
                }
            }
        ],
        language: {
            url: window.location.origin + "/Spanish.json"
        },
        order: []
    });
    $("#btn_añadir_cliente").on("click",()=> {
        window.location = window.location.origin + "/contratos/registrar"
    });
});
$.fn.DataTable.ext.errMode = "throw";
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});
function eliminar(id) {
    Swal.fire({
        title: "Opción Eliminar",
        text: "¿Seguro que desea guardar cambios?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: "Si, Confirmar",
        cancelButtonText: "No, Cancelar",
        allowOutsideClick: () => !Swal.isLoading()
    }).then(result => {
        if (result.isConfirmed) {
            var url_eliminar =
                window.location.origin + "/contratos/destroy/" + id;
            url_eliminar = url_eliminar.replace(":id", id);
            $(location).attr("href", url_eliminar);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                "Cancelado",
                "La Solicitud se ha cancelado.",
                "error"
            );
        }
    });
}
