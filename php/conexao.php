<?php

function getcon(){
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "presenca";
    $conexao = mysqli_connect($hostname, $user, $password, $database);

    if (!$conexao) {
        print "Falha com a conexão no Banco de dados";
    }
    return $conexao;
}
?>