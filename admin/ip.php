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
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <?php require("../pages/header.php"); ?>
        <title><?php echo($settings["title"]); ?> - IP Settings</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="../plugin/codemirror/lib/codemirror.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php $ipPattern = "/\b((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4}\b/u";
                if(!empty($_POST["ip"])){
                    $ipForBlock = filter($_POST["ip"]);
                    if(preg_match($ipPattern, $ipForBlock)){
                        $addBlockedIP = $connect->prepare("INSERT INTO blockedips (ip) VALUES (?)");
                        $addBlockedIP->execute(array(
                            $ipForBlock
                        )); ?>
                        <div class="alert alert-success" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related IP address successfully blocked.
                        </div>
                <?php }else{ ?>
                        <div class="alert alert-danger" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a valid IP address.
                        </div>
                    <?php }
                    }elseif(!empty($_POST["removeIp"])){
                        $ipForBlock = filter($_POST["removeIp"]);
                        if(!preg_match($ipPattern, $ipForBlock)){ ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a valid IP address.
                            </div>
                        <?php }else{
                            $ipQuery = $connect->prepare("SELECT * FROM blockedips WHERE ip = ?");
                            $ipQuery->execute(array(
                                $ipForBlock
                            ));
                            if($ipQuery->rowCount() < 1){ ?>
                                <div class="alert alert-danger" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>There is no block for specified IP address.
                                </div>
                            <?php }else{
                                $deleteIPBlock = $connect->prepare("DELETE FROM blockedips WHERE ip = ?");
                                $deleteIPBlock->execute(array(
                                    filter($_POST["removeIp"]),
                                )); ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>The IP address you specified successfully unblocked.
                                </div>
                            <?php }
                        }
                } ?>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">IP Block</p>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="ip"><strong>IP Address</strong></label>
                                    <div class="alert alert-info" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>You can completely block the IP address you specify from using the site.
                                    </div>
                                    <input class="form-control" type="text" id="ip" placeholder="Please specify an IP address." name="ip" required>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-ban"></i> Block</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">IP Unblock</p>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="removeIp"><strong>IP Address</strong></label>
                                    <div class="alert alert-info" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>You can unblock an IP address that you've blocked from using the site.
                                    </div>
                                    <input class="form-control" type="text" id="removeIp" placeholder="Please specify an IP address." name="removeIp" required>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-remove"></i> Unblock</button>
                            </div>
                        </form>
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