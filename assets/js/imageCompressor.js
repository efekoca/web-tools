document.getElementById("image").onchange = function(){
    if(this.files.length === 0){
        document.getElementById("alert").style.display = "block";
        return document.getElementById("alert").scrollIntoView({
            behavior: "smooth"
        });
    }else{
        let getFileName = this.files[0].name;
        if(getFileName.match(/.+(png|webp|jpeg|jpg)/) === null){
            document.getElementById("alert").style.display = "block";
            return document.getElementById("alert").scrollIntoView({
                behavior: "smooth"
            });
        }else{
            document.getElementById("fileButton").innerHTML = 'File selected';
        }
    }
}