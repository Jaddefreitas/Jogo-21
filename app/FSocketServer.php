<?php

namespace App;

use App\SocketServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\Environment\AppEnvironment;

/**
 * Singleton construtor do SocketServer
 */
class FSocketServer
{
    /**
     * @var IoServer Instância do servidor
     */
    public static IoServer $instance;

    private function __construct()
    {
        // não faz nada
    }

    public static function getInstance(): IoServer
    {
        if (!isset(self::$instance)) {
            self::$instance = IoServer::factory(
                new HttpServer(new WsServer(new SocketServer())),
                AppEnvironment::$port,
                AppEnvironment::$host
            );

            fwrite(STDERR, sprintf("Iniciado em: ws://%s:%s\n", AppEnvironment::$host, AppEnvironment::$port));
        }

        return self::$instance;
    }
}