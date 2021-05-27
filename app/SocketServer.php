<?php

namespace App;

use Exception;
use App\Evento\Request;
use App\Evento\Response;
use App\Evento\RequestHandle;
use App\Evento\ResponseHandle;
use App\Evento\Status\FStatus;
use App\Service\JogadorService;
use Ratchet\ConnectionInterface;
use App\Storage\JogadoresStorage;
use Ratchet\MessageComponentInterface;
use App\Evento\Status\InternalServerErrorStatus;

class SocketServer implements MessageComponentInterface
{
    public function onOpen(ConnectionInterface $conn)
    {
        fwrite(STDERR, sprintf("Jogador [%s] conectou-se; \n", $conn->resourceId));

        JogadorService::conectar($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Localiza o jogador relacionado à requisição
        $jogador = JogadoresStorage::find($from);

        // Se o jogador não for encontrado, pula a iteração
        if ($jogador === null) return;

        // Constrói o objeto de requisição e despacha o evento. Caso a requisicao seja
        // inválida, responde ao cliente o erro
        try {
            $request = Request::constructByMessage($msg);

            $request->jogador = $jogador;

            RequestHandle::dispatch($request);
        } catch (\Throwable $th) {
            $response = new Response;

            $response->jogador = $jogador;
            $response->tipo = FStatus::constructByInt($th->getCode()) ?? new InternalServerErrorStatus;
            $response->payload = (string) $th->getMessage();

            ResponseHandle::dispatch($response);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Localiza o jogador a ser desconectado
        $jogador = JogadoresStorage::find($conn);

        // Se o jogador não for encontrado, apenas para
        if ($jogador === null) return;

        fwrite(STDERR, sprintf("Jogador [%s] foi desconectado; \n", $conn->resourceId));

        // Retira o jogador do Storage
        JogadoresStorage::detach($jogador);
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        fwrite(STDERR, sprintf("Um erro ocorreu: %s; \n", $e->getMessage()));

        $conn->close();
    }
}