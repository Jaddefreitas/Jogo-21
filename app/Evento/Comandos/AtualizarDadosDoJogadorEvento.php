<?php

namespace App\Evento\Comandos;

use App\Evento\Request;
use App\Evento\Comandos\IEvento;
use App\Service\JogadorService;
use App\Service\SalaService;
use App\Util\Number;

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
        $jogador->identificador = $dados->identificador;
        $jogador->nome = $dados->nome;
        $jogador->cartas = $dados->cartas;
        $jogador->iniciar = $dados->iniciar;
        $jogador->posicao = $dados->posicao;
        $jogador->icone = $dados->icone;

        // Pega a sala do jogador
        $sala = $jogador->sala;

        // Se o jogador não estiver em uma sala, retorna
        if ($sala === null) return;

        SalaService::notificarJogadores($sala);
    }
}