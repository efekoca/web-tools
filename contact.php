<?php
    require("core/functions.php");
    require("core/dbConnect.php");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Contact</title>
    <?php require("pages/header.php"); ?>
    </head>

<body class="bg-primary-gradient">
<?php require("pages/navbar.php"); ?>
<section class="pt-5 mt-5 mb-4">
    <div class="container p-lg-5 pt-5">
        <div class="row mb-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <p class="fw-bold mb-2" style="color: #337bab;">Let's stay in touch!</p>
                <h3 class="fw-bold" data-aos="fade" data-aos-duration="1850" id="text" style="height: 65px;"><strong>Feel free to contact us for any questions, requests, suggestions and information!</strong><br><br></h3>
            </div>
        </div>
        <div class="d-flex justify-content-center container">
            <div class="col-md-6 col-xl-4 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </symbol>
                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </symbol>
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </symbol>
                    </svg>
                    <?php if((!empty($_POST["name"])) and (!empty($_POST["email"])) and (!empty($_POST["message"]))){
                        $mailPattern = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
                        $name = filter($_POST["name"]);
                        $email = filter($_POST["email"]);
                        $message = filter($_POST["message"]);
                        if(!preg_match($mailPattern, $email)){ ?>
                            <div class="alert alert-danger" role="alert" style="border-radius: 3px;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a valid e-mail.
                            </div>
                        <?php }elseif(strlen($name) > 200){ ?>
                            <div class="alert alert-danger" role="alert" style="border-radius: 3px;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a name under two hundred (200) characters.
                            </div>
                        <?php }elseif(strlen($email) > 200){ ?>
                            <div class="alert alert-danger" role="alert" style="border-radius: 3px;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify an e-mail under two hundred (200) characters.
                            </div>
                        <?php }elseif(strlen($message) > 5000){ ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a message under five thousand (5000) characters.
                            </div>
                        <?php }else{
                            $addContactMsg = $connect->prepare("INSERT INTO contact (name, email, message, status, date) VALUES (?, ?, ?, ?, ?)");
                            $addContactMsg->execute(array(
                                $name,
                                $email,
                                $message,
                                "open",
                                time(),
                            )); ?>
                            <div class="alert alert-success" role="alert" style="border-radius: 3px;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Başarılı:"><use xlink:href="#check-circle-fill"/></svg>The message successfully sent.
                            </div>
                    <?php }
                        }else{ ?>
                        <div class="alert alert-primary" role="alert" style="border-radius: 3px;">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Bilgilendirme:"><use xlink:href="#info-fill"/></svg>You will receive a response via the e-mail address you specify when your message is reviewed.
                        </div>
                    <?php } ?>
                <div>
                    <form method="post">
                        <div class="mb-3"><label for="name-1" class="form-label">Name:</label><input class="form-control" type="text" id="name-1" name="name" placeholder="Please specify a name." style="border-radius: 3px;" required></div>
                        <div class="mb-3"><label for="email-1" class="form-label">E-mail address:</label><input class="form-control" type="email" id="email-1" name="email" placeholder="Please specify an e-mail address." style="border-radius: 3px;" required></div>
                        <div class="mb-3"><label for="message-1" class="form-label">Message:</label><textarea class="form-control" id="message-1" name="message" rows="6" placeholder="Please specify a message." style="border-radius: 3px;" required></textarea></div>
                        <div><button class="btn btn-primary shadow d-block w-100" type="submit" style="border-radius: 3px;">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require("pages/footer.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
</body>
</html>
<?php $connect = null; ?>