let cpf = document.getElementById('cpf');
let button = document.getElementById('verificar');
cpf.addEventListener("keyup", validateValue);
cpf.addEventListener("focusout", validateValue);
button.disabled = true;
button.style.boxShadow ="5px 5px 0px #fd0101";
function validateValue(){
    let value = cpf.value;
    if(value.length == 14){
        let number = [];
        let first = 0;
        let second = 0;
        value = value.replace(".","");
        value = value.replace(".","");
        value = value.replace("-","");
        for(var i=0;i < 11;i++){
            number.push(parseInt(value.substr(i,1))); 
        }
        if(verifyRepeat(number)){
            first = multiplyParts(number,8,1);
            second = multiplyParts(number,9,0);
        }
        if(second > 9){
            second = 0;
        }
    if((first == number[9])&&(second == number[10])&&(cpf.value!= "000.000.000-00")){
        cpf.style.boxShadow ="5px 5px 0px #16fd01";
        button.style.boxShadow ="5px 5px 0px #16fd01";
        button.disabled = false;        
    }else{
        cpf.style.boxShadow ="5px 5px 0px #fd0101";
        button.style.boxShadow ="5px 5px 0px #fd0101";
        button.disabled = true;   
    }
}else{

    if(value.length == 3 ||value.length == 7){
        cpf.value = value +".";
    }
    if(value.length == 11){
        cpf.value = value+"-";
    }
    cpf.style.boxShadow ="5px 5px 0px #fd0101";
    button.style.boxShadow ="5px 5px 0px #fd0101";
    button.disabled = true;   
}

}


function verifyRepeat(valor){
    for(var i=0; i<(valor.length-1);i++){
        if(valor[i] != valor[i+1]){

            return true;
        }
    }
    return false;
}
function multiplyParts(number,max,start){
    
    var sumdigit =0;
    var comeco = start;
    for(var i=0;i<=max;i++){
        
        sumdigit += (number[i] *(comeco));
        comeco=comeco+1;
    }
       return (sumdigit%11);
   
}