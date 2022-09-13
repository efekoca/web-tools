<?php
$addStat = $connect->prepare("UPDATE stats SET proxy = proxy + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Proxy Extractor</title>
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
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-columns-gap" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6 1v3H1V1h5zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12v3h-5v-3h5zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8v7H1V8h5zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6v7h-5V1h5zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Proxy Extractor</h5>
                        <p class="text-muted card-text">Automatically separate proxy values from the entered content in the form of proxy:port without losing time.</p>
                        <?php if(!empty($_POST["text"])){
                            $patternForIP = "/(?<ip>\d{1,3}([.])\d{1,3}([.])\d{1,3}([.])\d{1,3}((:)|(\s) +)\d{1,8})/m";
                            $resultForIP = "";
                            if(preg_match_all($patternForIP, filter($_POST["text"]), $matchesForIp)){
                                foreach(@$matchesForIp["ip"] as $ip){
                                    $resultForIP .= $ip . "\n";
                                }
                            } ?>
                                <form method="post">
                                    <label for="text" style="display: none;"></label>
                                    <textarea type="text" class="form-control" id="text" name="text" placeholder="Please specify a content."><?php echo($resultForIP); ?></textarea>
                                    <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Extract</button>
                                </form>
                        <?php }else{ ?>
                            <form method="post">
                                <label for="text" style="display: none;"></label>
                                <textarea type="text" class="form-control" id="text" name="text" placeholder="Please specify a content."></textarea>
                                <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Extract</button>
                            </form>
                        <?php } ?>
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