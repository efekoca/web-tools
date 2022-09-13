<?php session_start(); ob_start();
if(empty($_COOKIE["id"])){
    header("Location: login.php");
    die(ob_end_flush());
}
require("../core/dbConnect.php");
require("../core/functions.php");
$getContactFormCount = $connect->prepare("SELECT * FROM contact WHERE status = ?");
$getContactFormCount->execute(array(
    "open"
));
$contactFormCount = $getContactFormCount->rowCount();

if(empty($_GET["page"])){
    $page = 1;
}elseif(!is_numeric(filter($_GET["page"]))){
    $connect = null;
    header("Location: blog.php");
    die();
}elseif(!empty($_GET["page"])){
    $page = intval(filter($_GET["page"]));
}else{
    $page = 1;
}

$rightAndLeftButtonLength = 2;
$perPageQueryLength = 8;
$numberOfRecordsToBeginPagination =	($page * $perPageQueryLength) - $perPageQueryLength;
$fetchErrorCount = 0;
if(!empty($_GET["search"])){
    $searchTitle = "%" . filter($_GET["search"]) . "%";
    $getBlogPosts = $connect->prepare("SELECT * FROM blog WHERE title LIKE ?");
    $getBlogPosts->execute(array(
            $searchTitle,
    ));
}else{
    $getBlogPosts = $connect->prepare("SELECT * FROM blog");
    $getBlogPosts->execute();
}
if($getBlogPosts->rowCount() > 0){
    $foundPagesLength = ceil($getBlogPosts->rowCount() / $perPageQueryLength);
    if($page > $foundPagesLength){
        $connect = null;
        header("Location: blog.php");
        die();
    }
    if(!empty($_GET["search"])){
        $fetchBlogs = $connect->prepare("SELECT * FROM blog WHERE title LIKE ? ORDER BY id DESC LIMIT {$numberOfRecordsToBeginPagination}, {$perPageQueryLength}");
        $fetchBlogs->execute(array(
            $searchTitle,
        ));
    }else{
        $fetchBlogs = $connect->prepare("SELECT * FROM blog ORDER BY id DESC LIMIT {$numberOfRecordsToBeginPagination}, {$perPageQueryLength}");
        $fetchBlogs->execute();
    }
    $blogs = $fetchBlogs->fetchAll(PDO::FETCH_ASSOC);
    $queryLength = $fetchBlogs->rowCount();
}else{ $fetchErrorCount += 1; } ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <?php require("../pages/header.php"); ?>
        <title><?php echo($settings["title"]); ?> - Blog Settings</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body id="page-top">
    <?php require("navbar.php"); ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Settings</h3>
        <div class="row mb-3">
            <div>
                <?php
                if((!empty($_POST["title"])) and (!empty($_POST["content"])) and (!empty($_POST["edit"]))){
                    $errorCount = 0;
                    $getSef = SEF(filter($_POST["title"]));
                    $queryForID = $connect->prepare("SELECT * FROM blog WHERE id = ?");
                    $queryForID->execute(array(
                        filter($_POST["edit"])
                    ));
                    if($queryForID->rowCount() < 1){
                        $errorCount += 1; ?>
                        <div class="alert alert-danger" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Couldn't find a post with specified ID.
                        </div>
                    <?php }
                    $queryForTitle = $connect->prepare("SELECT * FROM blog WHERE sef = ?");
                    $queryForTitle->execute(array(
                        $getSef
                    ));
                    if($queryForTitle->rowCount() > 0){
                        if($queryForTitle->fetch(PDO::FETCH_ASSOC)["id"] != filter($_POST["edit"])){
                            $errorCount += 1; ?>
                            <div class="alert alert-danger" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>A post with the specified title already exists. Please specify a different post title.
                            </div>
                        <?php }
                    }
                    if($errorCount < 1){
                        $editPost = $connect->prepare("UPDATE blog SET title = ?, content = ?, sef = ? WHERE id = ? LIMIT 1");
                        $editPost->execute(array(
                            filter($_POST["title"]),
                            javascriptFilter($_POST["content"]),
                            $getSef,
                            filter($_POST["edit"])
                        )); ?>
                        <div class="alert alert-success" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related post successfully edited.
                        </div>
                    <?php }
                }elseif(!empty($_GET["delete"])){
                    $errorCount = 0;
                    $queryForID = $connect->prepare("SELECT * FROM blog WHERE id = ?");
                    $queryForID->execute(array(
                        filter($_GET["delete"])
                    ));
                    if($queryForID->rowCount() < 1){
                        $errorCount += 1;
                    }
                    if($errorCount < 1){
                        $queryForCoverImg = $queryForID->fetch(PDO::FETCH_ASSOC);
                        $deleteContent = $connect->prepare("DELETE FROM blog WHERE id = ? LIMIT 1");
                        $deleteContent->execute(array(
                            filter($_GET["delete"]),
                        ));
                        @unlink("../blog/assets/imgs/{$queryForCoverImg["image"]}");
                    }
                } ?>
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <?php if((!empty($_GET["edit"])) or (!empty($_POST["edit"]))){
                            echo('<p class="text-primary m-0 fw-bold">Blog Post Edit</p>');
                        }elseif(!empty($_GET["delete"])){
                            echo('<p class="text-primary m-0 fw-bold">Blog Post Delete</p>');
                        }else{
                            echo('<p class="text-primary m-0 fw-bold">Blog Posts</p>');
                        } ?>
                    </div>
                    <div class="card-body">
                        <?php if(!empty($_GET["edit"])){
                            $getEditPostData = $connect->prepare("SELECT * FROM blog WHERE id = ? LIMIT 1");
                            $getEditPostData->execute(array(
                                filter($_GET["edit"]),
                            ));
                            if($getEditPostData->rowCount() < 1){ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>Couldn't find a post with specified ID.
                                </div>
                            <?php }else{
                                $editPostData = $getEditPostData->fetch(PDO::FETCH_ASSOC); ?>
                                <form method="post">
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="alert alert-info" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>Don't touch to areas that you don't want to change.
                                            </div>
                                            <label class="form-label" for="title"><strong>Post Title</strong></label>
                                            <input class="form-control" type="text" id="title" value="<?php echo($editPostData["title"]); ?>" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="content"><strong>Post Content</strong></label>
                                            <textarea id="content" class="ckeditor" name="content"><?php echo($editPostData["content"]); ?></textarea>
                                        </div>
                                        <input type="hidden" value="<?php echo($editPostData["id"]); ?>" name="edit">
                                        <div>
                                            <button class="btn btn-primary btn-sm w-100" type="submit"><i class="fa fa-floppy-disk"></i> Save</button>
                                        </div>
                                    </div>
                                </form>
                            <?php }
                        }elseif(!empty($_GET["delete"])){
                            if($errorCount > 0){ ?>
                                <div class="alert alert-danger" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Couldn't find a post with specified ID.
                                </div>
                            <?php }else{ ?>
                                <div class="alert alert-success" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Related post successfully deleted.
                                </div>
                            <?php } ?>
                        <?php }else{
                            if($fetchErrorCount < 1){
                                if($fetchBlogs->rowCount() < 1){ ?>
                                    <div class="w-100 alert alert-warning" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>Couldn't find a post with specified ID.
                                    </div>
                                <?php }else{ ?>
                                    <div class="table-responsive">
                                    <form class="float-end search-container d-flex flex-row justify-content-center mb-3">
                                        <label for="search"></label>
                                        <input class="form-control" type="search" id="search" name="search" placeholder="Specify something.">
                                        <button type="submit" aria-label="Post Search" style="padding: 8px 10px; background: #3763f4; font-size: 17px; border: none; cursor: pointer;">
                                            <svg id="searchIcon" stroke="white" stroke-width="1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Views</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Settings</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($blogs as $post){ ?>
                                        <tr>
                                            <th scope="row"><?php echo($post["id"]); ?></th>
                                            <td><?php echo(substr($post["title"], 0, 50) . (strlen($post["title"]) <= 50 ? "" : "...")); ?></td>
                                            <td><?php echo($post["author"]); ?></td>
                                            <td><?php echo($post["views"]); ?></td>
                                            <td><?php echo(getFormattedTime($post["date"])); ?></td>
                                            <td>
                                                <a href="../blog/<?php echo($post["sef"]); ?>" class="btn btn-primary" style="border-radius: 3px"><i class="far fa-eye"></i></a>
                                                <a href="?edit=<?php echo($post["id"]); ?>" class="btn btn-dark" style="border-radius: 3px"><i class="fas fa-edit"></i></a>
                                                <a href="?delete=<?php echo($post["id"]); ?>" class="btn btn-danger" style="border-radius: 3px"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php }
                                    echo("</tbody></table>"); ?>
                                </div>
                                <div class="text-center">
                                    <?php if($perPageQueryLength < $getBlogPosts->rowCount()){ ?>
                                    <nav aria-label="Pages">
                                        <ul class="pagination justify-content-center">
                                            <?php if($page - 1 > 0){ ?>
                                                <li class="page-item">
                                                    <a class="page-link" style="border-radius: 0;" href="?page=<?php echo($page - 1); ?>">Previous</a>
                                                </li>
                                            <?php }else{ ?>
                                                <li class="page-item disabled">
                                                    <a class="page-link" style="border-radius: 0;" href="#" tabindex="-1" aria-disabled="true">Next</a>
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
                                            if($foundPagesLength > $page){if(!empty($_GET["search"])){ ?>
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
                            <?php }
                            }else{ ?>
                                <div class="w-100 alert alert-warning" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>No data found.
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
    <script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    </body>
    </html>
<?php $connect = null; ob_end_flush(); ?>