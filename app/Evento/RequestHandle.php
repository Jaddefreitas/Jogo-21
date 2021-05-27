<?php

namespace App\Evento;

use ErrorException;
use App\Evento\Request;
use App\Evento\Status\StatusCode;

/**
 * Controlador de eventos do sistema. Manipula cada requisição proveniente do socket, trata-a e
 * despacha o evento subsequente a ele. Funciona como um gerenciador de rotas, só que para sockets
 */
class RequestHandle
{
    /**
     * @var array Lista de eventos disponiveis. A chave guarda o nome do evento, enquanto o valor
     * guarda a classe
     */
    public static array $eventos = [
        'JOGADOR_ATUALIZAR_DADOS' => \App\Evento\Comandos\AtualizarDadosDoJogadorEvento::class,
        'JOGADOR_ENTRAR_SALA' => \App\Evento\Comandos\ConectarNaSalaEvento::class
    ];

    /**
     * Executa um evento a partir de um objeto de requisião. Notificará uma exceção caso o evento
     * não seja reconhecido.
     * 
     * @param  \App\Evento\Request $request
     * @return void
     * @throws \ErrorException
     */
    public static function dispatch(Request $request): void
    {
        // Verifica se o objeto de resposta é válido
        if (!$request->isValid()) {
            throw new ErrorException("Requisicao invalida. Verifique o objeto submetido e tente novamente", StatusCode::STATUS_INTERNAL_SERVER_ERROR);
        }

        // Verifica se o evento requisitado é válido
        if (!array_key_exists($request->evento, self::$eventos)) {
            throw new ErrorException("Evento invalido. Verifique o evento requisitado e tente novamente", StatusCode::STATUS_NOT_FOUND);
        }

        fwrite(STDERR, sprintf("Mensagem de [%s]: %s %s\n", $request->jogador->conn->resourceId, $request->evento, $request->hash));

        // Executa o evento requisitado
        (self::$eventos[$request->evento])::run($request);
    }
}