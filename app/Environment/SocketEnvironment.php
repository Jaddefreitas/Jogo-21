<?php

namespace App\Environment;

use App\Environment\AppEnvironment;

class SocketEnvironment
{
    public static $address;

    private function __construct()
    {
        // não faz nada    
    }

    public static function load()
    {
        self::$address = 'tcp://' . AppEnvironment::$host . ':' . AppEnvironment::$port;
    }
}
