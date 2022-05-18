<?php
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/database.php";
require_once __DIR__."/Conexion/ListaClienteHex.php";
require_once __DIR__."/Decoder/BaseDecoder.php";
require_once __DIR__."/Dispositivos/Concox/GT06N.php";
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
