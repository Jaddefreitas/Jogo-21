<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

class OkStatus implements IStatus
{
    public function toString(): string
    {
        return 'OK';
    }

    public function toInt(): int
    {
        return 200;
    }
}