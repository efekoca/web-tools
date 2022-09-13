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
(function(){
    "use strict";
    var sidebar = document.querySelector('.sidebar');
    var sidebarToggles = document.querySelectorAll('#sidebarToggle, #sidebarToggleTop');
    if(sidebar){
        var collapseEl = sidebar.querySelector('.collapse');
        var collapseElementList = [].slice.call(document.querySelectorAll('.sidebar .collapse'))
        var sidebarCollapseList = collapseElementList.map(function (collapseEl){
            return new bootstrap.Collapse(collapseEl, { toggle: false });
        });
        for(var toggle of sidebarToggles){
            toggle.addEventListener('click', function(e){
                document.body.classList.toggle('sidebar-toggled');
                sidebar.classList.toggle('toggled');

                if (sidebar.classList.contains('toggled')){
                    for (var bsCollapse of sidebarCollapseList){
                        bsCollapse.hide();
                    }
                };
            });
        }
        window.addEventListener('resize', function(){
            var vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
            if (vw < 768) {
                for(var bsCollapse of sidebarCollapseList){
                    bsCollapse.hide();
                }
            };
        });
    }
    var fixedNaigation = document.querySelector('body.fixed-nav .sidebar');
    if(fixedNaigation){
        fixedNaigation.on('mousewheel DOMMouseScroll wheel', function(e){
            var vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
            if(vw > 768){
                var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
                this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                e.preventDefault();
            }
        });
    }
    var scrollToTop = document.querySelector('.scroll-to-top');
    if(scrollToTop){
        window.addEventListener('scroll', function(){
            var scrollDistance = window.pageYOffset;
            if(scrollDistance > 100){
                scrollToTop.style.display = 'block';
            }else{
                scrollToTop.style.display = 'none';
            }
        });
    }
})();