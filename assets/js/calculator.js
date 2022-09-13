let buttons = document.querySelectorAll("button"), buttonsCount = buttons.length, result = document.querySelector("#result");
for(let i = 0; i < buttonsCount; i++){
    buttons[i].onclick = check;
}
function check(){
    let currentValue = this.innerHTML;
    if(currentValue == "="){
        try{
            result.value = Function("return " + result.value)();
        }catch(e){
            result.value = 0;
        }
        return;
    }
    result.value += currentValue;
}