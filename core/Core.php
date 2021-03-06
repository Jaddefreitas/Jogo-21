<?php

namespace Core;

use Core\Provider\Dotenv;
use Ratchet\Server\IoServer;

/**
 * Coração do sistema. Carrega tudo que for preciso inicialmente
 */
class Core
{
    /**
     * Carrega os dados necessários vinculados ao coração do sistema
     * 
     * @return void
     */
    public function load()
    {
        // Desativa grande parte das notificações, logo que o servidor socket será executado
        error_reporting(E_ERROR | E_PARSE);

        // Carrega o dotenv e seus environments
        Dotenv::load();
    }

    /**
     * Executa o servidor socket passado via parâmetro
     * 
     * @param  \Ratchet\Server\IoServer $server
     * @return void
     */
    public function run(IoServer $server)
    {
        try {
            $server->run();
        } catch (\Throwable $th) {
            fwrite(STDERR, sprintf("ErrorException %u: %s\n", (int) $th->getCode(), (string) $th->getMessage()));
            exit(1);
        }
    }
}