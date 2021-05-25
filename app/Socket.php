<?php

namespace App;

use App\Config\Server;
use ErrorException;

/**
 * Socket Server
 * 
 * Classe principal que retorna uma instância única do socket existente. Faz uso do pattern
 * Singleton.
 */
class Socket
{
    /**
     * @var resource Instância do socket
     */
    public static $instance;

    private function __construct() {
        // não faz nada
    }

    /**
     * Retorna a instância do socket. Em caso de falha, notifica uma exceção
     * 
     * @throws \ErrorException
     * @return resource
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $host = Server::$host;
            $port = Server::$port;
            self::$instance = stream_socket_server("tcp://{$host}:{$port}", $errno, $errstr);
        }

        if (self::$instance === false) {
            throw new ErrorException("Error: $errno: $errstr");
        }

        return self::$instance;
    }
}