<?php

namespace App\Storage;

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
     * Retorna todos os usuários registrados
     * 
     * @return array
     */
    public static function get()
    {
        return self::$data;
    }

    /**
     * Procura um jogador pelo identificador. Caso não seja encontrado, retorna nulo
     * 
     * @param  string $identificador Identificador do jogador 
     * @return mixed
     */
    public static function find(string $identificador)
    {
        return array_key_exists($identificador, self::$data) ? self::$data[$identificador] : null;
    }
}
