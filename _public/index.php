<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="href=https://blueedtech.com.br/wp-content/uploads/2020/12/cropped-favicon-1-32x32.png" size=“32x32">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../_css/cadastro.css">
        <link rel="stylesheet" href="../_css/body.css">
        <link rel="stylesheet" href="../_css/modal.css">
        <script src="../_js/verificacpf.js" defer></script>
        <script src="../_js/status.js" defer></script>
        <script src="../_js/modal.js" defer></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <title>Cadastro</title>
    </head>
    <body>
        <header class="logo">
            <img class="img" src="../_img/bluelogo.png">
        </header>
        <?php
            include_once('../_apps/MakePresence.php');
            $makepresence = new MakePresence();
            $mensagem = $makepresence->messages(4,"");
            if(isset($_POST['ip'])||isset($_COOKIE['ip'])){
                
                $dtz = new DateTimeZone("America/Sao_Paulo");
                $dt = new DateTime("now", $dtz);
                
                $makepresence->setSessionDate($dt->format("Y-m-d"));
                $makepresence->setSessionTime($dt->format("H:i:s"));
                
                if(isset($_POST['CPF_CADASTRO'])){
                    
                    $makepresence->setSessionCpf($_POST['CPF_CADASTRO']);
                    
                }
                if(isset($_COOKIE['blueid'])){
                    $makepresence->setSessionId($_COOKIE['blueid']);
                }
                if(isset($_COOKIE['ip'])){
                    $makepresence->setSessionIp($_COOKIE['ip']);
                }else{
                    $makepresence->setSessionIp($_POST['ip']);
                    setcookie("ip",$_POST['ip'], time()+2*24*60*60);
                }
                if ((intval($dt->format("H")) == 18 && intval($dt->format("i")) >= 50)||(intval($dt->format("H")) == 19 && intval($dt->format("i"))<=30)) {
                    
                    $mensagem = $makepresence->verifyPresence('Presenca1'); 
                } 
                else {
                    if ((intval($dt->format("H")) == 20 && intval($dt->format("i")) >= 45)||(intval($dt->format("H")) == 21 && intval($dt->format("i"))<=45)) {
                        $mensagem = $makepresence->verifyPresence('Presenca2'); 
                    }else{
                        if ((intval($dt->format("H")) == 22 && intval($dt->format("i")) >= 30)||(intval($dt->format("H")) == 23 && intval($dt->format("i"))<=10)) {
                            $mensagem = $makepresence->verifyPresence('Presenca3'); 
                        } else {
                            $mensagem = $makepresence->verifyPresence('');
                        }
                    }
                }
                if(strcmp($mensagem[1],"register")==0){
                    $cpfteste = "'000.000.000-00'";
                    echo '
                    <div class="formulario">
                        <h1>Cadastre seu CPF</h1>
                        <form method="post" class="registro" action="index.php">
                    
                        <label for="cpf">CPF</label>
                        <input type="text" name="CPF_CADASTRO" id="cpf" placeholder="Ex. 000.000.000-00" 
                        minlength="11" maxlength="14" required="required" autocomplete="off" 
                        >
                        
                        <button id="verificar" class="botao" type="submit">Cadastrar</button>
                     
                     </form>
                    </div>
                    <div id="notice" style="display:flex;" class="modal">
                        <div class="content">
                            <h2 class="title">Este Controle de Presença captura o seu IP e seu CPF.</h2> 
                            <p>Caso tenha mais de um aluno usando o mesmo IP, entre em contato com a Blue EdTech.</p>
                            <p> Caso use IP dinâmico, saiba que o CPF será solicitado todas as vezes.</p>
                            <p>A veracidade dos dados fornecidos são de responsabilidade do usuário</p>
                            <button class="concordo">Concordo</button>
                        </div>
                    </div>
                    ';
                }else{
                    $color ='style="background-color:'.$mensagem[0].';"';
                    echo"
                        <div id='message' class='formulario' ".$color.">
                                <h1>$mensagem[1]</h1>
                                
                        </div>
                    ";
                }
            }else{
                
                $color = 'style="background-color:'.$mensagem[0].';"';
                echo"
                    <div id='message' class='formulario' ".$color.">
                            <h1>$mensagem[1]</h1>
                            
                    </div>
                    ";
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
            }
           
            
            
        ?>
        <footer class="avisar">
            <p>
            Caso encontre erro ou tenha uma sugestao de melhoria, fale com Blue EdTech através do Discord.
            </p>
        </footer>
    </body>
</html>