<?php
//  $servername = "localhost";
//  $username = "usuario";
//  $password = 'gps12345678';
//  $dbname = "gpstracker";
//  echo "start";
// while(true)
// {
//   try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
//     $query = "select * from ubicacion_recorrido where direccion is null order by fecha desc";
//     foreach($conn->query($query ) as $fila) {
//       //$data=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$fila['lat'].",".$fila['lng']."&key=AIzaSyB3oElOKZsIKTL2eB8peIQCTm6P77bJO1Q"),true);
//       $direccion= $data['results'][0]['address_components'][1]['long_name']." ".$data['results'][0]['address_components'][0]['long_name'];
//       $params = array(
//             ':direccion'     => $direccion,
//             ':imei' => $fila['imei'],
//             'fecha'=>$fila['fecha']
//         );
//         $sentencia = "UPDATE ubicacion_recorrido set direccion=:direccion where imei=:imei and fecha=:fecha";
//         $update = $conn->prepare($sentencia);
//         $update->execute($params);
//       }
  
//     } catch (PDOException $e) {
//         echo  "<br>" . $e->getMessage();
//     die();
//     }
// }
// $conn = null;
?>
