<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

class JogadorCriarStatus implements IStatus
{
    public function toString(): string
    {
        return 'JOGADOR_CRIAR';
    }

    public function toInt(): int
    {
        return 200;
    }
}