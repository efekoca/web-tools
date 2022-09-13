<?php session_start(); ob_start();
    require("../core/functions.php");
    require("../core/dbConnect.php");
    if(!empty($_COOKIE["id"])){
        $connect = null;
        header("Location: index.php");
        die();
    } ?>
<!DOCTYPE html>
<html lang="tr" class="h-100">
<head>
    <?php require("../pages/header.php"); ?>
    <title><?php echo($settings["title"]); ?> - Login</title>
</head>
<body class="bg-gradient-dark h-100">
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
<div class="container align-items-center justify-content-center d-flex h-100">
        <div class="col-md-9 col-lg-12">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex">
                            <div class="img-fluid flex-grow-1 bg-login-image" style="background-image: url(../assets/img/admin.jpg);"></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div>
                                    <h4 class="text-dark mb-4">
                                        The power is in your hands!
                                    </h4>
                                    <?php if((empty($_POST["username"])) or (empty($_POST["secure"])) or (empty($_POST["password"]))){ ?>
                                        <div class="alert alert-warning mb-0" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>You can change all settings through the admin panel and have unlimited access to the system.
                                        </div>
                                    <?php }else{
                                            $username = filter($_POST["username"]);
                                            $password = md5(filter($_POST["password"]));
                                            if(filter($_POST["secure"]) != $_SESSION["secure"]){ ?>
                                                <div class="alert alert-danger mb-0" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>You specified the wrong security code.
                                                </div>
                                            <?php }else{
                                                $queryForEditorLogin = $connect->prepare("SELECT * FROM editors WHERE username = ? AND password = ?");
                                                $queryForEditorLogin->execute(array(
                                                   $username,
                                                    $password,
                                                ));
                                                if((($username != $settings["username"]) or ($password != $settings["password"])) and ($queryForEditorLogin->rowCount() < 1)){ ?>
                                                    <div class="alert alert-danger mb-0" role="alert">
                                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>You've specified an incorrect username or password.
                                                    </div>
                                                <?php }else{
                                                    if(!empty($_POST["remember"])){
                                                        setcookie("id", "{$username}&{$password}", (time() + ((43200 * 2) * 90)), "/", null, null, true);
                                                    }else{
                                                        setcookie("id", "{$username}&{$password}", (time() + (43200 * 2)), "/", null, null, true);
                                                    }
                                                    if($queryForEditorLogin->rowCount() < 1){
                                                        $getDatasForSettings = $settings["logs"] == "" ? array() : json_decode($settings["logs"], TRUE);
                                                        $currentIP = getIP();
                                                        $currentDatas = array("ip" => $currentIP, "date" => time(), "browser" => $getBrowser, "device" => $getPlatform);
                                                        array_push($getDatasForSettings, $currentDatas);
                                                        $getDatasForSettings = json_encode($getDatasForSettings);
                                                        $addIPs = $connect->prepare("UPDATE settings SET logs = ?, lastIp = ? LIMIT 1");
                                                        $addIPs->execute(array(
                                                            $getDatasForSettings,
                                                            $currentIP,
                                                        ));
                                                        $connect = null;
                                                        header("Location: index.php");
                                                        die(ob_end_flush());
                                                    }else{
                                                        $connect = null;
                                                        header("Location: blog.php");
                                                        die(ob_end_flush());
                                                    }
                                                }
                                            }
                                        } ?>
                                </div>
                                <form class="user" method="post">
                                    <div><label for="username"></label><input id="username" class="form-control" type="text" placeholder="Please specify your username." name="username" required></div>
                                    <div class="mb-3"><label for="password"></label><input id="password" class="form-control" type="password" placeholder="Please specify your password." name="password" required></div>
                                    <div class="text-center">
                                        <img src="../core/secure.php" alt="Captcha" class="img-fluid" id="captcha">
                                        <a class="btn btn-dark btn-sm" style="border-radius: 3px; width: 100px; height: 31px;" href="#" onclick="renew()">Renew</a>
                                    </div>
                                    <div class="mb-3"><label for="secure"></label><input id="secure" class="form-control" type="text" placeholder="Please specify what you see in the picture." name="secure" required></div>
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox small">
                                            <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1" name="remember"><label class="form-check-label custom-control-label" for="formCheck-1">Remember me</label></div>
                                        </div>
                                    </div><button class="btn btn-primary d-block w-100" type="submit">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function renew(){
        let url = $("#captcha").attr("src");
        $("#captcha").attr("src", url + `?v=${new Date().getTime()}`);
    }
</script>
</body>
</html>
<?php $connect = null; ob_end_flush(); ?>