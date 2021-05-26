<?php

namespace App\Evento\Status;

/**
 * Mantém apenas os código de status genéricos
 */
class StatusCode
{
    public const STATUS_OK = 200;
    public const STATUS_BAD_REQUEST = 400;
    public const STATUS_NOT_FOUND = 404;
    public const STATUS_INTERNAL_SERVER_ERROR = 500;
}