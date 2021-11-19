<?php

require __DIR__.'/../vendor/autoload.php';
sleep(10);
echo "Inicio teltonika";
$server = new lbarrous\TeltonikaDecoder\Server\SocketServer("165.227.210.131", "6902");
$server->runServer();
