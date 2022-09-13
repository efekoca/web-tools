<?php
$addStat = $connect->prepare("UPDATE stats SET colorText = colorText + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Colored Text Generator</title>
    <?php require("pages/header.php"); ?>
</head>
<body class="bg-primary-gradient">
<?php require("pages/navbar.php"); ?>
<a id="topButton" href="#">
    <svg class="bi bi-chevron-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="white" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"></path>
    </svg>
</a>
<section class="pt-5 mt-5">
    <div class="container mb-0">
        <div class="pt-5 p-lg-5 d-flex justify-content-center align-items-center">
            <div class="col-11">
                <div class="card shadow-sm">
                    <div class="card-body px-4 py-5 px-md-5">
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-paint-bucket">
                                <path d="M6.192 2.78c-.458-.677-.927-1.248-1.35-1.643a2.972 2.972 0 0 0-.71-.515c-.217-.104-.56-.205-.882-.02-.367.213-.427.63-.43.896-.003.304.064.664.173 1.044.196.687.556 1.528 1.035 2.402L.752 8.22c-.277.277-.269.656-.218.918.055.283.187.593.36.903.348.627.92 1.361 1.626 2.068.707.707 1.441 1.278 2.068 1.626.31.173.62.305.903.36.262.05.64.059.918-.218l5.615-5.615c.118.257.092.512.05.939-.03.292-.068.665-.073 1.176v.123h.003a1 1 0 0 0 1.993 0H14v-.057a1.01 1.01 0 0 0-.004-.117c-.055-1.25-.7-2.738-1.86-3.494a4.322 4.322 0 0 0-.211-.434c-.349-.626-.92-1.36-1.627-2.067-.707-.707-1.441-1.279-2.068-1.627-.31-.172-.62-.304-.903-.36-.262-.05-.64-.058-.918.219l-.217.216zM4.16 1.867c.381.356.844.922 1.311 1.632l-.704.705c-.382-.727-.66-1.402-.813-1.938a3.283 3.283 0 0 1-.131-.673c.091.061.204.15.337.274zm.394 3.965c.54.852 1.107 1.567 1.607 2.033a.5.5 0 1 0 .682-.732c-.453-.422-1.017-1.136-1.564-2.027l1.088-1.088c.054.12.115.243.183.365.349.627.92 1.361 1.627 2.068.706.707 1.44 1.278 2.068 1.626.122.068.244.13.365.183l-4.861 4.862a.571.571 0 0 1-.068-.01c-.137-.027-.342-.104-.608-.252-.524-.292-1.186-.8-1.846-1.46-.66-.66-1.168-1.32-1.46-1.846-.147-.265-.225-.47-.251-.607a.573.573 0 0 1-.01-.068l3.048-3.047zm2.87-1.935a2.44 2.44 0 0 1-.241-.561c.135.033.324.11.562.241.524.292 1.186.8 1.846 1.46.45.45.83.901 1.118 1.31a3.497 3.497 0 0 0-1.066.091 11.27 11.27 0 0 1-.76-.694c-.66-.66-1.167-1.322-1.458-1.847z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Colored Text Generator</h5>
                        <p class="text-muted card-text">Quickly and automatically get your colored text code with text effects in HTML - CSS or BBCode format.</p>
                        <div class="container d-flex flex-column">
                            <div class="mb-4">
                                <span style="font-weight:bold;">I.</span> Text:<br>
                                <label for="input_text"></label>
                                <textarea class="form-control" id="input_text" style="height:180px; word-break: break-word; line-break: anywhere;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</textarea>
                            </div>
                            <div class="mb-4">
                                <span style="font-weight:bold;">II:</span> Text effect:<br/>
                                <label for="input_effect"></label>
                                <select class="form-control" id="input_effect">
                                    <option value="1">Horizontal Degrade</option>
                                    <option value="2">Middle Degrade</option>
                                    <option value="3">Triple Degrade</option>
                                    <option value="4">Plain Color</option>
                                    <option value="5">Random Color</option>
                                    <option value="6">Rainbow Colors</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <span style="font-weight:bold;">III:</span> Color settings:<br/><br/>
                                <div id="color_select1" style=" visibility:visible">
                                    Start color: <label for="input_color1"></label>
                                    <input id="input_color1" class='form-control color {hash:true,caps:true}' value='#FF0000'>
                                    <br/>End color:
                                    <label for="input_color2"></label><input id="input_color2" class='form-control color {hash:true,caps:true}' value='#0000FF'></div>
                                    <div id="color_select2" style=" visibility:hidden; display: none;">Start &amp; End color: <label
                                        for="input_color3"></label><input id="input_color3" class='form-control color {hash:true,caps:true}' value='#FF0000'><br/>Middle color:
                                    <label for="input_color4"></label><input id="input_color4" class='form-control color {hash:true,caps:true}' value='#0000FF'></div>
                                <div id="color_select3" style="visibility:hidden; display: none;">Start color: <label
                                        for="input_color5"></label><input id="input_color5" class='form-control color {hash:true,caps:true}' value='#FF0000'><br/>Middle color:
                                    <label for="input_color6"></label><input id="input_color6" class='form-control color {hash:true,caps:true}' value='#0000FF'><br/>End color:
                                    <label for="input_color7"></label><input id="input_color7" class='form-control color {hash:true,caps:true}' value='#00FF00'></div>
                                <div id="color_select4" style="visibility:hidden; display: none;">Color: <label
                                        for="input_color8"></label><input id="input_color8" class='form-control color {hash:true,caps:true}' value='#FF0000'></div>
                                <div id="color_select5" style="visibility:hidden; display: none;"><input class="form-control" type="button" value="Rastgele renk oluştur!" onClick="randomize_colors()"><label
                                        for="input_colorword"></label><input class="form-control" type="checkbox" id="input_colorword" style="display: none;"/></div>
                                <div id="color_select6" style="visibility:hidden; display: none;">There is no settings for rainbow colors.</div>
                            </div>
                            <div class="mb-4">
                                <span style="font-weight:bold;">IV:</span> Font:<br/>
                                <label for="input_font"></label>
                                <select class="form-control" id="input_font">
                                    <option value="">Default</option>
                                    <option value="Arial">Arial</option>
                                    <option value="Arial Black">Arial Black</option>
                                    <option value="Arial Narrow">Arial Narrow</option>
                                    <option value="Book Antiqua">Book Antiqua</option>
                                    <option value="Century Gothic">Century Gothic</option>
                                    <option value="Comic Sans MS">Comic Sans MS</option>
                                    <option value="Courier New">Courier New</option>
                                    <option value="Franklin Gothic Medium">Franklin Gothic Medium</option>
                                    <option value="Garamond">Garamond</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Impact">Impact</option>
                                    <option value="Lucida Console">Lucida Console</option>
                                    <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                    <option value="Microsoft Sans Serif">Microsoft Sans Serif</option>
                                    <option value="Palatino Linotype">Palatino Linotype</option>
                                    <option value="Tahoma">Tahoma</option>
                                    <option value="Times New Roman">Times New Roman</option>
                                    <option value="Trebuchet MS">Trebuchet MS</option>
                                    <option value="Verdana">Verdana</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <span style="font-weight:bold;">V:</span> Size:<br/>
                                <label for="input_size"></label><select class="form-control" id="input_size">
                                    <option value="0">Default</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                Bold: <label for="input_bold"></label><input type="checkbox" id="input_bold"/><br/>
                            </div>
                            <div class="mb-4">
                                Italic: <label for="input_italic"></label><input type="checkbox" id="input_italic"/>
                            </div>
                            <div class="mb-4">
                                <span style="font-weight:bold;">5:</span> Preview:<br/><br/>
                                <div id="div_preview"></div><br/><br/>
                                BBCode (for vBulletin):<br/>
                                <label for="output_bbcode"></label><textarea class="form-control" id="output_bbcode" rows="5" cols="80" readonly></textarea><br/>
                                <button class="btn btn-info" id="copyBBButton" onclick="copyBB()" style="border-radius: 2px;">Copy</button>
                                <br/><br/>
                                HTML (for websites):<br/>
                                <label for="output_html"></label><textarea class="form-control" id="output_html" rows="5" cols="80" readonly></textarea><br/>
                                <button class="btn btn-info" id="copyHTMLButton" onclick="copyHTML()" style="border-radius: 2px;">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require("pages/footer.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="assets/js/textColorizer.js"></script>
<script type="text/javascript">textcolorizer_handle();</script>
<script src="assets/js/all.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
<?php $connect = null; ?>