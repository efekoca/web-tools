document.getElementById("coverImage").onchange = function(){
    readURL(this);
}
document.getElementById("contentForm").addEventListener("submit", function(e){
    if(document.getElementById("coverImage").files.length === 0){
        e.preventDefault();
        document.getElementById("fileButton").innerHTML = '<i class="fa-solid fa-xmark"></i> Choose a file';
        document.getElementById("alert").style.display = "block";
        document.getElementById("alertMsg").innerText = "Please specify a valid cover image. (Allowed extensions: \"png, jpg, jpeg, webp\")";
        return document.getElementById("alert").scrollIntoView({
            behavior: "smooth"
        });
    }else{
        let getFileName = document.getElementById("coverImage").files[0].name;
        if(getFileName.match(/.+(png|webp|jpeg|jpg)/) === null){
            e.preventDefault();
            document.getElementById("alert").style.display = "block";
            document.getElementById("alertMsg").innerText = "Please specify a valid cover image. (Allowed extensions: \"png, jpg, jpeg, webp\")";
            return document.getElementById("alert").scrollIntoView({
                behavior: "smooth"
            });
        }
    }
});
$(document).ready(function(){
    CKEDITOR.instances.content.on("change", function(){
        let getData = this.getData();
        getData = stripHtml(getData.trim());
        document.getElementById("contentPreview").innerText = getData.substring(0, 200).trim() + "...";
        document.getElementById("estimatedReadingPreview").innerText = estimatedReadingTime(getData);
    });
});
document.getElementById("title").addEventListener("change", function(){
    document.getElementById("titlePreview").innerText = this.value;
});
function readURL(input){
    if((input.files) && (input.files[0])){
        if(input.files[0].name.match(/.+(png|webp|jpeg|jpg)/) === null){
            document.getElementById("alert").style.display = "block";
            document.getElementById("alertMsg").innerText = "Please specify a valid cover image. (Allowed extensions: \"png, jpg, jpeg, webp\")";
            return document.getElementById("alert").scrollIntoView({
                behavior: "smooth"
            });
        }
        let reader = new FileReader();
        reader.onload = function(e){
            document.getElementById("coverImagePreview").style.background = "url('" + e.target.result + "')";
            document.getElementById("coverImagePreview").style.backgroundSize = "cover";
        }
        reader.readAsDataURL(input.files[0]);
        document.getElementById("fileButton").innerHTML = '<i class="fa-solid fa-check"></i> File selected';
    }
}
function stripHtml(html){
    let tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}
function strWordCount(value){
    let words = value.replace(/([(\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, "");
    words = words.replace(/(^\s*)|(\s*$)/gi,"");
    words = words.replace(/[ ]{2,}/gi," ");
    words = words.replace(/\n /,"\n");
    words = words.replace(/[0-9]/gi,"");
    return words.split(" ").length;
}
function round(n, digits){
    let negative = false;
    if(n < 0){
        negative = true;
        n = n * -1;
    }
    let multiplicator = Math.pow(10, digits);
    n = parseFloat((n * multiplicator).toFixed(11));
    n = (Math.round(n) / multiplicator).toFixed(digits);
    if (negative) n = (n * -1).toFixed(digits);
    return n;
}
function estimatedReadingTime(content){
    let cleanedText = stripHtml(content.trim());
    cleanedText = strWordCount(cleanedText);
    cleanedText = cleanedText / 300;
    let ert =  round(cleanedText, 2);
    let explodedContent = String(ert).split(".");
    if(explodedContent.length < 1){
        return "1 minute reading time";
    }else if(explodedContent[1] > 59){
        return Math.ceil(ert) + " minutes reading time";
    }else if(explodedContent[1].substring(0, 1) == 0){
        return explodedContent[0] == 0 ? explodedContent[1].substring(1, 2) + " seconds reading time" : explodedContent[0] + " minutes " + explodedContent[1].substring(0, 2) + " seconds reading time";
    }else if(explodedContent[1].substring(0, 1) > 0){
        return explodedContent[0] == 0 ? explodedContent[1] + " seconds reading time" : explodedContent[0] + " minutes " + explodedContent[1] + " seconds reading time";
    }else{
        return explodedContent[0] == 0 ? explodedContent[1].substring(1, 2) + " seconds reading time" : explodedContent[0] + " minutes " + explodedContent[1].substring(1, 2) + " seconds reading time";
    }
}