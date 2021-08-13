function notificaciones(url) {
    $.ajax({
        dataType: "json",
        type: "POST",
        url: url,
        data: {
            _token: $("input[name=_token]").val(),
        },
    }).done(function (result) {
        //console.log(result);
        if (result.length != 0) {
            var sinleer = -1;
            var cuerpo = " ";
            var tamaño = 0;
            if (result.length > 5) {
                tamaño = 5;
            } else {
                tamaño = result.length;
            }
            for (var i = 0; i < tamaño; i++) {
                if (result[i].readuser == "0") {
                    sinleer = sinleer + 1;
                }
                var fecha_actual = new Date();
                var fecha = new Date(result[i].creado);
                var minutos = diff_minutes(fecha, fecha_actual);
                var tiempo;
                if (minutos == 0) {
                    tiempo = "Justo ahora.";
                } else if (minutos > 0 && minutos < 60) {
                    if (minutos == 1) {
                        tiempo = "hace " + minutos + " minuto.";
                    } else {
                        tiempo = "hace " + minutos + " minutos.";
                    }
                } else if (minutos >= 60 && minutos < 1440) {
                    var hora = Math.floor(minutos / 60);
                    var minuto = minutos % 60;
                    if (hora == 1) {
                        if (minuto == 1) {
                            tiempo =
                                "hace " + hora + " Hora " + minuto + " minuto";
                        } else {
                            tiempo =
                                "hace " + hora + " Hora " + minuto + " minutos";
                        }
                    } else {
                        if (minuto == 1) {
                            tiempo =
                                "hace " + hora + " Horas " + minuto + " minuto";
                        } else {
                            tiempo =
                                "hace " +
                                hora +
                                " Horas " +
                                minuto +
                                " minutos";
                        }
                    }
                } else {
                    var date = fecha.getDate();
                    var month = fecha.getMonth();
                    var year = fecha.getFullYear();
                    //  console.log(date,month+1,year);
                    tiempo = year + "/" + (month + 1) + "/" + date;
                }
                if (result[i].informacion === "Se desconecto la bateria") {
                    cuerpo =
                        cuerpo +
                        "<li><a href='#' class='dropdown-item'><div><img src='" +
                        window.location.origin +
                        "/img/gps.png' width='40px'>" +
                        " " +
                        result[i].informacion +
                        " " +
                        result[i].placa +
                        "  " +
                        "<img src='" +
                        windows.location.origin +
                        "/img/bateria.png' width='70px' style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>" +
                        tiempo +
                        "</a></li><li class='dropdown-divider'></li>";
                } else if (
                    result[i].informacion === "Aumento de la velocidad"
                ) {
                    cuerpo =
                        cuerpo +
                        "<li><a href='#' class='dropdown-item'><div><img src='" +
                        windows.location.origin +
                        "/img/gps.png' width='40px'>" +
                        " " +
                        result[i].informacion +
                        " " +
                        result[i].placa +
                        "  " +
                        "<img src='" +
                        windows.location.origin +
                        "/img/exceso.png' width='70px' style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>" +
                        tiempo +
                        "</a></li><li class='dropdown-divider'></li>";
                } else if (
                    result[i].informacion === "Ocurrio una alerta de ayuda"
                ) {
                    cuerpo =
                        cuerpo +
                        "<li><a href='#' class='dropdown-item'><div><img src='" +
                        windows.location.origin +
                        "/img/gps.png' width='40px'>" +
                        " " +
                        result[i].informacion +
                        " " +
                        result[i].placa +
                        "  " +
                        "<img src='" +
                        windows.location.origin +
                        "/img/ayuda.png' width='70px' style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>" +
                        tiempo +
                        "</a></li><li class='dropdown-divider'></li>";
                } else if (result[i].informacion === "fuera de rango") {
                    cuerpo =
                        cuerpo +
                        "<li><a href='#' class='dropdown-item'><div><img src='" +
                        windows.location.origin +
                        "/img/gps.png' width='40px'>" +
                        " " +
                        result[i].informacion +
                        " " +
                        result[i].placa +
                        "  " +
                        "<img src='" +
                        windows.location.origin +
                        "/img/rango.png' width='70px'  style='margin:0px 0px 0px 20px;border-radius: 10%;float: right;'></div>" +
                        tiempo +
                        "</a></li><li class='dropdown-divider'></li>";
                }
            }
            cuerpo =
                cuerpo +
                "<div style='text-align: center;'><a href='{{ route('notificacion.index') }}'>ver todos</a></div>";
            $("#notificacion_cuerpo").html(cuerpo);
            $("#notificacion_cabecera").html(
                '<i class="fa fa-bell"></i>  <span class="label label-primary" >' +
                    (sinleer + 1) +
                    "</span>"
            );
        } else {
            var c =
                "<li><a class='dropdown-item' ><div><i class='fa fa-envelope fa-fw'></i>No hay datos</div></a></li>";
            $("#notificacion_cuerpo").html(c);
            $("#notificacion_cabecera").html(
                '<i class="fa fa-bell"></i>  <span class="label label-primary" >0</span>'
            );
        }
    });
}
function diff_minutes(dt1, dt2) {
    var diff = (dt2.getTime() - dt1.getTime()) / 1000;
    diff = diff / 60;
    return Math.round(diff);
}
function abrirnotificacion() {
    var notificacion = document
        .getElementById("notificacion_todo")
        .classList.contains("show");
    if (notificacion === false) {
        $("#notificacion_cuerpo").addClass("show");
        $("#notificacion_todo").addClass("show");
        document
            .getElementById("notificacion_cabecera")
            .setAttribute("aria-expanded", "true");
        $.ajax({
            dataType: "json",
            type: "POST",
            url: url_notificacion_data,
            data: {
                _token: $("input[name=_token]").val(),
            },
        }).done(function (result) {
            $("#notificacion_cabecera").html(
                '<i class="fa fa-bell"></i>  <span class="label label-primary" >0</span>'
            );
        });
    } else {
        $("#notificacion_cuerpo").removeClass("show");
        $("#notificacion_todo").removeClass("show");
        document
            .getElementById("notificacion_cabecera")
            .setAttribute("aria-expanded", "false");
    }
}
