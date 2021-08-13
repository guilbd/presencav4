<?php
    session_start();
    include_once("conexao.php");
    $cpf = "";
    if(isset($_POST['CPF_CADASTRO'])){
        $cpf = $_POST['CPF_CADASTRO'];
    }
    
    $sql = "SELECT id FROM cadastro WHERE CPF = '$cpf'";
    $salvar = mysqli_query($conexao, $sql);
    if($salvar) {
        mysqli_close($conexao);
        $id = mysqli_fetch_assoc($salvar);
        $dtz = new DateTimeZone("America/Sao_Paulo");
        $dt = new DateTime("now", $dtz);
        $horarioPresenca = $dt->format("H:i:s");
        $dataHoje = $dt->format("Y-m-d");
        $sql = "INSERT INTO listadepreseca (IPdispositivo,Presenca1,id_cadastro,data) VALUES ('$ip','$horarioPresenca','$id','$dataHoje");
        mysqli_query($conexao, $sql);
        mysqli_close($conexao);
        echo"<script language='javascript' type='text/javascript'>
				    alert('A sua presença está concluída');
                    </script>";
    }else {
        $sql = "INSERT INTO cadastro (CPF) VALUES ('$cpf')");
        mysqli_query($conexao, $sql);
        mysqli_close($conexao);
        echo"<script language='javascript' type='text/javascript'>
				    alert('Cadastro Concluído');
				    window.location.href='index.php'";
			    </script>";
    }
?>