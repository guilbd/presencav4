<?php
        session_start();
        include_once("conexao.php");
        if(isset($_POST['ip'])){
            $ip = $_POST['ip'];
        }else{
            $ip = "";
        }
        
        $sql = "SELECT id_cadastro FROM listadepreseca WHERE IPdispositivo = '$ip'";
        $salvar = mysqli_query($conexao, $sql);
         
        if($salvar) {
            mysqli_close($conexao);
            $id = mysqli_fetch_assoc($salvar);
            $dtz = new DateTimeZone("America/Sao_Paulo");
            $dt = new DateTime("now", $dtz);
            $dataPresenca = $dt->format("Y-m-d H:i:s");
            try{
                $sql = "INSERT INTO listadepreseca (IPdispositivo,Presenca1,id_cadastro) VALUES ('$ip','$dataPresenca','$id')");
                mysqli_query($conexao, $sql);
                mysqli_close($conexao);
                echo"<script language='javascript' type='text/javascript'>
				    alert('A sua presença está concluída');
			    </script>";
	            } catch(error $e){
		            echo"<script language='javascript' type='text/javascript'>
				    alert('Erro ao realizar o cadastro, tente novamente');
				    window.location.href='cadastro.php'";
			    </script>";
	            }

        } else {
            <script language='javascript' type='text/javascript'>
                window.location.href='cadastro.php';</script>";
        }



<script>
    if (now.getHours() == 19 && (now.getMinutes() >= 0 || now.getMinutes() < 16)) {
        <?php
            session_start();

            include_once("conexao.php");
            $cpf = $_POST['CPF_LOGAR'];
            function isCpf($cpf)
            {
                $cpf = preg_replace("/[^0-9]/", "", $cpf);
                $digitoUm = 0;
                $digitoDois = 0;
                for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
                    $digitoUm += $cpf[$i] * $x;
                }
                for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {
                    if (str_repeat($i, 11) == $cpf) {
                        return false;
                    }
                    $digitoDois += $cpf[$i] * $x;
                }
                $calculoUm = (($digitoUm % 11) < 2) ? 0 : 11 - ($digitoUm % 11);
                $calculoDois = (($digitoDois % 11) < 2) ? 0 : 11 - ($digitoDois % 11);
                if ($calculoUm <> $cpf[9] || $calculoDois <> $cpf[10]) {
                    return false;
                }
                return true;
            }
            
            if (!isCpf($cpf)) {
                header('Status: 301 Moved Permanently', false, 301);
            
        ?>
            <html>
                <body>
                    <script>
                        alert("CPF inválido! Insira um cpf válido")
                        window.location.href = "index.php";
                    </script>
                </body>
            </html>
            <?php
                exit;
            }
            
            $cpf = addslashes($cpf);
            $sql = "insert into cadastro(cpf) values ('$cpf')";
            $salvar = mysqli_query($conexao, $sql);
            $linhas = mysqli_affected_rows($conexao);
            
            mysqli_close($conexao);
            if ($linhas == 1) {
                session_start();
                $_SESSION["CPF"] = $cpf;
                header('Status: 301 Moved Permanently', false, 301);
                header('location:pag.php');
            }
            ?>   

    }
    
    if (now.getHours() == 21 && (now.getMinutes() >= 0 || now.getMinutes() < 31)) {

    }
    if ((now.getHours() == 22 && now.getMinutes() > 44) || (now.getHours() == 23 && now.getMinutes() > 6){

    })
</script>