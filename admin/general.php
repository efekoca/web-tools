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
    <title><?php echo($settings["title"]); ?> - General Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css" integrity="sha512-uf06llspW44/LZpHzHT6qBOIVODjWtv4MxCricRxkzvopAlSWnTf6hpZTFxuuZcuNE9CBQhqE0Seu1CoRk84nQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="page-top">
    <?php require("navbar.php"); ?>
            <div class="container-fluid">
                <h3 class="text-dark mb-4">Settings</h3>
                <div class="row mb-3">
                    <div>
                            <?php if((!empty($_POST["title"])) and (!empty($_POST["keywords"])) and (!empty($_POST["description"])) and (!empty($_POST["homeSlogan"])) and (!empty($_POST["blogSlogan"]))){
                                $getErrorCount = 0;
                                $faviconUpload = 0;
                                $ogUpload = 0;
                                $googleCodes = empty($_POST["code"]) ? "" : $_POST["code"];
                                $executeArray = array(filter($_POST["title"]), javascriptFilter($_POST["homeSlogan"]), javascriptFilter($_POST["blogSlogan"]), filter($_POST["description"]), $googleCodes, filter($_POST["keywords"]));

                                if(!empty($_POST["uploadFavicon"])){
                                        if($_POST["uploadFavicon"] == "yes"){
                                                if(empty($_FILES["favicon"])){
                                                    $getErrorCount += 1; ?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select favicon image in ico format.
                                                    </div>
                                            <?php }elseif($_FILES["favicon"]["error"] > 0){
                                                    $getErrorCount += 1; ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select favicon image in ico format.
                                                </div>
                                            <?php }
                                            if($getErrorCount < 1){
                                                $getFaviconFile = filter($_FILES["favicon"]["name"]);
                                                if(!preg_match("/.+\.(ico)/", $getFaviconFile)){
                                                    $getErrorCount += 1; ?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select favicon image in ico format.
                                                    </div>
                                                <?php }else{
                                                    $faviconUpload += 1;
                                                }
                                            }
                                        }
                                }
                                if(!empty($_POST["uploadOG"])){
                                    if($_POST["uploadOG"] == "yes"){
                                        if(empty($_FILES["og"])){
                                            $getErrorCount += 1; ?>
                                            <div class="alert alert-danger" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select a valid meta image. (Allowed extensions: png, jpg, jpeg, webp)
                                            </div>
                                        <?php }elseif($_FILES["og"]["error"] > 0){
                                            $getErrorCount += 1; ?>
                                            <div class="alert alert-danger" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select a valid meta image. (Allowed extensions: png, jpg, jpeg, webp)
                                            </div>
                                        <?php }
                                        if($getErrorCount < 1){
                                            $getOGFile = filter($_FILES["og"]["name"]);
                                            if(!preg_match("/.+\.(jpg|jpeg|png|webp)/", $getOGFile)){
                                                $getErrorCount += 1; ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select a valid meta image. (Allowed extensions: png, jpg, jpeg, webp)
                                                </div>
                                            <?php }else{
                                                $ogUpload += 1;
                                            }
                                        }
                                    }
                                }

                                $src = "../assets/img/";
                                if(($faviconUpload) > 0 and ($ogUpload < 1)){
                                    $img = $_FILES["favicon"];
                                    $randomName = randomName();
                                    switch ($img["name"]) {
                                        case (substr($img["name"], -4) == "jpeg") or (substr($img["name"], -4) == "webp"):
                                            $formattedNewImgName = $src . $randomName . "." . substr($img["name"], -4);
                                            $imgName = $randomName . "." . substr($img["name"], -4);
                                            break;
                                        default:
                                            $formattedNewImgName = $src . $randomName . "." . substr($img["name"], -3);
                                            $imgName = $randomName . "." . substr($img["name"], -3);
                                    }
                                    if(move_uploaded_file($img["tmp_name"], $formattedNewImgName)){
                                        $editGeneralSettings = $connect->prepare("UPDATE settings SET title = ?, homeSlogan = ?, blogSlogan = ?, description = ?, googleCodes = ?, keywords = ?, favicon = ?, typeWriter = ?, typeWriterBlog = ?");
                                        array_push($executeArray, $imgName);
                                    }else{
                                        $getErrorCount += 1; ?>
                                        <div class="alert alert-danger" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><span>An unexpected error occurred while uploading favicon image. Please try again later.</span>
                                        </div>
                                    <?php }
                                }elseif(($faviconUpload < 1) and ($ogUpload > 0)){
                                    $img = $_FILES["og"];
                                    $randomName = randomName();
                                    switch ($img["name"]) {
                                        case (substr($img["name"], -4) == "jpeg") or (substr($img["name"], -4) == "webp"):
                                            $formattedNewImgName = $src . $randomName . "." . substr($img["name"], -4);
                                            $imgName = $randomName . "." . substr($img["name"], -4);
                                            break;
                                        default:
                                            $formattedNewImgName = $src . $randomName . "." . substr($img["name"], -3);
                                            $imgName = $randomName . "." . substr($img["name"], -3);
                                    }
                                    if(move_uploaded_file($img["tmp_name"], $formattedNewImgName)){
                                        $editGeneralSettings = $connect->prepare("UPDATE settings SET title = ?, homeSlogan = ?, blogSlogan = ?, description = ?, googleCodes = ?, keywords = ?, ogImage = ?, typeWriter = ?, typeWriterBlog = ?");
                                        array_push($executeArray, $imgName);
                                    }else{
                                        $getErrorCount += 1; ?>
                                        <div class="alert alert-danger" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><span>An unexpected error occurred while uploading meta image. Please try again later.</span>
                                        </div>
                                    <?php }
                                }elseif(($faviconUpload > 0) and ($ogUpload > 0)){
                                    $img = $_FILES["og"];
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
                                    $favImg = $_FILES["favicon"];
                                    $favRandomName = randomName();
                                    switch($favImg["name"]){
                                        case(substr($favImg["name"], -4) == "jpeg") or (substr($favImg["name"], -4) == "webp"):
                                            $favFormattedNewImgName = $src . $favRandomName . "." . substr($favImg["name"], -4);
                                            $favImgName = $favRandomName . "." . substr($favImg["name"], -4);
                                            break;
                                        default:
                                            $favFormattedNewImgName = $src . $favRandomName . "." . substr($favImg["name"], -3);
                                            $favImgName = $favRandomName . "." . substr($favImg["name"], -3);
                                    }
                                    if(move_uploaded_file($img["tmp_name"], $formattedNewImgName)){
                                        if(move_uploaded_file($favImg["tmp_name"], $favFormattedNewImgName)){
                                            $editGeneralSettings = $connect->prepare("UPDATE settings SET title = ?, homeSlogan = ?, blogSlogan = ?, description = ?, googleCodes = ?, keywords = ?, ogImage = ?, favicon = ?, typeWriter = ?, typeWriterBlog = ?");
                                            array_push($executeArray, $imgName, $favImgName);
                                        }else{
                                            $getErrorCount += 1;
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><span>An unexpected error occurred while uploading favicon image. Please try again later.</span>
                                            </div>
                                        <?php }
                                    }else{
                                        $getErrorCount += 1; ?>
                                        <div class="alert alert-danger" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><span>An unexpected error occurred while uploading meta image. Please try again later.</span>
                                        </div>
                                   <?php }
                                }else{
                                    $editGeneralSettings = $connect->prepare("UPDATE settings SET title = ?, homeSlogan = ?, blogSlogan = ?, description = ?, googleCodes = ?, keywords = ?, typeWriter = ?, typeWriterBlog = ?");
                                }
                                if($getErrorCount < 1){
                                            if((!empty($_POST["typeWriter"])) and (!empty($_POST["typeWriterBlog"]))){
                                                array_push($executeArray, "on", "on");
                                            }elseif((empty($_POST["typeWriter"])) and (!empty($_POST["typeWriterBlog"]))){
                                                array_push($executeArray, "off", "on");
                                            }elseif((!empty($_POST["typeWriter"])) and (empty($_POST["typeWriterBlog"]))){
                                                array_push($executeArray, "on", "off");
                                            }else{
                                                array_push($executeArray, "off", "off");
                                            }
                                            $editGeneralSettings->execute($executeArray); ?>
                                            <div class="alert alert-success" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related settings successfully saved.
                                            </div>
                                <?php }
                            } ?>
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">General Settings</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="mb-3">
                                                    <div class="alert alert-danger" style="display: none;" role="alert" id="alert">
                                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><span id="alertMsg"></span>
                                                    </div>
                                                    <div class="alert alert-info" role="alert">
                                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>When you change the settings, will be automatically applied to all pages; don't touch the areas that you don't want to change.
                                                    </div>
                                                    <label class="form-label" for="title"><strong>Site Title</strong></label>
                                                    <input class="form-control" type="text" id="title" value="<?php echo($settings["title"]); ?>" name="title" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="description"><strong>Site Description</strong></label>
                                                    <input class="form-control" type="text" id="description" value="<?php echo($settings["description"]); ?>" name="description" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="homeSlogan"><strong>Home Slogan</strong></label>
                                                    <input class="form-control" type="text" id="homeSlogan" value="<?php echo($settings["homeSlogan"]); ?>" name="homeSlogan" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="blogSlogan"><strong>Blog Slogan</strong></label>
                                                    <input class="form-control" type="text" id="blogSlogan" value="<?php echo($settings["blogSlogan"]); ?>" name="blogSlogan" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="keywords"><strong>Keywords (separate with commas)</strong></label>
                                                    <input class="form-control" value="<?php echo($settings["keywords"]); ?>" type="text" id="keywords" name="keywords" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="code"><strong>Google Adsense and Analytics Codes</strong></label>
                                                    <textarea id="code" name="code"><?php echo($settings["googleCodes"]); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label d-block"><strong>Favicon Image</strong></label>
                                                    <label for="favicon" class="form-label w-100"><a class="btn btn-dark btn-sm w-100" style="border-radius: 3px;" id="faviconFileButton"><i class="fa fa-file"></i> Choose a file</a></label>
                                                    <input class="form-control" name="favicon" style="display: none;" type="file" id="favicon">
                                                    <input type="hidden" id="uploadFavicon" name="uploadFavicon" value="no">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label d-block"><strong>Meta Image (OpenGraph)</strong></label>
                                                    <label for="og" class="form-label w-100"><a class="btn btn-dark btn-sm w-100" style="border-radius: 3px;" id="ogFileButton"><i class="fa fa-file"></i> Choose a file</a></label>
                                                    <input class="form-control" name="og" style="display: none;" type="file" id="og">
                                                    <input type="hidden" id="uploadOG" name="uploadOG" value="no">
                                                </div>
                                                <div class="flex-row d-flex">
                                                    <input class="form-check" type="checkbox" id="typeWriterBlog" name="typeWriterBlog" <?php echo($settings["typeWriterBlog"] == "on" ? "checked" : ""); ?>>
                                                    <label class="form-label" for="typeWriterBlog"><strong>&nbsp;Enable type writer effect for blog page tagline.</strong></label>
                                                </div>
                                                <div class="mb-3 flex-row d-flex">
                                                    <input class="form-check" type="checkbox" id="typeWriter" name="typeWriter" <?php echo($settings["typeWriter"] == "on" ? "checked" : ""); ?>>
                                                    <label class="form-label" for="typeWriter"><strong>&nbsp;Enable type writer effect for main page tagline.</strong></label>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js" integrity="sha512-8RnEqURPUc5aqFEN04aQEiPlSAdE0jlFS/9iGgUyNtwFnSKCXhmB6ZTNl7LnDtDWKabJIASzXrzD0K+LYexU9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js" integrity="sha512-HN6cn6mIWeFJFwRN9yetDAMSh+AK9myHF1X9GlSlKmThaat65342Yw8wL7ITuaJnPioG0SYG09gy0qd5+s777w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js" integrity="sha512-LarNmzVokUmcA7aUDtqZ6oTS+YXmUKzpGdm8DxC46A6AHu+PQiYCUlwEGWidjVYMo/QXZMFMIadZtrkfApYp/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js" integrity="sha512-I6CdJdruzGtvDyvdO4YsiAq+pkWf2efgd1ZUSK2FnM/u2VuRASPC7GowWQrWyjxCZn6CT89s3ddGI+be0Ak9Fg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/css/css.min.js" integrity="sha512-rQImvJlBa8MV1Tl1SXR5zD2bWfmgCEIzTieFegGg89AAt7j/NBEe50M5CqYQJnRwtkjKMmuYgHBqtD1Ubbk5ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script id="rendered-js" src="assets/js/general.js"></script>
</body>
</html>
<?php $connect = null; ob_end_flush(); ?>