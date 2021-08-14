<?php
    
    include_once("conexao.php");
    function presenca($presenca){
//verificar data primeira presença por ip e primeira data da presença se existir marca segunda presença
        $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '$ip'";
        $salvar = mysqli_query($conexao, $sql);
        mysqli_close($conexao);
        // Caso exista alguma presença com o ip do cliente
        if($salvar){
            mysqli_close($conexao);
            $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '$ip' AND data = '".$_SESSION['datahoje']."'";
            $salvar = mysqli_query($conexao, $sql);
            //caso exista uma presentaça com o ip na data atual
            if($salvar){
                mysqli_close($conexao);
                $id=$salvar;
                $sql = "SELECT $presenca FROM listadepreseca WHERE id = $id";
                $salvar = mysqli_query($conexao, $sql);
                // caso a presença 2 não exista
                if ($salvar){
                    $sql = "UPDATE listadepresenca SET $presenca='".$_SESSION['time']."' WHERE id=$id";
                    // caso o update tenha dado certo 
                    if($conexao -> query($sql)){
                        echo"<script language='javascript' type='text/javascript'>
                        alert('A sua segunda presença foi registrada');
                        </script>";
                    }
                    // caso o update não tenha dado certo
                    else{
                        echo"<script language='javascript' type='text/javascript'>
                        alert('Erro ao registrar segunda presença');
                        </script>";
                    }
                }
                // caso a presença 2 já exista
                else{
                    echo"<script language='javascript' type='text/javascript'>
                        alert('Sua presença já existe, por favor aguarde a próxima!');
                        </script>";
                }
                
            }
            // caso exista presença no ip mas não exista na data atual
            else{
                $sql = "INSERT INTO listadepreseca (IPdispositivo,$presenca,id_cadastro,data) VALUES ('$ip','".$_SESSION['time']."','$id','".$_SESSION['datahoje']."'");
            }
        }
        // caso não exista presença com o ip do cliente
        else{
            echo"<script language='javascript' type='text/javascript'>
                        alert('Seu ip não está cadastrado;');
                        window.location.href='cadastro.php';";
        }
    }


?>