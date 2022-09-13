<?php
$ip = getIP();
$IpDetails = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"), TRUE);
$getLocation = @explode(",", $IpDetails["loc"]);
$addStat = $connect->prepare("UPDATE stats SET ip = ip + 1 LIMIT 1");
$addStat->execute(); ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Detailed IP Information</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-hdd-network" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.5 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zM3 4.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8.5v3a1.5 1.5 0 0 1 1.5 1.5h5.5a.5.5 0 0 1 0 1H10A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5H.5a.5.5 0 0 1 0-1H6A1.5 1.5 0 0 1 7.5 10V7H2a2 2 0 0 1-2-2V4zm1 0v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm6 7.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Detailed IP Information</h5>
                            <p class="text-muted card-text">Access detailed information about your IP address (provider, location, etc.) with a single click.</p>
                            <div class="container mb-0">
                                <div class="py-5 p-lg-5">
                                    <div class="row row-cols-1 row-cols-md-2 mx-auto d-flex justify-content-center" style="max-width: 900px;">
                                        <div class="col-11 mb-4">
                                            <div class="card shadow-sm border-3">
                                                <div class="card-body px-4 py-5 px-md-5">
                                                    <p class="text-muted card-text">
                                                        <span style="font-weight: bold;">IP address:</span> <?php echo(@$IpDetails["ip"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Provider:</span> <?php echo(@$IpDetails["org"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Country:</span> <?php echo(@$IpDetails["country"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">City:</span> <?php echo(@$IpDetails["city"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Area:</span> <?php echo(@$IpDetails["region"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Postal code:</span> <?php echo(@$IpDetails["postal"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Latitude:</span> <?php echo(@$getLocation[0] ?? "0"); ?>°<br>
                                                        <span style="font-weight: bold;">Longitude:</span> <?php echo(@$getLocation[1] ?? "0"); ?>°
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="./" style="text-decoration: none;"><button type="button" class="btn btn-info" style="border-radius: 0; margin-top: 10px;">Go Back</button></a>
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