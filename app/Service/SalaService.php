<?php

namespace App\Service;

use ErrorException;
use App\Evento\Response;
use App\Model\SalaModel;
use App\Model\JogadorModel;
use App\Storage\SalasStorage;
use App\Evento\ResponseHandle;
use App\Evento\Status\StatusCode;
use App\Storage\JogadoresStorage;
use App\Evento\Status\SalaUpdateStatus;
use App\Util\Arr;
use App\Util\Number;

/**
 * Sala Service
 * 
 * Serviços prestados ao modelo de dados Sala. Aqui criamos as operações de criação de sala e
 * despacho de novas atualizações
 */
class SalaService
{
    /**
     * Cria uma nova sala de jogo. Em seguida, registra a sala de jogo no Storage e retorna-a. Se
     * desejado, pode receber o código de sala previamente
     * 
     * @param  ?string $codigo Codigo da sala
     * @return \App\Model\SalaModel
     */
    public static function criar(?string $codigo = null): SalaModel
    {
        // Cria a nova instância do modelo de sala
        $sala = new SalaModel;

        $sala->codigo = $codigo ?? self::_criarCodigoDaSala();

        // Guarda a sala no Storage
        SalasStorage::attach($sala);

        return $sala;
    }

    /**
     * Adiciona um jogador à sala de jogo. Caso a sala esteja cheia, notifica uma exceção. Retorna
     * a instância atualizada da sala.
     * 
     * @param  \App\Model\SalaModel $sala
     * @param  \App\Model\JogadorModel $jogador
     * @return \App\Model\SalaModel
     * @throws \ErrorException
     */
    public static function adicionarJogador(SalaModel $sala, JogadorModel $jogador)
    {
        // Verifica se o número de jogadores chegou ao limite, o que notificará uma exceção
        if (count($sala->jogadores) >= 4) {
            throw new ErrorException("A sala esta cheia", StatusCode::STATUS_BAD_REQUEST);
        }

        // Verifica se o jogador já pertence à sala, logo retornando a própria sala
        if (array_key_exists($jogador->identificador, array_flip(array_column($sala->jogadores, 'identificador')))) {
            return $sala;
        }

        // Estabelece a posição do jogador na sala
        $jogador->posicao = Number::toString(count($sala->jogadores) + 1);

        // Adiciona o jogador à lista de jogadores da sala
        $sala->jogadores[$jogador->posicao] = $jogador;

        // Registra o jogador como presente naquela sala
        $jogador->sala = $sala;

        // Retorna a sala
        return $sala;
    }

    /**
     * Notifica todos os jogadores da sala da situação atual da mesa.
     * 
     * @param  \App\Model\SalaModel $sala
     * @return \App\Model\SalaModel
     */
    public static function notificarJogadores(SalaModel $sala)
    {
        // Para cada jogador na sala, cria um objeto de resposta com os dados da sala e submete a
        // ele
        foreach ($sala->jogadores as $jogador) {
            // Formata a lista de jogadores para um padrão reconhecível
            $sala->jogadores = $sala->jogadores;

            $response = new Response;

            $response->jogador = JogadoresStorage::find($jogador->conn);
            $response->tipo = new SalaUpdateStatus;
            $response->payload = $sala;

            ResponseHandle::dispatch($response);
        }

        return $sala;
    }

    /**
     * Gera o código da sala, que possui um tamanho padrão de 5 dígitos, composto por letras
     * maiusculas e números.
     * 
     * @return string
     */
    private static function _criarCodigoDaSala()
    {
        // Determina o escopo de caracteres
        $characters = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');

        // Sorteia um caractere de cada vez do escopo, adicionando-o a uma lista
        $result = [];
        for ( $i = 0; $i < 5; $i++ ) {
            array_push($result, $characters[rand(0, count($characters)-1)]);
        }

        // Retorna a lista em formato de string
        return implode('', $result);
    }
}