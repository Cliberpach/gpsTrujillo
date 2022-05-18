<?php

class GT06N extends BaseDecoder
{
    /** The imei from dispositive*/
    public $imei = null;

    /** The latitud from dispositive*/
    public $lat = null;

    /** The longitud from dispositive*/
    public $lng = null;

    /** The data from dispositive */
    public $data = null;

    /** The speed from dispositive */
    public $speed = null;

    /** The latitud from dispositive */
    public $latitud = null;

    public $protocol=null;

    public function __construct($data)
    {
        $this->decode($data);
    }
    public function decode($data)
    {
        $this->data=$data;
        if (strlen($data) == 36) {
            $this->imei=substr($this->data,8,16);
            $this->protocol=substr($this->data,6,2);
        }
        else{
            $posicionInicial=strpos($this->data,"7878");
            $protocol=substr($data,$posicionInicial+6,2);
            if($protocol=="12")
            {
                $this->data=substr($this->data,$posicionInicial,72);
                $this->convertLatLng(substr($this->data,22,8),substr($this->data,30,8));
                $this->speed=hexdec(substr($this->data,38,2));
            }
        }
    }
    public function convertLatLng($lat,$lng)
    {
        $this->lat=((hexdec($lat)/60)/30000);
        $this->lng=((hexdec($lng)/60)/30000);
        if(intval($this->lat)!=0 && intval($this->lng)!=0)
        {
            $this->lat=$this->lat*-1;
            $this->lng=$this->lng*-1;
        }
    }
    public function getLatLng()
    {
        
    }
    public function responseFirst()
    {
        return "\x78\x78\x05\x01\x00\x01\xD9\xDC\x0D\x0A";
    }
}
