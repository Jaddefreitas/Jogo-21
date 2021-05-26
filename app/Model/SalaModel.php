<?php

namespace App\Model;

use Core\Contract\Arrayable;

/**
 * Sala Model
 * 
 * Modelo de dados da Sala de jogo. As salas são únicas, e armazenam um conjunto de jogadores nela
 */
class SalaModel implements Arrayable
{
    public string $codigo;
    public string $situacao = "";
    public array $jogadores = [];

    public function toArray(): array
    {
        $array = [
            'codigo' => (string) $this->codigo,
            'situacao' => (string) $this->situacao,
        ];

        foreach ($this->jogadores as $jogador) {
            $array['jogadores'][] = $jogador->toArray();
        }

        return $array;
    }
}