<?php

namespace App;

use App\SocketServer;
use App\Environment\SocketEnvironment;

/**
 * Singleton construtor do SocketServer
 */
class FSocketServer
{
    /**
     * @var SocketServer Instância do servidor
     */
    public static SocketServer $instance;

    private function __construct()
    {
        // não faz nada
    }

    public static function getInstance(): SocketServer
    {
        if (!isset(self::$instance)) {
            self::$instance = new SocketServer(SocketEnvironment::$address);
        }

        return self::$instance;
    }
}