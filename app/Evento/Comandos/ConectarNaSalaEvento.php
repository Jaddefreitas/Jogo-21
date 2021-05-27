<?php

namespace App\Evento\Comandos;

use App\Evento\Request;
use App\Service\SalaService;
use App\Storage\SalasStorage;
use App\Service\JogadorService;
use App\Evento\Comandos\IEvento;
use App\Evento\Status\JogadorAtualizarStatus;

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
            $sala = SalaService::criar($codigo);
        }

        // Adiciona o jogador na sala
        $sala = SalaService::adicionarJogador($sala, $request->jogador);

        // Notifica o próprio jogador das atualizações nos seus dados
        JogadorService::notificarJogador($request->jogador, new JogadorAtualizarStatus);

        // Notifica os jogadores da atualização na sala
        SalaService::notificarJogadores($sala);
    }
}