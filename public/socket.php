<?php
echo "start";
date_default_timezone_set('America/Lima');
$ip_address = "165.227.210.131";
$port = "6901";
// open a server on port 7331
$server = stream_socket_server("tcp://$ip_address:$port", $errno, $errorMessage);
if ($server === false) {
    die("stream_socket_server error: $errorMessage");
    echo "false";
}
$client_sockets = array();
$Clientes=array();
while (true) {
    // prepare readable sockets
    $read_sockets = $client_sockets;
    $read_sockets[] = $server;
    // start reading and use a large timeout
    if (!stream_select($read_sockets, $write, $except, 300000)) {
        die('stream_select error.');
        echo "error";
    }
    // new client
    if (in_array($server, $read_sockets)) {
        $new_client = stream_socket_accept($server);
        if ($new_client) {
            //print remote client information, ip and port number
    // echo 'new connection: ' . stream_socket_get_name($new_client, true) . "\n";
            $client_sockets[] = $new_client;
            $Clientes[]=array('socket'=>$new_client,'imei'=>" ",'data'=>" ");
    //echo "total clients: ". count($client_sockets) . "\n";
        }
        unset($read_sockets[ array_search($server, $read_sockets) ]);
    }
    // message from existing client
    foreach ($read_sockets as $socket) {
        //echo "SOCKET: ".$socket."\n";
        $data = fread($socket, 256);
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
                $posicion_imei=strpos($tk103_data[0],":");
                $imei = substr($tk103_data[0],$posicion_imei+1);
                $alarm = $tk103_data[1];
                $latitude=0.0;
                $longitude=0.0;
                if($tk103_data[7]!="" && $tk103_data[8]!="")
                    {
                    $latitude = degree_to_decimal($tk103_data[7], $tk103_data[8]);
                            }
                            if($tk103_data[9]!="" && $tk103_data[10]!="")
                    {
                $longitude = degree_to_decimal($tk103_data[9], $tk103_data[10]);
                }
                $gps_fecha = nmea_to_mysql_time();
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei']=$imei;
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data']=$data;
        
                //echo date("Y-m-d H:i:s",time());
                //echo "DATA - 2: ".$data."\n";
                insert_location_into_db($imei, $gps_fecha, $latitude,$longitude, $data);
                
                if($tk103_data[11]!="")
                {
                    insert_conexion($imei,"Conectado","Movimiento",$data);    
                }
                else
                {
                    insert_conexion($imei,"Conectado","Sin Movimiento",$data);
                }
                if($latitude!=0.0 && $longitude!=0.0)
                {
                    verifi_range($imei,$latitude,$longitude,$data);
                }
                break;
            case 19: 
                $posicion_imei=strpos($tk103_data[0],":");
                $imei = substr($tk103_data[0],$posicion_imei+1);
                $alarm = $tk103_data[1];
                $latitude=0.0;
                $longitude=0.0;
                if($tk103_data[7]!="" && $tk103_data[8]!="")
                    {
                    $latitude = degree_to_decimal($tk103_data[7], $tk103_data[8]);
                            }
                            if($tk103_data[9]!="" && $tk103_data[10]!="")
                    {
                $longitude = degree_to_decimal($tk103_data[9], $tk103_data[10]);
                }
                $gps_fecha = nmea_to_mysql_time();
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei']=$imei;
                $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data']=$data;
                        //echo date("Y-m-d H:i:s",time());
                //echo "DATA - 2: ".$data."\n";
                insert_location_into_db($imei, $gps_fecha, $latitude,$longitude, $data);
                if($latitude!=0.0 && $longitude!=0.0)
                {
                    verifi_range($imei,$latitude,$longitude,$data);
                }
                if($tk103_data[11]!="")
                {
                    insert_conexion($imei,"Conectado","Movimiento",$data);    
                }
                else
                {
                    insert_conexion($imei,"Conectado","Sin Movimiento",$data);
                }
                if ($alarm == "help me")
                 {
                  $response = "**,imei:" + $imei + ",E;";
                  insert_notificacion($imei,"Ocurrio una alerta de ayuda","help me",$data);
                }
                if($alarm=="acc off")
                {
                    insert_notificacion($imei,"Se desconecto la bateria","acc off",$data);
                }
                if($alarm=="speed")
                {
                    insert_notificacion($imei,"Aumento de la velocidad","speed",$data);
                }
            break;
         case 26:

            $imei = $tk103_data[1];
           // $alarm = $tk103_data[1];
            $latitude=$tk103_data[4];
            $longitude=$tk103_data[5];
            $gps_fecha = nmea_to_mysql_time();
            $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei']=$imei;
            $Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data']=$data;
                     //echo date("Y-m-d H:i:s",time());
                //echo "DATA - 2: ".$data."\n";
            insert_location_into_db($imei, $gps_fecha, $latitude,$longitude, $data);
            if($latitude!=0.0 && $longitude!=0.0)
            {
                verifi_range($imei,$latitude,$longitude,$data);
            }
            if(floatval($tk103_data[10])>0)
            {
            
                insert_conexion($imei,"Conectado","Movimiento",$data);    
            }
            else
            {
                insert_conexion($imei,"Conectado","Sin Movimiento",$data);
            }
            break;
        }
        if (!$data) {
            $imei_gps=$Clientes[array_search($socket, array_column($Clientes, 'socket'))]['imei'];
            $data_gps=$Clientes[array_search($socket, array_column($Clientes, 'socket'))]['data'];
            unset($client_sockets[ array_search($socket, $client_sockets) ]);
            unset($Clientes[array_search($socket, array_column($Clientes, 'socket'))]);
            fclose($socket);
            if(!is_null($imei_gps) && !is_null($data_gps))
            {
                insert_conexion($imei_gps,"Desconectado","Sin Movimiento",$data_gps); 
            }
            continue;
        }
        if (strlen($response) > 0 ) {
            fwrite($socket, $response);
            //echo "Respuesta".substr($tk103_data[0],5)."-".$response;   
            }
	
    }
}
function verifi_range($imei,$latitude,$longitude,$data)
{
    //echo "entro".$imei."\n";
    $polygon=array();
    $point1 = array($latitude,$longitude);
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
     try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        $query = "select cr.lat,cr.lng from dispositivo as d inner join detallecontrato as dc on dc.dispositivo_id=d.id inner join contrato as c on c.id=dc.contrato_id inner join contratorango as cr on cr.contrato_id=c.id where d.imei='".$imei."'";
        foreach($conn->query($query ) as $fila) {
            array_push($polygon,array($fila['lat'],$fila['lng']));
          }
          if(!contains($point1,$polygon))
          {
            insert_notificacion($imei,"fuera de rango","rango",$data);
          }
         // $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra) VALUES (:user_id,:informacion,:read_user,:creado,:extra)");
    // ue exec() because no results are returned
    //$conn->exec($sql);
        // $insert->execute($params);
        //echo "New notificactions of range successfully";
    } catch (PDOException $e) {
        echo 'Excepción capturada: verifi range ',  $e->getMessage(), "\n";
	die();
    }
    $conn = null;
}
function insert_conexion($imei,$estado,$movimiento,$data)
{
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    $sql="select * from estadodispositivo where imei='".$imei."'";
    if($resultado=$conn->query($sql))
            {
                if($resultado->fetchColumn()==0)
                {
                    date_default_timezone_set('America/Lima');	
                    $fecha=date("Y-m-d H:i:s", time());
                    //echo "este".$fecha;
                    $params = array(':imei'     => $imei,
                    ':estado'        => $estado,
                    ':fecha'     => $fecha,
                    ':movimiento'=>$movimiento,
                    ':cadena'=>$data);
                        $insert = $conn->prepare("INSERT INTO estadodispositivo(imei,estado,fecha,movimiento,cadena) VALUES (:imei,:estado,:fecha,:movimiento,:cadena)");
                    // ue exec() because no results are returned
                    //$conn->exec($sql);
                        $insert->execute($params);
                }
                else
                {
                    $id="";
                    date_default_timezone_set('America/Lima');	
                    $fecha=date("Y-m-d H:i:s", time());
                    //echo "este llego".$fecha;
                    foreach($conn->query($sql) as $fila)
                    {
                        $id=$fila['id'];
                    }
                    $params = array(':imei'     => $imei,
                    ':estado'        => $estado,
                    ':fecha'     => strval($fecha),
                    ':movimiento'=>$movimiento,
                    ':cadena'=>$data,
                    ':id' => $id);
                    $sentencia = "UPDATE estadodispositivo set imei=:imei, estado=:estado , fecha=:fecha,movimiento=:movimiento,cadena=:cadena where id=:id";
                    $update= $conn->prepare($sentencia);
                    $update->execute($params);
                }
            }
    } catch (PDOException $e) {
        echo 'Excepción capturada: insert conexion',  $e->getMessage(), "\n";
        die();
    }
    $resultado=null;
    $conn=null;
}
function insert_notificacion($imei,$mensaje,$tipoalerta,$data)
{   
    $alerta_permitida=0;
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
     try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        if($tipoalerta=="help me" || $tipoalerta=="acc off")
        {
            $alerta_permitida=1;
        }
        else
        {
        $query = "select d.id from dispositivo as d where d.imei='".$imei."'";
            foreach($conn->query($query ) as $fila)
            {
                $query_alerta = "select a.alerta from opcionalerta as o inner join alertas as a on a.id=o.alerta_id where o.dispositivo_id='".$fila['id']."'";
                foreach($conn->query($query_alerta) as $fila_alerta)
                {
                    if($fila_alerta['alerta']==$tipoalerta)
                    {
                        $alerta_permitida=1;
                    }
                }
            }
        }
        if($alerta_permitida==1)
        {
            $query = "select d.placa,d.nrotelefono,u.Token,u.id as user_id  from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join clientes as cli on cli.id=c.cliente_id inner join users as u on u.id=cli.user_id where d.estado='ACTIVO' and c.estado='ACTIVO' and d.imei='".$imei."'";
        foreach($conn->query($query ) as $fila) {
            if($fila['Token']!="")
            {
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
	  $fecha=date("Y-m-d H:i:s", time());
	  $params = array(':user_id'     => $fila['user_id'],
                ':informacion'        => $mensaje,
                ':read_user'     => "0",
                ':creado'   => $fecha,
                ':extra_cadena'=> $data,
                ':extra'   => $imei);
          $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra,extra_cadena) VALUES (:user_id,:informacion,:read_user,:creado,:extra,:extra_cadena)");
    // ue exec() because no results are returned
    //$conn->exec($sql);
         $insert->execute($params);
    	}
	$query = "select d.placa,d.nrotelefono,u.Token,u.id as user_id  from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join empresas as emp on emp.id=c.empresa_id inner join users as u on u.id=emp.user_id where d.estado='ACTIVO' and c.estado='ACTIVO' and d.imei='".$imei."'";
        foreach($conn->query($query ) as $fila) {
            if($fila['Token']!="")
            {/*
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
	  $fecha=date("Y-m-d H:i:s", time());
	  $params = array(':user_id'     => $fila['user_id'],
                ':informacion'        => $mensaje,
                ':read_user'     => "0",
                ':creado'   => $fecha,
                ':extra_cadena'=> $data,
                ':extra'   => $imei);
          $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra,extra_cadena) VALUES (:user_id,:informacion,:read_user,:creado,:extra,:extra_cadena)");
    // ue exec() because no results are returned
    //$conn->exec($sql);
         $insert->execute($params);	
}
          date_default_timezone_set('America/Lima');	  	
	  $fecha=date("Y-m-d H:i:s", time());
	  $params = array(':user_id'     => "1",
                ':informacion'        => $mensaje,
                ':read_user'     => "0",
                ':creado'   => $fecha,
                ':extra_cadena'=> $data,
                ':extra'   => $imei);
          $insert = $conn->prepare("INSERT INTO notificaciones(user_id,informacion,read_user,creado,extra,extra_cadena) VALUES (:user_id,:informacion,:read_user,:creado,:extra,:extra_cadena)");
    // ue exec() because no results are returned
    //$conn->exec($sql);
         $insert->execute($params);
        //echo "New notificactions successfully";
        }
    } catch (PDOException $e) {
        echo 'Excepción capturada: insert notification ',  $e->getMessage(), "\n";
	die();
    }
    $conn = null;
}
function insert_location_into_db($imei, $gps_time, $latitude, $longitude,$cadena)
{
    $servername = "localhost";
    $username = "usuario";
    $password = 'gps12345678';
    $dbname = "gpstracker";
    $params = array(':imei'     => $imei,
                    ':cadena'     => $cadena,
                    ':fecha' => $gps_time,
                    ':lat'     => $latitude,
                    ':lng'        => $longitude);
                // PLEASE NOTE, I am hardcoding the wordpress table prefix (wp_) until I can find a better way
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $conn->prepare("INSERT INTO ubicacion(imei,lat,lng,cadena,fecha) VALUES (:imei,:lat,:lng,:cadena,:fecha)");
    // use exec() because no results are returned
    //$conn->exec($sql);
        $query->execute($params);
        //echo "New record created successfully";
    } catch (PDOException $e) {
        echo 'Excepción capturada: insertar location ',  $e->getMessage(), "\n";
    }
    $conn = null;
}
function nmea_to_mysql_time()
{
	$fecha=" ";
	    /*$year = substr($date_time, 0, 2);
	    $month = substr($date_time, 2, 2);
	    $day = substr($date_time, 4, 2);
	    $hour = substr($date_time, 6, 2);
	    $minute = substr($date_time, 8, 2);
	    $second = substr($date_time, 10, 2);
            $fecha= date("Y-m-d H:i:s", mktime($hour, $minute, $second, $month, $day, $year));*/
          date_default_timezone_set('America/Lima');	  	
	  $fecha= date("Y-m-d H:i:s", time());
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
    if($polygon[0] != $polygon[count($polygon)-1])
        $polygon[count($polygon)] = $polygon[0];
    $j = 0;
    $oddNodes = false;
    $x = $point[1];
    $y = $point[0];
    $n = count($polygon);
    for ($i = 0; $i < $n; $i++)
    {
        $j++;
        if ($j == $n)
        {
            $j = 0;
        }
        if ((($polygon[$i][0] < $y) && ($polygon[$j][0] >= $y)) || (($polygon[$j][0] < $y) && ($polygon[$i][0] >=
            $y)))
        {
            if ($polygon[$i][1] + ($y - $polygon[$i][0]) / ($polygon[$j][0] - $polygon[$i][0]) * ($polygon[$j][1] -
                $polygon[$i][1]) < $x)
            {
                $oddNodes = !$oddNodes;
            }
        }
    }
    return $oddNodes;
}
function enviar_dispositivo($token,$placa,$telefono,$alerta,$image)
{
    try
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = array( 
                'title'     => $alerta,
                'body'      => $placa." ".$telefono,
                'image'       =>$image
        );
        $fields = array (
                'to' =>$token
                ,
                'notification' =>$message
        );
        $fields = json_encode ( $fields );
        $headers = array (
                'Content-Type: application/json',
                'Authorization: key=' . "AAAAbr9YAPo:APA91bE5I7FYwvC_AMaeoFINzGNVpmTmCSDIjXsfCdwsna7anizaFjNm_DCayCehOAZGi-Nk0M5R5Mn-UuU1Jmc2QTHCtd6CgyKDzm48t2g1H2U6vVHpfBeuo8XjpBRGQ8Y8GqsSd1-m"
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        //$result = curl_exec ( $ch );
        //echo $result;
        curl_close ( $ch );
    }
    catch(Exception $e)
    {
        echo 'Excepción capturada: firebase ',  $e->getMessage(), "\n";
    }
}
?>