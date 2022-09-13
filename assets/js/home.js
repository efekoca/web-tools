function showCookieBanner(id){
    let banner = document.getElementById(id);
    if(banner == null) return null;
    if(localStorage.getItem("cookie") == null) banner.classList.add("cookie-popup--not-accepted");
}
function hideCookieBanner(id, e){
    let banner = document.getElementById(id);
    if(banner == null) return null;
    localStorage.setItem("cookie", "yes");
    if(banner.classList.contains("cookie-popup--not-accepted")){
        banner.classList.add("cookie-popup--accepted");
        setTimeout(function(){
            banner.classList.remove("cookie-popup--not-accepted");
        }, 1500)
    }
}
$(document).ready(function(){
    showCookieBanner("cookie");
});
function searchTool(){
    var input, filter, toolsDiv, tools, a, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.trim().toUpperCase();
    toolsDiv = document.getElementById("tools");
    tools = toolsDiv.getElementsByClassName("col");
    for (i = 0; i < tools.length; i++){
        a = tools[i].getElementsByTagName("h5")[0];
        txtValue = a.textContent || a.innerText;
        if(txtValue.toUpperCase().indexOf(filter) > -1){
            tools[i].style.display = "";
        }else{
            tools[i].style.display = "none";
        }
    }
}