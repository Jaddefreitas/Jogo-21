<?php

namespace App\Evento;

use ErrorException;
use App\Evento\Response;
use App\Evento\Status\StatusCode;

/**
 * Controlador de eventos de resposta. Com ele, pode-se dispersar uma nova resposta ao buffer do
 * jogador, que será notificado via socket
 */
class ResponseHandle
{
    /**
     * Executa um despacho de resposta ao jogador, que será notificado via socket. Caso o objeto
     * de resposta seja inválido, notifica uma exceção.
     * 
     * @param  \App\Evento\Response $response
     * @return void
     * @throws \ErrorException
     */
    public static function dispatch(Response $response): void
    {
        // Verifica se o objeto de resposta é válido
        if (!$response->isValid()) {
            throw new ErrorException("Resposta invalida. Verifique o objeto submetido e tente novamente", StatusCode::STATUS_INTERNAL_SERVER_ERROR);
        }

        fwrite(STDERR, sprintf("Mensagem para [%s]: %s %s\n", $response->jogador->conn->resourceId, $response->tipo->toString(), $response->hash));

        // Submete os dados a partir da conexão do jogador
        $response->jogador->conn->send($response->toJson());
    }
}