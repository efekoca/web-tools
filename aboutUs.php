<?php
    require("core/functions.php");
    require("core/dbConnect.php");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - About Us</title>
    <?php require("pages/header.php"); ?>
    </head>

<body class="bg-primary-gradient">
<?php require("pages/navbar.php"); ?>
<section class="pt-5 mt-4 mb-4">
    <div class="container pt-5 pt-5 p-lg-5">
        <div class="row d-flex justify-content-center container">
            <h2 class="text-center"><strong>About Us</strong><h2>
            <?php echo($settings["aboutUsPage"]); ?>
        </div>
    </div>
</section>
<?php require("pages/footer.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
</body>
</html>
<?php $connect = null; ?>