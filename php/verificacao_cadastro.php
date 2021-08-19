<?php
    session_start();
    include_once("conexao.php");
    $cpf = "";
    if(isset($_POST['CPF_CADASTRO'])){
        $cpf = $_POST['CPF_CADASTRO'];
    }
    $conexao = getcon();
    $_SESSION['cpf']=$cpf;
    $sql = "SELECT id FROM alunos WHERE CPF = '".$_SESSION['cpf']."'";
    $salvar = mysqli_query($conexao, $sql);
    while($row = $salvar->fetch_assoc()) {
        echo "<script>document.cookie = 'blueid=".$row["id"]."'; </script>";
    }     
    if(mysqli_num_rows($salvar)>0) {
            echo"<script language='javascript' type='text/javascript'>
            console.log('Cpf existente".$valor."');
            window.location.href='../index.php';
        </script>";
         
    }else{
        $message = "'Seu CPF não está cadastrado em nosso banco de alunos matriculados.<br> Por favor entre em contato com a Blue no discord.'";
        echo"<script language='javascript' type='text/javascript'>
                window.location.href='../index.php?message=".$message.";
            </script>";
            
    }

?>
