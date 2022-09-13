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
        header("Location: addContent.php");
        die();
    }
    $getTotalTools = $connect->prepare("SELECT * FROM stats");
    $getTotalTools->execute();
    $totalTools = $getTotalTools->fetch(PDO::FETCH_ASSOC);
    $totalUseCount = array_sum($totalTools);
    $getContactFormCount = $connect->prepare("SELECT * FROM contact WHERE status = ?");
    $getContactFormCount->execute(array(
       "open"
    ));
    $contactFormCount = $getContactFormCount->rowCount();
    $getBrowsersAndDevices = $connect->prepare("SELECT * FROM browsers");
    $getBrowsersAndDevices->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <?php require("../pages/header.php"); ?>
    <title><?php echo($settings["title"]); ?> - Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body id="page-top">
    <?php require("navbar.php"); ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-3">
                        <div class="card shadow py-2 d-flex h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Last logged in IP address</span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span><?php echo($settings["lastIp"]); ?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-info-circle fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-3">
                        <div class="card shadow border-start-success py-2 d-flex h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Total usage count of tools</span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span><?php echo($totalUseCount); ?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-chart-line fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-3">
                        <div class="card shadow border-start-success py-2 d-flex h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Visitor count of today</span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span><?php echo($dailyVisitCount); ?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-chart-pie fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-3">
                        <div class="card shadow border-start-warning py-2 d-flex h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="row align-items-center no-gutters">
                                    <div class="col me-2">
                                        <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Count of pending forms</span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span><?php echo($contactFormCount); ?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow d-flex h-100">
                            <div class="card-header py-3">
                                <h6 class="text-primary fw-bold m-0"><?php echo(empty($_POST["editNote"]) ? "Add note" : "Edit note"); ?></h6>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <?php if(!empty($_POST["editContent"]) and (!empty($_POST["idForEdit"]))){
                                        $editNoteData = $connect->prepare("UPDATE notes SET note = ? WHERE id = ?");
                                        $editNoteData->execute(array(
                                           javascriptFilter($_POST["editContent"]),
                                           filter($_POST["idForEdit"])
                                        )); ?>
                                        <div class="alert alert-success" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>The relevant note content has been successfully edited.
                                        </div>
                                    <?php }elseif(!empty($_POST["addNote"])){
                                        $addNote = $connect->prepare("INSERT INTO notes (note, date) VALUES (?, ?)");
                                        $addNote->execute(array(
                                            javascriptFilter($_POST["addNote"]),
                                            time(),
                                        )); ?>
                                        <div class="alert alert-success" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>The relevant note has been successfully added.
                                        </div>
                                    <?php }elseif(!empty($_POST["deleteNote"])){
                                        $deleteNote = $connect->prepare("DELETE FROM notes WHERE id = ?");
                                        $deleteNote->execute(array(
                                            filter($_POST["deleteNote"]),
                                        )); ?>
                                        <div class="alert alert-success" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>The relevant note has been successfully deleted.
                                        </div>
                                    <?php }elseif(!empty($_POST["editNote"])){ ?>
                                        <div class="alert alert-info" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>You can click the "Save" button by making the necessary adjustments below.
                                        </div>
                                    <?php }else{ ?>
                                        <div class="alert alert-info" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>You can add unlimited note.
                                        </div>
                                    <?php } ?>
                                    <p>Details, content or ideas you deem necessary; save for future and easily access.</p>
                                        <label for="text" class="form-label">Specify note content:</label>
                                        <?php if(empty($_POST["editNote"])){ ?>
                                            <textarea type="text" id="text" class="ckeditor" placeholder="Please specify a content." name="addNote"></textarea>
                                        <?php }else{
                                            $getCurrentNoteData = $connect->prepare("SELECT * FROM notes WHERE id = ?");
                                            $getCurrentNoteData->execute(array(
                                                filter($_POST["editNote"]),
                                            ));
                                            if($getCurrentNoteData->rowCount() > 0){
                                                $getCurrentNote = $getCurrentNoteData->fetch(PDO::FETCH_ASSOC); ?>
                                                 <input type="hidden" name="idForEdit" value="<?php echo($getCurrentNote["id"]); ?>">
                                                <textarea type="text" class="ckeditor" id="text" name="editContent"><?php echo($getCurrentNote["note"]); ?></textarea>
                                        <?php }else{ ?>
                                                <div class="alert alert-warning" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
                                                </div>
                                            <?php }
                                        } ?>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light w-100"><?php echo(empty($_POST["editNote"]) ? "Add" : "Save"); ?></button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow d-flex h-100">
                            <div class="card-header py-3">
                                <h6 class="text-primary fw-bold m-0">Bots visiting the site</h6>
                            </div>
                                <?php if($getBrowsersAndDevices->rowCount() > 0){ ?>
                                    <div class="chart card-body d-flex justify-content-center align-items-center">
                                        <div class="chart-container" id="chartContainer">
                                            <canvas id="bots"></canvas>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div class="alert alert-warning" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
                                    </div>
                                <?php } ?>
                        </div>
                    </div>
                    <div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="text-primary fw-bold m-0">Notes</h6>
                            </div>
                                <?php
                                $getNotes = $connect->prepare("SELECT * FROM notes ORDER BY ID DESC");
                                $getNotes->execute();
                                if($getNotes->rowCount() > 0){
                                    echo('<ul class="list-group list-group-flush"><form method="post" id="noteForm"><input type="hidden" id="deleteNote" name="deleteNote"><input type="hidden" name="editNote" id="editNote">');
                                    foreach($getNotes->fetchAll(PDO::FETCH_ASSOC) as $note){ ?>
                                        <li class="list-group-item">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col me-2">
                                                    <h6 class="mb-0"><strong><?php echo($note["note"]); ?></strong></h6><span class="text-xs"><?php echo(getFormattedTime($note["date"])); ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <a class="btn btn-primary" style="border-radius: 0;" onclick="editNote('<?php echo($note["id"]); ?>')">Edit</a>
                                                    <a class="btn btn-danger" style="border-radius: 0;" onclick="deleteNote('<?php echo($note["id"]); ?>')">Delete</a>
                                                </div>
                                            </div>
                                        </li>
                                <?php }
                                    echo("</form></ul>");
                                    }else{ ?>
                                        <div class="card-body">
                                            <div class="alert alert-warning" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
                                            </div>
                                        </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require("../pages/footer.php"); ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script src="//cdn.ckeditor.com/4.19.0/basic/ckeditor.js"></script>
<script src="assets/js/topButton.js"></script>
<script>
    function deleteNote(val){
        document.getElementById("deleteNote").value = val;
        document.getElementById("noteForm").submit();
    }
    function editNote(val){
        document.getElementById("editNote").value = val;
        document.getElementById("noteForm").submit();
    }
</script>
<?php if($getBrowsersAndDevices->rowCount() > 0){ ?>
    <script>
        <?php
            $browsersAndDevices = $getBrowsersAndDevices->fetch(PDO::FETCH_ASSOC)["browsers"];
            $browsers = json_decode($browsersAndDevices, TRUE);
            $browsers = array_filter($browsers, function($key, $val){
                return strpos(strtolower($val), "bot");
            }, ARRAY_FILTER_USE_BOTH);
            echo "let getBots = " . json_encode(array_keys($browsers)) . ";\n";
            echo "let getBotsData = " . json_encode(array_values($browsers)) . ";\n";
        ?>
    </script>
    <script src="assets/js/stats.js"></script>
<?php } ?>
</body>
</html>
<?php $connect = null; ob_end_flush(); ?>