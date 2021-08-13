<?php
enviar_dispositivo("prueba","speed","https://gpsbmsac.com/img/exceso.png");
function enviar_dispositivo($placa,$alerta,$image)
{
	
        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = array( 
                'title'     => $alerta,
                'body'      => $placa,
                'image'     =>$image
        );
        $fields = array (
                'to' =>"dmfBZNN3RbaVhDSpVkaaG3:APA91bEGoEJvqb5ybFeQFOOb9VJiYzRFSd0zwfhu0ighjWKsuRrhgXcHoZXblFJT3M7aHx6sJyqd5CN9UFdWuOBQrg6uj9O3HvEPhYiFZ38vjP_doevtjKCGmoh03RhHQdKi7Wv_dWUu"
                ,
                'notification' =>$message
        );
        $fields = json_encode ( $fields );
        
        $headers = array (
                'Content-Type: application/json',
                'Authorization: key=' . "AAAARFhYEKw:APA91bG9sa72_ku7sVWuaDpLNed0s19mD96scf4GIWw2vSi-XdtDYSnmmRB8SG9pznVfrSulD0xcazo_xTceIh048tNXvSFTaviuTecBJByFOjF4enQrNhhuiiai_WvxE_LyWspSqlR_"
                
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
