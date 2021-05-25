<?php

namespace Core\Contract;

/**
 * Determina uma instância de servidor, geralmente baseado em um socket. Esta instância deve
 * receber em seu construtor um endereço de servidor e possuir um método de início. É esperado o
 * tratamento de erros a partir de Throwables
 */
interface IServer
{
    /**
     * Constrói o servidor a partir de um endereço fornecido
     * 
     * @param string $address Endereço IP do servidor
     * @return \Core\Contract\IServer
     * @throws \Throwable
     */
    public function __construct(string $address);

    /**
     * Inicializa o servidor a partir dos dados já estabelecidos na classe
     * 
     * @return void
     * @throws \Throwable
     */
    public function run();
}