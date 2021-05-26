<?php

namespace App\Evento\Comandos;

use App\Evento\Request;
use App\Evento\Comandos\IEvento;
use App\Service\SalaService;

/**
 * Atualiza dados do jogador no sistema, notificando todos que interessar
 */
class AtualizarDadosDoJogadorEvento implements IEvento
{
    public static function run(Request $request): void
    {
        // Pega os dados do jogador submetido
        $dados = $request->payload;

        // Pega o jogador que submeteu a requisicao
        $jogador = $request->jogador;

        // Atualiza cada propriedade relevante do jogador
        $jogador->cartas = $dados->cartas;
        $jogador->iniciar = $dados->iniciar;

        // Pega a sala do jogador
        $sala = $jogador->sala;

        // Notifica os jogadores da sala da atualização do jogador
        SalaService::notificarJogadores($sala);
    }
}