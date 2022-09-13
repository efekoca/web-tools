<?php session_start(); ob_start();
if(empty($_COOKIE["id"])){
    header("Location: login.php");
    die(ob_end_flush());
}
require("../core/dbConnect.php");
require("../core/functions.php");
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
        <title><?php echo($settings["title"]); ?> - User Settings</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php if((!empty($_POST["currentPassword"])) and (!empty($_POST["newPassword"])) and (!empty($_POST["username"]))){
                    $currentPassword = md5(filter($_POST["currentPassword"]));
                    $filteredUsernameForChange = filter($_POST["username"]);
                    if($currentPassword != $cookiePassword){ ?>
                        <div class="alert alert-danger" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>The current password data you specified doesn't match with your current password.
                        </div>
                    <?php }else{
                        $queryForChange = $connect->prepare("SELECT * FROM editors WHERE username = ?");
                        $queryForChange->execute(array(
                            $filteredUsernameForChange
                        ));
                        if(($queryForChange->rowCount() > 0) or ($settings["username"] == $filteredUsernameForChange)){ ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>The username you specified is already in use. Please try another username.
                            </div>
                        <?php }else{
                            if(($cookieUsername != $settings["username"]) and ($cookiePassword != $settings["password"])){
                                $updateUser = $connect->prepare("UPDATE editors SET username = ?, password = ? WHERE username = ?");
                                $updateUser->execute(array(
                                    $filteredUsernameForChange,
                                    md5(filter($_POST["newPassword"])),
                                    $cookieUsername
                                ));
                            }else{
                                $updateUser = $connect->prepare("UPDATE settings SET username = ?, password = ?");
                                $updateUser->execute(array(
                                    $filteredUsernameForChange,
                                    md5(filter($_POST["newPassword"]))
                                ));
                            } ?>
                            <div class="alert alert-success" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related settings successfully saved.
                            </div>
                        <?php }
                    }
                } ?>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">User Settings</p>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="mb-3"><label class="form-label" for="username"><strong>Username</strong></label><input class="form-control" type="text" id="username" value="<?php echo($cookieUsername); ?>" name="username" required></div>
                                <div class="mb-3"><label class="form-label" for="password"><strong>New Password</strong></label><input class="form-control" type="password" id="password" placeholder="Please specify a new password." name="newPassword" required></div>
                                <div class="mb-3"><label class="form-label" for="currentPassword"><strong>Current Password</strong></label><input class="form-control" type="password" id="currentPassword" placeholder="Please specify your current password." name="currentPassword" required></div>
                            </div>
                            <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-floppy-disk"></i> Save</button>
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