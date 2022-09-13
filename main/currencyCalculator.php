<?php
$getFile = @simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml", "SimpleXMLElement", LIBXML_NOCDATA);
$i = 1;
if($getFile){
    $xmlCurrency = json_encode($getFile);
    $arrayCurrency = json_decode($xmlCurrency, TRUE);
}
$addStat = $connect->prepare("UPDATE stats SET currencyCalculator = currencyCalculator + 1 LIMIT 1");
$addStat->execute();
?>

    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Currency Calculator</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-currency-exchange">
                                    <path d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Currency Calculator</h5>
                            <p class="text-muted card-text">Quickly convert from Turkish lira to the specified currency with one click and instant data.</p>
                            <?php if($getFile){
                                    if(!empty($_POST["currency"]) and (!empty($_POST["amount"]))){
                                        $currencyPost = filter($_POST["currency"]);
                                        $getCurrency = array_filter($arrayCurrency["Currency"], function($el){
                                            global $currencyPost;
                                            return $el["@attributes"]["Kod"] == $currencyPost;
                                        });
                                        $getValOfCurrency = count($getCurrency) > 0 ? reset($getCurrency)["ForexSelling"] : 0;
                                        $cleanAmount = filter($_POST["amount"]);
                                        $result = $cleanAmount * $getValOfCurrency; ?>
                                        <div class="alert alert-dark" role="alert">
                                            <?php echo("Result of the convert ({$cleanAmount} {$currencyPost}): <b>" . $result . " TL</b>"); ?>
                                        </div>
                                    <?php } ?>
                                    <form method="post">
                                        <select class="form-select" name="currency" aria-label="Currency">
                                            <option selected disabled>Select the currency to convert.</option>
                                            <?php foreach($arrayCurrency["Currency"] as $item){
                                                $currentName = getFormattedStr($item["CurrencyName"]);
                                                $currentCode = $item["@attributes"]["Kod"];
                                                if(strtolower($currentCode) != "xdr"){
                                                    echo("<option value='{$currentCode}'>{$currentName} ({$currentCode})</option>");
                                                }
                                            } ?>
                                        </select>
                                            <label for="amount"></label>
                                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Please specify amount to calculate." required>
                                            <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Calculate</button>
                                    </form>
                            <?php }else{ ?>
                                <div class="alert alert-danger" role="alert">
                                    An unexpected error occurred while getting currency data. Please try again later.
                                </div>
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