$(document).on("click", ".boton-editar", function() {
    if ($("#modal_editar_geocerca #nombre_contrato_rango").val().length != 0) {
        var table = $(".dataTables-detalle-geocerca").DataTable();
        table
            .row($("#modal_editar_geocerca #indice").val())
            .remove()
            .draw();

        var arreglo = JSON.parse(
            $("#modal_editar_geocerca #geocerca_gps").val()
        );
        var t = $(".dataTables-detalle-geocerca").DataTable();
        t.row
            .add([
                "",
                $("#modal_editar_geocerca #nombre_contrato_rango").val(),
                arreglo
            ])
            .draw(false);
        guardar();
        $("#modal_editar_geocerca").modal("hide");
    } else {
        toastr.error("Ingrese todo los datos", "Error");
    }
});
