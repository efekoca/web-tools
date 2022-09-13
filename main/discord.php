<?php
$addStat = $connect->prepare("UPDATE stats SET discord = discord + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Discord Profile Information</title>
    <?php require("pages/header.php"); ?>
</head>
<body class="bg-primary-gradient">
<?php require("pages/navbar.php"); ?>
<a id="topButton" href="#">
    <svg class="bi bi-chevron-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="white" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"></path>
    </svg>
</a>
<section class="pt-5 mt-5">
    <div class="container mb-0">
        <div class="pt-5 p-lg-5 d-flex justify-content-center align-items-center">
            <div class="col-11">
                <div class="card shadow-sm">
                    <div class="card-body px-4 py-5 px-md-5">
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-discord" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.19 12.19 0 0 0-3.658 0 8.258 8.258 0 0 0-.412-.833.051.051 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032c.001.014.01.028.021.037a13.276 13.276 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011 8.875 8.875 0 0 1-1.248-.595.05.05 0 0 1-.02-.066.051.051 0 0 1 .015-.019c.084-.063.168-.129.248-.195a.05.05 0 0 1 .051-.007c2.619 1.196 5.454 1.196 8.041 0a.052.052 0 0 1 .053.007c.08.066.164.132.248.195a.051.051 0 0 1-.004.085 8.254 8.254 0 0 1-1.249.594.05.05 0 0 0-.03.03.052.052 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019 13.235 13.235 0 0 0 4.001-2.02.049.049 0 0 0 .021-.037c.334-3.451-.559-6.449-2.366-9.106a.034.034 0 0 0-.02-.019Zm-8.198 7.307c-.789 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.45.73 1.438 1.613 0 .888-.637 1.612-1.438 1.612Zm5.316 0c-.788 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.451.73 1.438 1.613 0 .888-.631 1.612-1.438 1.612Z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Discord Profile Information</h5>
                        <p class="text-muted card-text">With one click, quickly view the detailed information of the specified profile. (avatar, badges, discriminator, etc.)</p>
                        <?php if(!empty($_POST["profile"])){ ?>
                                <?php $profile = filter($_POST["profile"]);
                                    $idPattern = "/^[0-9]+$/";
                                    if(preg_match($idPattern, $profile)){
                                        $link = "https://discordapp.com/api/users/{$profile}";
                                        $ch = curl_init();
                                        curl_setopt_array($ch, array(
                                            CURLOPT_URL => $link,
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_HTTPHEADER => array(
                                                "Authorization: Bot {$token}",
                                            ),
                                            CURLOPT_FOLLOWLOCATION => true,
                                        ));
                                        $chEnd = curl_exec($ch);
                                        $err = curl_error($ch);
                                        curl_close($ch);
                                        if(!$err){
                                            $getData = json_decode($chEnd, TRUE);
                                            $avatarUrl = @$getData["avatar"] == null ? "https://cdn.discordapp.com/embed/avatars/1.png" : "https://cdn.discordapp.com/avatars/{$getData["id"]}/{$getData["avatar"]}.png";
                                            $flags = array(
                                                "Early Verified Bot Developer" => 131072,
                                                "Discord Staff" => 1,
                                                "Partnered Server Owner" => 2,
                                                "HypeSquad Events" => 4,
                                                "Bug Hunter Level - 1" => 8,
                                                "HypeSquad Bravery" => 64,
                                                "HypeSquad Brilliance" => 128,
                                                "HypeSquad Balance" => 256,
                                                "Early Supporter" => 512,
                                                "Bug Hunter Level - 2" => 16384
                                                );
                                                $getUserFlag = @$getData["public_flags"];
                                                $userFlags = "";
                                                foreach($flags as $key => $val){
                                                    if(($getUserFlag & $val) == $val){
                                                        $userFlags .= $key . ", ";
                                                    }
                                                }
                                                $userFlags = @substr($userFlags, 0, strlen($userFlags) - 2); ?>
                                                <div class="container mb-0">
                                                    <div class="py-5 p-lg-5">
                                                        <div class="row row-cols-1 row-cols-md-2 mx-auto d-flex justify-content-center" style="max-width: 900px;">
                                                                <div class="col-11 mb-4">
                                                                    <div class="card shadow-sm border-3">
                                                                        <div class="card-body px-4 py-5 px-md-5">
                                                                            <h5 class="fw-bold card-title">
                                                                                <img src="<?php echo($avatarUrl); ?>" style="width:40px;" class="rounded-circle" alt="Avatar">
                                                                                <?php echo(@$getData["username"] ?? "Not specified."); ?>
                                                                                #<?php echo(@$getData["discriminator"] ?? "Not specified."); ?>
                                                                            </h5>
                                                                            <p class="text-muted card-text">
                                                                                <span style="font-weight: bold;">ID:</span> <?php echo(@$getData["id"] ?? "Not specified."); ?><br>
                                                                                <span style="font-weight: bold;">Badges:</span> <?php echo(@$userFlags); ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }else{ ?>
                                            <div class="alert alert-danger" role="alert">
                                                No profile found for the specified ID.
                                            </div>
                                        <?php }
                                    }else{ ?>
                                        <div class="alert alert-danger" role="alert">
                                            Please specify a true ID. (An example: 971324676783616010)
                                        </div>
                              <?php } ?>
                        <?php } ?>
                        <form method="post">
                            <label for="profile" style="display: none;"></label>
                            <input type="number" class="form-control" id="profile" name="profile" placeholder="Please specify an ID." required>
                            <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require("pages/footer.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="assets/js/all.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
<?php $connect = null; ?>
