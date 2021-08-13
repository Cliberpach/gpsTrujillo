$(function() {
    $(".select2_form").select2({
        placeholder: "SELECCIONAR",
        allowClear: true,
        height: "200px",
        width: "100%"
    });
    $(".input-group.date").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        language: "es",
        format: "yyyy/mm/dd"
    });
    $(".formulario").on("submit", function() {
        var x = document.getElementById("contenedor");
        x.style.display = "none";
        $(".loader-spinner").show();
    });
    if ($("#fecha_inicio").val() === "-") {
        $("#fecha_inicio").val(" ");
        $("#fecha_fin").val(" ");
    }
    $(".dataTables-detalle-contrato").DataTable({
        dom: "lTfgitp",
        bPaginate: true,
        bLengthChange: true,
        responsive: true,
        bFilter: true,
        bInfo: false,
        columnDefs: [
            {
                targets: 0,
                visible: false,
                searchable: false
            },
            {
                searchable: false,
                targets: [1],
                data: null,
                render: function(data, type, row) {
                    return (
                        "<div class='btn-group'>" +
                        "<a class='btn btn-sm btn-warning btn-edit' style='color:white'>" +
                        "<i class='fa fa-pencil'></i>" +
                        "</a>" +
                        "<a class='btn btn-sm btn-danger btn-delete' style='color:white'>" +
                        "<i class='fa fa-trash'></i>" +
                        "</a>" +
                        "</div>"
                    );
                }
            },
            {
                targets: [2]
            },
            {
                targets: [3]
            },
            {
                targets: [4]
            }
        ],
        bAutoWidth: false,
        aoColumns: [
            {
                sWidth: "0%"
            },
            {
                sWidth: "15%",
                sClass: "text-center"
            },
            {
                sWidth: "15%",
                sClass: "text-center"
            },
            {
                sWidth: "15%",
                sClass: "text-center"
            },
            {
                sWidth: "15%",
                sClass: "text-center"
            }
        ],
        language: {
            url: window.location.origin + "/Spanish.json"
        },
        order: [[0, "desc"]]
    });
    $(".dataTables-detalle-geocerca").DataTable({
        dom: "lTfgitp",
        bPaginate: true,
        bLengthChange: true,
        responsive: true,
        bFilter: true,
        bInfo: false,
        columnDefs: [
            {
                searchable: false,
                targets: [0],
                data: null,
                render: function(data, type, row) {
                    return (
                        "<div class='btn-group'>" +
                        "<a class='btn btn-sm btn-warning btn-edit-geocerca' style='color:white'>" +
                        "<i class='fa fa-pencil'></i>" +
                        "</a>" +
                        "<a class='btn btn-sm btn-danger btn-delete-geocerca' style='color:white'>" +
                        "<i class='fa fa-trash'></i>" +
                        "</a>" +
                        "</div>"
                    );
                }
            },
            {
                targets: [1]
            },
            {
                targets: [2],
                visible: false,
                searchable: false
            }
        ],
        bAutoWidth: false,
        aoColumns: [
            {
                sWidth: "15%",
                sClass: "text-center"
            },
            {
                sWidth: "15%",
                sClass: "text-center"
            },
            {
                sWidth: "0%"
            }
        ],
        language: {
            url: window.location.origin + "/Spanish.json"
        },
        order: [[1, "desc"]]
    });
    if (!($("#detalle").val() === undefined)) {
        var detalle = JSON.parse($("#detalle").val());
        var t = $(".dataTables-detalle-contrato").DataTable();
        detalle.forEach(value => {
            t.row
                .add([
                    value.dispositivo_id,
                    "",
                    value.placa,
                    value.pago,
                    value.costo_instalacion,
                    value.costo_instalacion
                ])
                .draw(false);
        });
        guardardispositivos();
        var detalle_gps = JSON.parse($("#posiciones_gps").val());
        var tabla = $(".dataTables-detalle-geocerca").DataTable();
        detalle_gps.forEach(value => {
            tabla.row.add(["", value.nombre, value.geocerca]).draw(false);
        });
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
    onStepChanging: function(event, currentIndex, newIndex) {
        return true;
    },
    onStepChanged: function(event, currentIndex, priorIndex) {},
    onFinishing: function(event, currentIndex) {
        var form = $(this);
        return true;
    },
    onFinished: function(event, currentIndex) {
        var form = $(this);
        form.submit();
    }
});

function fechafinal(e) {
    var start = new Date($(e).val());
    start.setFullYear(start.getFullYear() + 1);
    var final = start
        .toISOString()
        .slice(0, 10)
        .replace(/-/g, "/");
    $("#fecha_fin").val(final);
}

function limpiarErrores() {
    $("#pago").removeClass("is-invalid");
    $("#error-precio").text("");
    $("#dispositivo").removeClass("is-invalid");
    $("#error-dispositivo").text("");
    $("#costo_instalacion").removeClass("is-invalid");
    $("#erro-costo_instalacion").removeClass("is-invalid");
}

function buscardispositivo(id) {
    var existe = false;
    var t = $(".dataTables-detalle-contrato").DataTable();
    t.rows()
        .data()
        .each(function(el, index) {
            if (el[0] == id) {
                existe = true;
            }
        });
    return existe;
}
$("#btn_agregar_detalle").on("click", function() {
    limpiarErrores();
    var enviar = false;
    if ($("#dispositivo").val() == "") {
        toastr.error("Seleccione dispositivo.", "Error");
        enviar = true;
        $("#dispositivo").addClass("is-invalid");
        $("#error-dispositivo").text("El campo Dispositivo es obligatorio.");
    } else {
        var existe = buscardispositivo($("#dispositivo").val());
        if (existe == true) {
            toastr.error("dispositivo ya se encuentra ingresado.", "Error");
            enviar = true;
        }
    }
    if ($("#pago").val() == "") {
        toastr.error("Ingrese el precio del despositivo.", "Error");
        enviar = true;
        $("#pago").addClass("is-invalid");
        $("#error-precio").text("El campo Precio es obligatorio.");
    }
    if ($("#costo_instalacion").val() == "") {
        toastr.error("Ingrese el costo instalacion del despositivo.", "Error");
        enviar = true;
        $("#costo_instalacion").addClass("is-invalid");
        $("#error-costo_instalacion").text(
            "El campo costo instalacion es obligatorio."
        );
    }
    if (enviar != true) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        Swal.fire({
            title: "Opción Agregar",
            text: "¿Seguro que desea agregar Dispositivo?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: "Si, Confirmar",
            cancelButtonText: "No, Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                llegarDatos();
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

function llegarDatos() {
    var detalle = {
        producto_id: $("#dispositivo").val(),
        presentacion: $("#dispositivo option:selected").text(),
        precio: $("#pago").val(),
        costo: $("#costo_instalacion").val()
    };
    agregarTabla(detalle);
}

function agregarTabla($detalle) {
    var t = $(".dataTables-detalle-contrato").DataTable();
    t.row
        .add([
            $detalle.producto_id,
            "",
            $detalle.presentacion,
            $detalle.precio,
            $detalle.costo
        ])
        .draw(false);
    guardardispositivos();
}
$(document).on("click", ".btn-edit", function(event) {
    var table = $(".dataTables-detalle-contrato").DataTable();
    var data = table.row($(this).parents("tr")).data();
    $("#modal_editar_detalle #indice").val(
        table.row($(this).parents("tr")).index()
    );
    $("#modal_editar_detalle #dispositivo")
        .val(data[0])
        .trigger("change");
    $("#modal_editar_detalle #pago").val(data[3]);
    $("#modal_editar_detalle #costo_instalacion").val(data[4]);
    $("#modal_editar_detalle").modal("show");
});

function guardardispositivos() {
    var dispositivo = [];
    var table = $(".dataTables-detalle-contrato").DataTable();
    var data = table.rows().data();
    var total = 0;
    data.each(function(value, index) {
        total = total + parseFloat(value[4]);
        let fila = {
            dispositivo_id: value[0],
            pago: value[3],
            costo: value[4]
        };
        dispositivo.push(fila);
    });
    $("#dispositivo_tabla").val(JSON.stringify(dispositivo));
    $("#total").html(total);
}
$(document).on("click", ".btn-delete", function(event) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    Swal.fire({
        title: "Opción Eliminar",
        text: "¿Seguro que desea eliminar Producto?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: "Si, Confirmar",
        cancelButtonText: "No, Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            var table = $(".dataTables-detalle-contrato").DataTable();
            table
                .row($(this).parents("tr"))
                .remove()
                .draw();
            guardardispositivos();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                "Cancelado",
                "La Solicitud se ha cancelado.",
                "error"
            );
        }
    });
});

function dispositivoprecio(e) {
    $("#pago").val(
        $(e)
            .find(":selected")
            .data("precio")
    );
}
function modificar() {
    var cbnposicion = $("#posicion").val();
    if (cbnposicion != "") {
        var lat = $("#lat").val();
        var lng = $("#lng").val();
        markers[cbnposicion].setPosition(
            new google.maps.LatLng(parseFloat(lat), parseFloat(lng))
        );
        generar();
    }
}
function generar() {
    var areaCoordinates = [];
    markers.forEach(value => {
        areaCoordinates.push([
            value.getPosition().lat(),
            value.getPosition().lng()
        ]);
    });
    var areaPath = [];
    areaCoordinates.forEach(value => {
        areaPath.push(new google.maps.LatLng(value[0], value[1]));
    });
    var polygonOptions = {
        paths: areaPath,
        strokeColor: "#FFFF00",
        strokeOpacity: 0.9,
        strokeWeight: 1,
        fillColor: "#FFFF00",
        fillOpacity: 0.2
    };

    polygon.setOptions(polygonOptions);
    polygon.setMap(map);
}

function rangoelegido(e) {
    var id = $(e).val();
    $.ajax({
        dataType: "json",
        type: "POST",
        url: window.location.origin + "/rangospuntos",
        data: {
            _token: $("input[name=_token]").val(),
            id: id
        }
    }).done(function(detalle) {
        markers.forEach(value => {
            value.setMap(null);
        });
        markers = [];
        for (var i = 0; i < detalle.length; i++) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(
                    parseFloat(detalle[i].lat),
                    parseFloat(detalle[i].lng)
                ),
                map: map,
                draggable: true
            });
            google.maps.event.addListener(marker, "dragend", function() {
                generar();
            });
            markers.push(marker);
            generar();
        }
    });
}

function rangoelegido_editar(e) {
    var id = $(e).val();
    $.ajax({
        dataType: "json",
        type: "POST",
        url: window.location.origin + "/rangospuntos",
        data: {
            _token: $("input[name=_token]").val(),
            id: id
        }
    }).done(function(detalle) {
        for (var j = 0; j < markers_geocerca.length; j++) {
            markers_geocerca[j].setMap(null);
        }
        markers_geocerca = [];
        for (var i = 0; i < detalle.length; i++) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(
                    parseFloat(detalle[i].lat),
                    parseFloat(detalle[i].lng)
                ),
                map: map_geocerca,
                draggable: true
            });
            google.maps.event.addListener(marker, "dragend", function() {
                generar_editar();
            });
            markers_geocerca.push(marker);
            generar_editar();
        }
    });
}
$("#btnguardar").on("click", function() {
    if (
        (markers.length >= 3) &
        ($("#nombre_contrato_rango").val().length != 0)
    ) {
        var arreglo = [];
        markers.forEach(value => {
            arreglo.push([
                value.getPosition().lat(),
                value.getPosition().lng()
            ]);
        });

        var t = $(".dataTables-detalle-geocerca").DataTable();
        t.row.add(["", $("#nombre_contrato_rango").val(), arreglo]).draw(false);
        guardar();
        limpiarMarcadores();
    } else {
        toastr.error(
            "Falta datos,los marcadores deben ser de 3 a mas o el nombre falta",
            "Error"
        );
    }
});

function limpiarMarcadores() {
    markers.forEach(value => {
        value.setMap(null);
    });
    markers = [];
    polygon.setMap(null);
}
$(document).on("click", ".btn-edit-geocerca", function(event) {
    var table = $(".dataTables-detalle-geocerca").DataTable();
    var data = table.row($(this).parents("tr")).data();
    $("#modal_editar_geocerca #indice").val(
        table.row($(this).parents("tr")).index()
    );
    $("#modal_editar_geocerca #nombre_contrato_rango").val(data[1]);
    var detalle = data[2];
    for (var j = 0; j < markers_geocerca.length; j++) {
        markers_geocerca[j].setMap(null);
    }
    markers_geocerca = [];
    for (var i = 0; i < detalle.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(
                parseFloat(detalle[i][0]),
                parseFloat(detalle[i][1])
            ),
            map: map_geocerca,
            draggable: true
        });
        google.maps.event.addListener(marker, "dragend", function() {
            generar_editar();
        });
        markers_geocerca.push(marker);
        generar_editar();
    }
    $("#modal_editar_geocerca").modal("show");
});

function generar_editar() {
    var areaCoordinates = [];
    for (var i = 0; i < markers_geocerca.length; i++) {
        var arreglo = [];
        arreglo.push(markers_geocerca[i].getPosition().lat());
        arreglo.push(markers_geocerca[i].getPosition().lng());
        areaCoordinates.push(arreglo);
    }
    var pointCount = areaCoordinates.length;
    var areaPath = [];
    var arreglo_geocerca = [];
    for (var i = 0; i < pointCount; i++) {
        var tempLatLng = new google.maps.LatLng(
            areaCoordinates[i][0],
            areaCoordinates[i][1]
        );
        areaPath.push(tempLatLng);

        var latlng = [];
        latlng.push(areaCoordinates[i][0]);
        latlng.push(areaCoordinates[i][1]);
        arreglo_geocerca.push(latlng);
    }
    var polygonOptions = {
        paths: areaPath,
        strokeColor: "#FFFF00",
        strokeOpacity: 0.9,
        strokeWeight: 1,
        fillColor: "#FFFF00",
        fillOpacity: 0.2
    };

    polygon.setOptions(polygonOptions);
    polygon.setMap(map_geocerca);
    $("#modal_editar_geocerca #geocerca_gps").val(
        JSON.stringify(arreglo_geocerca)
    );
}

function guardar() {
    var arreglo = [];
    var data = $(".dataTables-detalle-geocerca")
        .DataTable()
        .order([1, "asc"])
        .rows()
        .data();
    data.each(function(value, index) {
        let fila = {
            geocerca: value[2],
            nombre: value[1]
        };
        arreglo.push(fila);
    });
    $("#posiciones_guardar").val(JSON.stringify(arreglo));
}
$(document).on("click", ".btn-delete-geocerca", function(event) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    Swal.fire({
        title: "Opción Eliminar",
        text: "¿Seguro que desea eliminar Geocerca?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: "Si, Confirmar",
        cancelButtonText: "No, Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            var table = $(".dataTables-detalle-geocerca").DataTable();
            table
                .row($(this).parents("tr"))
                .remove()
                .draw();
            guardar();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                "Cancelado",
                "La Solicitud se ha cancelado.",
                "error"
            );
        }
    });
});
