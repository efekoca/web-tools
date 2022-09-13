<?php
if((basename($_SERVER['PHP_SELF']) == basename(__FILE__)) or (basename($_SERVER['PHP_SELF']) == substr(basename(__FILE__), 0, (strlen(basename(__FILE__)) - 4)))){
    header("Location: ./");
    die();
} ?>
<nav class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <span class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-tools">
                        <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"></path>
                    </svg>
            </span>
            <span></span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" data-bs-target="#navcol-1"><span class="visually-hidden">Navigasyon</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse text-center" id="navcol-1">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php" data-bs-target="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="blog/">Blog</a></li>
                <li class="nav-item"><a class="nav-link active" href="aboutUs.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link active" href="cookie.php">Cookie Policy</a></li>
                <li class="nav-item"><a class="nav-link active" href="stats.php">Statistics</a></li>
                <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
            </ul>
                <?php
                if(!empty($_COOKIE["id"])){
                    echo('<div><a class="nav-link text-white btn btn-primary btn-sm" style="border-radius: 3px;" href="admin/">Go to Panel</a></div>');
                }else{
                    echo('<div><a class="nav-link text-white btn btn-primary btn-sm" style="border-radius: 3px;" href="admin/login.php">Login to Panel</a></div>');
                } ?>
        </div>
    </div>
</nav>