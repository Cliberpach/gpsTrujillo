<?php
echo "start";
date_default_timezone_set('America/Lima');
$ip_address = "165.227.210.131";
$port = "6901";
$server = stream_socket_server("tcp://$ip_address:$port", $errno, $errorMessage);
if ($server === false) {
    die("stream_socket_server error: $errorMessage");
    echo "false";
}
$client_sockets = array();
$Clientes = array();
while (true) {
    $read_sockets = $client_sockets;
    $read_sockets[] = $server;
    if (!stream_select($read_sockets, $write, $except, 300000)) {
        die('stream_select error.');
        echo "error";
    }
    if (in_array($server, $read_sockets)) {
        $new_client = stream_socket_accept($server);
        if ($new_client) {
           // echo 'new connection: ' . stream_socket_get_name($new_client, true) . "\n";
            $client_sockets[] = $new_client;
            $Clientes[] = array('socket' => $new_client, 'imei' => " ", 'data' => " ");
        }
        unset($read_sockets[array_search($server, $read_sockets)]);
    }
    foreach ($read_sockets as $socket) {
       // echo "SOCKET: ".$socket."\n";
      //  $data = fread($socket, 256);
       //echo gettype($socket);
          $data = fread($socket,256);
        //echo "data: " . $data . "\n";
        $tk103_data = explode(',', $data);
        $response = "";
        switch (count($tk103_data)) {
            case 1: // 864895031563388 -> heartbeat requires "ON" response
                    $response = "ON";
                //echo "sent ON to client\n";
                break;
            case 3: // ##,imei:864895031563388,A -> this requires a "LOAD" response
                if ($tk103_data[0] == "##") {
                    $response = "LOAD";
                    // echo "sent LOAD to client\n";
                }
                break;
            case 13:
                $posicion_imei = strpos($tk103_data[0], ":");
                $imei = substr($tk103_data[0], $posicion_imei + 1);
                $alarm = $tk103_data[1];
                $latitude = 0.0;
                $longitude = 0.0;
                if ($tk103_data[7] != "" && $tk103_data[8] != "") {
                    $latitude = degree_to_decimal($tk103_data[7], $tk103_data[8]);
                }
                if ($tk103_data[9] != "" && $tk103_data[10] != "") {
                    $longitude = degree_to_decimal($tk103_data[9], $tk103_data[10]);
                }
                $gps_fecha = nmea_to_mysql_time();
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei'] = $imei;
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data'] = $data;
                insert_location_into_db($imei, $gps_fecha, $latitude, $longitude, $data);
                insert_ubicacion_db($imei, $gps_fecha, $latitude, $longitude, $data);
                actualizar_ruta_db($imei,$gps_fecha,$latitude,$longitude,$data);
                if ($tk103_data[11] != "") {
                    insert_conexion($imei, "Conectado", "Movimiento", $data);
                } else {
                    insert_conexion($imei, "Conectado", "Sin Movimiento", $data);
                }
                if ($latitude != 0.0 && $longitude != 0.0) {
                   // verifi_range($imei, $latitude, $longitude, $data);
                }
                kilometraje($imei,$data);
                break;
            case 19:
                $posicion_imei = strpos($tk103_data[0], ":");
                $imei = substr($tk103_data[0], $posicion_imei + 1);
                $alarm = $tk103_data[1];
                $latitude = 0.0;
                $longitude = 0.0;
                if ($tk103_data[7] != "" && $tk103_data[8] != "") {
                    $latitude = degree_to_decimal($tk103_data[7], $tk103_data[8]);
                }
                if ($tk103_data[9] != "" && $tk103_data[10] != "") {
                    $longitude = degree_to_decimal($tk103_data[9], $tk103_data[10]);
                }
                $gps_fecha = nmea_to_mysql_time();
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei'] = $imei;
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data'] = $data;
                insert_location_into_db($imei, $gps_fecha, $latitude, $longitude, $data);
                insert_ubicacion_db($imei, $gps_fecha, $latitude, $longitude, $data);
                actualizar_ruta_db($imei,$gps_fecha,$latitude,$longitude,$data);
                if ($latitude != 0.0 && $longitude != 0.0) {
                    //verifi_range($imei, $latitude, $longitude, $data);
                }
                if ($tk103_data[11] != "") {
                    insert_conexion($imei, "Conectado", "Movimiento", $data);
                } else {
                    insert_conexion($imei, "Conectado", "Sin Movimiento", $data);
                }
                kilometraje($imei,$data);
                // if ($alarm == "help me") {
                //     $response = "**,imei:" + $imei + ",E;";
                //     insert_notificacion($imei, "Ocurrio una alerta de ayuda", "help me", $data);
                // }
                // if ($alarm == "acc off") {
                //     insert_notificacion($imei, "Se desconecto la bateria", "acc off", $data);
                // }
                // if ($alarm == "speed") {
                //     insert_notificacion($imei, "Aumento de la velocidad", "speed", $data);
                // }
                break;
            case 26:
                //echo "meintrack";
                $imei = $tk103_data[1];
                $latitude = $tk103_data[4];
                $longitude = $tk103_data[5];
                $gps_fecha = nmea_to_mysql_time();
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei'] = $imei;
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data'] = $data;
                insert_location_into_db($imei, $gps_fecha, $latitude, $longitude, $data);
                insert_ubicacion_db($imei, $gps_fecha, $latitude, $longitude, $data);
                actualizar_ruta_db($imei,$gps_fecha,$latitude,$longitude,$data);
                if ($latitude != 0.0 && $longitude != 0.0) {
                    //verifi_range($imei, $latitude, $longitude, $data);
                }
                if (floatval($tk103_data[10]) > 0) {
                    insert_conexion($imei, "Conectado", "Movimiento", $data);
                } else {
                    insert_conexion($imei, "Conectado", "Sin Movimiento", $data);
                }
                kilometraje($imei,$data);
                break;
            default:
               // echo $data;
        }
        if (!$data) {
            $imei_gps = $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei'];
            $data_gps = $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data'];
            unset($client_sockets[array_search($socket, $client_sockets)]);
            unset($Clientes[array_search($socket, array_column($Clientes, 'socket'))]);
            fclose($socket);
            if (!is_null($imei_gps) && !is_null($data_gps)) {
                insert_conexion($imei_gps, "Desconectado", "Sin Movimiento", $data_gps);
            }
            continue;
        }
        if (strlen($response) > 0) {
            fwrite($socket, $response);
        }
    }
}
function actualizar_ruta_db($imei,$gps_time,$latitude, $longitude, $data)
{
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
    $time = new DateTime($gps_time);
    $time->sub(new DateInterval('PT' .'15'. 'M'));
    $fechaantes = $time->format('Y-m-d H:i');
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from ubicacion_recorrido where imei='" . $imei . "';";
        $conn->query($sql);
                $query="select * from ubicacion where imei='" . $imei . "' and fecha>='".$fechaantes."'";
                    foreach ($conn->query($query) as $fila) {
                    $params = array(
                        ':imei'     => $fila['imei'],
                        ':cadena'     => $fila['cadena'],
                        ':fecha' => $fila['fecha'],
                        ':lat'     => $fila['lat'],
                        ':lng'        => $fila['lng'],
                        ':direccion'=>$fila['direccion']
                    );
                    $insert = $conn->prepare("INSERT INTO ubicacion_recorrido(imei,lat,lng,cadena,fecha,direccion) VALUES (:imei,:lat,:lng,:cadena,:fecha,:direccion)");
                    $insert->execute($params);
                }
    }
    catch(PDOException $e)
    {
        echo "error a la actualizacion de la ruta ".$e." \n";
    }
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
function verifi_range($imei, $latitude, $longitude, $data)
{
    $point1 = array($latitude, $longitude);
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $valor_entrada = array();
        $query = "select cr.id from dispositivo as d inner join detallecontrato as dc on dc.dispositivo_id=d.id inner join contrato as c on c.id=dc.contrato_id inner join contratorango as cr on cr.contrato_id=c.id where d.imei='" . $imei . "';";
        foreach ($conn->query($query) as $fila) {
            $polygon = array();
            $query_two = "select dc.lat,dc.lng from detalle_contratorango as dc inner join contratorango as c on dc.contratorango_id=c.id where c.id='".$fila['id']."';";
            foreach ($conn->query($query_two) as  $Fila) {
                array_push($polygon, array($Fila['lat'], $Fila['lng']));
            }
            if (!contains($point1, $polygon)) {
                array_push($valor_entrada, "false");
            } else {
                array_push($valor_entrada, "true");
            }
        }
        if (!array_search("true", $valor_entrada)) {
            insert_notificacion($imei, "fuera de rango", "rango", $data);
        }
    } catch (PDOException $e) {
        echo 'Excepción capturada: verifi range ',  $e->getMessage(), "\n";
        die();
    }
    $conn = null;
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
function insert_notificacion($imei, $mensaje, $tipoalerta, $data)
{
    $alerta_permitida = 0;
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        if ($tipoalerta == "help me" || $tipoalerta == "acc off") {
            $alerta_permitida = 1;
        } else {
            $query = "select d.id from dispositivo as d where d.imei='" . $imei . "'";
            foreach ($conn->query($query) as $fila) {
                $query_alerta = "select a.alerta from opcionalerta as o inner join alertas as a on a.id=o.alerta_id where o.dispositivo_id='" . $fila['id'] . "'";
                foreach ($conn->query($query_alerta) as $fila_alerta) {
                    if ($fila_alerta['alerta'] == $tipoalerta) {
                        $alerta_permitida = 1;
                    }
                }
            }
        }
        if ($alerta_permitida == 1) {
            $query = "select d.placa,d.nrotelefono,u.Token,u.id as user_id  from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join clientes as cli on cli.id=c.cliente_id inner join users as u on u.id=cli.user_id where d.estado='ACTIVO' and c.estado='ACTIVO' and d.imei='" . $imei . "'";
            foreach ($conn->query($query) as $fila) {
                if ($fila['Token'] != "") {
                    /*
                if($mensaje=="Ocurrio una alerta de ayuda")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/ayuda.png");
                }
                if($mensaje=="Se desconecto la bateria")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/bateria.png");
                }
                if($mensaje=="Aumento de la velocidad")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/exceso.png");
                }
                if($mensaje=="fuera de rango")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/rango.png");
                }*/
                }
                date_default_timezone_set('America/Lima');
                $fecha = date("Y-m-d H:i:s", time());
                $params = array(
                    ':user_id'     => $fila['user_id'],
                    ':informacion'        => $mensaje,
                    ':read_user'     => "0",
                    ':creado'   => $fecha,
                    ':extra_cadena' => $data,
                    ':extra'   => $imei
                );
                $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra,extra_cadena) VALUES (:user_id,:informacion,:read_user,:creado,:extra,:extra_cadena)");
                $insert->execute($params);
            }
            $query = "select d.placa,d.nrotelefono,u.Token,u.id as user_id  from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join empresas as emp on emp.id=c.empresa_id inner join users as u on u.id=emp.user_id where d.estado='ACTIVO' and c.estado='ACTIVO' and d.imei='" . $imei . "'";
            foreach ($conn->query($query) as $fila) {
                if ($fila['Token'] != "") {/*
                if($mensaje=="Ocurrio una alerta de ayuda")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/ayuda.png");
                }
                if($mensaje=="Se desconecto la bateria")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/bateria.png");
                }
                if($mensaje=="Aumento de la velocidad")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/exceso.png");
                }
                if($mensaje=="fuera de rango")
                {
                    enviar_dispositivo($fila['Token'],$fila['placa'],$fila['nrotelefono'],$mensaje,"https://aseguroperu.com/img/rango.png");
                }*/
                }
                date_default_timezone_set('America/Lima');
                $fecha = date("Y-m-d H:i:s", time());
                $params = array(
                    ':user_id'     => $fila['user_id'],
                    ':informacion'        => $mensaje,
                    ':read_user'     => "0",
                    ':creado'   => $fecha,
                    ':extra_cadena' => $data,
                    ':extra'   => $imei
                );
                $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra,extra_cadena) VALUES (:user_id,:informacion,:read_user,:creado,:extra,:extra_cadena)");
                $insert->execute($params);
            }
            date_default_timezone_set('America/Lima');
            $fecha = date("Y-m-d H:i:s", time());
            $params = array(
                ':user_id'     => "1",
                ':informacion'        => $mensaje,
                ':read_user'     => "0",
                ':creado'   => $fecha,
                ':extra_cadena' => $data,
                ':extra'   => $imei
            );
            $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra,extra_cadena) VALUES (:user_id,:informacion,:read_user,:creado,:extra,:extra_cadena)");
            $insert->execute($params);
        }
    } catch (PDOException $e) {
        echo 'Excepción capturada: insert notification ',  $e->getMessage(), "\n";
        die();
    }
    $conn = null;
}
function insert_location_into_db($imei, $gps_time, $latitude, $longitude, $cadena)
{
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
    //direccion agregado
    //$data=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&key=AIzaSyB3oElOKZsIKTL2eB8peIQCTm6P77bJO1Q"),true);
    //$direccion= $data['results'][0]['address_components'][1]['long_name']." ".$data['results'][0]['address_components'][0]['long_name'];
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
        if($latitude!=0 || $longitude!=0)
        {
            foreach ($conn->query($query) as $fila) {
                $velocidad_km =0;
                $arreglo_cadena = explode(',', $cadena);
                if ($fila['nombre']== "TRACKER303") {


                    $velocidad_km = floatval($arreglo_cadena[11]) * 1.85;
                    $velocidad_km = sprintf("%.2f", $velocidad_km);

            } else if ($fila['nombre'] == "MEITRACK") {

                $velocidad_km = floatval($arreglo_cadena[10]);
                $velocidad_km = sprintf("%.2f", $velocidad_km);
            }
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

function nmea_to_mysql_time()
{
    $fecha = " ";
    /*$year = substr($date_time, 0, 2);
	    $month = substr($date_time, 2, 2);
	    $day = substr($date_time, 4, 2);
	    $hour = substr($date_time, 6, 2);
	    $minute = substr($date_time, 8, 2);
	    $second = substr($date_time, 10, 2);
            $fecha= date("Y-m-d H:i:s", mktime($hour, $minute, $second, $month, $day, $year));*/
    date_default_timezone_set('America/Lima');
    $fecha = date("Y-m-d H:i:s", time());
    return $fecha;
}
function degree_to_decimal($coordinates_in_degrees, $direction)
{
    $degrees = (int)($coordinates_in_degrees / 100);
    $minutes = $coordinates_in_degrees - ($degrees * 100);
    $seconds = $minutes / 60;
    $coordinates_in_decimal = $degrees + $seconds;
    if (($direction == "S") || ($direction == "W")) {
        $coordinates_in_decimal = $coordinates_in_decimal * (-1);
    }
    return number_format($coordinates_in_decimal, 6, '.', '');
}
function contains($point, $polygon)
{
    if ($polygon[0] != $polygon[count($polygon) - 1])
        $polygon[count($polygon)] = $polygon[0];
    $j = 0;
    $oddNodes = false;
    $x = $point[1];
    $y = $point[0];
    $n = count($polygon);
    for ($i = 0; $i < $n; $i++) {
        $j++;
        if ($j == $n) {
            $j = 0;
        }
        if ((($polygon[$i][0] < $y) && ($polygon[$j][0] >= $y)) || (($polygon[$j][0] < $y) && ($polygon[$i][0] >=
            $y))) {
            if ($polygon[$i][1] + ($y - $polygon[$i][0]) / ($polygon[$j][0] - $polygon[$i][0]) * ($polygon[$j][1] -
                $polygon[$i][1]) < $x) {
                $oddNodes = !$oddNodes;
            }
        }
    }
    return $oddNodes;
}
function enviar_dispositivo($token, $placa, $telefono, $alerta, $image)
{
    try {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = array(
            'title'     => $alerta,
            'body'      => $placa . " " . $telefono,
            'image'       => $image
        );
        $fields = array(
            'to' => $token,
            'notification' => $message
        );
        $fields = json_encode($fields);
        $headers = array(
            'Content-Type: application/json',
            'Authorization: key=' . ""
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_close($ch);
    } catch (Exception $e) {
        echo 'Excepción capturada: firebase ',  $e->getMessage(), "\n";
    }
}
function kilometraje($imei,$data)
{
    // $servername = "localhost";
    // $username = "usuario";
    // $password = 'gps12345678';
    // $dbname = "gpstracker";
    // try {
    //     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //         $queryd=$conn->prepare("select * from dispositivo where imei='".$imei."'");
    //         $queryd->execute();
    //         $dispositivo= $queryd->fetch();
    //         $query = "select posicion.lat,posicion.lng,posicion.cadena,posicion.fecha from (select imei,lat,lng,cadena,fecha from historial union select imei,lat,lng,cadena,fecha from ubicacion) as posicion where imei='" . $imei . "'";

    //         $datos=$conn->query($query)->fetchAll();
    //         $suma=0.0;
    //         for($i=0;$i<count($datos);$i++)
    //         {
    //             if ($i < count($datos) - 1) {
    //                 $response = computeDistanceBetween(
    //                     ['lat' => $datos[$i]['lat'], 'lng' =>  $datos[$i]['lng']], //from array [lat, lng]
    //                     ['lat' =>  $datos[$i + 1]['lat'], 'lng' =>  $datos[$i + 1]['lng']]
    //                 );
    //                 $suma = $suma + $response;
    //             }
    //         }
          
    //         $km_inicial=$dispositivo['km_inicial'];
    //         echo $km_inicial;
    //         if($km_inicial!=0)
    //         {
    //             $km_actual=$dispositivo['km_actual'];
    //             if($km_actual<($suma/1000))
    //             {
    //                 $query =$conn->prepare( "select d.placa,d.nrotelefono,u.Token,u.id as user_id  from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join empresas as emp on emp.id=c.empresa_id inner join users as u on u.id=emp.user_id where d.estado='ACTIVO' and c.estado='ACTIVO' and d.imei='" . $imei . "'");
    //                 $user_dispositivo=$conn->query($query)->fetchAll();
    //                 date_default_timezone_set('America/Lima');
    //                 $fecha = date("Y-m-d H:i:s", time());
    //                 $params = array(
    //                     ':user_id'     => $user_dispositivo['user_id'],
    //                     ':informacion'        => "Alerta Kilometraje",
    //                     ':read_user'     => "0",
    //                     ':creado'   => $fecha,
    //                     ':extra_cadena' => $data,
    //                     ':extra'   => $imei
    //                 );
    //                 $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra,extra_cadena) VALUES (:user_id,:informacion,:read_user,:creado,:extra,:extra_cadena)");
    //                 $insert->execute($params);
    //                 //--------------------------
    //                 $km_actual=$dispositivo['km_actual']+$dispositivo['km_aumento'];
    //                 $params = array(
    //                     ':id'     => $dispositivo['id'],
    //                     ':km_actual'     => $km_actual,
    //                 );
    //                 $sentencia = "UPDATE dispositivo set imei=:imei, lat=:lat , lng=:lng,fecha=:fecha,cadena=:cadena where id=:id";
    //                 $update = $conn->prepare($sentencia);
    //                 $update->execute($params);
    //             }
    //         }



    // } catch (PDOException $e) {
    //     echo 'Excepción capturada: insert kilometraje ',  $e->getMessage(), "\n";
    //     die();
    // }
    // $conn = null;
}
function computeDistanceBetween($from,$to)
{
    return computeAngleBetween($from, $to) * 6371009;
}
function computeAngleBetween($from, $to)
{
    return distanceRadians(deg2rad($from['lat']), deg2rad($from['lng']),
    deg2rad($to['lat']), deg2rad($to['lng']));
}
function distanceRadians( $lat1,  $lng1,  $lat2,  $lng2) {
    return arcHav(havDistance($lat1, $lat2, $lng1 - $lng2));
}
function arcHav($x)
{
    return 2 * asin(sqrt($x));
}
function havDistance($lat1, $lat2, $dLng) {
    return hav($lat1 - $lat2) + hav($dLng) * cos($lat1) * cos($lat2);
}
 function hav($x) {
    $sinHalf = sin($x * 0.5);
    return $sinHalf * $sinHalf;
}
