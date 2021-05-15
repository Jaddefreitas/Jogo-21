<?php
error_reporting(E_ALL);

echo"<h2> Conexão feita!";

$service_port = getservbyname('www', 'tcp');

$adress = gethostbyname('www.exemple.com');

$socket = socket_creat(AF_INET, SOCK_STREAM, SOL_TCP);

if($socket === false){
    echo "socket_strerror(socket_last_error())" . "\n";
}
else{
    echo "Passou!";
}
echo "Voce esta conectando em: 'address' na porta '$service_port'...";
$result = socket_connect($socket, $address, $service_port);

if($result === false){
    echo "socket_connect() failed. \n Reason: ($reasult)" . socket_strerror(socket_last_error($socket)) . "\n";
}
else{
    echo "Passou na segunda etapa!";
}

$in = "HEAD / HTTP/1.1\r\n";
$in .="Host: www.exemple.com\r\n";
$in .="Connection: Close\r\n\r\n";
$out = '';

echo "Sending HTTP HEAD request...";
socket_write($socket, $in, strlen($in));
echo "ok. \n";

echo "Reading response: \n\n";
while($out = socket_read($socket, 2048)){
    echo $out;
}

echo "Closing socket...";
socket_close($socket);
echo "Deu Certo!";
?>