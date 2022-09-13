let editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    styleActiveLine: true,
    lineNumbers: true,
    matchBrackets: true,
    autoCloseBrackets: true,
    autoCloseTags: true,
    lineWrapping: true,
    mode: "htmlmixed",
    htmlMode: true,
});
document.getElementById("favicon").onchange = function(){
    readURLFav(this);
}
document.getElementById("og").onchange = function(){
    readURLOG(this);
}
function readURLFav(input){
    if((input.files) && (input.files[0])){
        if(input.files[0].name.match(/.+(ico)/) === null){
            document.getElementById("alert").style.display = "block";
            document.getElementById("alertMsg").innerText = "Please select a favicon image in 'ico' format.";
            return document.getElementById("alert").scrollIntoView({
                behavior: "smooth"
            });
        }
        document.getElementById("uploadFavicon").value = "yes";
        document.getElementById("faviconFileButton").innerHTML = '<i class="fa-solid fa-check"></i> File selected';
    }
}
function readURLOG(input){
    if((input.files) && (input.files[0])){
        if(input.files[0].name.match(/.+(png|jpg|jpeg|webp)/) === null){
            document.getElementById("alert").style.display = "block";
            document.getElementById("alertMsg").innerText = "Please select a valid meta image. (Allowed extensions: png, jpg, jpeg, webp)";
            return document.getElementById("alert").scrollIntoView({
                behavior: "smooth"
            });
        }
        document.getElementById("uploadOG").value = "yes";
        document.getElementById("ogFileButton").innerHTML = '<i class="fa-solid fa-check"></i> File selected';
    }
}