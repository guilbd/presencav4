
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <title>Cadastro</title>
</head>

<body>
    <header class="logo">

    </header>
    

<?php
    session_start();
    if(isset($_GET['registro'])){
        echo "
        <div class='formulario'>
    <h1>Efetue Seu Cadastro</h1>
    <form method='post' class='registro' action='php/verificacao_cadastro.php'>
        
            <label for='cpf'>CPF</label>
            <input type='text' name='CPF_CADASTRO' id='cpf' placeholder='Ex. 000.000.000-00' 
            minlength='11' maxlength='14' required='required' autocomplete='off' 
            onkeypress='$(this).mask('000.000.000-00');'>
            
            <button id='verificar' class='botao' type='submit'>Iniciar</button>
         
    </form>
</div>
        ";
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
            if (intval($dt->format("H")) == 19 && (intval($dt->format("i")) >= 0 && intval($dt->format("i")) < 16)) {
                $mensagem = presenca('Presenca1');
                
            } 
            else {
                if (intval($dt->format("H")) == 21 && (intval($dt->format("i")) >= 0 && intval($dt->format("i")) < 31)) {
                $mensagem = presenca('Presenca2');
                }else{
                    if ((intval($dt->format("H")) == 22 && intval($dt->format("i")) > 44) || (intval($dt->format("H")) == 23 && intval($dt->format("i")) > 6)) {
                        $mensagem = presenca('Presenca3');
                    } else {
                        $mensagem = "Aguarde o horário da proxima presença ".(intval($dt->format("H")) == 10);
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
</body>

</html>