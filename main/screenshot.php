<?php
$addStat = $connect->prepare("UPDATE stats SET screenshot = screenshot + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Website Screenshot</title>
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
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-camera" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"></path>
                                <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Website Screenshot</h5>
                        <p class="text-muted card-text">Take a screenshot of specified website and review it by one click.</p>
                        <?php if(!empty($_POST["url"])){
                            $urlPattern = "/^(http(s)?\:\/\/)(www\.)?[a-zA-Z0-9\-\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*(\/)?)$/u";
                            $siteURL = filter($_POST["url"]);
                            if(preg_match($urlPattern, $siteURL)){
                                $siteURL = substr($siteURL, -1) == "/" ? substr($siteURL, 0, strlen($siteURL) - 1) : $siteURL;
                                $googlePagespeedData = @file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$siteURL&screenshot=true&key=$googleApiKey");
                                $googlePagespeedData = json_decode($googlePagespeedData, true);
                                $screenshot = @$googlePagespeedData["lighthouseResult"]["audits"]["final-screenshot"]["details"]["data"] ?? "";
                                if($screenshot == ""){ ?>
                                    <div class="alert alert-danger" role="alert">
                                        An unexpected error occurred to getting screenshot of specified website.<br>
                                        Possible reasons: <br>
                                        - The site of the specified address may not be valid.<br>
                                        - The specified address may have disabled access to bots.
                                    </div>
                                <?php }else{ ?>
                                    <div class="alert alert-dark" role="alert">
                                        Screenshot of specified website: (<?php echo($siteURL); ?>)
                                    </div>
                                    <img src="<?php echo($screenshot); ?>" class="img-fluid d-flex justify-content-center" alt=""><br>
                                <?php }
                            }else{ ?>
                                <div class="alert alert-danger" role="alert">
                                    Please specify a true website. (An example: https://google.com)
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <form method="post">
                            <label for="url" style="display: none;"></label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Please specify a website.">
                            <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Get Screenshot</button>
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
</body>
</html>
<?php $connect = null; ?>
