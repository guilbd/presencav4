<?php
    session_start();
    if(isset $_GET['ip']){
        $_SESSION['ip'] = $_GET['ip'];
        $dtz = new DateTimeZone("America/Sao_Paulo");
        $dt = new DateTime("now", $dtz);
        $_SESSION['datahoje'] = $dt->format("Y-m-d");
        $_SESSION['time'] = $dt->format("H:i:s");
        include_once("presenca.php");
        if (($dt->format("H") == 19 && ($dt->format("i") >= 0 || $dt->format("i") < 16))) {
            presenca('Presenca1');
        } 
        if ($dt->format("H") == 21 && ($dt->format("i") >= 0 || $dt->format("i") < 31)) {
            presenca('Presenca2');
        }
        if (($dt->format("H") == 22 && $dt->format("i") > 44) || ($dt->format("H") == 23 && $dt->format("i") > 6)) {
            presenca('Presenca3');
        } else {
            echo"<script language='javascript' type='text/javascript'>
            alert('Aguarde o horário da proxima presença');
            </script>";
        }
    }  
    else{
        echo"
            <script>
                var ip;
                window.location.href='index.php?ip='+valorip;
            </script>
        ";
    }
?>
