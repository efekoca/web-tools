<?php
$addStat = $connect->prepare("UPDATE stats SET githubUser = githubUser + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Github Profile Information</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-person-badge-fill" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-.245z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Github Profile Information</h5>
                            <p class="text-muted card-text">With a single click view the detailed information of the specified profile and access the profile picture.</p>
                            <?php if(!empty($_POST["profile"])){
                                $formattedProfile = filter($_POST["profile"]);
                                $pattern = "/(http(s)?:\/\/(www.)?github\.com\/(?<id>[A-Za-z0-9_\-]+)\/?)$/u";
                                if(!preg_match($pattern, $formattedProfile, $matches)){ ?>
                                    <div class="alert alert-danger" role="alert">
                                        Please specify a true profile link. (An example: https://github.com/efekoca)
                                    </div>
                                <?php }else{
                                    $profileName = $matches["id"];
                                    $ch = curl_init();
                                    curl_setopt_array($ch, array(
                                        CURLOPT_URL => "https://api.github.com/users/{$profileName}",
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_HTTPHEADER => array(
                                            "Authorization: token {$githubToken}",
                                        ),
                                        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36",
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_REFERER => "https://google.com"
                                    ));
                                    $chEnd = curl_exec($ch);
                                    $err = curl_error($ch);
                                    curl_close($ch);
                                    if(!$err){
                                        $profileData = @json_decode($chEnd, TRUE);
                                        if(array_key_exists("message", $profileData)){
                                        if(@$profileData["message"] == "Not Found"){ ?>
                                            <div class="alert alert-danger" role="alert">
                                                No profile data was found for the related query.
                                            </div>
                                        <?php }else{ ?>
                                            <div class="alert alert-danger" role="alert">
                                                API limit reached. Please try again later.
                                            </div>
                                        <?php } ?>
                                        <?php }else{ ?>
                                            <div class="alert alert-dark" role="alert">
                                                <?php if(count($profileData) > 0){ ?>
                                                    <div>
                                                        <span style="font-weight: bold;">Username:</span> <?php echo(@$profileData["login"] ?? "Not specified."); ?> (<a style="text-decoration: none;" href="<?php echo($profileData["html_url"]); ?>">Go to Profile</a>)<br>
                                                        <span style="font-weight: bold;">Name:</span> <?php echo(@$profileData["name"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Location:</span> <?php echo(@$profileData["location"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Account creation date:</span> <?php echo(@getFormattedTime(strtotime($profileData["created_at"]))); ?><br>
                                                        <span style="font-weight: bold;">Biography:</span> <?php echo(@$profileData["bio"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Follower count:</span> <?php echo(@$profileData["followers"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Follow count:</span> <?php echo(@$profileData["following"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Project count:</span> <?php echo(@$profileData["public_repos"] ?? "Not specified."); ?><br>
                                                        <span style="font-weight: bold;">Profile picture:</span><br>
                                                        <img id="pp" class="img-fluid" style="width: 10%; max-width: 100%; height: auto; margin-top: 10px;" src="<?php echo(@$profileData["avatar_url"]); ?>" alt="<?php echo(@$profileData["login"]); ?>"> <br>
                                                        <a style="text-decoration: none;" download="<?php echo(@$profileData["avatar_url"]); ?>" id="downloadTag"><button type="button" class="btn btn-primary" style="border-radius: 0; margin-top: 15px; width: auto;" id="downloadButton">Download</button></a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <style>
                                                @media screen and (max-width: 768px){
                                                    #pp{
                                                        width: 40% !important;
                                                    }
                                                }
                                            </style>
                                            <script>
                                                document.getElementById("downloadTag").setAttribute("href", "<?php echo(@$profileData["avatar_url"]); ?>");
                                            </script>
                                        <?php }
                                    }
                                }
                            } ?>
                            <form method="post" id="profileForm">
                                <label for="profile" style="display: none;"></label>
                                <input type="text" class="form-control" id="profile" name="profile" placeholder="Please specify a profile URL.">
                                <button style="margin-top: 20px;" class="btn btn-dark shadow" type="submit">Search</button>
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