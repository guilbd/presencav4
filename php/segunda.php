<?php

//verificar data primeira presença por ip e primeira data da presença se existir marca segunda presença
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$day = $dt->format('d');
$dataHoje = $dt->format("Y-m-d");
$horarioPresenca = $dt->format("H:i:s");
$sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '$ip' AND data = '$dataHoje'";
    $salvar = mysqli_query($conexao, $sql);

// $_SESSION['ip'] = ip

// caso não exista primeira presença neste ip nesta data gera cadastro de presença marca segunda chamada


// caso não exista o ip redireciona para cadastro


?>