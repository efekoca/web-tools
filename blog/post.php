<?php
    require("../core/dbConnect.php");
    require("../core/functions.php");
    $getUrl = url();
    $par = array_filter(explode("/", @$_GET["par"]));
    if(empty($par[0])){
        $connect = null;
        header("Location: ./");
        die();
    }
    $updatePostView = $connect->prepare("UPDATE blog SET views = views + 1 WHERE id = ?");
    $updatePostView->execute(array(
       $getPost["id"],
    ));
    $formattedBlogTitle = "";
    $keywords = "";
    $queryValues = array();
    $explodedContent = count(array_filter(explode(" ", $getPost["title"]))) == 0 ? array($getPost["title"]) : array_filter(explode(" ", $getPost["title"]));
    foreach($explodedContent as $item){
        if(strlen($item) > 2){
            $formattedBlogTitle .= "title LIKE ? OR ";
            $keywords .= $item . ", ";
            array_push($queryValues, "%{$item}%");
        }
    }
    $keywords = substr($keywords, 0, (strlen($keywords) - 2));
    $formattedBlogTitle = substr($formattedBlogTitle, 0,strlen($formattedBlogTitle) - 4);
    $formattedBlogTitle = "SELECT * FROM blog WHERE " . $formattedBlogTitle . " LIMIT 5";
    $getSimilarPosts = $connect->prepare($formattedBlogTitle);
    $getSimilarPosts->execute($queryValues);
    if($getSimilarPosts->rowCount() > 0){
        $getSimilarPostsControl = 1;
        $getSimilarPostsData = $getSimilarPosts->fetchAll(PDO::FETCH_ASSOC);
        $getSimilarPostsData = array_filter($getSimilarPostsData, function($item) use ($getPost){
            return $item["id"] != $getPost["id"];
        });
        if(count($getSimilarPostsData) < 1){
            $getSimilarPostsControl = 0;
        }
    }else{
        $getSimilarPostsControl = 0;
    }
    $formattedDescriptionForPost = descFilter($getPost["content"], 157);
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($getPost["title"]); ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta property="og:image" content="<?php echo($getUrl); ?>/blog/assets/imgs/<?php echo($getPost["image"]); ?>">
        <meta property="og:description" content="<?php echo($formattedDescriptionForPost); ?>">
        <meta name="description" content="<?php echo($formattedDescriptionForPost); ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo($getUrl); ?>">
        <meta property="og:site_name" content="<?php echo($settings["title"]); ?>">
        <meta property="og:title" content="<?php echo($getPost["title"]); ?>">
        <meta name="keywords" content="<?php echo($keywords . ", " . $getPost["title"]); ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="<?php echo($getUrl); ?>">
        <meta name="twitter:title" content="<?php echo($getPost["title"]); ?>">
        <meta name="twitter:description" content="<?php echo($formattedDescriptionForPost); ?>">
        <meta name="twitter:image" content="<?php echo($getUrl); ?>/blog/assets/imgs/<?php echo($getPost["image"]); ?>">
        <link rel="icon" href="<?php echo($getUrl); ?>/assets/img/<?php echo($settings["favicon"]); ?>">
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <?php if($settings["googleCodes"] != ""){ echo($settings["googleCodes"]); }  ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body class="bg-primary-gradient">
    <?php require("navbar.php"); ?>
    <a id="topButton" href="#">
        <svg class="bi bi-chevron-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="white" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"></path>
        </svg>
    </a>
    <section class="pt-5">
        <div class="container mb-0 pt-4 pt-xl-5">
            <div class="pt-5 pt-lg-5 container">
                <div class="flex-column d-flex justify-content-center mx-auto" style="max-width: 900px;">
                    <div class="text-center mb-4">
                        <h1 id="text" class="fw-bold"><?php echo($getPost["title"]); ?></h1>
                    </div>
                
                    <div style="word-break: break-word;" class="mb-3">
                        <?php echo($getPost["content"]); ?>
                    </div>
                    <div class="text-muted d-flex justify-content-between bg-transparent border-top-0 small">
                        <div class="date">
                            <?php echo(getFormattedTime($getPost["date"])); ?>
                        </div>
                        <div class="stats">
                            <i class="far fa-eye"></i> <?php echo($getPost["views"]); ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <?php if($getSimilarPostsControl == 0){
                            echo("<div style='border-radius: 2px !important; margin-top: 50px; padding: 5px;' class=\"badge bg-info\"><i class=\"fa fa-book\"></i> No similar post found.</div></div>");
                        }else{
                            echo("<div style='border-radius: 2px !important; margin-top: 50px; margin-bottom: 50px; padding: 5px;' class=\"badge bg-info\"><i class=\"fa fa-book\"></i> Similar Posts</div></div>"); ?>
                        <div class="d-flex justify-content-center row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;">
                        <?php foreach($getSimilarPostsData as $post){ ?>
                                <div class="col mb-4">
                                    <div class="card shadow-sm" style="border-radius: 0;">
                                        <div class="card-img-top" style="border-radius: 0; height: 284px; background: url(assets/imgs/<?php echo($post["image"]); ?>); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                                        <div class="card-body px-4 py-4 px-md-5">
                                            <h5 class="fw-bold card-title text-center"><?php echo($post["title"]); ?></h5>
                                            <p class="text-center">
                                                <span class="badge bg-primary" style="border-radius: 3px !important;"><i class="fas fa-user"></i> Author: <?php echo($post["author"]); ?></span> -
                                                <span class="badge bg-primary" style="border-radius: 3px !important;"><i class="far fa-clock"></i> <?php echo(estimatedReadingTime($post["content"])); ?></span>
                                            </p>
                                            <p class="text-muted card-text mb-4" style="word-break: break-all;">
                                                <?php echo(descFilter($post["content"], 217)); ?>
                                            </p>
                                            <a href="<?php echo($post["sef"]); ?>" class="btn btn-primary shadow" style="border-radius: 2px !important;">More</a>
                                        </div>
                                        <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0 small">
                                            <div class="date">
                                                <?php echo(getFormattedTime($post["date"])); ?>
                                            </div>
                                            <div></div>
                                            <div class="stats">
                                                <i class="far fa-eye"></i> <?php echo($post["views"]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            echo("</div>");
                        } ?>
                </div>
            </div>
        </div>
    </section>
    <div class="cookie-popup" id="cookie">
        <div>
        <span class="icon">
                            <svg id="cookieIcon" width="20" height="20" viewbox="0 0 45 45" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M37.6021 19.3233C39.5596 20.9915 42.1974 21.6218 44.6975 21.0187C44.737 21.5533 44.7567 22.1 44.7567 22.6589C44.7567 23.2178 44.7365 23.773 44.6959 24.3243C44.0453 33.0328 38.3799 40.5638 30.193 43.6029C22.0061 46.642 12.799 44.6321 6.62349 38.4576C0.750062 32.5832 -1.37923 23.9351 1.09537 16.0053C3.56998 8.07543 10.2399 2.17326 18.4119 0.681905C19.4918 0.487625 20.5844 0.372454 21.6811 0.337311C21.66 0.574068 21.6486 0.810824 21.6486 1.05407C21.6493 3.7219 22.9745 6.21531 25.1854 7.70839L26.1194 8.34082L25.8519 9.43704C25.1623 12.2536 26.0444 15.2231 28.1597 17.2065C30.2751 19.1898 33.2953 19.8789 36.0616 19.0095L36.9186 18.7395L37.6021 19.3233ZM17.3734 41.3189C24.0328 43.0698 31.1191 41.0994 35.9189 36.1622C39.0841 33.015 41.0367 28.8514 41.4324 24.4054C39.5365 24.1702 37.7315 23.4574 36.1865 22.3338C35.3541 22.5255 34.5027 22.6221 33.6486 22.6216C27.4338 22.6216 22.3784 17.5662 22.3784 11.3514C22.3785 10.8123 22.417 10.2739 22.4935 9.74028C20.6737 8.23592 19.3727 6.19776 18.7743 3.9138C18.9759 3.87542 19.1775 3.84001 19.3792 3.80758C19.177 3.84001 18.9754 3.87542 18.7743 3.9138C18.6889 3.58947 18.6181 3.26082 18.5619 2.92785C18.6159 3.26028 18.6867 3.58893 18.7743 3.9138C15.0368 4.6342 11.6027 6.463 8.9189 9.16218C3.98172 13.962 2.01132 21.0483 3.76218 27.7077C5.51305 34.3672 10.7139 39.568 17.3734 41.3189Z" />
                                <circle cx="9.81081" cy="21.5676" r="2.67568" />
                                <circle cx="20.027" cy="24.5676" r="2.83784" />
                                <circle cx="31.0541" cy="28.6216" r="3.72973" />
                                <circle cx="17.9189" cy="34.5406" r="1.62162" />
                                <circle cx="16.2972" cy="12.6486" r="1.45946" />
                                <circle cx="35.1081" cy="11.4324" r="2.18919" />
                                <circle cx="33.3243" cy="2.83784" r="2.83784" />
                                <circle cx="43.054" cy="15.0811" r="1.2973" />
                            </svg>
        </span>
            We are using <a href="http://www.aboutcookies.org/" target="_blank" style="text-decoration: underline;">cookies</a> to give you a better experience.
        </div>
        <div class="cookie-popup-actions">
            <button onclick="hideCookieBanner('cookie')">Confirm</button>
        </div>
    </div>
    <?php require("../pages/footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/home.js"></script>
    <script src="../assets/js/all.js"></script>
    <script src="../assets/js/bold-and-bright.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </body>
    </html>
<?php $connect = null; ?>