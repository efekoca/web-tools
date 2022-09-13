<?php session_start(); ob_start();
if(empty($_COOKIE["id"])){
    header("Location: login.php");
    die(ob_end_flush());
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../plugin/phpmailer/src/Exception.php';
require '../plugin/phpmailer/src/PHPMailer.php';
require '../plugin/phpmailer/src/SMTP.php';
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
$getAllContactForms = $connect->prepare("SELECT * FROM contact");
$getAllContactForms->execute();
$allContactForms = $getAllContactForms->fetchAll(PDO::FETCH_ASSOC); ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <?php require("../pages/header.php"); ?>
        <title><?php echo($settings["title"]); ?> - Contact Forms</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php if(!empty($_POST["deleteForm"])){
                    $deleteForm = $connect->prepare("DELETE FROM contact WHERE id = ? LIMIT 1");
                    $deleteForm->execute(array(
                        filter($_POST["deleteForm"]),
                    )); ?>
                    <div class="alert alert-success" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related contact form successfully deleted.
                    </div>
                <?php } ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary fw-bold m-0">Contact Forms</h6>
                    </div>
                    <?php
                    if(!empty($_POST["editForm"])){
                        $getFormData = $connect->prepare("SELECT * FROM contact WHERE id = ?");
                        $getFormData->execute(array(
                            filter($_POST["editForm"])
                        ));
                        if($getFormData->rowCount() < 1){ ?>
                            <div class="card-body">
                                <div class="alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
                                </div>
                            </div>
                        <?php }else{
                            $editFormData = $getFormData->fetch(PDO::FETCH_ASSOC); ?>
                            <div class="card-body">
                                <div class="alert alert-info" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>The response you specify will be sent to the related user's e-mail address.
                                </div>
                                <form method="post">
                                    <div class="mb-3">
                                        <label class="form-label" for="question">User's message:</label>
                                        <input class="form-control" value="<?php echo($editFormData["message"]); ?>" id="question" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="answer">Response text:</label>
                                        <input type="hidden" value="<?php echo($editFormData["id"]); ?>" name="idForAnswer">
                                        <textarea id="answer" class="ckeditor" name="answer"></textarea>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Answer</button>
                                </form>
                            </div>
                        <?php }
                    }elseif((!empty($_POST["answer"])) and (!empty($_POST["idForAnswer"]))){
                        $getAnswerContact = $connect->prepare("SELECT * FROM contact WHERE id = ?");
                        $getAnswerContact->execute(array(
                            filter($_POST["idForAnswer"]),
                        ));
                        if($getAnswerContact->rowCount() < 1){ ?>
                            <div class="card-body">
                                <div class="alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
                                </div>
                            </div>
                        <?php }else{
                            $answerContact = $getAnswerContact->fetch(PDO::FETCH_ASSOC);
                            $filteredAnswer = javascriptFilter($_POST["answer"]);
                            $mail = new PHPMailer(true);
                            $recieverMail = $answerContact["email"];
                            $recieverName = $answerContact["name"];
                            $msg = "<center><div><img src=\"http://{$siteLink}/assets/img/{$settings["ogImage"]}\" alt='' style='width: 500px; height: 250px;'></div>Hello, {$recieverName}! <br /> <p><b style='font-weight: bold;'>Your message with id #{$answerContact["id"]}</b> answered from us! <br /><div><span style='font-weight: bold;'>Response content:</span><p>{$filteredAnswer}</p></div><br />Have a good day!</p> <br />In case of any problems or matters that you need to consult, please contact us from <a style = 'text-decoration: none;' href = 'http://{$siteLink}/contact.php'>this URL</a>! <br /><br /> Regards, {$settings["title"]}.<br /><br /></center>";
                            try{
                                $mail->SMTPDebug = 0;
                                $mail->isSMTP();
                                $mail->Host = $mailHost;
                                $mail->SMTPAuth = true;
                                $mail->CharSet = 'UTF-8';
                                $mail->Username = $mailUsername;
                                $mail->Password = $mailPassword;
                                $mail->SMTPSecure = 'tls';
                                $mail->Port = 587;
                                $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
                                $mail->setFrom($mailUsername, $settings["title"]);
                                $mail->addAddress($recieverMail, $recieverName);
                                $mail->isHTML(true);
                                $mail->Subject = "{$settings["title"]} - İletişim";
                                $mail->MsgHTML($msg);
                                $mail->send();
                                $isErr = 0;
                            }catch(Exception $err){
                                $isErr = 1;
                            }
                            if($isErr == 1){ ?>
                                <div class="card-body">
                                    <div class="alert alert-danger" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>An unexpected error occurred while sending response content to related user. Check your mail settings and try again later.
                                    </div>
                                </div>
                            <?php }else{
                                $updateStatusContact = $connect->prepare("UPDATE contact SET status = ? WHERE id = ? LIMIT 1");
                                $updateStatusContact->execute(array(
                                    "answered",
                                    filter($_POST["idForAnswer"])
                                )); ?>
                                <div class="card-body">
                                    <div class="alert alert-success" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Response content successfully sent to user.
                                    </div>
                                </div>
                            <?php }
                        }
                    }elseif(!empty($_POST["getForm"])){
                        $getCurrentFormForLook = $connect->prepare("SELECT * FROM contact WHERE id = ?");
                        $getCurrentFormForLook->execute(array(
                            filter($_POST["getForm"])
                        )); ?>
                        <div class="card-body">
                            <?php if($getCurrentFormForLook->rowCount() > 0){ ?>
                                <div class="mb-3">
                                    <label for="contactMsg" class="form-label">User's message:</label>
                                    <input id="contactMsg" value="<?php echo($getCurrentFormForLook->fetch(PDO::FETCH_ASSOC)["message"]); ?>" class="form-control" disabled>
                                </div>
                            <?php }else{ ?>
                                <div class="alert alert-warning mb-3" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
                                </div>
                            <?php } ?>
                            <a class="btn btn-primary btn-sm w-100" href="contacts.php">Go Back</a>
                        </div>
                    <?php }elseif($getAllContactForms->rowCount() > 0){
                        echo('<ul class="list-group list-group-flush"><form method="post" id="contactForm"><input type="hidden" id="editForm" name="editForm"><input type="hidden" name="deleteForm" id="deleteForm"><input type="hidden" name="getForm" id="getForm">');
                        foreach($allContactForms as $contact){ ;?>
                            <li class="list-group-item">
                                <ul class="row align-items-center no-gutters">
                                    <ul class="col">
                                        <li class="mb-2">
                                            <strong>Name:</strong> <?php echo($contact["name"]); ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong>E-mail:</strong> <?php echo($contact["email"]); ?>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Status:</strong> <?php echo($contact["status"] == "open" ? "<span class='text-success' style='text-decoration: underline;'>Open</span>" : "<span class='text-info' style='text-decoration: underline;'>Answered</span>"); ?>
                                        </li>
                                        <li class="mb-0">
                                            <strong>Message:</strong> <?php echo(substr($contact["message"], 0, 60)); ?>
                                        </li>
                                        <span class="text-xs"><?php echo(getFormattedTime($contact["date"])); ?></span>
                                    </ul>
                                    <div class="col-auto">
                                        <a class="btn btn-dark" style="border-radius: 0;" onclick="getForm('<?php echo($contact["id"]); ?>')">View</a>
                                        <?php if($contact["status"] == "open"){ ?>
                                            <a class="btn btn-primary" style="border-radius: 0;" onclick="editNote('<?php echo($contact["id"]); ?>')">Answer</a>
                                        <?php } ?>
                                        <a class="btn btn-danger" style="border-radius: 0;" onclick="deleteNote('<?php echo($contact["id"]); ?>')">Delete</a>
                                    </div>
                                </ul>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="assets/js/topButton.js"></script>
    <script src="assets/js/contacts.js"></script>
    <script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>