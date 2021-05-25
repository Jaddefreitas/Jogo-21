<?php

namespace App\Config;

class Server
{
    public static $host;
    public static $port;

    private function __construct()
    {
        // não faz nada    
    }

    public static function load()
    {
        self::$host = $_ENV['SERVER_HOST'];
        self::$port = $_ENV['SERVER_PORT'];
    }
}
