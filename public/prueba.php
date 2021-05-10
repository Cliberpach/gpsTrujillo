<?php
$servername = "localhost";
$username = "root";
$password = 'nMSN1DjhjD5GvIbsfFst';
$dbname = "gpstracker";
 try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
$query = "select d.placa,d.nrotelefono,u.Token  from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join clientes as cli on cli.id=c.cliente_id inner join users as u on u.id=cli.user_id where d.estado='ACTIVO' and c.estado='ACTIVO' and d.imei='864895031398066'";
    foreach($conn->query($query ) as $fila) {
      echo $fila['placa']."\n";
      echo $fila['nrotelefono']."\n";
      echo $fila['Token']."\n";
      if($fila['Token']=="")
      {
        echo "datos";
      }
  }
    echo "New notificactions successfully";
} catch (PDOException $e) {
    echo  "<br>" . $e->getMessage();
die();
}

$conn = null;
?>
