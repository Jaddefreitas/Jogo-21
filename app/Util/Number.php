<?php

namespace App\Util;

/**
 * Classe auxiliar para números. Serve principalmente para tratar alguns dados entre aplicação e
 * servidor.
 */
class Number
{
    /**
     * Converte um numero em string para uma representação em inteiro.
     * 
     * @param  string $numero
     * @return int
     */
    public static function toInteger(string $numero): int
    {
        $parse = [
            'um' => 1,
            'dois' => 2,
            'tres' => 3,
            'quatro' => 4,
        ];

        return $parse[$numero] ?? 1;
    }

    /**
     * Converte um numero em inteiro para uma representação em string.
     * 
     * @param  int $numero
     * @return int
     */
    public static function toString(int $numero): string
    {
        $parse = [
            1 => 'um',
            2 => 'dois',
            3 => 'tres',
            4 => 'quatro',
        ];

        return $parse[$numero] ?? 'um';
    }
}