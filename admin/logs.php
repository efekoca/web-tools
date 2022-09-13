<?php session_start(); ob_start();
if(empty($_COOKIE["id"])){
    header("Location: login.php");
    die(ob_end_flush());
}
require("../core/dbConnect.php");
require("../core/functions.php");
if(($cookieUsername != $settings["username"]) and ($cookiePassword != $settings["password"])){
    $connect = null;
    ob_end_flush();
    header("Location: ../");
    die();
}
$getContactFormCount = $connect->prepare("SELECT * FROM contact WHERE status = ?");
$getContactFormCount->execute(array(
    "open"
));
$contactFormCount = $getContactFormCount->rowCount();
$getLogs = json_decode($settings["logs"], true);
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <?php require("../pages/header.php"); ?>
        <title><?php echo($settings["title"]); ?> - Log Records</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Log Records</p>
                    </div>
                    <div class="card-body">
                        <?php if(count($getLogs) > 0){
                            foreach(array_reverse($getLogs) as $log){?>
                                <ul class="mb-3">
                                    <li><b>IP address:</b> <?php echo($log["ip"]); ?></li>
                                    <li><b>Browser:</b> <?php echo($log["browser"]); ?></li>
                                    <li><b>Device:</b> <?php echo($log["device"]); ?></li>
                                    <li><b>Login date:</b> <?php echo(getFormattedTime($log["date"])); ?></li>
                                </ul><hr>
                        <?php }
                            }else{ ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>No log record found.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php require("../pages/footer.php"); ?>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="assets/js/topButton.js"></script>
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>