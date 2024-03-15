<template>
    <div>
        <div class="row" style="background: white">
            <div class="col-lg-12" style="padding: 0px">
                <div id="map" style="height: 700px"></div>
            </div>
        </div>
        <div class="ibox" id="carrera" style="margin: 0px !important">
            <div class="ibox-title" style="padding: 5px 50px 8px 15px">
                <div class="input-group">
                    <input
                        class="form-control"
                        style=""
                        id="myInput"
                        v-on:key-up="buscar()"
                        type="text"
                        placeholder="Busquedad"
                    />
                    <span class="input-group-append"
                        ><a
                            style="
                                color: black;
                                cursor: default;
                                background-color: white !important;
                                border-top: 1px solid rgb(229, 230, 231) !important;
                                border-right: 1px solid rgb(229, 230, 231) !important;
                                border-bottom: 1px solid rgb(229, 230, 231) !important;
                                border-left: none;
                            "
                            class="btn btn-primary"
                        >
                            <i class="fa fa-search"></i></a
                    ></span>
                </div>
                <div
                    class="ibox-tools"
                    style="top: 5px !important; right: 5px !important"
                >
                    <a
                        class="collapse-link btn btn-primary"
                        id="ocultar_dispositivos"
                        data-ocultado="0"
                    >
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding: 0px !important">
                <div style="height: 245px !important" class="contenedor">
                    <table class="table table-bordered" style="">
                        <tbody id="myTable">
                            <tr
                                v-for="item in dispositivos_data"
                                :key="item.id"
                                @click="zoom(item)"
                            >
                                <td style="padding: 0px 0px 0px 0px">
                                    <div class="padre">
                                        <div class="one">
                                            <!-- <input
                                                type="checkbox"
                                                class="i-checks"
                                                :name="'check_' + item.imei"
                                            /> -->
                                        </div>
                                        <div class="two">
                                            {{ item.placa }}
                                            <br />
                                            <p
                                                style="
                                                    margin: 0px;
                                                    color: rgb(168, 161, 161);
                                                "
                                                id="last_time"
                                            >
                                                {{
                                                    item.dispositivo_ubicacion !=
                                                    null
                                                        ? item
                                                              .dispositivo_ubicacion
                                                              .fecha
                                                        : "-"
                                                }}
                                            </p>
                                        </div>

                                        <div class="three">
                                            <p id="last_velocidad">
                                                {{
                                                    item.dispositivo_ubicacion !=
                                                    null
                                                        ? item
                                                              .dispositivo_ubicacion
                                                              .velocidad
                                                        : "-"
                                                }}
                                            </p>
                                        </div>
                                        <div id="estado_gps" class="four">
                                            <div
                                                v-if="
                                                    item.estado_dispositivo
                                                        .movimiento ==
                                                        'Movimiento' &&
                                                        item.estado_dispositivo
                                                            .estado ==
                                                            'Conectado'
                                                "
                                                class="circulo"
                                                style="background-color: green"
                                            ></div>
                                            <div
                                                v-if="
                                                    item.estado_dispositivo
                                                        .movimiento ==
                                                        'Sin Movimiento' &&
                                                        item.estado_dispositivo
                                                            .estado ==
                                                            'Conectado'
                                                "
                                                class="circulo"
                                                style="background-color: yellow"
                                            ></div>
                                            <div
                                                v-if="
                                                    item.estado_dispositivo
                                                        .estado ==
                                                        'Desconectado'
                                                "
                                                class="circulo"
                                                style="background-color: red"
                                            ></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="leyenda" id="leyenda">
            <div class="row">
                <div class="col-lg-2"><b>LEYENDA</b></div>
                <div class="col-lg-3">
                    <div style="margin-top: 5px">Conectado</div>
                    <div class="circle_gps button" id="button-0"></div>
                </div>
                <div class="col-lg-3">
                    <div style="margin-top: 5px">Desconectado</div>
                    <div class="circle_gps_red button" id="button-0"></div>
                </div>
                <div class="col-lg-3">
                    <div style="margin-top: 5px">Sin Movimiento</div>
                    <div class="circle_gps_yellow button" id="button-0"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user", "dispositivos"],
    data() {
        return {
            map: null,
            markers: [],
            imei: null,
            dispositivos_data: [],
            marcadores_ruta: [],
            polylines: []
        };
    },
    mounted() {
        let $this = this;
        this.dispositivos_data = this.dispositivos;
        this.inicializarMapa();
        $("#myInput").on("keyup", function() {
            var value = $(this)
                .val()
                .toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle(
                    $(this)
                        .text()
                        .toLowerCase()
                        .indexOf(value) > -1
                );
            });
        });
        window.socketClient.on("newUbication" + this.user.id, data => {
            $this.actualizacion(data);
            // console.log(data)
        });
        window.addEventListener("load", function() {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green"
            });
        });
    },
    methods: {
        actualizacion(data) {
            let $this = this;
            let i = -1;
            let nuevo = [];
            this.dispositivos_data.forEach((value, index, array) => {
                if (index == i) {
                    value.estado_dispositivo.movimiento =
                        data.estado_dispositivo.movimiento;
                    value.estado_dispositivo.estado =
                        data.estado_dispositivo.estado;
                    value.dispositivo_ubicacion.velocidad = data.velocidad;
                    value.dispositivo_ubicacion.fecha = data.fecha;
                }
                nuevo.push(value);
            });
            var data_marker = this.markers.find(e => e.imei == data.imei);
            data_marker.marker.setPosition(
                new google.maps.LatLng(
                    parseFloat(data.lat),
                    parseFloat(data.lng)
                )
            );
            data_marker.info.setOptions({
                position: new google.maps.LatLng(
                    parseFloat(data.lat),
                    parseFloat(data.lng)
                )
            });
            this.dispositivos_data = nuevo;
            if (this.imei == data.imei) {
                $this.eliminarMarcadores();
                $this.eliminaruta();
                data.recorrido.forEach((value, index, array) => {
                    let img = value.img;
                    img.scaledSize = new google.maps.Size(40, 40);
                    img.origin = new google.maps.Point(0, 0);
                    let marker = new google.maps.Marker({
                        position: new google.maps.LatLng(
                            parseFloat(value.lat),
                            parseFloat(value.lng)
                        ),
                        icon: img,
                        title: value.placa
                    });
                    marker.setMap($this.map);
                    $this.marcadores_ruta.push(marker);
                });
                $this.drawRoute(data.recorrido_arreglo);
            }
        },
        inicializarMapa() {
            let $this = this;
            this.map = new google.maps.Map(document.getElementById("map"), {
                /*zoom: 12,
                center: { lat: -6.77137, lng: -79.84088 },*/
                zoom:9,
                center:{ lat: -8.11599, lng: -79.02998 },
                gestureHandling: "greedy",
                zoomControl: false,
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: false
            });
            const carrera = document.getElementById("carrera");
            this.map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(
                carrera
            );
            const leyenda = document.getElementById("leyenda");
            this.map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(
                leyenda
            );
            const image = {
                url: window.location.origin + "/img/gps.png",
                // This marker is 20 pixels wide by 32 pixels high.
                scaledSize: new google.maps.Size(50, 50)
                // The origin for this image is (0, 0).
            };
            this.dispositivos_data.forEach((value, index, array) => {
                if (value.dispositivo_ubicacion != null) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(
                            parseFloat(value.dispositivo_ubicacion.lat),
                            parseFloat(value.dispositivo_ubicacion.lng)
                        ),
                        icon: image,
                        title: value.placa
                    });
                    marker.setMap($this.map);

                    google.maps.event.clearInstanceListeners(marker);
                    //apartado para la placa --start
                    var myOptions = {
                        disableAutoPan: true,
                        maxWidth: 0,
                        pixelOffset: new google.maps.Size(-40, -69),
                        zIndex: null,
                        closeBoxURL: "",
                        position: new google.maps.LatLng(
                            parseFloat(value.dispositivo_ubicacion.lat),
                            parseFloat(value.dispositivo_ubicacion.lng)
                        ),
                        infoBoxClearance: new google.maps.Size(1, 1),
                        isHidden: false,
                        pane: "floatPane",
                        enableEventPropagation: false
                    };
                    myOptions.content =
                        '<div class="info-box-wrap"><div class="info-box-text-wrap">' +
                        value.placa +
                        "</div></div>";
                    var ibLabel = new InfoBox(myOptions);
                    ibLabel.open($this.map);
                    $this.markers.push({
                        marker: marker,
                        imei: value.imei,
                        info: ibLabel
                    });
                }
            });
        },
        zoom: async function(item) {
            let $this = this;
            var data = this.markers.find(e => e.imei == item.imei);
            if (data != undefined) {
                var posicion = data.marker.getPosition();
                if (data.marker.getMap() != null) {
                    this.map.setZoom(16);
                    this.map.setCenter(posicion);
                }
                if (item.estado_dispositivo.estado != "Desconectado") {
                    this.imei = item.imei;
                    let datos = await axios.get(
                        window.location.origin + "/gpsruta",
                        {
                            params: {
                                imei: this.imei
                            }
                        }
                    );
                    this.eliminarMarcadores();
                    this.eliminaruta();
                    datos.data.recorrido.forEach((value, index, array) => {
                        let img = value.img;
                        img.scaledSize = new google.maps.Size(40, 40);
                        img.origin = new google.maps.Point(0, 0);
                        let marker = new google.maps.Marker({
                            position: new google.maps.LatLng(
                                parseFloat(value.lat),
                                parseFloat(value.lng)
                            ),
                            icon: value.img,
                            title: value.placa
                        });
                        marker.setMap($this.map);
                        this.marcadores_ruta.push(marker);
                    });
                    this.drawRoute(datos.data.data_recorrido);
                }
            }

            //console.log(datos);
        },
        drawRoute: function(lineCoordinates) {
            var pointCount = lineCoordinates.length;
            var linePath = [];
            for (var i = 0; i < pointCount; i++) {
                var tempLatLng = new google.maps.LatLng(
                    lineCoordinates[i][0],
                    lineCoordinates[i][1]
                );
                linePath.push(tempLatLng);
            }
            var lineOptions = {
                path: linePath,
                strokeWeight: 7,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8
            };
            var polyline = new google.maps.Polyline(lineOptions);
            polyline.setMap(this.map);
            this.polylines.push(polyline);
        },
        eliminarMarcadores() {
            this.marcadores_ruta.forEach((value, index, array) => {
                value.setMap(null);
            });
            this.marcadores_ruta = [];
        },
        eliminaruta() {
            this.polylines.forEach((value, index, array) => {
                value.setMap(null);
            });
            this.polylines = [];
        }
    }
};
</script>
