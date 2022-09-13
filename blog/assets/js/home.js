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