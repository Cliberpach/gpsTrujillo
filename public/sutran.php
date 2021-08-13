<?php 
$myfile = fopen("./key/file", "r");
$key=fread($myfile, filesize("./key/file"));
fclose($myfile);
$str="identificacion|20601359350|sutran2016";
$host = "181.177.244.104"; 
$port =5889; 
// $message = encrypt($str,$key); 
//$message=utf8_encode("SKw4GwhxFh81VOMgNq9t+HqP5FqOSrYfEGUiDZuJVeNMFmbyugZGIGFS05sNdiuu");
$fe="SKw4GwhxFh81VOMgNq9t+HqP5FqOSrYfEGUiDZuJVeNMFmbyugZGIGFS05sNdiuu";
$message=mb_convert_encoding($fe, "UTF-8", mb_detect_encoding($fe, "UTF-8, ISO-8859-1, ISO-8859-15", true));


$socket = socket_create(AF_INET, SOCK_STREAM,SOL_TCP) or die("No se pudo crear el socket\n");

$result = socket_connect($socket, gethostbyname('sig.sutran.gob.pe'), $port) or die("No se pudo conectar con el servidor\n"); 

 $sent=socket_write($socket, $message, strlen($message)) or die("No se pudo enviar datos al servidor\n"); 
 if($sent===false){
     echo "nada"."\r\n";
 }
 else
 {
     echo "bien"."\r\n";
 }
 $result = socket_read($socket,2048) or die("Could not read server response\n");
 echo "Reply From Server  :" . $result."\n";
//  $read = socket_read( $socket, 1024 );
//  if( $read == false )
//  {
//      throw new Exception( sprintf( "Unable to read from socket: %s", socket_strerror( socket_last_error() ) ) );
//  }
// //  while ($get = socket_read($socket, 1024, PHP_NORMAL_READ)) {
// //     $content .= $get;
// // }
// // socket_close($socket);
// // echo $content;

 socket_close($socket);


function encrypt($data = '', $key = NULL) {
    if($key != NULL && $data != ""){
        $method = "AES-256-CBC";
        $key1 = mb_convert_encoding($key, "UTF-8"); //Encoding to UTF-8
        //Randomly generate IV and salt
        $salt1 = random_bytes (20); 
        $IVbytes = random_bytes (16); 
        //SecretKeyFactory Instance of PBKDF2WithHmacSHA1 Java Equivalent
        $hash = openssl_pbkdf2($key1,$salt1,'256','65556', 'sha1'); 
        // Encrypt
        $encrypted = openssl_encrypt($data, $method, $hash, OPENSSL_RAW_DATA, $IVbytes);
        // Concatenate salt, IV and encrypted text and base64-encode the result
        $result = base64_encode($salt1.$IVbytes.$encrypted);            
        return $result;
    }else{
        return "String to encrypt, Key is required.";
    }
}
function writeUTF($string) {
    $utfString = utf8_encode($string);
    $length = strlen($utfString);
    print(pack("n", $length));
    print($utfString);
    flush();
}
?>