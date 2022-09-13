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
        <title><?php echo($settings["title"]); ?> - Tool Settings</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php if(!empty($_POST["closeTool"])){
                    $postData = filter($_POST["closeTool"]);
                    if(@$pageNames[$postData] == null){ ?>
                        <div class="alert alert-danger" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select a valid tool.
                    <?php }else{
                        $queryForClosedTool = $connect->prepare("SELECT * FROM closedtools WHERE name = ?");
                        $queryForClosedTool->execute(array(
                            $postData,
                        ));
                        $closeTool = $connect->prepare("INSERT INTO closedtools (name) VALUES (?)");
                        $closeTool->execute(array(
                            $postData
                        ));
                        ?>
                        <div class="alert alert-success" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Specified tool successfully closed to use.
                        </div>
                <?php }
                }elseif(!empty($_POST["openTool"])){
                    $postData = filter($_POST["openTool"]);
                    if(@$pageNames[$postData] == null){ ?>
                        <div class="alert alert-danger" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please select a valid tool.
                        </div>
                    <?php }else{
                        $queryForClosedTool = $connect->prepare("SELECT * FROM closedtools WHERE name = ?");
                        $queryForClosedTool->execute(array(
                            $postData,
                        ));
                        $closeTool = $connect->prepare("DELETE FROM closedtools WHERE name = ? LIMIT 1");
                        $closeTool->execute(array(
                            $postData
                        ));
                        ?>
                        <div class="alert alert-success" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Specified tool successfully opened to use.
                        </div>
                    <?php }
                } ?>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Block to Use of a Tool</p>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="toolForClose"><strong>Tool</strong></label>
                                    <select class="form-select" aria-label="toolForClose" id="toolForClose" name="closeTool">
                                        <option selected disabled>Please select a tool.</option>
                                        <?php foreach($pageNames as $key => $val){
                                          echo("<option value='{$key}'>{$val}</option>");
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-floppy-disk"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Unblock to Use of a Tool</p>
                    </div>
                    <div class="card-body">
                        <?php $queryForBlockedTools = $connect->prepare("SELECT * FROM closedtools");
                        $queryForBlockedTools->execute();
                        if($queryForBlockedTools->rowCount() > 0){ ?>
                            <form method="post">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="toolForOpen"><strong>Tool</strong></label>
                                        <select class="form-select" aria-label="toolForOpen" id="toolForOpen" name="openTool">
                                            <option selected disabled>Please select a tool.</option>
                                            <?php foreach($queryForBlockedTools->fetchAll(PDO::FETCH_ASSOC) as $tool){
                                                echo("<option value='{$tool["name"]}'>{$pageNames[$tool["name"]]}</option>");
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-floppy-disk"></i> Save</button>
                                </div>
                            </form>
                        <?php }else{ ?>
                            <div class="alert alert-warning" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No closed tool found for usage.
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
    <script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>