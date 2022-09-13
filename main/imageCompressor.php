<?php
$addStat = $connect->prepare("UPDATE stats SET imageCompressor = imageCompressor + 1 LIMIT 1");
$addStat->execute();
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Image Compressor</title>
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
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-image" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"></path>
                                </svg>
                            </div>
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
                            <h5 class="fw-bold card-title">Image Compressor</h5>
                            <p class="text-muted card-text">Convert selected image to reduced size with one click without losing quality.</p>
                            <?php if(!empty($_POST["isUpload"])){
                                $getErrorCount = 0;
                                if(empty($_FILES["image"])){
                                    $getErrorCount += 1;
                                }elseif($_FILES["image"]["error"] > 0){
                                    $getErrorCount += 1;
                                }
                                if($getErrorCount < 1){
                                    $fileName = filter($_FILES["image"]["name"]);
                                    if(!preg_match("/.+\.(png|webp|jpeg|jpg)/", $fileName)){
                                        $getErrorCount += 1; ?>
                                        <div class="alert alert-danger" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Please specify a true image. (Allowed extensions: png, jpg, jpeg, webp)
                                        </div>
                                    <?php }else{
                                        $getFileName = compress($_FILES["image"]["tmp_name"]); ?>
                                        <div class="mb-3">
                                            <img id="pp" class="img-fluid w-100" style="width: 10%; max-width: 100%; height: auto; margin-top: 10px;" src="compressedImages/<?php echo($getFileName); ?>" alt="Sıkıştırılacak Resim"> <br>
                                            <a style="text-decoration: none;" download="compressedImages/<?php echo($getFileName); ?>" id="downloadTag"><button type="button" class="btn btn-primary w-100" style="margin-top: 15px;" id="downloadButton">Download</button></a>
                                        </div>
                                        <script>
                                            document.getElementById("downloadTag").setAttribute("href", "compressedImages/<?php echo($getFileName); ?>");
                                        </script>
                                    <?php }
                                }
                            } ?>
                            <div class="alert alert-danger" role="alert" id="alert" style="display: none;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>Lütfen doğru bir resim seçiniz. (İzin verilen uzantılar: png, jpg, jpeg, webp)
                            </div>
                            <form method="post" enctype="multipart/form-data" id="imageForm">
                                <div>
                                    <label class="form-label d-block"><strong>Image for Compress</strong></label>
                                    <label for="image" class="form-label w-100"><a class="btn btn-primary" id="fileButton"><i class="fa fa-file"></i> Choose a file</a></label>
                                    <input class="form-control" name="image" style="display: none;" type="file" id="image">
                                    <input type="hidden" name="isUpload" value="yes">
                                </div>
                                <button style="margin-top: 20px;" class="btn btn-dark shadow" type="submit">Compress</button>
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
    <script src="assets/js/imageCompressor.js" </script>
    </body>
    </html>
<?php $connect = null; ?>