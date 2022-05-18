<?php

use React\Socket\ConnectionInterface;

require_once __DIR__."../vendor/autoload.php";


$socket = new React\Socket\SocketServer('104.248.58.194:6901');

$socket->on('connection', function (React\Socket\ConnectionInterface $connection){

});

$socket->on('error', function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});

echo 'Listening on ' . $socket->getAddress() . PHP_EOL;

function insertUbication()
{

}
