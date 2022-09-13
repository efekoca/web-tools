const input = document.getElementById("colorPicker");
const colorCode = document.getElementById("colorCode");
setColor();
input.addEventListener("input", setColor);
function setColor(){
    colorCode.innerHTML = input.value;
}
function copy(){
    let button = document.getElementById("copyButton");
    let copyText = document.getElementById("colorCode");
    let textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    if(textArea.value.length > 0){
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        button.disabled = true;
        button.innerText = "(Copied)";
        setTimeout(function(){
            button.disabled = false;
            button.innerText = "(Copy)";
        }, 1500);
    }
}