<?php
require __DIR__ . "/../requireClass.php";
sleep(10);
$socket = new React\Socket\SocketServer('104.248.58.194:6900');
$listaClienteHex = new ListaClienteHex();
$socket->on('connection', function (React\Socket\ConnectionInterface $connection) use ($listaClienteHex) {
   // echo "nueva conexion \n";
    $listaClienteHex->addClient($connection);
});
$socket->on('error', function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});
echo 'Listening on ' . $socket->getAddress() . PHP_EOL;
