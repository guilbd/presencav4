var cpf = document.getElementById('cpf');
cpf.addEventListener("focusout", validaeValue);
function validateValue(){
    let value = cpf.value;
    let valuesplit = value.split(".");
    let validadenumber = valuesplit[2].split("-");
    if(valuesplit[0])

}


$cpf = preg_replace("/[^0-9]/", "", cpf);
    var digitoUm = 0;
    var digitoDois = 0;
    for (var i = 0, var x = 10; var i <= 8; var i++, var x--) {
        var digitoUm += cpf[$i] * x;
    }
    for (var i = 0, $x = 11; $i <= 9; $i++, $x--) {
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