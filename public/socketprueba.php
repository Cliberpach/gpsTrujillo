<?php
echo "start";
date_default_timezone_set('America/Lima');
$ip_address = "165.227.210.131";
$port = "6902";
$server = stream_socket_server("tcp://$ip_address:$port", $errno, $errorMessage, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN);
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
        $data = fread($socket, 256);
        echo "data: " . strlen($data) . "\n";
        // $tk103_data = explode(',', $data);
        // $response = "";
        // switch (count($tk103_data)) {
        //     case 1:
        //         echo "caso1 \n";
        //         echo json_decode$tk103_data;
        //         echo "\n";
        //         $response = "ON";
        //         break;
        //     case 3:
        //         echo "caso3 \n";
        //         echo $tk103_data;
        //         echo "\n";
        //         if ($tk103_data[0] == "##") {
        //             $response = "LOAD";
        //         }
        //         break;
        //     case 13:
        //         echo "caso13 \n";
        //         echo $tk103_data;
        //         echo "\n";
        //         echo $tk103_data;
        //         break;
        //     case 19:
        //         echo "caso19 \n";
        //         echo $tk103_data;
        //         echo "\n";
        //         echo $tk103_data;
        //         break;
        //     default:
        //         // echo $data;
        // }
        if (!$data) {
            fclose($socket);
            continue;
        }
    }
}
