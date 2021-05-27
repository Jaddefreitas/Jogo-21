<?php

namespace App\Storage;

use App\Storage\AStorage;
use App\Storage\TCallStaticStorage;

/**
 * Salas Storage
 * 
 * Banco de dados de todas as salas do servidor
 */
class SalasStorage extends AStorage
{
    use TCallStaticStorage;

    public static function find($index)
    {
        $storage = static::getStorage();

        while ($storage->valid()) {
            if ($storage->current()->codigo === $index) {
                $object = $storage->current();
                $storage->rewind();
                return $object;
            }

            $storage->next();
        }

        return null;
    }
}
