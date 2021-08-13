<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style/style.css" media="screen">
    <link rel="icon" href="href=https://blueedtech.com.br/wp-content/uploads/2020/12/cropped-favicon-1-32x32.png" size=“32x32">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <title>Cadastro</title>
</head>

<body>
    <h1>Efeute o seu cadastro</h1>
    <div class="formulario">
        <form method="post" action="verificacao_cadastro.php">
            <div id="dados">
                <label for="cpf"><strong>CPF</strong></label>
                <input type="text" name="CPF_CADASTRO" id="cpf" placeholder="Ex. 000.000.000-00" minlength="11" maxlength="14" required="required" autocomplete="off" onkeypress="$(this).mask('000.000.000-00');">
                <a href="form.php">
                    <button id="verificar" class="botao" type="submit">Iniciar</button>
                </a>
            </div>
        </form>
    </div>
</body>

</html>