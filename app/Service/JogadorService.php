<?php

namespace App\Service;

use App\Evento\Response;
use App\Model\JogadorModel;
use App\Evento\ResponseHandle;
use App\Evento\Status\IStatus;
use Ratchet\ConnectionInterface;
use App\Storage\JogadoresStorage;

/**
 * Jogador Service
 * 
 * Serviços prestados ao modelo de dados Jogador. Com esse, podemos criar novos jogadores de
 * acordo com o padrão estabelecido.
 */
class JogadorService
{
    /**
     * Cria um novo jogador vinculado a conexão dele. Retorna um novo modelo de jogador, após
     * guarda-lo no Storage
     * 
     * @param \Ratchet\ConnectionInterface $conn
     * @return \App\Model\JogadorModel
     */
    public static function conectar(ConnectionInterface $conn): JogadorModel
    {
        // Cria a nova instância do modelo de jogador
        $jogador = new JogadorModel;

        $jogador->conn = $conn;
        $jogador->identificador = self::_criarIdentificadorDoJogador();
        $jogador->icone = self::_sortearIcone();

        // Guarda o jogador no Storage
        JogadoresStorage::attach($jogador);

        return $jogador;
    }

    /**
     * Notifica um jogador das atualizações nos dados dele, informando qual o evento realizado
     * 
     * @param  \App\Model\JogadorModel $jogador
     * @param  \App\Evento\Status\IStatus
     * @return void
     */
    public static function notificarJogador(JogadorModel $jogador, IStatus $tipo): void
    {
        // Constrói o objeto a ser submetido
        $response = new Response;

        $response->jogador = $jogador;
        $response->tipo = $tipo;
        $response->payload = $jogador;

        ResponseHandle::dispatch($response);
    }

    /**
     * Cria o identificador do jogador. O tamanho padrão do identificador é 13, possuindo apenas
     * letras minúsculas e números, seguindo o padrão 4-4-3 e separados por traços (-).
     * 
     * @return string
     */
    private static function _criarIdentificadorDoJogador() {
        // Determina o escopo de caracteres
        $characters = str_split('abcdefghijklmnopqrstuvwxyz0123456789');

        // Sorteia um caractere de cada vez do escopo, adicionando-o a uma lista
        $result = [];
        for ( $i = 1; $i <= 11; $i++ ) {
            array_push($result, $characters[rand(0, count($characters)-1)]);

            // Se for um número divisível por 4, adiciona o traço
            if ($i % 4 === 0) {
                array_push($result, '-');
            }
        }

        // Retorna a lista em formato de string
        return implode('', $result);
    }

    /**
     * Sorteia um ícone para o jogador, retornando o seu nome.
     * 
     * @return string
     */
    private static function _sortearIcone() {
        // Determina a lista de ícones disponíveis
        $iconesDisponiveis = ['001-rpg-game.svg',
                              '002-dices.svg',
                              '003-game-over.svg',
                              '004-origami.svg',
                              '005-ball-of-wool.svg',
                              '006-sheep.svg',
                              '007-brooch.svg',
                              '008-ankh.svg',
                              '009-mask.svg',
                              '010-quill.svg',
                              '011-arrows.svg',
                              '012-hamsa.svg',
                              '013-freemasonry.svg',
                              '014-crystal.svg',
                              '015-bonfire.svg',
                              '016-deer.svg',
                              '017-coffee-breaks.svg',
                              '018-maps-and-location.svg',
                              '019-hourglass.svg',
                              '020-maps-and-location-1.svg',
                              '021-construction-and-tools.svg',
                              '022-sports-and-competition.svg',
                              '023-google-maps.svg',
                              '024-risk.svg',
                              '025-clock.svg',
                              '026-video-game.svg',
                              '027-miscellaneous.svg',
                              '028-dominoes.svg',
                              '029-puzzle.svg',
                              '030-fossil.svg',
                              '031-world-map.svg',
                              '032-roman-helmet.svg',
                              '033-shell.svg',
                              '034-stonehenge.svg',
                              '035-statue.svg',
                              '036-pharaoh.svg',
                              '037-tomb.svg',
                              '038-boomerang.svg',
                              '039-cave-painting.svg',
                              '040-cat.svg',
                              '041-musket.svg',
                              '042-poison.svg',
                              '043-parrot.svg',
                              '044-map.svg',
                              '045-anchor.svg',
                              '046-whale.svg',
                              '047-tank.svg',
                              '048-brake-disc.svg',
                              '049-gears.svg',
                              '050-speedometer.svg'];

        // Sorteia um ícone
        return $iconesDisponiveis[rand(0, count($iconesDisponiveis)-1)];
    }
}