<?php

abstract class BaseDecoder
{
    abstract public function decode($data);
    abstract public function getLatLng();
}
