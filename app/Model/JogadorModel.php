<?php

namespace App\Model;

/**
 * Jogador Model
 * 
 * Modelo de dados do Jogador. Esses são os Jogadores que serão guardados no Storage do sistema
 */
class JogadorModel
{
    public $stream;
    public string $buffer = "";
    public string $identificador;
    public string $nome;
    public array $cartas = [];
    public bool $iniciar = false;
    public array $posicao;
    public string $icone;
}