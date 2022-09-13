<?php
$addStat = $connect->prepare("UPDATE stats SET draw = draw + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Draw Generator</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-card-list">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"></path>
                                    <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Draw Generator</h5>
                            <p class="text-muted card-text">Choose a winner easily, quickly and automatically with advanced options from the specified participants.</p>
                            <?php if((!empty($_POST["winnerCount"])) and (!empty($_POST["participant"]))){
                                    $participants = filter($_POST["participant"]);
                                    $participant = explode("\r\n", $participants);
                                    if(!empty($_POST["unique"])){
                                        $participant = array_unique($participant);
                                    }
                                    $winner = array();
                                    $participant = array_values(array_diff($participant, array("")));
                                    $participantCount = count($participant);
                                    $winnerCount = filter($_POST["winnerCount"]);
                                    $control = array();
                                    date_default_timezone_set("Europe/Istanbul");
                                    $date = date("Y-m-d H:i:s");
                                    $dateForFile = date("Y-m-d H-i-s");
                                    $result = "Number of people participating in the draw: " . $participantCount . "</br>Total draw count: " . $participantCount . "</br>Draw date: " . $date . "</br><hr>Winner(s): <br/>";
                                    if($winnerCount <= $participantCount){
                                            for($i = 1; $i <= $winnerCount; $i++){
                                                $randomNum = rand(0, $participantCount - 1);
                                                if(!in_array($randomNum, $control)){
                                                    if((empty($unique)) and (in_array($participant[$randomNum], $winner))){
                                                        $i--;
                                                    }else{
                                                        array_push($control, $randomNum);
                                                        array_push($winner, $participant[$randomNum]);
                                                        $result .= "<b>" . $i . "</b>". " - " . $participant[$randomNum] . "<br/>";
                                                    }
                                                }else{
                                                    $i--;
                                                }
                                            } ?>
                                            <div class="alert alert-dark" role="alert">
                                                <p id="draw">
                                                    <?php echo($result); ?>
                                                </p>
                                            </div>
                                            <?php }else{ ?>
                                                <div class="alert alert-danger" role="alert">
                                                    The number of winners shouldn't exceed the number of participants.
                                                </div>
                                    <?php }
                            } ?>
                            <form method="post">
                                <div class="form-group mb-3">
                                    <label for="winnerCount">Winner count:</label>
                                    <input id="winnerCount" name="winnerCount" class="form-control" type="number">
                                </div>
                                <div class="form-check-inline mb-3">
                                    <label for="unique">Remove duplicate participants:</label>
                                    <input id="unique" name="unique" class="form-check-input" type="checkbox">
                                    <br/><small><i>If a participant has more than one permission to participate, do not tick this option.</i></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="participant">Participants:</label>
                                    <textarea id="participant" class="form-control" name="participant"></textarea>
                                </div>
                                <button class="btn btn-dark" type="submit">Start</button>
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