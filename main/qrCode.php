<?php
$addStat = $connect->prepare("UPDATE stats SET qrCode = qrCode + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - QR Code Generator</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-qr-code" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M5 1H1v4h4V1ZM1 11v4h4v-4H1ZM15 1h-4v4h4V1ZM5 0h1v6H0V0h5Zm0 10h1v6H0v-6h5Zm6-10h-1v6h6V0h-5ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Zm-2 4.5V12h1v3h4v1H7v-.5Zm9-1.5v2h-3v-1h2v-1h1ZM2 2h2v2H2V2Zm10 0h2v2h-2V2ZM4 12H2v2h2v-2Z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">QR Code Generator</h5>
                            <p class="text-muted card-text">Create a QR code of the specified content in the specified dimensions and use it quickly by one click.</p>
                            <?php if((!empty($_POST["text"])) and (!empty($_POST["size"]))){
                                $getSize = filter($_POST["size"]);
                                $qrCodeUrl = "https://chart.googleapis.com/chart?chs=" . $getSize . "x" . $getSize . "&cht=qr&chl=" . filter($_POST["text"]) . "&choe=UTF-8"; ?>
                                <div class="alert alert-dark d-flex justify-content-center container flex-column align-items-center" role="alert">
                                    <p><?php echo("QR Code of <b>" . filter($_POST["text"]) . ":</b>"); ?></p>
                                    <img class="img-fluid" src="<?php echo($qrCodeUrl); ?>" alt="">
                                    <a style="text-decoration: none;" id="downloadTag"><button type="button" class="btn btn-primary" style="border-radius: 3px; margin-top: 30px;" id="downloadButton">Download</button></a>
                                </div>
                                <script type="text/javascript">
                                    let url = "<?php echo($qrCodeUrl); ?>";
                                    document.getElementById("downloadTag").addEventListener("click", (event) => {
                                        fetch(url)
                                            .then(resp => resp.blob())
                                            .then(data => {
                                                const blob = window.URL.createObjectURL(data);
                                                const anchor = document.createElement("a");
                                                anchor.style.display = "none";
                                                anchor.href = blob;
                                                anchor.download = "qrCode.png";
                                                document.body.appendChild(anchor);
                                                anchor.click();
                                                window.URL.revokeObjectURL(blob);
                                            })
                                            .catch((e) => {
                                                document.getElementById("downloadButton").innerText = "An unexpected error occurred.";
                                            });
                                    });
                                </script>
                            <?php } ?>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="text" class="form-label">QR code content:</label>
                                    <input type="text" class="form-control" id="text" name="text" placeholder="Please specify a content." required>
                                </div>
                                <div>
                                    <label for="size" class="form-label">QR code size (px):</label>
                                    <input type="text" class="form-control" id="size" name="size" value="250" required>
                                </div>
                                <button style="margin-top: 30px;" class="btn btn-dark shadow" type="submit">Generate</button>
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