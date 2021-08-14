<?php
    session_start();
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $_SESSION['datahoje'] = $dt->format("Y-m-d");
    $_SESSION['time'] = $dt->format("H:i:s");
?>

<script>
    var now = new Date;
    if ((now.getHours() == 19 && (now.getMinutes() >= 0 || now.getMinutes() < 16))) {
        window.location.href = "primeira.php";
    } 
    if (now.getHours() == 21 && (now.getMinutes() >= 0 || now.getMinutes() < 31)) {
        window.location.href = "segunda.php";
    }
    if ((now.getHours() == 22 && now.getMinutes() > 44) || (now.getHours() == 23 && now.getMinutes() > 6)) {
        window.location.href = "terceira.php";
    } else {
        window.location.href = "aguarde.php";
    }
</script>