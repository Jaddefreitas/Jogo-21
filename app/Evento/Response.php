<?php

namespace App\Evento;

use App\Model\JogadorModel;
use App\Evento\Status\IStatus;
use Core\Contract\Arrayable;

/**
 * Objeto de resposta de evento. Deve possuir sempre um jogador, que será notificado, um tipo de
 * resposta e um corpo.
 */
class Response
{
    /**
     * @var \App\Model\JogadorModel Jogador a ser notificado
     */
    public JogadorModel $jogador;

    /**
     * @var \App\Exception\Status\IStatus Tipo de resposta
     */
    public IStatus $tipo;

    /**
     * @var mixed Dados a serem submetidos na requisição 
     */
    public $payload;

    /**
     * @var string Hash, em base_64, que identifica a mensagem
     */
    public $hash;

    /**
     * Constrói a resposta com a hash estabelecida
     * 
     * @return \App\Evento\Response
     */
    public function __construct()
    {
        $this->hash = (string) base64_encode(substr((str_pad(rand(1, getrandmax()), 7, '0', STR_PAD_LEFT)), 0, 7));
    }

    /**
     * Verifica se o objeto de resposta é válido
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        if (!isset($this->jogador)) return false;
        if (!isset($this->tipo)) return false;
        if (!isset($this->payload)) return false;
        if (!isset($this->hash)) return false;

        return true;
    }

    /**
     * Converte o objeto de resposta para um json. Caso o objeto seja inválido, retorna nulo
     * 
     * @return ?string
     */
    public function toJson(): ?string
    {
        if (!$this->isValid()) return null;

        return json_encode([
            'event' => (string) $this->tipo->toString(),
            'payload' => ($this->payload instanceof Arrayable) ?
                $this->payload->toArray() :
                $this->payload,
            'hash' => (string) $this->hash
        ]);
    }
}