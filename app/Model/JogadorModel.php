<?php

namespace App\Model;

use Core\Contract\Arrayable;
use Ratchet\ConnectionInterface;

/**
 * Jogador Model
 * 
 * Modelo de dados do Jogador. Esses são os Jogadores que serão guardados no Storage do sistema
 */
class JogadorModel implements Arrayable
{
    public ConnectionInterface $conn;
    public string $identificador = "";
    public string $nome = "";
    public array $cartas = [];
    public bool $iniciar = false;
    public int $posicao = 0;
    public string $icone = "";
    public SalaModel $sala;

    public function toArray(): array
    {
        return [
            'identificador' => (string) $this->identificador,
            'nome' => (string) $this->nome,
            'cartas' => $this->cartas,
            'iniciar' => (bool) $this->iniciar,
            'posicao' => (int) $this->posicao,
            'icone' => (string) $this->icone
        ];
    }
}