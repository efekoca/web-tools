<?php
$addStat = $connect->prepare("UPDATE stats SET meta = meta + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Meta Tag Generator</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-tags">
                                    <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"></path>
                                    <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Meta Tag Generator</h5>
                            <p class="text-muted card-text">Automatically generate meta tag codes that allow search engines to correctly classify your site.</p>
                            <?php if((!empty($_POST["url"])) and (!empty($_POST["title"])) and (!empty($_POST["description"])) and (!empty($_POST["keywords"])) and (!empty($_POST["favicon"]))){ ?>
                                <pre class="container alert-dark alert" style="overflow: hidden; white-space: normal; padding: 25px;" role="alert">
                                    <b style="display: block; margin-bottom: 5px;">Result:</b>
                                    <code style="white-space: normal; word-break: break-all;" id="code">
                                        &lt;meta charset="utf-8"&gt; &lt;!-- Charset --&gt;<br>
                                        &lt;meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"&gt; &lt;!-- Mobile compability --&gt;<br>
                                        &lt;link rel="icon" href="<?php echo(filter($_POST["favicon"])); ?>"&gt; &lt;!-- Favicon --&gt;<br>
                                        &lt;meta property="og:url" content="<?php echo(filter($_POST["url"])); ?>"&gt; &lt;!-- Site address --&gt;<br>
                                        &lt;meta name="keywords" content="<?php echo(filter($_POST["keywords"])); ?>"&gt; &lt;!-- Keywords --&gt;<br>
                                        &lt;meta name="description" content="<?php echo(filter($_POST["description"])); ?>"&gt; &lt;!-- Site description --&gt;<br>
                                        &lt;meta property="og:description" content="<?php echo(filter($_POST["description"])); ?>"&gt; &lt;!-- OpenGraph site description --&gt;<br>
                                        &lt;meta property="og:type" content="website"&gt; &lt;!-- OpenGraph type --&gt;<br>
                                        &lt;meta property="og:site_name" content="<?php echo(filter($_POST["title"])); ?>"&gt; &lt;!-- OpenGraph site name --&gt;<br>
                                        &lt;meta property="og:title" content="<?php echo(filter($_POST["title"])); ?>"&gt; &lt;!-- OpenGraph site title --&gt;
                                    </code>
                                </pre>
                                <a onclick="copy()" style="text-decoration: none; cursor: pointer;" id="copyButton"><button class="btn btn-primary mb-3" style="border-radius: 2px;" id="copyButtonText">Copy</button></a>
                            <?php } ?>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="url" class="form-label">Site URL:</label>
                                    <input type="text" class="form-control" id="url" name="url" placeholder="https://<?php echo($siteLink); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Site title:</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Please specify a site title." required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Site description:</label>
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Please specify a site description." required>
                                </div>
                                <div class="mb-3">
                                    <label for="keywords" class="form-label">Site keywords (separate with commas):</label>
                                    <input type="text" class="form-control" id="keywords" name="keywords" placeholder="word1, word2, word3" required>
                                </div>
                                <div class="mb-3">
                                    <label for="favicon" class="form-label">Site favicon URL:</label>
                                    <input type="text" class="form-control" id="favicon" name="favicon" placeholder="Please specify a favicon." required>
                                </div>
                                <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Generate</button>
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
    <script src="assets/js/metaTag.js"></script>
    </body>
    </html>
<?php $connect = null; ?>