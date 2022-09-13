function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}
function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
function rgbToHex(R,G,B) {return toHex(R)+toHex(G)+toHex(B)}
function toHex(n) {
    n = parseInt(n,10);
    if (isNaN(n)) return "00";
    n = Math.max(0,Math.min(n,255));
    return "0123456789ABCDEF".charAt((n-n%16)/16)
        + "0123456789ABCDEF".charAt(n%16);
}
input_effect=""
input_color1=""
input_color2=""
input_color3=""
input_color4=""
input_color5=""
input_color6=""
input_color7=""
input_color8=""
input_text=""
input_font=""
input_size=""
input_bold=0
input_italic=0
input_colorword=0
random_length=0;
update=0
var random_char=new Array();
function randomize_colors() {
    var length=document.getElementById("input_text").value.length;
    var a;
    for (a=0; a<length; a+=1) {
        random_char[a]=rgbToHex(Math.floor(Math.random()*256),Math.floor(Math.random()*256),Math.floor(Math.random()*256))
    }
    random_length=length;
    update=1
}
function textcolorizer_handle() {

    if (input_effect!=document.getElementById("input_effect").value) {
        document.getElementById("color_select1").style.visibility="hidden";
        document.getElementById("color_select2").style.visibility="hidden";
        document.getElementById("color_select3").style.visibility="hidden";
        document.getElementById("color_select4").style.visibility="hidden";
        document.getElementById("color_select5").style.visibility="hidden";
        document.getElementById("color_select6").style.visibility="hidden";
        document.getElementById("color_select1").style.display="none";
        document.getElementById("color_select2").style.display="none";
        document.getElementById("color_select3").style.display="none";
        document.getElementById("color_select4").style.display="none";
        document.getElementById("color_select5").style.display="none";
        document.getElementById("color_select6").style.display="none";
        document.getElementById("color_select"+document.getElementById("input_effect").value).style.visibility="visible";
        document.getElementById("color_select"+document.getElementById("input_effect").value).style.display="block";
        update=1;
    }
    input_effect=document.getElementById("input_effect").value;

    if (input_color1!=document.getElementById("input_color1").value) {update=1;}
    input_color1=document.getElementById("input_color1").value;

    if (input_color2!=document.getElementById("input_color2").value) {update=1;}
    input_color2=document.getElementById("input_color2").value;

    if (input_color3!=document.getElementById("input_color3").value) {update=1;}
    input_color3=document.getElementById("input_color3").value;

    if (input_color4!=document.getElementById("input_color4").value) {update=1;}
    input_color4=document.getElementById("input_color4").value;

    if (input_color5!=document.getElementById("input_color5").value) {update=1;}
    input_color5=document.getElementById("input_color5").value;

    if (input_color6!=document.getElementById("input_color6").value) {update=1;}
    input_color6=document.getElementById("input_color6").value;

    if (input_color7!=document.getElementById("input_color7").value) {update=1;}
    input_color7=document.getElementById("input_color7").value;

    if (input_color8!=document.getElementById("input_color8").value) {update=1;}
    input_color8=document.getElementById("input_color8").value;

    if (input_text!=document.getElementById("input_text").value) {update=1;}
    input_text=document.getElementById("input_text").value;

    if (input_font!=document.getElementById("input_font").value) {update=1;}
    input_font=document.getElementById("input_font").value;

    if (input_size!=document.getElementById("input_size").value) {update=1;}
    input_size=document.getElementById("input_size").value;

    if (input_bold!=document.getElementById("input_bold").checked) {update=1;}
    input_bold=document.getElementById("input_bold").checked;

    if (input_italic!=document.getElementById("input_italic").checked) {update=1;}
    input_italic=document.getElementById("input_italic").checked;

    if (input_colorword!=document.getElementById("input_colorword").checked) {update=1;}
    input_colorword=document.getElementById("input_colorword").checked;

    if (update==1) {
        update=0;
        str_html="";
        str_bbcode="";
        var str_bbcodeend="";
        str_style="";
        if (input_bold==1) {str_style+="font-weight:bold;"; str_bbcode+="[b]"; str_bbcodeend="[/b]"+str_bbcodeend;}
        if (input_italic==1) {str_style+="font-style:italic;"; str_bbcode+="[i]"; str_bbcodeend="[/i]"+str_bbcodeend;}
        if (input_font!="") {str_style+='font-family:"'+input_font+'";'; str_bbcode+='[font="'+input_font+'"]'; str_bbcodeend="[/font]"+str_bbcodeend;}
        if (input_size!="0") {
            var str_size;
            str_size=""
            if (input_size=="1") str_size="10px"
            if (input_size=="2") str_size="12px"
            if (input_size=="3") str_size="15px"
            if (input_size=="4") str_size="17px"
            if (input_size=="5") str_size="22px"
            if (input_size=="6") str_size="27px"
            if (input_size=="7") str_size="35px"
            str_style+='font-size:'+str_size+';';
            str_bbcode+='[size="'+input_size+'"]';
            str_bbcodeend="[/size]"+str_bbcodeend;
        }
        if (str_style!="") str_html+="<span style='"+str_style+"'>";
        var a,r,g,b,rinc,ginc,binc,ccol;
        if (input_effect=="1") {
            r=hexToR(input_color1)
            g=hexToG(input_color1)
            b=hexToB(input_color1)
            rinc=(hexToR(input_color2)-r)/input_text.length
            ginc=(hexToG(input_color2)-g)/input_text.length
            binc=(hexToB(input_color2)-b)/input_text.length
            for (a=0; a<input_text.length; a++) {
                ccol=rgbToHex(r,g,b);
                if (input_text.charAt(a)==" ") {
                    str_html+=" ";
                    str_bbcode+=" ";
                } else {
                    str_html+="<span style='color:#"+ccol+";'>"+input_text.charAt(a)+"</span>";
                    str_bbcode+='[color=#'+ccol+']'+input_text.charAt(a)+"[/color]";
                }
                r+=rinc;
                g+=ginc;
                b+=binc;
            }
        } else if (input_effect=="2") {
            r=hexToR(input_color3)
            g=hexToG(input_color3)
            b=hexToB(input_color3)
            rinc=(hexToR(input_color4)-r)/Math.floor(input_text.length/2)
            ginc=(hexToG(input_color4)-g)/Math.floor(input_text.length/2)
            binc=(hexToB(input_color4)-b)/Math.floor(input_text.length/2)
            for (a=0; a<input_text.length; a++) {
                ccol=rgbToHex(r,g,b);
                if (input_text.charAt(a)==" ") {
                    str_html+=" ";
                    str_bbcode+=" ";
                } else {
                    str_html+="<span style='color:#"+ccol+";'>"+input_text.charAt(a)+"</span>";
                    str_bbcode+='[color=#'+ccol+']'+input_text.charAt(a)+"[/color]";
                }
                if (a<Math.floor(input_text.length/2)) {
                    r+=rinc;
                    g+=ginc;
                    b+=binc;
                } else {
                    r-=rinc;
                    g-=ginc;
                    b-=binc;
                }
            }
        } else if (input_effect=="3") {
            r=hexToR(input_color5)
            g=hexToG(input_color5)
            b=hexToB(input_color5)
            rinc=(hexToR(input_color6)-r)/Math.floor(input_text.length/2)
            ginc=(hexToG(input_color6)-g)/Math.floor(input_text.length/2)
            binc=(hexToB(input_color6)-b)/Math.floor(input_text.length/2)
            var r2,g2,b2,rinc2,ginc2,binc2;
            r2=hexToR(input_color6)
            g2=hexToG(input_color6)
            b2=hexToB(input_color6)
            rinc2=(hexToR(input_color7)-r2)/Math.floor(input_text.length/2)
            ginc2=(hexToG(input_color7)-g2)/Math.floor(input_text.length/2)
            binc2=(hexToB(input_color7)-b2)/Math.floor(input_text.length/2)
            for (a=0; a<input_text.length; a++) {
                ccol=rgbToHex(r,g,b);
                if (input_text.charAt(a)==" ") {
                    str_html+=" ";
                    str_bbcode+=" ";
                } else {
                    str_html+="<span style='color:#"+ccol+";'>"+input_text.charAt(a)+"</span>";
                    str_bbcode+='[color=#'+ccol+']'+input_text.charAt(a)+"[/color]";
                }
                if (a<Math.floor(input_text.length/2)) {
                    r+=rinc;
                    g+=ginc;
                    b+=binc;
                } else {
                    r+=rinc2;
                    g+=ginc2;
                    b+=binc2;
                }
            }
        } else if (input_effect=="4") {
            str_html+="<span style='color:"+input_color8+";'>"+input_text+"</span>"
            str_bbcode+='[color='+input_color8+']'+input_text+"[/color]";
        } else if (input_effect=="5") {
            var i=0;
            for (a=0; a<input_text.length; a++) {
                ccol=random_char[i];
                if (input_colorword==0) i++;
                if (input_colorword==1 && input_text.charAt(a)==" ") i++;
                if (a>=random_length) {
                    str_html+=input_text.charAt(a)
                    str_bbcode+=input_text.charAt(a)
                } else {
                    if (input_colorword==0) {
                        if (input_text.charAt(a)==" ") {
                            str_html+=" ";
                            str_bbcode+=" ";
                        } else {
                            str_html+="<span style='color:#"+ccol+";'>"+input_text.charAt(a)+"</span>";
                            str_bbcode+='[color=#'+ccol+']'+input_text.charAt(a)+"[/color]";
                        }
                    } else {
                        if (a==0 || input_text.charAt(a-1)==" ") {
                            str_html+="<span style='color:#"+ccol+";'>"+input_text.charAt(a);
                            str_bbcode+='[color=#'+ccol+']'+input_text.charAt(a);
                        } else if (a==input_text.length-1 || input_text.charAt(a)==" ") {
                            str_html+=input_text.charAt(a)+"</span>";
                            str_bbcode+=input_text.charAt(a)+'[/color]';
                        } else {
                            str_html+=input_text.charAt(a);
                            str_bbcode+=input_text.charAt(a);
                        }
                    }
                }
            }
        } else if (input_effect=="6") {
            var i,s,p;
            for (a=0; a<input_text.length; a++) {
                i=a/input_text.length;
                s=1/6
                p=(i%s)/s
                if (i>=s*0) ccol=rgbToHex(255,255*p,0);
                if (i>=s*1) ccol=rgbToHex(255*(1-p),255,0);
                if (i>=s*2) ccol=rgbToHex(0,255,255*p);
                if (i>=s*3) ccol=rgbToHex(0,255*(1-p),255);
                if (i>=s*4) ccol=rgbToHex(255*p,0,255);
                if (i>=s*5) ccol=rgbToHex(255,0,255*(1-p));
                if (input_text.charAt(a)==" ") {
                    str_html+=" ";
                    str_bbcode+=" ";
                } else {
                    str_html+="<span style='color:#"+ccol+";'>"+input_text.charAt(a)+"</span>";
                    str_bbcode+='[color=#'+ccol+']'+input_text.charAt(a)+"[/color]";
                }
            }
        }
        if (str_style!="") {str_html+="</span>"}
        document.getElementById("div_preview").innerHTML="<span style='font-size:12px'>"+str_html+"</span>";
        document.getElementById("output_bbcode").value=str_bbcode+str_bbcodeend;
        document.getElementById("output_html").value=str_html;
    }
    setTimeout(textcolorizer_handle,50)
}
function copyBB(){
    let button = document.getElementById("copyBBButton");
    let copyText = document.getElementById("output_bbcode");
    if(copyText.value.length > 0){
        copyText.select();
        document.execCommand("Copy");
        button.disabled = true;
        button.innerText = "Copied";
        setTimeout(function(){
            button.disabled = false;
            button.innerText = "Copy";
        }, 1500);
    }
}
function copyHTML(){
    let button = document.getElementById("copyHTMLButton");
    let copyText = document.getElementById("output_html");
    if(copyText.value.length > 0){
        copyText.select();
        document.execCommand("Copy");
        button.disabled = true;
        button.innerText = "Copied";
        setTimeout(function(){
            button.disabled = false;
            button.innerText = "Copy";
        }, 1500);
    }
}