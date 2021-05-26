<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

class NotFoundStatus implements IStatus
{
    public function toString(): string
    {
        return 'NOT_FOUND';
    }

    public function toInt(): int
    {
        return 404;
    }
}