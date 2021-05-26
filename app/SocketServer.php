<?php

namespace App;

use ErrorException;
use Core\Contract\IServer;
use App\Service\JogadorService;
use App\Storage\JogadoresStorage;
use App\Environment\AppEnvironment;

/**
 * Socket Server
 * 
 * Servidor socket para conexão e transmissão de dados do sistema. Funciona como um singleton.
 */
class SocketServer implements IServer
{
    private $except;
    private $server;

    /**
     * Constrói a classe 
     */
    public function __construct(string $uri)
    {
        $this->server = stream_socket_server($uri, $error_code, $error_message);
        stream_set_blocking($this->server, false);

        if ($this->server === false) {
            throw new ErrorException("SocketServer > $error_message", $error_code);
        }

        fwrite(STDERR, sprintf("%s Iniciado em: %s\n", AppEnvironment::$name, stream_socket_get_name($this->server, false)));
    }

    /**
     * Inicializa o loot infinito do servidor, que escuta todos os eventos do socket
     * 
     * @return void
     */
    public function run(): void
    {
        while (true) {
            $this->except = null;
            $streams = array_column(JogadoresStorage::get(), 'stream');
            $readable = $streams;
            $writable = $streams;

            // Adiciona a stream do servidor no array de streams de somente leitura para conseguir
            // aceitar novas conexões, quando disponíveis
            $readable[] = $this->server;

            // Em um looping infinito, a stream_select() retornará quantas streams foram
            // modificadas, a partir disso iteramos sobre elas (tanto as de escrita quanto de
            // leitura), lendo ou escrevendo. A stream_select() recebe os arrays por referência e
            // ela os zera (remove seus itens) até que uma stream muda de estado, quando isso
            // acontece, a stream_select() volta com essa stream para o array, é nesse momento que
            // conseguimos iterar escrevendo ou lendo.
            if (stream_select($readable, $writable, $this->except, 0, 200000) > 0) {
                $this->readFromStreams($readable);
                $this->writeToStreams($writable);
                $this->release($streams);
            }
        }
    }

    /**
     * Manipula as conexões que possuam dados disponíveis para leitura. Quando a conexão for do
     * proprio servidor, 
     * 
     * @param  array $streams
     * @return void
     */
    private function readFromStreams(array $streams): void
    {
        foreach ($streams as $stream) {
            // Se conexão igual a conexão do servidor, a operação é uma operação para registrar
            // uma nova conexão no servidor
            if ($stream === $this->server) {
                $this->acceptConnection($stream);
                continue;
            }

            // Localiza o jogador pelo stream
            $jogador = JogadoresStorage::find($stream);

            // Se o jogador não for encontrado, pula para a próxima iteração
            if ($jogador === null) continue;

            // Armazena os dados no buffer do jogador
            $jogador->buffer .= fread($stream, 4096);
        }
    }

    /**
     * Manipula as operações de escrita nas conexões disponíveis. Para isso, verifica-se o
     * registro de mensagens no buffer, que significa que há dados a serem enviados ao jogador
     * 
     * @param  array $streams
     * @return void
     */
    private function writeToStreams(array $streams): void
    {
        foreach ($streams as $stream) {
            // Localiza o jogador pela sua conexão
            $jogador = JogadoresStorage::find($stream);

            // Se o jogador não for encontrado, pula para a próxima iteração
            if ($jogador === null) continue;

            // Se o buffer estiver com dados, despacha a mensagem para o jogador e limpa o buffer
            // do mesmo
            if (strlen($jogador->buffer) > 0) {
                // Despacha para o cliente o que está no buffer
                $bytesWritten = fwrite($stream, "Server says: {$jogador->buffer}", 2048);

                // Remove do buffer a parte escrita;
                $jogador->buffer = substr($jogador->buffer, $bytesWritten);
            }
        }
    }

    /**
     * Verifica se a conexão foi encerrada. Nesse caso, faz a limpeza do jogador no Storage.
     * 
     * @param  array $streams
     * @return void
     */
    private function release(array $streams): void
    {
        foreach ($streams as $stream) {
            // Quando uma conexão é fechada, ela entra no modo EOF (end-of-file),
            // usamos a feof() pra verificar esse estado e então devidamente executar fclose().
            // Verifica se a conexão foi encerrada. Nesse caso, a conexão entra em modo EOF
            // (end-of-file), precisando ser fechada e o jogador limpado do Storage
            if (feof($stream)) {
                fwrite(STDERR, sprintf("Jogador [%s] foi desconectado; \n", stream_socket_get_name($stream, true)));
                fclose($stream);
                JogadoresStorage::remove($stream);
            }
        }
    }

    /**
     * Registra uma nova conexão. Nesse momento, registra um jogo jogador no sistema, a partir do
     * despacho da operação de conexão.
     * 
     * @return void
     */
    private function acceptConnection($stream): void
    {
        $connection = stream_socket_accept($stream, 0, $clientAddress);

        if ($connection) {
            fwrite(STDERR, sprintf("Jogador [%s] conectou-se; \n", $clientAddress));
            stream_set_blocking($connection, false);
            JogadorService::conectar($connection);
        }
    }
}
