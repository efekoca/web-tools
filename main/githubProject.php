<?php
$addStat = $connect->prepare("UPDATE stats SET githubProject = githubProject + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Github Repository Lister</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-github" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Github Repository Lister</h5>
                            <p class="text-muted card-text">With one click, quickly view and list the projects of the specified profile in detail.</p>
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
                                        CURLOPT_URL => "https://api.github.com/users/{$profileName}/repos",
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
                                        <?php  }else{ ?>
                                            <?php if(count($profileData) > 0){ ?>
                                                <div class="container mb-0">
                                                    <div class="py-5 p-lg-5">
                                                        <div class="row row-cols-1 row-cols-md-2 mx-auto d-flex justify-content-center" style="max-width: 900px;">
                                                            <?php foreach($profileData as $project){ ?>
                                                                <div class="col-11 mb-4">
                                                                    <div class="card shadow-sm border-3">
                                                                        <div class="card-body px-4 py-5 px-md-5">
                                                                            <h5 class="fw-bold card-title">
                                                                                <?php echo(@$project["name"] ?? "Not specified."); ?>
                                                                            </h5>
                                                                            <p class="text-muted card-text">
                                                                                <?php echo(@$project["description"] ?? "Description isn't specified."); ?><br>
                                                                                <span style="font-weight: bold;">Language:</span> <?php echo(@$project["language"] ?? "Not specified."); ?><br>
                                                                                <span style="font-weight: bold;">Licence:</span> <?php echo(@$project["license"]["name"] ?? "Not specified."); ?><br>
                                                                                <span style="font-weight: bold;">Release date:</span> <?php echo(@getFormattedTime(strtotime($project["created_at"])) ?? "Not specified."); ?><br>
                                                                                <span style="font-weight: bold;">Tags:</span>
                                                                                <?php if(count($project["topics"]) > 0){
                                                                                    $formattedTopics = "";
                                                                                    foreach($project["topics"] as $topic){
                                                                                        $formattedTopics .= $topic . ", ";
                                                                                    }
                                                                                    $formattedTopics = substr($formattedTopics, 0, strlen($formattedTopics) - 2);
                                                                                }else{
                                                                                    $formattedTopics = "Tag isn't specified.";
                                                                                }
                                                                                echo($formattedTopics); ?> <br>
                                                                                <span style="font-weight: bold;">Star count:</span> <?php echo(@$project["stargazers_count"] ?? "Not specified."); ?><br>
                                                                                <span style="font-weight: bold;">Watcher count:</span> <?php echo(@$project["watchers_count"] ?? "Not specified."); ?><br>
                                                                                <span style="font-weight: bold;">Fork count:</span> <?php echo(@$project["forks_count"] ?? "Not specified."); ?><br>
                                                                                <span style="font-weight: bold;">Is it archived:</span> <?php echo(@$project["archived"] == false ? "No." : "Yes."); ?><br>
                                                                            </p>
                                                                            <a href="<?php echo(@$project["html_url"]); ?>">
                                                                                <button class="btn btn-info" style="border-radius: 5px;">Go to Project</button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }else{
                                                echo("Belirtilen profile ait herhangi bir proje bulunamadı.");
                                            } ?>
                                        <?php }
                                    }else{ ?>
                                        <div class="alert alert-dark" role="alert">
                                            An unexpected error occurred during the query. Please try again later.
                                        </div>
                                    <?php }
                                }
                            } ?>
                            <form method="post" id="profileForm">
                                <label for="profile" style="display: none;"></label>
                                <input type="text" class="form-control" id="profile" name="profile" placeholder="Please specify a profile URL.">
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