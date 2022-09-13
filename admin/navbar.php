<?php if((basename($_SERVER["PHP_SELF"]) == basename(__FILE__)) or (basename($_SERVER["PHP_SELF"]) == substr(basename(__FILE__), 0, (strlen(basename(__FILE__)) - 4)))){
    header("Location: ./");
    die();
} ?>
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
<a id="topButton" href="#">
    <svg class="bi bi-chevron-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="white" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"></path>
    </svg>
</a>
<div id="wrapper">
<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-icon rotate-n-12"><i class="fa fa-gears"></i></div>
            <div class="sidebar-brand-text mx-3"><span>SETTINGS</span></div>
        </a>
        <hr class="sidebar-divider my-0">
        <ul class="navbar-nav text-light" id="accordionSidebar">
            <?php if(($cookieUsername == $settings["username"]) and ($cookiePassword == $settings["password"])){ ?>
                <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                <div class="dropdown nav-item">
                    <a class="nav-link" style="cursor: pointer" data-bs-toggle="dropdown"><i class="fa fa-sliders"></i> Site Settings <i class="fa-solid fa-caret-down"></i></a>
                    <ul class="dropdown-menu" style="background: none; border: none; padding: 0;">
                        <li class="nav-item"><a class="nav-link" href="general.php"><i class="fas fa-cog"></i><span>General Settings</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="aboutUs.php"><i class="fas fa-folder-open"></i><span>Footer Settings</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="aboutUsPage.php"><i class="fas fa-book"></i><span>Abous Us Settings</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="cookie.php"><i class="fas fa-cookie"></i><span>Cookie Policy Settings</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="ip.php"><i class="fas fa-location-dot"></i><span>IP Settings</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="ads.php"><i class="fas fa-coins"></i><span>Ad Settings</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="toolsSettings.php"><i class="fas fa-toolbox"></i><span>Tool Settings</span></a></li>
                    </ul>
                </div>
                <div class="dropdown nav-item">
                    <a class="nav-link" style="cursor: pointer" data-bs-toggle="dropdown"><i class="fa fa-rss"></i> Blog Settings <i class="fa-solid fa-caret-down"></i></a>
                    <ul class="dropdown-menu" style="background: none; border: none; padding: 0;">
                        <li class="nav-item"><a class="nav-link" href="addContent.php"><i class="fas fa-envelope-open-text"></i><span>Add Post</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="blog.php"><i class="fas fa-align-center"></i><span>Blog Posts</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="editor.php"><i class="fas fa-pen-nib"></i><span>Editor Settings</span></a></li>
                    </ul>
                </div>
                <li class="nav-item"><a class="nav-link" href="user.php"><i class="fas fa-user"></i><span>User Settings</span></a></li>
                <li class="nav-item"><a class="nav-link" href="contacts.php"><i class="fas fa-comments"></i><span>Contact Forms</span></a></li>
                <li class="nav-item"><a class="nav-link" href="logs.php"><i class="fas fa-industry"></i><span>Log Records</span></a></li>
    </ul>
    <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
    </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
    <div id="content">
    <nav class="navbar navbar-light navbar-expand shadow mb-4 topbar static-top">
        <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav flex-nowrap ms-auto">
                <li class="nav-item dropdown no-arrow mx-1">
                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter"><?php echo($contactFormCount); ?></span><i class="fas fa-envelope fa-fw"></i></a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                            <h6 class="dropdown-header">Unanswered Contact Forms</h6>
                            <?php if($contactFormCount > 0){
                                $contactForms = $getContactFormCount->fetchAll(PDO::FETCH_ASSOC);
                                foreach($contactForms as $contact){ ?>
                                    <a class="dropdown-item d-flex align-items-center" href="contacts.php?id=<?php echo($contact["id"]); ?>" style="text-decoration: none;">
                                        <div class="fw-bold">
                                            <div class="text-truncate"><span><?php echo(substr($contact["message"], 0, 30)); ?></span></div>
                                            <p class="small text-gray-500 mb-0"><?php echo($contact["name"]); ?> - <?php echo(getFormattedTime($contact["date"])); ?></p>
                                        </div>
                                    </a>
                                <?php }
                            }else{ ?>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="fw-bold">
                                        <div><span>There is no unanswered contact form.</span></div>
                                        <p class="small text-gray-500 mb-0"><?php echo(getFormattedTime(time())); ?></p>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                </li>
                <li class="d-none d-sm-block topbar-divider"></li>
                <li class="nav-item dropdown no-arrow">
                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-lg-inline me-2 text-gray-600 small"><i class="fas fa-user"></i> <?php echo($cookieUsername); ?></span></a>
                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                            <a class="dropdown-item" href="user.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;User Settings</a>
                            <a class="dropdown-item" href="logs.php"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Log Records</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Log out</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
            <?php }else{ ?>
                <li class="nav-item"><a class="nav-link" href="user.php"><i class="fas fa-user"></i><span>User Settings</span></a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php"><i class="fas fa-align-center"></i><span>Blog Posts</span></a></li>
                <li class="nav-item"><a class="nav-link" href="addContent.php"><i class="fas fa-envelope-open-text"></i><span>Add Post</span></a></li>
    </ul>
    <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
    </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
    <div id="content">
    <nav class="navbar navbar-light navbar-expand shadow mb-4 topbar static-top">
        <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav flex-nowrap ms-auto">
                <li class="d-none d-sm-block topbar-divider"></li>
                <li class="nav-item dropdown no-arrow">
                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-lg-inline me-2 text-gray-600 small"><i class="fas fa-user"></i> <?php echo($cookieUsername); ?></span></a>
                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                            <a class="dropdown-item" href="user.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;User Settings</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Log out</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
            <?php } ?>