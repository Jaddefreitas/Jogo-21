<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

class BadRequestStatus implements IStatus
{
    public function toString(): string
    {
        return 'BAD_REQUEST';
    }

    public function toInt(): int
    {
        return 400;
    }
}