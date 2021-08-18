<?php
    
    include_once("conexao.php");
    
    function presenca($presenca){
        $data = explode("-",$_SESSION['datahoje']);
        $conexao = getcon();
//verificar data primeira presença por ip e primeira data da presença se existir marca segunda presença
        $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '".$_SESSION['ip']."'";
        $salvar =mysqli_query($conexao, $sql);
        $id = 0;
        $nome = "";
        while($row = $salvar->fetch_assoc()) {
            $id = $row["id_cadastro"];
        }
        $nome = "";
        while($row = $salvar->fetch_assoc()) {
            $id = $row["id_cadastro"];
        }
        if(mysqli_num_rows($salvar)>0){
            $sql = "SELECT nome FROM alunos WHERE id = '".$id."'";
            $salvar = mysqli_query($conexao, $sql);
            while($row = $salvar->fetch_assoc()) {
                $nome = $row["nome"];
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
                        return ucfirst(strtolower($nome)).".<br>Sua ".substr($presenca, -1)."ª Presença foi registrada em: ".$_SESSION['time']." do dia ".$data[2]."/".$data[1]."/".$data[0]."!";
                    }
                    // caso o update não tenha dado certo
                    else{
                        return "Error: " . $sql . "<br>" . $conexao->error;
                    }
                }
                // caso a presença 2 já exista
                else{
                    return ucfirst(strtolower($nome))." . A sua ".substr($presenca, -1)."ª presença já foi registrada em: ".$data[2]."/".$data[1]."/".$data[0]." ás: ".$valor;
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
                   
                    return ucfirst(strtolower($nome)).".<br>Sua ".substr($presenca, -1)."ª Presença foi registrada em: ".$_SESSION['time']." do dia ".$data[2]."/".$data[1]."/".$data[0]."!";
                
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
                
                $sql = "SELECT id, nome FROM alunos WHERE cpf = '".$_SESSION['cpf']."'";
                $salvar = mysqli_query($conexao, $sql);
                
                if(mysqli_num_rows($salvar)>0) {
                    
                    $id = "";
                    $nome = "";
                    while($row = $salvar->fetch_assoc()) {
                        $id = $row["id"];
                        $nome = $row["nome"];
                    }
                    
                    $sql = "INSERT INTO listadepreseca (IPdispositivo,".$presenca.",id_cadastro,data) VALUES ('".$_SESSION['ip']."','".$_SESSION['time']."','$id','".$_SESSION['datahoje']."')";
                    
                    if ($conexao->query($sql) === TRUE) {
                        $conexao->close();
                        return ucfirst(strtolower($nome)).".<br>Sua ".substr($presenca, -1)."ª Presença foi registrada em: ".$_SESSION['time']." do dia ".$data[2]."/".$data[1]."/".$data[0]."!";
                    
                        }else{
                            $valor =$conexao->error;
                            echo"<script language='javascript' type='text/javascript'>
                            console.log('Erro ao registrar presença".$valor."');
                            window.location.href='index.php';
                        </script>";
                        } 
                    
                }else {
                    echo"<script language='javascript' type='text/javascript'>
                    alert('Seu ip não está cadastrado;');
                    window.location.href='index.php?registro=registro';
                </script>
                ";
                        
                    
                }
            }else {
                echo"<script language='javascript' type='text/javascript'>
                alert('Seu ip não está cadastrado;');
                window.location.href='index.php?registro=registro';
            </script>
            ";
                    
                
            }
        }
    }
    function outTime(){
        $conexao = getcon();
        $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '".$_SESSION['ip']."'";
        $salvar =mysqli_query($conexao, $sql);
        $id = 0;
        $nome = "";
        while($row = $salvar->fetch_assoc()) {
            $id = $row["id_cadastro"];
        }
        if(mysqli_num_rows($salvar)>0){
            $sql = "SELECT nome FROM alunos WHERE id = '".$id."'";
            $salvar = mysqli_query($conexao, $sql);
            while($row = $salvar->fetch_assoc()) {
                $nome = $row["nome"];
            }  
            if(mysqli_num_rows($salvar)>0) {
                return ucfirst(strtolower($nome)).".<br> O horário do registro de chamada está incorreto.";
            }
        }
    }

?>