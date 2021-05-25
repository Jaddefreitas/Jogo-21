<?php

namespace App\Environment;

class AppEnvironment
{
    public static $name;
    public static $version;
    public static $host;
    public static $port;

    private function __construct()
    {
        // não faz nada    
    }

    public static function load()
    {
        self::$name = $_ENV['APP_NAME'];
        self::$version = $_ENV['APP_VERSION'];
        self::$host = $_ENV['APP_HOST'];
        self::$port = $_ENV['APP_PORT'];
    }
}
