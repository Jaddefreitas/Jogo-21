<?php
//  Jogo 21 
//  Devs: Mateus Barros de Moura Pereira 
//        Jadde de Freitas Leite 

//pilha com a funcao de puxar cartas para o jogador 

$cartas = ["A",1,2,3,4,5,6,7,8,9,10,"J","Q","K"];

for($i = 0; $i < 13; $i++){
    if($cartas[$i] == $_GET['carta']){
        echo "sua carta eh" . $_GET['carta'];
    }
}


$cartas = array();
array_push($cartas); //retorna todos os elementos

print_r($cartas);

array_pop($cartas); //remove o ultimo elemento

print_r($cartas);

//lista encadeada para ordenacao das cartas 

?>