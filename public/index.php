<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Core;
use App\SocketServer;
use App\Environment\SocketEnvironment;

// Pega a instância básica, coração do sistema
$core = new Core;

// Inicia o servidor
$core->load();
$core->run(new SocketServer(SocketEnvironment::$address));
