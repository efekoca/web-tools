<?php
    $getFile = @simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml", "SimpleXMLElement", LIBXML_NOCDATA);
    $i = 1;
    $addStat = $connect->prepare("UPDATE stats SET currency = currency + 1 LIMIT 1");
    $addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Currency</title>
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
            <div class="pt-5 p-lg-5">
                <div class="row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px; display: flex; justify-content: center;">
                    <?php if($getFile){
                        foreach($getFile->Currency as $element){ ?>
                            <div class="col mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body px-4 py-5 px-md-5" id="<?php echo($i); ?>">
                                        <h5 class="fw-bold card-title">
                                            <?php echo("<b style='font-weight: bold;'>#{$i}</b> " . $element->attributes()["CurrencyCode"] . " - " . getFormattedStr($element->CurrencyName)); ?>
                                        </h5>
                                        <p class="text-muted card-text mb-4">
                                            Buying: <?php echo($element->ForexBuying); ?> TL<br />
                                            <?php if($element->attributes()["CurrencyCode"] != "XDR"){?>
                                                Selling: <?php echo($element->ForexSelling); ?> TL <br />
                                            <?php } ?>
                                            <?php if($element->CrossRateOther != ""){?>
                                                Cross Rate: <?php echo($element->CrossRateOther); ?>
                                            <?php } ?>
                                        </p>
                                        <div class="card-footer mb-4">
                                            <?php echo("Last updated date: " . $getFile->attributes()["Tarih"]); ?>
                                        </div>
                                        <button id="<?php echo($i . 'Button'); ?>" onclick="highlightCard(<?php echo($i); ?>)" class="btn btn-dark shadow" style="border-radius: 3px;">Highlight</button>
                                    </div>
                                </div>
                            </div>
                        <?php $i++;
                        }
                    }else{ ?>
                        <div class="alert alert-danger" role="alert">
                            An unexpected error occurred while getting currency data. Please try again later.
                        </div>
                    <?php } ?>
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
    <script src="assets/js/currency.js"></script>
    </body>
</html>
<?php $connect = null; ?>