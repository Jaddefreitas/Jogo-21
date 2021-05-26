<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

/**
 * Construtor para os status existentes no sistema
 */
class FStatus
{
    /**
     * @var array Lista de status disponiveis
     */
    public static array $status = [
        \App\Evento\Status\BadRequestStatus::class,
        \App\Evento\Status\InternalServerErrorStatus::class,
        \App\Evento\Status\NotFoundStatus::class,
        \App\Evento\Status\OkStatus::class
    ];

    /**
     * Constrói um status pelo código fornecido. Se não for encontrado, retorna nulo.
     * 
     * @param  int $code
     * @return ?\App\Evento\Status\IStatus
     */
    public static function constructByInt(int $code): ?IStatus
    {
        foreach (self::$status as $status) {
            $instance = new $status;
            if ($instance->toInt() === $code) {
                return $instance;
            }
        }

        return null;
    }
}