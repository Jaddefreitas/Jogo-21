<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

class SalaUpdateStatus implements IStatus
{
    public function toString(): string
    {
        return 'SALA_UPDATE_STATUS';
    }

    public function toInt(): int
    {
        return 200;
    }
}