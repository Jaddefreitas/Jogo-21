<?php

namespace App\Util;

/**
 * Classe de utilitários para JSONs
 */
class Json
{
    /**
     * Verifica se a string é um json válido
     * 
     * @param  string $string
     * @return bool
     */
    public static function isJson(string $string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}