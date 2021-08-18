
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="href=https://blueedtech.com.br/wp-content/uploads/2020/12/cropped-favicon-1-32x32.png" size=“32x32">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/modal.css">
    <script src="js/verificacpf.js" defer></script>
    <script src="js/modal.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <title>Cadastro</title>
</head>

<body>
    <header class="logo">
        <img class="img" src="img/bluelogo.png">
    </header>
    

<?php
    session_start();
    if(isset($_GET['registro'])){
        $cpfteste = "'000.000.000-00'";
        echo '
        <div class="formulario">
    <h1>Cadastre seu CPF</h1>
    <form method="post" class="registro" action="php/verificacao_cadastro.php">
        
            <label for="cpf">CPF</label>
            <input type="text" name="CPF_CADASTRO" id="cpf" placeholder="Ex. 000.000.000-00" 
            minlength="11" maxlength="14" required="required" autocomplete="off" 
            onkeypress="$(this).mask('.$cpfteste.');">
            
            <button id="verificar" class="botao" type="submit">Cadastrar</button>
         
    </form>
</div>
        ';
    }
    else{
        $mensagem = "Desative o Adblock para que que o sistema possa funcionar!";
        if(isset($_POST['ip'])){
            
            $_SESSION['ip'] = $_POST['ip'];
            $dtz = new DateTimeZone("America/Sao_Paulo");
            $dt = new DateTime("now", $dtz);
            $_SESSION['datahoje'] = $dt->format("Y-m-d");
            $_SESSION['time'] = $dt->format("H:i:s");
            $datata = $_SESSION['datahoje'];
           
            include_once("php/presenca.php");
            if ((intval($dt->format("H")) >= 18 && intval($dt->format("i")) >= 50)&&(intval($dt->format("H")) <= 19 && intval($dt->format("i"))<=30)) {
                $mensagem = presenca('Presenca1'); 
            } 
            else {
                if ((intval($dt->format("H")) >= 20 && intval($dt->format("i")) >= 45)&&(intval($dt->format("H")) <= 21 && intval($dt->format("i"))<=45)) {
                $mensagem = presenca('Presenca2');
                }else{
                    if ((intval($dt->format("H")) >= 22 && intval($dt->format("i")) >= 30)&&(intval($dt->format("H")) <= 23 && intval($dt->format("i"))<=10)) {
                        $mensagem = presenca('Presenca3');
                    } else {
                        $mensagem = outTime();
                    }
                }
            }
            
        }  
        else{
            echo"
                <script src='js/jquery-3.6.0.min.js'></script>
                <script>
                function redirectPost(url,data) {
                    var form = document.createElement('form');
                    document.body.appendChild(form);
                    form.method = 'post';
                    form.action = url;
                    for (var name in data) {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ip';
                        input.value = data;
                        form.appendChild(input);
                    }
                    form.submit();
                }
                $.getJSON('https://api.ipify.org?format=jsonp&callback=?', function(data) {
                    var values = JSON.parse(JSON.stringify(data, null, 2));
                    redirectPost('index.php',values.ip);
                  });
                  
                    
                </script>";
            //         var ip;
            //         window.location.href='index.php?ip='+valorip;
            //     </script>

            // ";
        }
        echo"
        <div class='formulario'>
                <h1>$mensagem</h1>
                
        </div>
        ";
    }
?>
<div id="notice" class="modal">
    <div class="content">
        <h2 class="title">Este Controle de Presença captura o seu IP e seu CPF.</h2> 
        <p>Caso tenha mais de um aluno usando o mesmo IP, entre em contato com a Blue EdTech.</p>
        <p> Caso use IP dinâmico, saiba que o CPF será solicitado todas as vezes.</p>
        <p>A veracidade dos dados fornecidos são de responsabilidade do usuário</p>
        <button class="concordo">Concordo</button>
    </div>
</div>
<footer class="avisar">
    <p>
    Caso encontre erro ou tenha uma sugestao de melhoria, fale com Blue EdTech através do Discord.
    </p>
</footer>
</body>

</html>