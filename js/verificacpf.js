let cpf = document.getElementById('cpf');
let button = document.getElementById('verificar');
cpf.addEventListener("keyup", validateValue);
button.disabled = true;
button.style.boxShadow ="5px 5px 0px #fd0101";
function validateValue(){
    let value = cpf.value;
    if(value.length == 14){
    var number = [];
    var first = 0;
    var second = 0;
    var sumdigit = 0;
    value = value.replace(".","");
    value = value.replace(".","");
    value = value.replace("-","");
    for(var i=0;i < 11;i++){
        number.push(parseInt(value.substr(i,1))); 
    }
    for(var i=0;i<9;i++){
        sumdigit += (number[i] *(10-i));
    }
    if((11-(sumdigit%11))<10){
        first = 11-(sumdigit%11);
    }else{
        first = 0;
    }
    for(var i=0;i<10;i++){
        sumdigit += (number[i] *(11-i));
    }
    if((11-(sumdigit%11))<10){
        second = 11-(sumdigit%11);
    }else{
        second = 0;
    }
    if(first == number[9] && second == number[10]){
        cpf.style.boxShadow ="5px 5px 0px #16fd01";
        button.style.boxShadow ="5px 5px 0px #16fd01";
        button.disabled = false;        
    }else{
        cpf.style.boxShadow ="5px 5px 0px #fd0101";
        button.style.boxShadow ="5px 5px 0px #fd0101";
        button.disabled = true;   
    }
}else{
    cpf.style.boxShadow ="5px 5px 0px #fd0101";
    button.style.boxShadow ="5px 5px 0px #fd0101";
    button.disabled = true;   
}

}

