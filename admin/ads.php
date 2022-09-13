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
$getAds = $connect->prepare("SELECT * FROM ads");
$getAds->execute();
$ads = $getAds->fetchAll(PDO::FETCH_ASSOC); ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <?php require("../pages/header.php"); ?>
        <title><?php echo($settings["title"]); ?> - Ad Settings</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php if((!empty($_POST["title"])) and (!empty($_POST["area"]))){
                    $getErrorCount = 0;
                        if(empty($_FILES["adImage"])){
                            $getErrorCount += 1; ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a valid image. (Allowed extensions: png, jpg, jpeg, webp, gif)
                            </div>
                        <?php }elseif($_FILES["adImage"]["error"] > 0){
                            $getErrorCount += 1; ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a valid image. (Allowed extensions: png, jpg, jpeg, webp, gif)
                            </div>
                        <?php }
                        if($getErrorCount < 1){
                            $getCoverImageFileName = filter($_FILES["adImage"]["name"]);
                            if(!preg_match("/.+\.(png|webp|jpeg|jpg|gif)/", $getCoverImageFileName)){
                                $getErrorCount += 1; ?>
                                <div class="alert alert-danger" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a valid image. (Allowed extensions: png, jpg, jpeg, webp, gif)
                                </div>
                            <?php }
                        }
                        if($getErrorCount < 1){
                            $src = "../assets/img/";
                            $img = $_FILES["adImage"];
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
                                $addUser = $connect->prepare("INSERT INTO ads (title, area, image) VALUES (?, ?, ?)");
                                $addUser->execute(array(
                                    filter($_POST["title"]),
                                    filter($_POST["area"]),
                                    $imgName,
                                )); ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related ad successfully added.
                                </div>
                            <?php }else{ ?>
                                <div class="alert alert-danger" style="display: none;" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>An unexpected error occurred while loading the ad image. Please try again later.
                                </div>
                            <?php }
                        }
                } ?>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Add Ad</p>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" id="adForm">
                            <div class="alert alert-info" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>Ads are placed under the search button on the main page or above the footer section, depending on the selection. You can add unlimited ad.
                            </div>
                            <div class="row">
                                <div class="mb-3" style="display: none;" id="alert">
                                    <div class="alert alert-danger" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><span id="alertMsg"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="title"><strong>Ad Title</strong></label>
                                    <input class="form-control" type="text" id="title" placeholder="Please specify a title." name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="area"><strong>Ad Area</strong></label>
                                    <select class="form-select" aria-label="Ad Area" id="area" name="area" required>
                                        <option selected disabled>Please select an ad area.</option>
                                        <option value="search">Below the search section (Only main page)</option>
                                        <option value="footer">Top of the footer section (All pages)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block"><strong>Ad Image</strong></label>
                                    <label for="adImage" class="form-label w-100"><a class="btn btn-dark w-100" style="border-radius: 3px;" id="fileButton"><i class="fa fa-file"></i> Choose a file</a></label>
                                    <input class="form-control" name="adImage" style="display: none;" type="file" id="adImage">
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Edit Ad</p>
                    </div>
                    <div class="card-body">
                        <?php if((!empty($_POST["editTitle"])) and (!empty($_POST["editID"])) and (!empty($_POST["editArea"]))){
                            $filteredIDForEdit = filter($_POST["editID"]);
                            $getEditData = $connect->prepare("SELECT * FROM ads WHERE id = ?");
                            $getEditData->execute(array(
                                $filteredIDForEdit
                            ));
                            if($getEditData->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>An ad record with the specified ID couldn't found.
                                </div>
                            <?php }else{
                                $editData = $getEditData->fetch(PDO::FETCH_ASSOC);
                                $editAd = $connect->prepare("UPDATE ads SET title = ?, area = ? WHERE id = ? LIMIT 1");
                                $editAd->execute(array(
                                    filter($_POST["editTitle"]),
                                    filter($_POST["editArea"]),
                                    $filteredIDForEdit,
                                )); ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Settings successfully saved.
                                </div>
                            <?php }
                        }elseif(!empty($_GET["edit"])){
                            $getEditData = $connect->prepare("SELECT * FROM ads WHERE id = ?");
                            $getEditData->execute(array(
                                filter($_GET["edit"])
                            ));
                            if($getEditData->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>Couldn't found any ad with specified ID.
                                </div>
                            <?php }else{
                                $editData = $getEditData->fetch(PDO::FETCH_ASSOC); ?>
                                <form method="post">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label" for="editTitle"><strong>Ad Title</strong></label>
                                            <input class="form-control" type="text" id="editTitle" value="<?php echo($editData["title"]); ?>" name="editTitle" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="editArea"><strong>Ad Area</strong></label>
                                            <select class="form-select" aria-label="Reklam Alanı" id="editArea" name="editArea" required>
                                                <option disabled>Please specify an ad area.</option>
                                                <option value="search" <?php echo($editData["area"] == "search" ? "selected" : ""); ?>>Below the search section (Only main page)</option>
                                                <option value="footer" <?php echo($editData["area"] == "footer" ? "selected" : ""); ?>>Top of the footer section (All pages)</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="editID" value="<?php echo($editData["id"]); ?>">
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-floppy-disk"></i> Save</button>
                                    </div>
                                </form>
                            <?php }
                        }elseif(!empty($_GET["delete"])){
                            $getEditData = $connect->prepare("SELECT * FROM ads WHERE id = ?");
                            $getEditData->execute(array(
                                filter($_GET["delete"])
                            ));
                            if($getEditData->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
                                </div>
                            <?php }else{
                                @unlink("../assets/img/" . $getEditData->fetch(PDO::FETCH_ASSOC)["image"]);
                                $deleteEditor = $connect->prepare("DELETE FROM ads WHERE id = ?");
                                $deleteEditor->execute(array(
                                    filter($_GET["delete"])
                                )); ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related ad successfully deleted.
                                </div>
                            <?php }
                        }else{
                            if($getAds->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No attached ad found.
                                </div>
                            <?php }else{ ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Ad Area</th>
                                            <th scope="col">Image</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($ads as $ad){ ?>
                                            <tr>
                                                <th scope="row"><?php echo($ad["id"]); ?></th>
                                                <td><?php echo($ad["title"]); ?></td>
                                                <td><?php echo($ad["area"] == "footer" ? "Top of the footer section (All pages)" : "Under the search button (Only main page)"); ?></td>
                                                <td><img src="../assets/img/<?php echo($ad["image"]); ?>" class="img-fluid" style="width: auto; height: 100px;"></td>
                                                <td>
                                                    <a href="?edit=<?php echo($ad["id"]); ?>" class="btn btn-dark" style="border-radius: 3px"><i class="fas fa-edit"></i></a>
                                                    <a href="?delete=<?php echo($ad["id"]); ?>" class="btn btn-danger" style="border-radius: 3px"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php }
                                        echo("</tbody></table>"); ?>
                                </div>
                            <?php }
                        } ?>
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
    <script src="assets/js/ad.js"></script>
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>