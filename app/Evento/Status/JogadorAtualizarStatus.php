<?php

namespace App\Evento\Status;

use App\Evento\Status\IStatus;

class JogadorAtualizarStatus implements IStatus
{
    public function toString(): string
    {
        return 'JOGADOR_ATUALIZAR';
    }

    public function toInt(): int
    {
        return 200;
    }
}