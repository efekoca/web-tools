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
        <title><?php echo($settings["title"]); ?> - Footer Content</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php if((!empty($_POST["aboutUs"])) and (!empty($_POST["website"])) and (!empty($_POST["instagram"])) and (!empty($_POST["github"]))){
                    $updateAboutUs = $connect->prepare("UPDATE settings SET aboutUs = ?, website = ?, instagram = ?, github = ?");
                    $updateAboutUs->execute(array(
                       javascriptFilter($_POST["aboutUs"]),
                        filter($_POST["website"]),
                        filter($_POST["instagram"]),
                        filter($_POST["github"]),
                    ));
                    ?>
                        <div class="alert alert-success" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Settings successfully saved.
                        </div>
                <?php } ?>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Footer Settings</p>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="aboutUs"><strong>Footer Content</strong></label>
                                    <textarea id="aboutUs" class="ckeditor" name="aboutUs"><?php echo($settings["aboutUs"]); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="github"><strong>Github Profile URL</strong></label>
                                    <input class="form-control" type="text" id="github" value="<?php echo($settings["github"]); ?>" name="github" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="instagram"><strong>Instagram Profile URL</strong></label>
                                    <input class="form-control" type="text" id="instagram" value="<?php echo($settings["instagram"]); ?>" name="instagram" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="website"><strong>Website URL</strong></label>
                                    <input class="form-control" type="text" id="website" value="<?php echo($settings["website"]); ?>" name="website" required>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-floppy-disk"></i> Save</button>
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
    <script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>