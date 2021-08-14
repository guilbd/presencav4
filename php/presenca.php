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
                $id = $row["id_cadastro"];
            }
        }
        // Caso exista alguma presença com o ip do cliente
        if(mysqli_num_rows($salvar)>0){
            
            $sql = "SELECT id FROM listadepreseca WHERE IPdispositivo = '".$_SESSION['ip']."' AND data = '".$_SESSION['datahoje']."'";
            $salvar = mysqli_query($conexao, $sql);
           
            //caso exista uma presentaça com o ip na data atual
            if(mysqli_num_rows($salvar)>0){
                while($row = $salvar->fetch_assoc()) {
                    $id = $row["id"];
                }
                
                $sql = "SELECT ".$presenca." FROM listadepreseca WHERE id = '".$id."'";
                $salvar = mysqli_query($conexao, $sql);
                $valor = "";
                while($row = $salvar->fetch_assoc()) {
                    if(strcmp($presenca,"Presenca1")==0){
                        
                        $valor = $row["Presenca1"];
                    }elseif(strcmp($presenca,"Presenca2")==0){
                        
                        $valor = $row["Presenca2"];
                        
                    }elseif(strcmp($presenca,"Presenca3")==0){
                        
                        $valor = $row["Presenca3"];
                    }
                    
                }
                
                
                
                // caso a presença 2 não exista
                if (strcmp($valor, NULL)==0){
                    

                    $sql = "UPDATE listadepreseca SET ".$presenca."='".$_SESSION['time']."' WHERE id='".$id."'";
                    
        
                    // caso o update tenha dado certo 
                    
                    if ($conexao->query($sql) === TRUE) {
                        $conexao->close();
                        return "A sua presença foi registrada";
                    }
                    // caso o update não tenha dado certo
                    else{
                        return "Error: " . $sql . "<br>" . $conexao->error;
                    }
                }
                // caso a presença 2 já exista
                else{
                    return "Sua presença já existe, por favor aguarde a próxima!";
                }
                
            }
            // caso exista presença no ip mas não exista na data atual
            else{
                
                $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '".$_SESSION['ip']."'";
                $salvar =mysqli_query($conexao, $sql);
                $id = 0;
                if(mysqli_num_rows($salvar)>0){
                    while($row = $salvar->fetch_assoc()) {
                        $id = $row["id_cadastro"];
                    }
                }
                
                $sql = "INSERT INTO listadepreseca (IPdispositivo,".$presenca.",id_cadastro,data) VALUES ('".$_SESSION['ip']."','".$_SESSION['time']."','".$id."','".$_SESSION['datahoje']."')";
                if ($conexao->query($sql) === TRUE) {
                   
                    echo"<script language='javascript' type='text/javascript'>
                            alert('A sua presença está concluída');
                            window.location.href='index.php';
                            </script>";
                
                    }else{
                        $valor =$conexao->error;
                        echo"<script language='javascript' type='text/javascript'>
                        console.log('Erro ao registrar presença".$valor."');
                        window.location.href='index.php';
                    </script>";
                    } 
            }

            mysqli_close($conexao);
        }
        // caso não exista presença com o ip do cliente
        else{
            if(isset($_SESSION['cpf'])){
                
                $sql = "SELECT id FROM cadastro WHERE CPF = '".$_SESSION['cpf']."'";
                $salvar = mysqli_query($conexao, $sql);
                
                if(mysqli_num_rows($salvar)>0) {
                    
                    $id = "";
                    while($row = $salvar->fetch_assoc()) {
                        $id = $row["id"];
                    }
                
                    $sql = "INSERT INTO listadepreseca (IPdispositivo,".$presenca.",id_cadastro,data) VALUES ('".$_SESSION['ip']."','".$_SESSION['time']."','$id','".$_SESSION['datahoje']."')";
                    
                    if ($conexao->query($sql) === TRUE) {
                        $conexao->close();
                        echo"<script language='javascript' type='text/javascript'>
                                alert('A sua presença está concluída');
                                window.location.href='index.php';
                                </script>";
                    
                        }else{
                            $valor =$conexao->error;
                            echo"<script language='javascript' type='text/javascript'>
                            console.log('Erro ao registrar presença".$valor."');
                            window.location.href='index.php';
                        </script>";
                        } 
                    
                }else {
                    echo"<script language='javascript' type='text/javascript'>
                    alert('Seu cpf não está cadastrado;');
                    window.location.href='index.php?registro=registro';
                </script>
                ";
                        
                    
                }
            }else {
                echo"<script language='javascript' type='text/javascript'>
                alert('Seu cpf não está cadastrado;');
                window.location.href='index.php?registro=registro';
            </script>
            ";
                    
                
            }
        }
    }


?>