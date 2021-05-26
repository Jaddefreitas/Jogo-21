<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

class InternalServerErrorStatus implements IStatus
{
    public function toString(): string
    {
        return 'INTERNAL_SERVER_ERROR';
    }

    public function toInt(): int
    {
        return 500;
    }
}