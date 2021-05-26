<?php

namespace App\Storage;

use App\Storage\AStorage;

/**
 * Salas Storage
 * 
 * Banco de dados de todas as salas do servidor
 */
class SalasStorage extends AStorage
{
    public static array $data = [];

    public static function indexPorObjeto($object)
    {
        return (string) $object->codigo;
    }

    public static function castIndex($index)
    {
        return (string) $index;
    }
}
