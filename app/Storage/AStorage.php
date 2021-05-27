<?php

namespace App\Storage;

use App\Storage\TCallStaticStorage;

/**
 * Storage abstrato, que implementa o singleton dos storages. Recomenda-se a chamada do trait
 * TCallStaticStorage ao extende-lo
 */
abstract class AStorage
{
    /**
     * Busca um valor por seu indice, a partir de uma operação personalizada para cada storage. Se
     * não encontrar um valor, retorna nulo
     * 
     * @param  mixed $index Indice utilizado para busca
     * @return mixed
     */
    abstract public static function find($index);
}