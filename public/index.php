<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Core;
use App\FSocketServer;

// Pega a instância básica, coração do sistema
$core = new Core;

// Inicia o servidor
$core->load();
$core->run(FSocketServer::getInstance());
