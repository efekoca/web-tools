<?php
$addStat = $connect->prepare("UPDATE stats SET indexCalculator = indexCalculator + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Index Calculator</title>
    <?php require("pages/header.php"); ?>
    <link rel="stylesheet" href="assets/css/indexCalculator.css">
    <script src="assets/js/indexCalculator.js" type="text/javascript"></script>
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
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-ui-checks" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Index Calculator</h5>
                        <p class="text-muted card-text">Get quick result for your body index with a single click specifying height and weight.</p>
                        <div id="indexForm" class="container col-lg-8 col-xs-12 col-centered">
                            <div class="text-center">
                                <div class="mb-3">
                                    <img src="assets/img/fitness.png" alt="" />
                                </div>
                                <div>
                                    <h2>Body Index Calculator</h2>
                                </div>
                                <form name="bodyCalculator">
                                    <div>
                                        <label class="col1" for="weight">Weight (Specify for kg)</label>
                                        <input class="col2" type="text" name="weight" id="weight" value="Specify your weight." onfocus="fcs(this);" onblur="fcs(this)" required>
                                    </div>
                                    <div>
                                        <label class="col1" for="height">Height (Specify for cm)</label>
                                        <input class="col2" type="text" name="height" id="height" value="Specify your height." onfocus="fcs(this);" onblur="fcs(this)" required>
                                    </div>
                                    <div>
                                        <input type="button" value="Hesapla" onClick="calculateIndex()">
                                    </div>
                                    <div>
                                        <label class="col1" for="bodyIndexData">Your body index:</label>
                                        <input class="col2 fw-bold" type="text" name="bodyIndexData" id="bodyIndexData">
                                    </div>
                                    <div>
                                        <label class="col1" for="calculatedResult">Result:</label>
                                        <input class="col2 fw-bold" type="text" name="calculatedResult" id="calculatedResult">
                                    </div>
                                    <div>
                                        <input type="reset" value="Sıfırla" />
                                    </div>
                                </form>
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
<script src="assets/js/all.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
<?php $connect = null; ?>