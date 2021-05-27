<?php

namespace App\Util;

/**
 * Utilitários para arrays. Aqui convertemos o array de jogadores da sala para um objeto
 * compatível com o frontend
 */
class Arr
{
    /**
     * Converte o array em objeto com índices representando o nome da posição.
     * 
     * @param  array $arr
     * @return array
     */
    public static function toObject(array $arr): array
    {
        $new_array = [];
        $parse = ['um', 'dois', 'tres', 'quatro'];

        foreach ($arr as $k => $v) {
            $new_array[$parse[$k]] = $v;
        }

        return $new_array;
    }
}