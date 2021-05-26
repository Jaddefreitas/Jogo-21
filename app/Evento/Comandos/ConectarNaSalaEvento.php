<?php

namespace App\Evento\Comandos;

use App\Evento\Request;
use App\Evento\Comandos\IEvento;
use App\Service\SalaService;
use App\Storage\SalasStorage;

/**
 * Conecta um jogador à sala a partir do código submetido
 */
class ConectarNaSalaEvento implements IEvento
{
    public static function run(Request $request): void
    {
        // Pega o código da sala buscado
        $codigo = (string) $request->payload;

        // Busca o código da sala no Storage
        $sala = SalasStorage::find($codigo);

        // Se a sala não existir, cria-a
        if ($sala === null) {
            $sala = SalaService::criar();
        }

        // Adiciona o jogador na sala
        SalaService::adicionarJogador($sala, $request->jogador);

        // Notifica os jogadores da atualização na sala
        SalaService::notificarJogadores($sala);
    }
}