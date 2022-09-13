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
$getEditors = $connect->prepare("SELECT * FROM editors");
$getEditors->execute();
$editors = $getEditors->fetchAll(PDO::FETCH_ASSOC); ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <?php require("../pages/header.php"); ?>
        <title><?php echo($settings["title"]); ?> - Editor Settings</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php if((!empty($_POST["username"])) and (!empty($_POST["password"]))){
                    $queryUsername = $connect->prepare("SELECT * FROM editors WHERE username = ?");
                    $queryUsername->execute(array(
                       filter($_POST["username"])
                    ));
                    if($queryUsername->rowCount() > 0){ ?>
                        <div class="alert alert-danger" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>An editor with the specified username already exists. Please specify an other username.
                        </div>
                    <?php }else{
                        $addUser = $connect->prepare("INSERT INTO editors (username, password) VALUES (?, ?)");
                        $addUser->execute(array(
                            filter($_POST["username"]),
                            md5(filter($_POST["password"])),
                        )); ?>
                    <div class="alert alert-success" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related editor successfully created with specified settings.
                    </div>
                <?php }
                } ?>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Add Editor</p>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="alert alert-info" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>The user you create as an editor can only add, delete and edit posts.
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="username"><strong>Username</strong></label>
                                    <input class="form-control" type="text" id="username" placeholder="Please specify an username." name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password"><strong>Password</strong></label>
                                    <input class="form-control" type="text" id="password" placeholder="Please specify a password." name="password" required>
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
                        <p class="text-primary m-0 fw-bold">Edit Editor</p>
                    </div>
                    <div class="card-body">
                        <?php if((!empty($_POST["editUsername"])) and (!empty($_POST["editID"])) and (!empty($_POST["editPassword"]))){
                            $filteredIDForEdit = filter($_POST["editID"]);
                            $getEditData = $connect->prepare("SELECT * FROM editors WHERE id = ?");
                            $getEditData->execute(array(
                                $filteredIDForEdit
                            ));
                            if($getEditData->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No editor found with specified ID.
                                </div>
                            <?php }else{
                                $editData = $getEditData->fetch(PDO::FETCH_ASSOC);
                                $filteredPasswordForEdit = filter($_POST["editPassword"]);
                                $editPassword = $editData["password"] == $filteredPasswordForEdit ? $filteredPasswordForEdit : md5($filteredPasswordForEdit);
                                $editEditor = $connect->prepare("UPDATE editors SET username = ?, password = ? WHERE id = ? LIMIT 1");
                                $editEditor->execute(array(
                                   filter($_POST["editUsername"]),
                                    $editPassword,
                                    $filteredIDForEdit,
                                )); ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related settings successfully saved.
                                </div>
                            <?php }
                        }elseif(!empty($_GET["edit"])){
                            $getEditData = $connect->prepare("SELECT * FROM editors WHERE id = ?");
                            $getEditData->execute(array(
                                filter($_GET["edit"])
                            ));
                            if($getEditData->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No editor found with specified ID.
                                </div>
                            <?php }else{
                                $editData = $getEditData->fetch(PDO::FETCH_ASSOC); ?>
                                <form method="post">
                                    <div class="alert alert-info" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>Password is encrypted data for security purposes.
                                    </div>
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label" for="editUsername"><strong>Username</strong></label>
                                            <input class="form-control" type="text" id="editUsername" value="<?php echo($editData["username"]); ?>" name="editUsername" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="editPassword"><strong>Password</strong></label>
                                            <input class="form-control" type="text" id="editPassword" value="<?php echo($editData["password"]); ?>" name="editPassword" required>
                                        </div>
                                        <input type="hidden" name="editID" value="<?php echo($editData["id"]); ?>">
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-floppy-disk"></i> Save</button>
                                    </div>
                                </form>
                        <?php }
                        }elseif(!empty($_GET["delete"])){
                            $getEditData = $connect->prepare("SELECT * FROM editors WHERE id = ?");
                            $getEditData->execute(array(
                                filter($_GET["delete"])
                            ));
                            if($getEditData->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No editor found with specified ID.
                                </div>
                            <?php }else{
                                $deleteEditor = $connect->prepare("DELETE FROM editors WHERE id = ?");
                                $deleteEditor->execute(array(
                                   filter($_GET["delete"])
                                )); ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related editor successfully deleted.
                                </div>
                            <?php }
                        }else{
                            if($getEditors->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No editor found.
                                </div>
                            <?php }else{ ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Settings</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($editors as $editor){ ?>
                                            <tr>
                                                <th scope="row"><?php echo($editor["id"]); ?></th>
                                                <td><?php echo($editor["username"]); ?></td>
                                                <td>
                                                    <a href="?edit=<?php echo($editor["id"]); ?>" class="btn btn-dark" style="border-radius: 3px"><i class="fas fa-edit"></i></a>
                                                    <a href="?delete=<?php echo($editor["id"]); ?>" class="btn btn-danger" style="border-radius: 3px"><i class="far fa-trash-alt"></i></a>
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
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>