<?php
$addStat = $connect->prepare("UPDATE stats SET preview = preview + 1 LIMIT 1");
$addStat->execute();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Code Previewer</title>
    <?php require("pages/header.php"); ?>
    <link rel="stylesheet" href="plugin/codemirror/lib/codemirror.css">
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
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-code">
                                <path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8l-3.147-3.146z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Code Previewer</h5>
                        <p class="text-muted card-text">Preview and edit HTML / CSS and JavaScript codes with the live web code editor.</p>
                            <div class="container">
                                <div class="mb-5">
                                    <label for="code"></label>
                                    <textarea id="code">
                                    </textarea>
                                </div>
                                <iframe id="result" width="100%" class="mb-2" height="400px" style="border: 2px solid gray">
                                </iframe>
                                <button onclick="run()" class="btn btn-info" style="border-radius: 2px;">Run</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require("pages/footer.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="plugin/codemirror/lib/codemirror.js"></script>
<script src="assets/js/all.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="plugin/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="plugin/codemirror/mode/xml/xml.js"></script>
<script src="plugin/codemirror/mode/javascript/javascript.js"></script>
<script src="plugin/codemirror/mode/css/css.js"></script>
<script id="rendered-js" src="assets/js/codePreview.js"></script>
</body>
</html>
<?php $connect = null; ?>