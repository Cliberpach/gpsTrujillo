<?php

use App\Models\DispositivoUbicacion;
use App\Models\EstadoDispositivo;
use App\Models\Dispositivo;
use App\Models\Ubicacion;
use App\Models\UbicacionRecorrido;
use React\Socket\ConnectionInterface;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use Illuminate\Database\Capsule\Manager as DB;

class ListaClienteHex
{
    use RecursoDatabase;
    public $conexiones;

    public function __construct()
    {
        $this->conexiones = new SplObjectStorage();
    }
    public function addClient(ConnectionInterface $connection)
    {
        $this->conexiones->attach($connection);
        $this->managedEvents($connection);
    }
    public function managedEvents(ConnectionInterface $connection)
    {

        $connection->on('close', function () use ($connection) {
            $this->disconnectClient($connection);
            $this->conexiones->offsetUnset($connection);
        });
        $connection->on('data', function ($data) use ($connection) {
            $data = bin2hex($data);
            $response = "";
            if (is_null($this->getObject($connection))) {
                $response = $this->firstTime($connection, $data);
            } else {
                $this->typeConnection($connection, $data);
            }
            if (strlen($response) > 0) {
                $connection->write($response);
            }
        });
    }
    public function firstTime(ConnectionInterface $connection, $data)
    {
        $response = "";
        if (strlen($data) == 36 && str_contains($data, "7878")) {
            $gt06n = new GT06N($data);
            $response = $gt06n->responseFirst();
            $this->setObject($connection, $gt06n);
        }
        return $response;
    }
    public function typeConnection(ConnectionInterface $connection, $data)
    {
        $object = $this->getObject($connection);
        if (is_a($object, 'GT06N')) {
            $object->decode($data);
            $object = $this->setObject($connection, $object);
            if ($object->imei != null && $object->lat != null && $object->lng != null) {
                $fecha = $this->dateCurrent();;
                $this->insertUbication($object->imei, $object->lat, $object->lng, $object->data, null);
                $this->rutaDispositivo($object->imei, $fecha);
                $this->estadoDispositivo($object->imei, "Conectado", floatval($object->speed) > 2 ? "Movimiento" : "Sin Movimiento", $object->data);
                $this->nuevaUbicacion($object->imei);
            }
        }
    }
    public function getObject(ConnectionInterface $connection)
    {
        return $this->conexiones->offsetGet($connection);
    }
    public function setObject(ConnectionInterface $connection, $object)
    {
        $this->conexiones->offsetSet($connection, $object);
        return $this->conexiones->offsetGet($connection);
    }
    public function disconnectClient(ConnectionInterface $connection)
    {
        if (!is_null($this->getObject($connection))) {
            if ($this->getObject($connection)->imei != null) {
                $fecha = $this->dateCurrent();
                $this->estadoDispositivo($this->getObject($connection)->imei, "Desconectado", "Sin Movimiento", null);
            }
        }
    }
    public function estadoDispositivo($imei, $estado, $movimiento, $data)
    {
        try {
            $dispositivo = Dispositivo::where('imei', $imei)->first();
            if ($dispositivo) {
                EstadoDispositivo::updateOrCreate(['dispositivo_id' => $dispositivo->id], array(
                    'dispositivo_id'     => $dispositivo->id,
                    'estado'     => $estado,
                    'movimiento'        => $movimiento,
                    'cadena'        => $data
                ));
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: insert conexion',  $e->getMessage(), "\n";
            die();
        }
    }
    public function rutaDispositivo($imei, $fecha)
    {
        $time = new DateTime($fecha);
        $time->sub(new DateInterval('PT' . '15' . 'M'));
        $fechaantes = $time->format('Y-m-d H:i:s');
        try {
            UbicacionRecorrido::where('imei', $imei)->delete();
            $dataUbicacion = Ubicacion::where('imei', $imei)->where('created_at', '>=', $fechaantes)->get();
            $arr = [];
            foreach ($dataUbicacion as $key => $value) {
                $arr[] = [
                    'imei'     => $value->imei,
                    'cadena'     => $value->cadena,
                    'fecha' => $value->fecha,
                    'lat'     => $value->lat,
                    'lng'        => $value->lng,
                ];
            }
            $dataArreglo = array_chunk($arr, count($arr));
            foreach ($dataArreglo as $key => $value) {
                UbicacionRecorrido::insert($value);
            }
        } catch (Exception $e) {
            echo "error a la actualizacion de la ruta " . $e . " \n";
        }
    }
    public function insertUbication($imei, $latitude, $longitude, $cadena, $alarm)
    {
        try {
            Ubicacion::create(
                [
                    'imei'     => $imei,
                    'cadena'     => $cadena,
                    'lat'     => $latitude,
                    'lng'        => $longitude
                ]
            );
            $dispositivo = Dispositivo::where('imei', $imei)->first();
            if ($dispositivo && $latitude != 0 && $longitude != 0) {
                DispositivoUbicacion::updateOrCreate(['imei' => $imei], array(
                    'imei'     => $imei,
                    'cadena'     => $cadena,
                    'lat'     => $latitude,
                    'lng'        => $longitude
                ));
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: insertar location ',  $e->getMessage(), "\n";
        }
        try {
            $this->nuevaUbicacion($imei);
        } catch (Exception $er) {
            echo 'Excepción capturada: real time ',  $er->getMessage(), "\n";
        }
    }
    public function dateCurrent()
    {
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s", time());
        return $fecha;
    }
    public function  nuevaUbicacion($imei)
    {
        try {
            $consulta = Dispositivo::where('imei', $imei);
            if ($consulta->count() != 0) {
                $dispositivo = $consulta->first();
                $usuarios = DB::table('contrato as c')
                    ->join('detallecontrato as dc', 'dc.contrato_id', '=', 'c.id')
                    ->join('dispositivo as d', 'd.id', '=', 'dc.dispositivo_id')
                    ->join('clientes as cl', 'cl.id', '=', 'c.cliente_id')
                    ->where('d.imei', $imei)->select('cl.user_id')->get();
                $usuarios->push(array("user_id" => 1));
                $consultaUbicacion = DB::table('dispositivo_ubicacion')->where('imei', $imei)->first();
                $arreglo_cadena = explode(',', $consultaUbicacion->cadena);
                $estado = "Sin Movimiento";
                $velocidad_km = 0;

                if ($dispositivo->nombre == "TRACKER303") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($dispositivo->nombre == "MEITRACK") {
                    $velocidad_km = floatval($arreglo_cadena[10]);
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($dispositivo->nombre == "TELTONIKA12O") {
                    $velocidad_km = floatval($arreglo_cadena[3]);
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($dispositivo->nombre == "COBAN") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($dispositivo->nombre == "CONCOX") {
                    $velocidad_km = hexdec(substr($consultaUbicacion->cadena, 38, 2));
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                }

                $consultaUbicacion->velocidad = $velocidad_km;
                $consultaUbicacion->estado = $estado;
                $consultaUbicacion->estado_dispositivo = DB::table('estadodispositivo')->where('imei', $imei)->first();
                $recorrido = $this->recorrido($imei);
                $consultaUbicacion->recorrido = $recorrido['recorrido'];
                $consultaUbicacion->recorrido_arreglo = $recorrido['data_recorrido'];
                // broadcast(new NuevaUbicacionEvent($consultaUbicacion, $usuarios));
                $options = [
                    'context' => [
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false
                        ]
                    ]
                ];
                $client = new Client(new Version2X('https://corporacionminkay.com:3000', $options));
                $client->initialize();
                $client->emit('newUbication', [
                    'usuarios' => $usuarios,
                    'data' => json_encode($consultaUbicacion)
                ]);
                $client->close();
            }
        } catch (Exception $er) {
            echo 'Excepción capturada: real time ',  $er->getMessage(), "\n";
        }
    }
    public function recorrido($imei)
    {
        $recorrido = array();
        $arreglo_recorrido = array();
        $fila = DB::table('ubicacion_recorrido as ur')
            ->join('dispositivo as d', 'd.imei', '=', 'ur.imei')
            ->select('ur.*', 'd.nombre', 'd.placa')
            ->where('ur.lat', '!=', 0)
            ->where('ur.imei', $imei)->orderBy('ur.fecha', 'asc')->get();
        for ($i = 0; $i < count($fila); $i++) {

            $arreglo_cadena = explode(',', $fila[$i]->cadena);
            $velocidad_km = "0 kph";
            $altitud = "0 Metros";
            $odometro = "0 Km";
            $nivelCombustible = "0%";
            $volumenCombustible = "0.0 gal";
            $horaDelMotor = "0.0";
            $intensidadSenal = "0.0";
            $estado = "Sin Movimiento";
            $latLng = array();
            array_push($latLng, $fila[$i]->lat);
            array_push($latLng, $fila[$i]->lng);

            array_push($arreglo_recorrido, $latLng);
            if ($i < count($fila) - 1) {
                if ($fila[$i]->nombre == "TRACKER303") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } else if ($fila[$i]->nombre == "MEITRACK") {
                    $velocidad_km = floatval($arreglo_cadena[10]);
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $altitud = $arreglo_cadena[13];
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($fila[$i]->nombre == "TELTONIKA12O") {
                    $velocidad_km = floatval($arreglo_cadena[3]);
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($fila[$i]->nombre == "COBAN") {
                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                    $velocidad_km = sprintf("%.2f", $velocidad_km) . " kph";
                } elseif ($fila[$i]->nombre == "CONCOX") {
                    $velocidad_km = hexdec(substr($fila[$i]->cadena, 38, 2));
                    $estado = ($velocidad_km <= 0) ? $estado : "En Movimiento";
                }
                $marcador = SphericalUtil::computeHeading(
                    ['lat' => $fila[$i]->lat, 'lng' => $fila[$i]->lng], //from array [lat, lng]
                    ['lat' => $fila[$i + 1]->lat, 'lng' => $fila[$i + 1]->lng]
                );
                // if ($vkm > 2) {
                array_push($recorrido, array(
                    "placa" => $fila[$i]->placa,
                    "imei" => $fila[$i]->imei,
                    "img" => $this->imgComputeHeading($marcador),
                    "estado" => $estado,
                    "lat" => $fila[$i]->lat,
                    "lng" => $fila[$i]->lng,
                    "intensidadSenal" => $intensidadSenal,
                    "fecha" => $fila[$i]->fecha,
                    "altitud" => $altitud,
                    "velocidad" => $velocidad_km,
                    "nivelCombustible" => $nivelCombustible,
                    "volumenCombustible" => $volumenCombustible,
                    "horaDelMotor" => $horaDelMotor,
                    "direccion" => $fila[$i]->direccion,
                    "odometro" => $odometro
                ));
                // }
            }
        }
        return array("recorrido" => $recorrido, "data_recorrido" => $arreglo_recorrido);
    }
    public function imgComputeHeading($valor)
    {
        $image = array();
        if ($valor == 0) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_0.png"
            );
        } else if ($valor > 0 && $valor < 45) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_22.png"
            );
        } else if ($valor == 45) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_45.png"
            );
        } else if ($valor > 45 && $valor < 90) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_67.png"
            );
        } else if ($valor == 90) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_90.png"
            );
        } else if ($valor > 90 && $valor < 135) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_112.png"
            );
        } else if ($valor == 135) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_135.png"
            );
        } else if ($valor > 135 && $valor < 180) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_157.png"
            );
        } else if ($valor == 180 || $valor == -180) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_180.png"
            );
        } else if ($valor < 0 && $valor > -45) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_N22.png"
            );
        } else if ($valor == -45) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_N45.png"
            );
        } else if ($valor < -45 && $valor > -90) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_N67.png"
            );
        } else if ($valor == -90) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_N90.png"
            );
        } else if ($valor < 90 && $valor > -135) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_N112.png"
            );
        } else if ($valor == -135) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_N135.png"
            );
        } else if ($valor < -135 && $valor > -180) {
            $image = array(
                "url" =>
                "https://corporacionminkay.com/" .
                    "img/rotation/gpa_prueba_N157.png"
            );
        }
        return $image;
    }
}
