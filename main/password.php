<?php
$addStat = $connect->prepare("UPDATE stats SET password = password + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Password Generator</title>
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
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-unlock">
                                <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Password Generator</h5>
                        <p class="text-muted card-text">Secure your accounts by easily and automatically generating mixed and secure passwords.</p>
                        <?php if(!empty($_POST["length"])){
                            $passLength = filter($_POST["length"]);
                            if(!is_numeric($passLength)){ ?>
                                <div class="alert alert-danger" role="alert">
                                    Please specify a true password length.
                                </div>
                            <?php }elseif(($passLength > 50) or ($passLength < 1)){ ?>
                                <div class="alert alert-danger" role="alert">
                                    Please specify a password length between one (1) and fifty (50).
                                </div>
                            <?php }else{
                                $lowerChars = str_shuffle("abcdefghijklmnopqrstuvwxyz");
                                $upperChars = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
                                $symbols = str_shuffle("!*_-+,.?");
                                $differentSymbols = str_shuffle("<>;:^()%&=#$@}{[]");
                                $numbers = str_shuffle("0123456789");
                                $formattedChars = $lowerChars . $upperChars;
                                if(!empty($_POST["symbols"])){
                                    $formattedChars .= $symbols;
                                }
                                if(!empty($_POST["numbers"])){
                                    $formattedChars .= $numbers;
                                }
                                if(!empty($_POST["complicatedSymbols"])){
                                    $formattedChars .= $differentSymbols;
                                }
                                $shuffledChars = str_shuffle($formattedChars);
                                $getPassword = randomPass($passLength, $shuffledChars); ?>
                                <div class="alert alert-dark" role="alert">
                                    Generated Password: <b id="password"><?php echo($getPassword); ?></b> <a onclick="copy()" id="copyButton" href="#">(Copy)</a>
                                </div>
                                <script src="assets/js/password.js"></script>
                            <?php  }
                         }else{ ?>
                            <div class="alert alert-info" role="alert">
                                By default, generates a random password only using uppercase and lowercase letters.
                            </div>
                        <?php } ?>
                        <form method="post">
                            <div class="mb-3">
                                <label for="length" class="form-label">Password length (between one (1) and fifty (50)):</label>
                                <input id="length" name="length" class="form-control" type="number" placeholder="Please specify a length.">
                            </div>
                            <div class="form-check-inline d-block mb-3">
                                <label for="numbers">Add numbers:</label>
                                <input id="numbers" name="numbers" class="form-check-input" type="checkbox">
                                <br/><small><i>0123456789</i></small>
                            </div>
                            <div class="form-check-inline mb-3 d-block">
                                <label for="symbols">Add symbols:</label>
                                <input id="symbols" name="symbols" class="form-check-input" type="checkbox">
                                <br/><small><i>!*_-+,.?</i></small>
                            </div>
                            <div class="form-check-inline mb-3 d-block">
                                <label for="complicatedSymbols">Add complicated symbols:</label>
                                <input id="complicatedSymbols" name="complicatedSymbols" class="form-check-input" type="checkbox">
                                <br/><small><i><>;:^()%&=#$@}{[]</i></small>
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
</body>
</html>
<?php $connect = null; ?>
