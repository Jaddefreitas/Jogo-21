<?php

namespace App\Evento;

use stdClass;
use App\Util\Json;
use ErrorException;
use App\Model\JogadorModel;
use Ratchet\ConnectionInterface;
use App\Evento\Status\StatusCode;

/**
 * Objeto de requisição para despacho de eventos. Permite validar a submissão de um evento via
 * socket e construir um objeto compatível com a string de requisição. Assim, também valida se a
 * string submetida é válida
 */
class Request
{
    /**
     * @var \App\Model\JogadorModel Jogador da requisição
     */
    public JogadorModel $jogador;

    /**
     * @var string Tipo de evento
     */
    public string $evento;

    /**
     * @var mixed Dados submetidos no corpo da requisição 
     */
    public $payload;

    /**
     * @var string Hash, em base_64, que identifica a mensagem
     */
    public $hash;

    /**
     * Verifica se o objeto de requisição é válido
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        if (!isset($this->jogador)) return false;
        if (!isset($this->evento)) return false;
        if (!isset($this->payload)) return false;
        if (!isset($this->hash)) return false;

        return true;
    }

    /**
     * Constrói o objeto a partir dos dados submetidos via socket. Se os dados submetidos não
     * forem válidos, notifica uma exceção
     * 
     * @param  mixed $data Dados submetidos 
     * @return \App\Evento\Request
     * @throws \ErrorException
     */
    public static function constructByMessage(string $data)
    {
        // Verifica se o dado é um json
        if (!Json::isJson($data)) {
            throw new ErrorException("Dados invalidos. Formato em JSON esperado", StatusCode::STATUS_BAD_REQUEST);
        }

        // Transforma os dados em formato JSON para um array
        $json = json_decode($data);

        // Verifica se o json possui um formato válido
        if (!self::_JsonObjectIsValid($json)) {
            throw new ErrorException("Json invalido. Deve possuir as chaves \"event\" e \"payload\"", StatusCode::STATUS_BAD_REQUEST);
        }

        // Cria o novo objeto de requisição
        $request = new Request;

        $request->evento = (string) $json->event;
        $request->payload = $json->payload;
        $request->hash = (string) $json->hash;

        return $request;
    }

    /**
     * Verifica se o objeto tem um formato válido. Requisições válidas devem tem dois campos:
     * "event" e "payload".
     * 
     * @param  \stdClass $json
     * @return bool
     */
    private static function _JsonObjectIsValid(stdClass $json)
    {
        return isset($json->event) && isset($json->payload) && isset($json->hash);
    }
}