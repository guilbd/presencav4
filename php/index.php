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