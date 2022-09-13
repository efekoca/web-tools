document.getElementById("adImage").onchange = function(){
    readURL(this);
}
document.getElementById("adForm").addEventListener("submit", function(e){
    if(document.getElementById("adImage").files.length === 0){
        e.preventDefault();
        document.getElementById("fileButton").innerHTML = '<i class="fa-solid fa-xmark"></i> Choose a file';
        document.getElementById("alert").style.display = "block";
        document.getElementById("alertMsg").innerText = "Please specify a valid cover image. (Allowed extensions: \"png, jpg, jpeg, webp\")";
        return document.getElementById("alert").scrollIntoView({
            behavior: "smooth"
        });
    }else{
        let getFileName = document.getElementById("adImage").files[0].name;
        if(getFileName.match(/.+(png|webp|jpeg|jpg|gif)/) === null){
            e.preventDefault();
            document.getElementById("alert").style.display = "block";
            document.getElementById("alertMsg").innerText = "Please specify a valid cover image. (Allowed extensions: \"png, jpg, jpeg, webp\")";
            return document.getElementById("alert").scrollIntoView({
                behavior: "smooth"
            });
        }
    }
});
function readURL(input){
    if((input.files) && (input.files[0])){
        if(input.files[0].name.match(/.+(png|webp|jpeg|jpg|gif)/) === null){
            document.getElementById("alert").style.display = "block";
            document.getElementById("alertMsg").innerText = "Please specify a valid cover image. (Allowed extensions: \"png, jpg, jpeg, webp\")";
            return document.getElementById("alert").scrollIntoView({
                behavior: "smooth"
            });
        }
        let reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        document.getElementById("fileButton").innerHTML = '<i class="fa-solid fa-check"></i> File selected';
    }
}