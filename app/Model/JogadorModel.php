<?php

namespace App\Model;

use Core\Contract\Arrayable;
use DateTime;
use DateTimeInterface;
use Ratchet\ConnectionInterface;

/**
 * Jogador Model
 * 
 * Modelo de dados do Jogador. Esses são os Jogadores que serão guardados no Storage do sistema
 */
class JogadorModel implements Arrayable
{
    public ConnectionInterface $conn;
    public DateTimeInterface $last_modified;
    public string $identificador = "";
    public string $nome = "";
    public array $cartas = [];
    public bool $iniciar = false;
    public string $posicao = "";
    public string $icone = "";
    public ?SalaModel $sala = null;

    public function __construct()
    {
        $this->last_modified = new DateTime();
    }

    public function toArray(): array
    {
        return [
            'identificador' => (string) $this->identificador,
            'nome' => (string) $this->nome,
            'cartas' => $this->cartas,
            'iniciar' => (bool) $this->iniciar,
            'posicao' => (string) $this->posicao,
            'icone' => (string) $this->icone
        ];
    }
}