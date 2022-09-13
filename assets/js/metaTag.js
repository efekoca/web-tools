function copy(){
    let button = document.getElementById("copyButton");
    let copyText = document.getElementById("code");
    let copyButton = document.getElementById("copyButtonText");
    let textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    if(textArea.value.length > 0){
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        copyButton.disabled = true;
        copyButton.innerText = "Copied";
        setTimeout(function(){
            copyButton.disabled = false;
            copyButton.innerText = "Copy";
        }, 1500);
    }
}