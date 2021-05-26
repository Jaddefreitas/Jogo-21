<?php

namespace App\Storage;

use App\Storage\AStorage;

/**
 * Jogadores Storage
 * 
 * Guarda os dados de cada jogador conectado ao sistema, funcionando como banco de dados
 */
class JogadoresStorage extends AStorage
{
    public static array $data = [];

    public static function indexPorObjeto($object)
    {
        return (int) $object->stream;
    }

    public static function castIndex($index)
    {
        return (int) $index;
    }
}
