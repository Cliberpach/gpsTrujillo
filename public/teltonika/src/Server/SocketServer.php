<?php

/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 16/07/2018
 * Time: 13:23
 */

namespace lbarrous\TeltonikaDecoder\Server;

// require 'vendor/autoload.php';
// sleep(2);
use lbarrous\TeltonikaDecoder\Entities\ImeiNumber;
use React\Socket\ConnectionInterface;
use lbarrous\TeltonikaDecoder\TeltonikaDecoderImp;
use PDO;
use PDOException;
use DateTime;
use DateInterval;
// use lbarrous\TeltonikaDecoder\Database\DataStore;

class SocketServer
{

    private $host;
    private $port;
    // private $dataBase;

    /**
     * SocketServer constructor.
     * @param $host
     * @param $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
        // $this->dataBase = new DataStore();
    }

    public function runServer()
    {

        $loop = \React\EventLoop\Factory::create();

        //Creation of new TCP socket
        $socket = new \React\Socket\Server($this->host . ":" . $this->port, $loop);

        $socket->on('connection', function (ConnectionInterface $connection) {

            //We nget on two scenarios:
            //1. We get IMEI, which we decode, we can even valid if it's correct, and then we send to the device a hex confirmation "\x01"
            //2. We start getting AVL Data in two ways
            //2.1 We firstly get a first part of the HEX string
            //2.2 We get the last of the HEX string, so we match the two parts and we finally get the complete HEX string which we can decode to get the data

            //As we get the data in two times we need to get a variable to store it
            $hexDataGPS = "";

            //We store the imei to store with the data
            $imei = "";

            //We set a react event for every time we get data on our socket.
            $connection->on('data', function ($data) use ($connection, &$hexDataGPS, &$imei) {

                //If we get a 17 characters string it means we are getting IMEI number, we have to decode it, check IMEI and send confirmation
                if (strlen($data) == 17) {

                    //We always get binary info so we decode it into HEX
                    $data = bin2hex($data);

                    //DECODE IMEI
                    $imei = new ImeiNumber($data);
                    $imei->getImeiNumber();

                    //YOU CAN OPTIONALLY DO STUFF WITH YOUR IMEI BEFORE SENDING CONFIRMATION

                    /**/

                    //SEND CONFIRMATION
                    $connection->write("\x01"); //(Binary packet => 01)
                } else {

                    //We always get binary info so we decode it into HEX
                    $data = bin2hex($data);

                    //We get the first part of the data
                    if (strlen($data) == 20) {
                        $hexDataGPS .= $data;
                    }

                    //We get the last part
                    else {
                        $hexDataGPS .= $data;

                        // echo "Got a complete AVLMessage:\n";
                        // echo $hexDataGPS;
                        // echo "\n";

                        //We decode the message
                        $decoder = new TeltonikaDecoderImp($hexDataGPS, $imei);
                        $AVLArray = $decoder->getArrayOfAllData();

                        //Show output
                        // echo json_encode($AVLArray);
                        // echo "\n";
                        // echo $AVLArray;
                        // echo "\n";


                        $numerOfElementsReceived = $decoder->getNumberOfElements();
                        // echo "Elements received: ".$numerOfElementsReceived."\n";
                        date_default_timezone_set('America/Lima');
                        $fecha_actual = date("Y-m-d", time());
                        foreach ($AVLArray as $dato) {
                            
                            $time = new DateTime($dato->getDateTime());
                            $fecha_teltonica = $time->format('Y-m-d');
                            if ($fecha_actual == $fecha_teltonica) {
                                $latitude = $dato->getGpsData()->getLatitude();
                                $longitude = $dato->getGpsData()->getLongitude();
                                $velocidad = $dato->getGpsData()->getSpeed();

                                $fecha = $this->nmea_to_mysql_time();
                                $imei_get= strval($dato->getImei()->getImeiNumber());
                                $cadena = $imei_get . "," . $latitude . "," . $longitude . "," . $velocidad;
                                $this->insert_location_into_db(
                                    $imei_get,
                                    $fecha,
                                    $latitude,
                                    $longitude,
                                    $cadena,
                                    $velocidad
                                );
                                $this->insert_ubicacion_db(
                                    $imei_get,
                                    $fecha,
                                    $latitude,
                                    $longitude,
                                    $cadena
                                );
                                $this->actualizar_ruta_db(
                                    $imei_get,
                                    $fecha,
                                    $latitude,
                                    $longitude,
                                    $cadena
                                );

                                if ($velocidad != 0) {
                                    $this->insert_conexion($imei_get, "Conectado", "Movimiento", $cadena);
                                } else {
                                    $this->insert_conexion($imei_get, "Conectado", "Sin Movimiento", $cadena);
                                }
                            }
                        }
                        // echo "Data saved into the database"."\n";

                        //Send the response to server with the number of records we got (4 bytes integer)
                        $connection->write(pack('N', $numerOfElementsReceived));
                        //$connection->write($numerOfElementsReceived);
                    }
                }
            });
        });
        echo "Listening on {$socket->getAddress()}\n";
        $loop->run();
    }
    function insert_conexion($imei, $estado, $movimiento, $data)
    {
        $servername = "localhost";
        $username = "usuario";
        $password = 'gps12345678';
        $dbname = "gpstracker";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $sql = "select * from estadodispositivo where imei='" . $imei . "'";
            if ($resultado = $conn->query($sql)) {
                if ($resultado->fetchColumn() == 0) {
                    date_default_timezone_set('America/Lima');
                    $fecha = date("Y-m-d H:i:s", time());
                    $params = array(
                        ':imei'     => $imei,
                        ':estado'        => $estado,
                        ':fecha'     => $fecha,
                        ':movimiento' => $movimiento,
                        ':cadena' => $data
                    );
                    $insert = $conn->prepare("INSERT INTO estadodispositivo(imei,estado,fecha,movimiento,cadena) VALUES (:imei,:estado,:fecha,:movimiento,:cadena)");
                    $insert->execute($params);
                } else {
                    $id = "";
                    date_default_timezone_set('America/Lima');
                    $fecha = date("Y-m-d H:i:s", time());
                    foreach ($conn->query($sql) as $fila) {
                        $id = $fila['id'];
                    }
                    $params = array(
                        ':imei'     => $imei,
                        ':estado'        => $estado,
                        ':fecha'     => strval($fecha),
                        ':movimiento' => $movimiento,
                        ':cadena' => $data,
                        ':id' => $id
                    );
                    $sentencia = "UPDATE estadodispositivo set imei=:imei, estado=:estado , fecha=:fecha,movimiento=:movimiento,cadena=:cadena where id=:id";
                    $update = $conn->prepare($sentencia);
                    $update->execute($params);
                }
            }
        } catch (PDOException $e) {
            echo 'Excepción capturada: insert conexion',  $e->getMessage(), "\n";
            die();
        }
        $resultado = null;
        $conn = null;
    }
    function nmea_to_mysql_time()
    {
        $fecha = " ";
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s", time());
        return $fecha;
    }
    function insert_location_into_db($imei, $gps_time, $latitude, $longitude, $cadena, $velocidad)
    {
        $servername = "localhost";
        $username = "usuario";
        $password = 'gps12345678';
        $dbname = "gpstracker";
        $params = array(
            ':imei'     => $imei,
            ':cadena'     => $cadena,
            ':fecha' => $gps_time,
            ':lat'     => $latitude,
            ':lng'        => $longitude
        );
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = $conn->prepare("INSERT INTO ubicacion(imei,lat,lng,cadena,fecha) VALUES (:imei,:lat,:lng,:cadena,:fecha)");
            $query->execute($params);
            $query = "select * from dispositivo  where imei='" . $imei . "' and sutran='SI' ";
            if ($latitude != 0 || $longitude != 0) {
                foreach ($conn->query($query) as $fila) {
                    $velocidad_km = sprintf("%.2f", $velocidad);

                    $params = array(
                        ':placa'     => $fila['placa'],
                        ':latitud'        => $latitude,
                        ':longitud'     => $longitude,
                        ':rumbo'   => "-1",
                        ':velocidad' => $velocidad_km,
                        ':evento'   => "-1",
                        ':fecha'   => $gps_time,
                        ':fechaemv'   => $gps_time,
                        ':estado'   => "0",
                        ':respuesta'   => "-1",
                    );
                    $insert = $conn->prepare("INSERT INTO sutran(placa,latitud,longitud,rumbo,velocidad,evento,fecha,fechaemv,estado,respuesta) VALUES (:placa,:latitud,:longitud,:rumbo,:velocidad,:evento,:fecha,:fechaemv,:estado,:respuesta)");
                    $insert->execute($params);
                }
            }
        } catch (PDOException $e) {
            echo 'Excepción capturada: insertar location ',  $e->getMessage(), "\n";
        }
        $conn = null;
    }
    function insert_ubicacion_db($imei, $gps_time, $latitude, $longitude, $cadena)
    {
        $servername = "localhost";
        $username = "usuario";
        $password = 'gps12345678';
        $dbname = "gpstracker";
        if ($latitude != 0 && $longitude != 0) {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "select * from dispositivo_ubicacion where imei='" . $imei . "'";
                if ($resultado = $conn->query($sql)) {
                    if ($resultado->fetchColumn() == 0) {
                        $params = array(
                            ':imei'     => $imei,
                            ':cadena'     => $cadena,
                            ':fecha' => $gps_time,
                            ':lat'     => $latitude,
                            ':lng'        => $longitude
                        );
                        $insert = $conn->prepare("INSERT INTO dispositivo_ubicacion(imei,lat,lng,cadena,fecha) VALUES (:imei,:lat,:lng,:cadena,:fecha)");
                        $insert->execute($params);
                    } else {
                        $id = "";
                        foreach ($conn->query($sql) as $fila) {
                            $id = $fila['id'];
                        }
                        $params = array(
                            ':imei'     => $imei,
                            ':cadena'     => $cadena,
                            ':fecha' => $gps_time,
                            ':lat'     => $latitude,
                            ':lng'        => $longitude,
                            ':id' => $id
                        );
                        $sentencia = "UPDATE dispositivo_ubicacion set imei=:imei, lat=:lat , lng=:lng,fecha=:fecha,cadena=:cadena where id=:id";
                        $update = $conn->prepare($sentencia);
                        $update->execute($params);
                    }
                }
            } catch (PDOException $e) {
                echo 'Excepción capturada: insertar last location  ',  $e->getMessage(), "\n";
            }
            $conn = null;
        }
    }
    function actualizar_ruta_db($imei, $gps_time, $latitude, $longitude, $data)
    {
        $servername = "localhost";
        $username = "usuario";
        $password = 'gps12345678';
        $dbname = "gpstracker";
        $time = new DateTime($gps_time);
        $time->sub(new DateInterval('PT' . '15' . 'M'));
        $fechaantes = $time->format('Y-m-d H:i');
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "delete from ubicacion_recorrido where imei='" . $imei . "';";
            $conn->query($sql);
            $query = "select * from ubicacion where imei='" . $imei . "' and fecha>='" . $fechaantes . "'";
            foreach ($conn->query($query) as $fila) {
                $params = array(
                    ':imei'     => $fila['imei'],
                    ':cadena'     => $fila['cadena'],
                    ':fecha' => $fila['fecha'],
                    ':lat'     => $fila['lat'],
                    ':lng'        => $fila['lng'],
                    ':direccion' => $fila['direccion']
                );
                $insert = $conn->prepare("INSERT INTO ubicacion_recorrido(imei,lat,lng,cadena,fecha,direccion) VALUES (:imei,:lat,:lng,:cadena,:fecha,:direccion)");
                $insert->execute($params);
            }
        } catch (PDOException $e) {
            echo "error a la actualizacion de la ruta " . $e . " \n";
        }
    }
}
