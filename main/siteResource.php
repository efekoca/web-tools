<?php
$addStat = $connect->prepare("UPDATE stats SET siteResource = siteResource + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Website Resource Code</title>
        <?php require("pages/header.php"); ?>
        <link rel="stylesheet" href="plugin/codemirror/lib/codemirror.css">
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-file-earmark-code" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"></path>
                                    <path d="M8.646 6.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 9 8.646 7.354a.5.5 0 0 1 0-.708zm-1.292 0a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .708l2 2a.5.5 0 0 0 .708-.708L5.707 9l1.647-1.646a.5.5 0 0 0 0-.708z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Website Resource Code</h5>
                            <p class="text-muted card-text">Quickly find and view the source code (HTML, CSS and JS) of the specified URL by one click.</p>
                            <?php if(!empty($_POST["url"])){
                                $urlPattern = "/^(http(s)?\:\/\/.)?(www\.)?[a-zA-Z0-9\-\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)+$/";
                                $filteredURL = filter($_POST["url"]);
                                if(!preg_match($urlPattern, $filteredURL)){ ?>
                                    <div class="alert alert-danger" role="alert">
                                        Please specify a valid URL.
                                    </div>
                                <?php }else{ ?>
                                    <?php $ch = curl_init();
                                    curl_setopt_array($ch, array(
                                    CURLOPT_URL => filter($_POST["url"]),
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 9; SM-G950F Build/PPR1.180610.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36",
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_REFERER => "https://google.com"
                                    ));
                                    $resultForSource = curl_exec($ch);
                                    $err = curl_error($ch);
                                    curl_close($ch);

                                    if(!$err){ ?>
                                        <div class="mb-5">
                                            <label for="code"></label>
                                            <textarea id="code"><?php echo($resultForSource); ?></textarea>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="alert alert-danger" role="alert">
                                            An unexpected error occurred while retrieving the source code for the specified site; please try again later.
                                        </div>
                                    <?php }
                                    }
                            } ?>
                            <form method="post">
                                <label for="url" style="display: none;"></label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Please specify an URL." required>
                                <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Find</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require("pages/footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/all.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assets/js/bold-and-bright.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="plugin/codemirror/lib/codemirror.js"></script>
    <script src="plugin/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="plugin/codemirror/mode/xml/xml.js"></script>
    <script src="plugin/codemirror/mode/javascript/javascript.js"></script>
    <script src="plugin/codemirror/mode/css/css.js"></script>
    <script id="rendered-js">
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            styleActiveLine: true,
            lineNumbers: true,
            matchBrackets: true,
            autoCloseBrackets: true,
            autoCloseTags: true,
            lineWrapping: true,
            mode: "htmlmixed",
            htmlMode: true,
        });
    </script>
    </body>
    </html>
<?php $connect = null; ?>