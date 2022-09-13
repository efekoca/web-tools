<?php
$addStat = $connect->prepare("UPDATE stats SET editor = editor + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Live Text Editor</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-journal-richtext" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.5 3.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zm-.861 1.542 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047L11 4.75V7a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 7v-.5s1.54-1.274 1.639-1.208zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"></path>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Live Text Editor</h5>
                            <p class="text-muted card-text">Create quality online content with instant, advanced and live preview text editor. <br>(You can access the HTML and CSS codes by clicking the "Source" button.)</p>
                            <label for="text" style="display: none;"></label>
                            <textarea type="text" class="ckeditor" id="text" placeholder="Please specify a content."></textarea><br>
                            <div>
                                <div class="justify-content-center d-flex" style="font-weight: 1000">Live preview:</div>
                                <div id="preview" class="justify-content-center d-flex">
                                    <div class="collector" id="collector">
                                        Nothing specified.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require("pages/footer.php"); ?>
    <script src="https://cdn.ckeditor.com/4.14.1/full-all/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/all.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assets/js/bold-and-bright.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            CKEDITOR.instances["text"].on("change", function(){
                document.getElementById("collector").innerHTML = `${CKEDITOR.instances["text"].getData() == "" ? "Nothing specified." : CKEDITOR.instances["text"].getData()}`;
            });
        });
    </script>
    </body>
    </html>
<?php $connect = null; ?>