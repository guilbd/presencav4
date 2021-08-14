<?php
    
    include_once("conexao.php");
    
    function presenca($presenca){
        $conexao = getcon();
//verificar data primeira presença por ip e primeira data da presença se existir marca segunda presença
        $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '".$_SESSION['ip']."'";
        $salvar =mysqli_query($conexao, $sql);
        $id = 0;
        if(mysqli_num_rows($salvar)>0){
            while($row = $salvar->fetch_assoc()) {
                $id = $row["id"];
            }
        }
        
        // Caso exista alguma presença com o ip do cliente
        if(mysqli_num_rows($salvar)>0){
            
            $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '".$_SESSION['ip']."' AND data = '".$_SESSION['datahoje']."'";
            $salvar = mysqli_query($conexao, $sql);
            
            //caso exista uma presentaça com o ip na data atual
            if(mysqli_num_rows($salvar)>0){
                
                $sql = "SELECT ".$presenca." FROM listadepreseca WHERE id = '".$id."'";
                
                // caso a presença 2 não exista
                if (mysqli_num_rows($conexao->query($sql))>0){
                    $sql = "UPDATE listadepresenca SET ".$presenca."='".$_SESSION['time']."' WHERE id='".$id."'";
                    // caso o update tenha dado certo 
                    if($conexao -> query($sql)){
                        return "A sua segunda presença foi registrada";
                    }
                    // caso o update não tenha dado certo
                    else{
                        return "Erro ao registrar presença";
                    }
                }
                // caso a presença 2 já exista
                else{
                    return "Sua presença já existe, por favor aguarde a próxima!";
                }
                
            }
            // caso exista presença no ip mas não exista na data atual
            else{
                $sql = "INSERT INTO listadepreseca (IPdispositivo,".$presenca.",id_cadastro,data) VALUES ('".$_SESSION['ip']."','".$_SESSION['time']."','".$id."','".$_SESSION['datahoje']."')";
            }

            mysqli_close($conexao);
        }
        // caso não exista presença com o ip do cliente
        else{
            echo"<script language='javascript' type='text/javascript'>
                        alert('Seu ip não está cadastrado;');
                        window.location.href='index.php?registro=registro';
                    </script>
                    ";
        }
    }


?>