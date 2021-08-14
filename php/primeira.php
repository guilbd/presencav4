<?php
        session_start();
        include_once("conexao.php");
        $ip = "";
        if(isset($_POST['ip'])){
            $ip = $_POST['ip'];
        }
        
        $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '$ip'";
        $salvar = mysqli_query($conexao, $sql);
         
        if($salvar) {
            mysqli_close($conexao);
            $id = mysqli_fetch_assoc($salvar);
            try{
                $sql = "INSERT INTO listadepreseca (IPdispositivo,Presenca1,id_cadastro,data) VALUES ('$ip','$horarioPresenca','$id','$dataHoje");
                mysqli_query($conexao, $sql);
                mysqli_close($conexao);
                echo"<script language='javascript' type='text/javascript'>
				    alert('A sua presença está concluída');
			    </script>";
	            } catch(error $e){
		            echo"<script language='javascript' type='text/javascript'>
				    alert('Erro ao realizar a inserção');
				    window.location.href='index.php';
			    </script>";
	            }

        } else {
            <script language='javascript' type='text/javascript'>
                window.location.href='cadastro.php';</script>";
        }

?>