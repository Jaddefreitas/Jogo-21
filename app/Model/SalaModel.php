<?php

namespace App\Model;

/**
 * Sala Model
 * 
 * Modelo de dados da Sala de jogo. As salas são únicas, e armazenam um conjunto de jogadores nela
 */
class SalaModel
{
    public string $codigo;
    public string $situacao = "";
    public array $jogadores;
}