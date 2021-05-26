<?php

namespace App\Storage;

use App\Model\JogadorModel;

/**
 * Jogadores Storage
 * 
 * Guarda os dados de cada jogador conectado ao sistema, funcionando como banco de dados
 */
class JogadoresStorage
{
    /**
     * @var array Todos os dados guardados
     */
    public static array $data = [];

    private function __construct()
    {
        // não faz nada
    }

    /**
     * Retorna todos os jogadores registrados
     * 
     * @return array<\App\Model\JogadorModel>
     */
    public static function get(): array
    {
        return self::$data;
    }

    /**
     * Adiciona um novo jogador. Necessita de uma conexão estabelecida
     * 
     * @param  \App\Model\JogadorModel $jogador
     * @return void
     */
    public static function add(JogadorModel $jogador): void
    {
        self::$data[(int) $jogador->stream] = $jogador;
    }

    /**
     * Remove um jogador a partir de sua conexão
     * 
     * @param  resource $stream Recurso da conexao do jogador
     * @return void
     */
    public static function remove($stream)
    {
        if (array_key_exists((int) $stream, self::$data)) {
            unset(self::$data[(int) $stream]);
        }
    }

    /**
     * Procura um jogador pela conexão dele. Caso não seja encontrado, retorna nulo
     * 
     * @param  resource $stream Recurso da conexao do jogador 
     * @return \App\Model\JogadorModel|null
     */
    public static function find($stream): ?\App\Model\JogadorModel
    {
        return array_key_exists((int) $stream, self::$data) ? self::$data[(int) $stream] : null;
    }
}
