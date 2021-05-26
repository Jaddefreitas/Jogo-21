<?php

namespace App\Evento\Comandos;

use App\Evento\Request;

/**
 * Interface de um evento. Todos os eventos devem possuir um comando de execução, onde receberão
 * um objeto de requisição vindo do controlador de requisições.
 */
interface IEvento
{
    /**
     * Efetua a execução de um evento a partir da requisição submetida
     * 
     * @param  \App\Evento\Request $request
     * @return void
     */
    public static function run(Request $request): void;
}