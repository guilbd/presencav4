<?php
    session_start();
    include_once("conexao.php");
    $cpf = "";
    if(isset($_POST['CPF_CADASTRO'])){
        $cpf = $_POST['CPF_CADASTRO'];
    }
    $conexao = getcon();
    $sql = "SELECT id FROM cadastro WHERE CPF = '$cpf'";
    $salvar = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($salvar)>0) {
        
        $id = "";
        while($row = $salvar->fetch_assoc()) {
            $id = $row["id"];
        }
        $sql = "INSERT INTO listadepreseca (IPdispositivo,Presenca1,id_cadastro,data) VALUES ('".$_SESSION['ip']."','".$_SESSION['time']."','$id','".$_SESSION['datahoje']."')";
        
        if ($conexao->query($sql) === TRUE) {
            $conexao->close();
            echo"<script language='javascript' type='text/javascript'>
				    alert('A sua presença está concluída');
                    window.location.href='../index.php';
                    </script>";
        
            }else{
                $valor =$conexao->error;
                echo"<script language='javascript' type='text/javascript'>
                console.log('Erro ao registrar presença".$valor."');
                window.location.href='../index.php';
            </script>";
            } 
        
    }else {
        $sql = "INSERT INTO cadastro (CPF) VALUES ('".$cpf."')";
        if ($conexao->query($sql) === TRUE) {
            $conexao->close();
            echo"<script language='javascript' type='text/javascript'>
				    alert('Cadastro Concluído');
				    window.location.href='../index.php';
			    </script>";
        
            }else{
                $valor =$conexao->error;
                echo"<script language='javascript' type='text/javascript'>
                console.log('Erro ao realizar cadastro".$valor."');
                window.location.href='../index.php';
            </script>";
            } 
        
    }

?>