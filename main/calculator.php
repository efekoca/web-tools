<?php
$addStat = $connect->prepare("UPDATE stats SET calculator = calculator + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Calculator</title>
    <?php require("pages/header.php"); ?>
    <link rel="stylesheet" href="assets/css/calculator.css">
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
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-calculator" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"></path>
                                <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Calculator</h5>
                        <p class="text-muted card-text">Calculate your math stuffs with modern and easy to use theme designed calculator.</p>
                        <div id="calculator" class="container">
                            <div id="screen">
                                <label for="result"></label>
                                <input type="text" class="w-100" id="result" readonly="readonly"/>
                            </div>
                            <div id="buttons" class="p-3">
                                <div class="row">
                                    <button class="col">7</button>
                                    <button class="col">8</button>
                                    <button class="col">9</button>
                                    <button class="col">+</button>
                                </div>
                                <div class="row">
                                    <button class="col">4</button>
                                    <button class="col">5</button>
                                    <button class="col">6</button>
                                    <button class="col">-</button>
                                </div>
                                <div class="row">
                                    <button class="col">1</button>
                                    <button class="col">2</button>
                                    <button class="col">3</button>
                                    <button class="col">/</button>
                                </div>
                                <div class="row">
                                    <button class="col">0</button>
                                    <button class="col">.</button>
                                    <button class="col">=</button>
                                    <button class="col">*</button>
                                </div>
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
<script src="assets/js/calculator.js"></script>
</body>
</html>
<?php $connect = null; ?>