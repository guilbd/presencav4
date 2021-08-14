<?php
    session_start();
    include_once("conexao.php");
    $cpf = "";
    if(isset($_POST['CPF_CADASTRO'])){
        $cpf = $_POST['CPF_CADASTRO'];
    }
    $conexao = getcon();
    $_SESSION['cpf']=$cpf;
    $sql = "SELECT id FROM cadastro WHERE CPF = '".$_SESSION['cpf']."'";
    $salvar = mysqli_query($conexao, $sql);
               
    if(mysqli_num_rows($salvar)>0) {
            echo"<script language='javascript' type='text/javascript'>
            console.log('Cpf existente".$valor."');
            window.location.href='../index.php';
        </script>";
         
    }else{
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
