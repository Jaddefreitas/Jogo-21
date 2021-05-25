<?php

namespace Core\Provider;

use App\Environment\AppEnvironment;
use App\Environment\SocketEnvironment;

/**
 * Dotenv Provider
 * 
 * Manipula as operações da lib Dotenv
 */
class Dotenv
{
    public static function load()
    {
        // Carrega o dotenv e os arquivos de configuração
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Carrega os arquivos de configuração do sistema
        AppEnvironment::load();
        SocketEnvironment::load();
    }
}