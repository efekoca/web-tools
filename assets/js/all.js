$(document).ready(function(){
    let topButton = $("#topButton");
    $(window).scroll(function(){
        if($(window).scrollTop() > 300){
            topButton.addClass("show");
        }else{
            topButton.removeClass("show");
        }
    });
    topButton.on("click", function(e){
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, "300");
    });
});