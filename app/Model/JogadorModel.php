<?php

namespace App\Model;

/**
 * Jogador Model
 * 
 * Modelo de dados do Jogador. Esses são os Jogadores que serão guardados no Storage do sistema
 */
class JogadorModel
{
    public string $conexao;
    public string $identificador;
    public string $nome;
    public array $cartas = [];
    public bool $iniciar = false;
    public array $posicao;
    public string $icone;

    /**
     * Verifica se o modelo do cliente é válido
     * 
     * @return bool
     */
    public function isValid()
    {
        if (!isset($this->conexao)) return false;
        if (!$this->identificadorIsValid()) return false;
        if (!$this->nomeIsValid()) return false;
        if (!isset($this->cartas)) return false;
        if (!isset($this->iniciar)) return false;
        if (!$this->posicaoIsValid()) return false;
        if (!isset($this->icone)) return false;

        return true;
    }

    /**
     * Verifica se o identificador é válido
     * 
     * @return bool
     */
    public function identificadorIsValid()
    {
        // Verifica se o identificador tem tamanho igual a 13
        if (strlen($this->identificador) !== 13)
            return false;

        // Verifica se o identificador é composto apenas por letras maiúsculas e números
        if (strtoupper($this->identificador) !== $this->identificador)
            return false;

        return true;
    }

    /**
     * Verifica se o nome do cliente é válido
     * 
     * @return bool
     */
    public function nomeIsValid()
    {
        // Verifica se o nome tem tamanho entre 3 e 7 e então retorna
        return strlen($this->nome) > 2 && strlen($this->nome) < 8;
    }

    /**
     * Verifica se a posição do jogador é válida
     * 
     * @return bool
     */
    public function posicaoIsValid()
    {
        // Verifica se é alguma posição de 1 a 4, por extenso
        return in_array($this->posicao, ['um', 'dois', 'tres', 'quatro']);
    }

    /**
     * Verifica se o ícone é válido
     * 
     * @return bool
     */
    public function iconeIsValid()
    {
        // Verifica se o ícone é alguma string válida
        return in_array($this->icone, ['001-rpg-game.svg',
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
                                       '050-speedometer.svg']);
    }
}