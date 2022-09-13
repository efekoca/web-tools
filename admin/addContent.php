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
        <title><?php echo($settings["title"]); ?> - Add Post</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Blog Settings</h3>
        <div class="row">
            <div>
                <?php if((!empty($_POST["title"])) and (!empty($_POST["content"]))){
                        $getErrorCount = 0;
                        $sef = SEF(filter($_POST["title"]));
                        $querySef = $connect->prepare("SELECT * FROM blog WHERE sef = ?");
                        $querySef->execute(array(
                            $sef,
                        ));
                        if($querySef->rowCount() > 0){
                            $getErrorCount += 1; ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>A post with the specified title already exists. Please select a different post title.
                            </div>
                        <?php }
                        if(empty($_FILES["coverImage"])){
                            $getErrorCount += 1; ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please choose a correct cover image. (Allowed extensions: png, jpg, jpeg, webp)
                            </div>
                        <?php }elseif($_FILES["coverImage"]["error"] > 0){
                            $getErrorCount += 1; ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please choose a correct cover image. (Allowed extensions: png, jpg, jpeg, webp)
                            </div>
                        <?php }
                        if($getErrorCount < 1){
                            $getCoverImageFileName = filter($_FILES["coverImage"]["name"]);
                            if(!preg_match("/.+\.(png|webp|jpeg|jpg)/", $getCoverImageFileName)){
                                $getErrorCount += 1; ?>
                                <div class="alert alert-danger" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please choose a correct cover image. (Allowed extensions: png, jpg, jpeg, webp)
                                </div>
                            <?php }
                        }
                        if($getErrorCount < 1){
                            $src = "../blog/assets/imgs/";
                            $img = $_FILES["coverImage"];
                            $randomName = randomName();
                            switch($img["name"]){
                                case (substr($img["name"], -4) == "jpeg") or (substr($img["name"], -4) == "webp"):
                                    $formattedNewImgName = $src . $randomName . "." . substr($img["name"], -4);
                                    $imgName = $randomName . "." . substr($img["name"], -4);
                                    break;
                                default:
                                    $formattedNewImgName = $src . $randomName . "." . substr($img["name"], -3);
                                    $imgName = $randomName . "." . substr($img["name"], -3);
                            }
                            if(move_uploaded_file($img["tmp_name"], $formattedNewImgName)){
                                $addContent = $connect->prepare("INSERT INTO blog (title, content, date, sef, image, views, author) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                $addContent->execute(array(
                                    filter($_POST["title"]),
                                    javascriptFilter($_POST["content"]),
                                    time(),
                                    $sef,
                                    $imgName,
                                    0,
                                    $cookieUsername,
                                ));
                                $pingSitemap = @file_get_contents("http://www.google.com/webmasters/sitemaps/ping?sitemap=" . url() . "/sitemap.xml");
                                ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg><?php echo($pingSitemap != false ? "The relevant post successfully added and the sitemap updated." : "The related post successfully added but an unexpected error occurred while updating the sitemap."); ?>
                                </div>
                            <?php }else{ ?>
                                <div class="alert alert-danger" style="display: none;" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>An unexpected error occurred while loading the cover image. Please try again later.
                                </div>
                            <?php }
                        }
                   } ?>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Add Post</p>
                    </div>
                    <div class="card-body">
                        <form method="post" id="contentForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="mb-3">
                                    <div class="alert alert-danger" style="display: none;" role="alert" id="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><span id="alertMsg"></span>
                                    </div>
                                    <label class="form-label" for="title"><strong>Post Title</strong></label>
                                    <div class="alert alert-info" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>You can see the live preview from the card below when you fill the data fields.
                                    </div>
                                    <input class="form-control" type="text" id="title" placeholder="Please specify a title." name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="content"><strong>Post Content</strong></label>
                                    <textarea id="content" class="ckeditor" name="content"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block"><strong>Cover Image</strong></label>
                                    <label for="coverImage" class="form-label w-100"><a class="btn btn-dark w-100" style="border-radius: 3px;" id="fileButton"><i class="fa fa-file"></i> Choose a file</a></label>
                                    <input class="form-control" name="coverImage" style="display: none;" type="file" id="coverImage">
                                </div>
                                <label class="form-label d-block"><strong>Live Preview</strong></label>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-center row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;">
                                        <div class="col mb-4">
                                            <div class="card shadow-sm" style="border-radius: 0;">
                                                <div class="card-img-top" id="coverImagePreview" style="border-radius: 0; height: 284px; background: url(../blog/assets/imgs/default.jpg); background-size: cover; background-repeat: no-repeat;"></div>
                                                <div class="card-body px-4 py-5 px-md-5 d-flex justify-content-center flex-column align-items-center">
                                                    <h5 class="fw-bold card-title text-center" id="titlePreview">Please specify a title.</h5>
                                                    <p class="text-center">
                                                        <span class="badge bg-primary" style="border-radius: 3px !important;"><i class="fas fa-user"></i> Author: <?php echo($cookieUsername); ?></span> -
                                                        <span class="badge bg-primary" style="border-radius: 3px !important;"><i class="far fa-clock"></i> <span id="estimatedReadingPreview">Specify a content</span></span>
                                                    </p>
                                                    <p class="text-muted card-text mb-4" style="word-break: break-all;" id="contentPreview">
                                                        Please specify a content.
                                                    </p>
                                                    <a href="#" class="btn btn-primary shadow" style="width:100%;border-radius: 2px !important;">More</a>
                                                </div>
                                                <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0 small">
                                                    <div class="date">
                                                        <?php echo(getFormattedTime(time())); ?>
                                                    </div>
                                                    <div></div>
                                                    <div class="stats">
                                                        <i class="far fa-eye"></i> 1
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div>
                                    <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-plus"></i> Add</button>
                                </div>
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
    <script src="assets/js/addContent.js"></script>
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>