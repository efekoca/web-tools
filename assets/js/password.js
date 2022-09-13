function copy(){
    let button = document.getElementById("copyButton");
    let copyText = document.getElementById("password");
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