<?php
    include 'Distance.php';
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "gpstracker_gpsbmsac";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=3308", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $imei="865429040021789";
            $queryd=$conn->prepare("select * from dispositivo where imei='".$imei."'");
            $queryd->execute();
            $dispositivo= $queryd->fetch();
            $query = "select posicion.lat,posicion.lng,posicion.cadena,posicion.fecha from (select imei,lat,lng,cadena,fecha from ubicacion) as posicion where imei='" . $imei . "'";
            //$i=0;
            $datos=$conn->query($query)->fetchAll();
            $suma=0.0;
            for($i=0;$i<count($datos);$i++)
            {
                if ($i < count($datos) - 1) {
                    $response = computeDistanceBetween(
                        ['lat' => $datos[$i]['lat'], 'lng' =>  $datos[$i]['lng']], //from array [lat, lng]
                        ['lat' =>  $datos[$i + 1]['lat'], 'lng' =>  $datos[$i + 1]['lng']]
                    );
                    $suma = $suma + $response;
                }
            }
            echo $suma/1000;
            echo $dispositivo['sutran'];
            // foreach ( $datos as $fila) {
            //     if($i<count($datos)-1)
            //     {

            //     }
            // }

    } catch (PDOException $e) {
        echo 'Excepción capturada: insert notification ',  $e->getMessage(), "\n";
        die();
    }
    $conn = null;
?>
