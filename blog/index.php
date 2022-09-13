<?php
require("../core/dbConnect.php");
require("../core/functions.php");
if(empty($_GET["page"])){
    $page = 1;
}elseif(!is_numeric(filter($_GET["page"]))){
    $connect = null;
    header("Location: ./");
    die();
}elseif(!empty($_GET["page"])){
    $page = intval(filter($_GET["page"]));
}else{
    $page = 1;
}
$rightAndLeftButtonLength = 2;
$perPageQueryLength = 8;
$numberOfRecordsToBeginPagination =	($page * $perPageQueryLength) - $perPageQueryLength;
$foundBlogCount = 0;
if(empty($_GET["search"])){
    $getBlogPosts = $connect->prepare("SELECT * FROM blog");
    $getBlogPosts->execute();
    if($getBlogPosts->rowCount() > 0){
        $foundBlogCount += 1;
        $foundPagesLength = ceil($getBlogPosts->rowCount() / $perPageQueryLength);
        if($page > $foundPagesLength){
            $connect = null;
            header("Location: ./");
            die();
        }
        $fetchBlogs = $connect->prepare("SELECT * FROM blog ORDER BY id DESC LIMIT {$numberOfRecordsToBeginPagination}, {$perPageQueryLength}");
        $fetchBlogs->execute();
        $blogs = $fetchBlogs->fetchAll(PDO::FETCH_ASSOC);
        $queryLength = $fetchBlogs->rowCount();
    }
}else{
    $searchString = "%" . filter($_GET["search"]) . "%";
    $getBlogPosts = $connect->prepare("SELECT * FROM blog WHERE title LIKE ?");
    $getBlogPosts->execute(array(
        $searchString
    ));
    if($getBlogPosts->rowCount() > 0){
        $foundBlogCount += 1;
        $foundPagesLength = ceil($getBlogPosts->rowCount() / $perPageQueryLength);
        if($page > $foundPagesLength){
            $connect = null;
            header("Location: ./");
            die();
        }
        $fetchBlogs = $connect->prepare("SELECT * FROM blog WHERE title LIKE ? LIMIT {$numberOfRecordsToBeginPagination}, {$perPageQueryLength}");
        $fetchBlogs->execute(array(
            $searchString
        ));
        $blogs = $fetchBlogs->fetchAll(PDO::FETCH_ASSOC);
        $queryLength = $fetchBlogs->rowCount();
    }
} ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Blog</title>
        <?php require("header.php"); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../assets/css/forFooter.css">
    </head>

    <body class="bg-primary-gradient">
    <?php require("navbar.php"); ?>
    <a id="topButton" href="#">
        <svg class="bi bi-chevron-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="white" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"></path>
        </svg>
    </a>
    <header class="pt-5">
        <div class="container pt-4 pt-xl-5">
            <div class="row pt-5">
                <div class="col-md-8 col-xl-6 text-center text-md-start mx-auto">
                    <div class="text-center">
                        <h3 id="text" class="fw-bold bounce animated" style="height: 65px;"><?php echo($settings["blogSlogan"]); ?></h3>
                    </div>
                </div>
                <div class="col-12 col-lg-10 mx-auto">
                    <div class="position-relative" style="display: flex;flex-wrap: wrap;justify-content: flex-end;">
                        <div style="position: relative;flex: 0 0 45%;transform: translate3d(-15%, 35%, 0);"></div>
                        <div style="position: relative;flex: 0 0 45%;/*transform: translate3d(-5%, 20%, 0);*/"></div>
                        <div style="position: relative;flex: 0 0 60%;transform: translate3d(0, 0%, 0);"></div>
                    </div>
                </div>
            </div>
            <form method="get" class="search-container d-flex flex-row justify-content-center mt-4">
                <label for="search"></label>
                <input id="search" class="form-control" type="text" placeholder="Bir makale başlığı belirtiniz." name="search">
                <button type="submit" aria-label="Makale Arama">
                    <svg id="searchIcon" stroke="white" stroke-width="1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </form>
        </div>
    </header>
    <section>
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
        <div class="container mb-0">
            <div class="pt-5 container">
                <div class="d-flex justify-content-center row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;" id="blog">
                    <?php if($foundBlogCount < 1){ ?>
                    <div class="w-100 alert alert-warning" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No post found.
                    </div>
                </div>
                <?php }else{
                foreach($blogs as $post){ ?>
                    <div class="col mb-5">
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
                                <div class="stats">
                                    <i class="far fa-eye"></i> <?php echo($post["views"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <div class="text-center">
                <?php if($perPageQueryLength < $getBlogPosts->rowCount()){ ?>
                <nav aria-label="Pages">
                    <ul class="pagination justify-content-center">
                        <?php if($page - 1 > 0){
                            if(!empty($_GET["search"])){ ?>
                                <li class="page-item">
                                    <a class="page-link" style="border-radius: 0;" href="?page=<?php echo($page - 1); ?>&search=<?php echo($_GET["search"]); ?>">Previous</a>
                                </li>
                            <?php }else{ ?>
                                <li class="page-item">
                                    <a class="page-link" style="border-radius: 0;" href="?page=<?php echo($page - 1); ?>">Previous</a>
                                </li>
                            <?php }
                        }else{ ?>
                            <li class="page-item disabled">
                                <a class="page-link" style="border-radius: 0;" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                        <?php }
                        for($i = $page - $rightAndLeftButtonLength; $i <= $page + $rightAndLeftButtonLength; $i++){
                            if(($i > 0) and ($i <= $foundPagesLength)){
                                if($page == $i){
                                    echo("<li class='page-item disabled'><a class='page-link' href='#' aria-disabled='true' tabindex='-1'>{$i}</a></li>");
                                }else{
                                    if(!empty($_GET["search"])){
                                        echo("<li class='page-item'><a class='page-link' href='?page=" . $i . "&search=" . $_GET["search"] . "'>{$i}</a></li>");
                                    }else{
                                        echo("<li class='page-item'><a class='page-link' href='?page=" . $i . "'>{$i}</a></li>");
                                    }
                                }
                            }
                        }
                        if($foundPagesLength > $page){
                            if(!empty($_GET["search"])){ ?>
                                <li class="page-item">
                                    <a style="border-radius: 0;" class="page-link" href="?page=<?php echo($page + 1); ?>&search=<?php echo($_GET["search"]); ?>">Next</a>
                                </li>
                            <?php }else{ ?>
                                <li class="page-item">
                                    <a style="border-radius: 0;" class="page-link" href="?page=<?php echo($page + 1); ?>">Next</a>
                                </li>
                            <?php }
                        }else{ ?>
                            <li class="page-item disabled">
                                <a style="border-radius: 0;" class="page-link" href="#" aria-disabled="true" tabindex="-1">Next</a>
                            </li>
                        <?php }
                        echo("</ul>");
                        echo("</ul>");
                        echo("</nav>");
                        }else{
                            echo("<p style='font-weight: bold; font-size: 15px;'>Page: {$page}/{$foundPagesLength}</p>");
                        } ?>
            </div>
            <?php } ?>
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
    <?php if($settings["typeWriterBlog"] == "on"){ ?>
        <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
        <script>
            var app = document.getElementById("text");
            var typewriter = new Typewriter(app, {
                loop: true
            });
            typewriter.typeString("<?php echo($settings["blogSlogan"]); ?>").pauseFor(2500).start();
        </script>
    <?php } ?>
    <script src="../assets/js/bold-and-bright.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </body>
    </html>
<?php $connect = null; ?>