<?php
function enviar_dispositivo($token,$placa,$telefono,$alerta,$image)
{
        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = array( 
                'title'     => $alerta,
                'body'      => $placa." ".$telefono,
                'image'     =>$image
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
        
        $result = curl_exec ( $ch );
        echo $result;
        curl_close ( $ch );
}
?>
