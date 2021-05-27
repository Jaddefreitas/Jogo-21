<?php

namespace App\Storage;

use App\Storage\AStorage;
use App\Storage\TCallStaticStorage;

/**
 * Jogadores Storage
 * 
 * Guarda os dados de cada jogador conectado ao sistema, funcionando como banco de dados
 */
class JogadoresStorage extends AStorage
{
    use TCallStaticStorage;

    public static function find($index)
    {
        $storage = static::getStorage();

        while ($storage->valid()) {
            if (spl_object_hash($storage->current()->conn) === spl_object_hash($index)) {
                $object = $storage->current();
                $storage->rewind();
                return $object;
            }

            $storage->next();
        }

        return null;
    }
}
