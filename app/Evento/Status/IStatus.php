<?php

namespace App\Evento\Status;

/**
 * Status de uma resposta. Sempre possui sua representação em inteiro e em string 
 */
interface IStatus
{
    /**
     * Retorna a representação do status em string
     * 
     * @return string
     */
    public function toString(): string;

    /**
     * Retorna a representação do status em int
     * 
     * @return int
     */
    public function toInt(): int;
}