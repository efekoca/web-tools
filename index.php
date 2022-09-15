<?php
    require("core/dbConnect.php");
    require("core/functions.php");
    $getAdsForIndex = $connect->prepare("SELECT * FROM ads WHERE area = ?");
    $getAdsForIndex->execute(array(
            "search"
    ));
    $par = array_filter(explode("/", @$_GET["par"]));
    if((empty($par[0])) or (@$par[0] == "index")){ ?>
        <!DOCTYPE html>
        <html lang="tr">
        <head>
            <title><?php echo($settings["title"]); ?></title>
            <?php require("pages/header.php"); ?>
            <link rel="stylesheet" href="assets/css/forFooter.css">
        </head>

        <body class="bg-primary-gradient">
        <?php require("pages/navbar.php"); ?>
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
                            <h3 id="text" class="fw-bold bounce animated" style="height: 65px;"><?php echo($settings["homeSlogan"]); ?></h3>
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
                <div class="search-container d-flex flex-row justify-content-center mt-4">
                    <label for="search"></label>
                    <input onkeyup="searchTool()" id="search" class="form-control" type="search" placeholder="Specify a tool name." name="search">
                    <button type="submit" aria-label="Tool Search" disabled>
                        <svg id="searchIcon" stroke="white" stroke-width="1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
                <?php if($getAdsForIndex->rowCount() > 0){ ?>
                    <div class="d-flex justify-content-center gap-4 flex-column align-items-center row-cols-1 row-cols-md-2 mx-auto mt-5" style="max-width: 900px;">
                        <?php foreach($getAdsForIndex->fetchAll(PDO::FETCH_ASSOC) as $adSearch){ ?>
                            <div class="text-center">
                                <a href="<?php echo($adSearch["link"]); ?>"><img class="img-fluid" src="<?php echo(url()); ?>/assets/img/<?php echo($adSearch["image"]); ?>" alt="<?php echo($adSearch["title"]); ?>"></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </header>
        <section>
            <div class="container mb-0">
                <div class="pt-5">
                    <div class="d-flex justify-content-center row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;" id="tools">

                        <div class="col mb-4" id="screenshot.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-camera" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"></path>
                                            <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Website Screenshot</h5>
                                    <p class="text-muted card-text mb-4">Take a screenshot of specified website and review it by one click.</p><a href="screenshot.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="whois.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-window-stack">
                                            <path fill-rule="evenodd" d="M12 1a2 2 0 0 1 2 2 2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2 2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h10ZM2 12V5a2 2 0 0 1 2-2h9a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1Zm1-4v5a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V8H3Zm12-1H3V5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2ZM4.5 6a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1ZM6 6a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Zm2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
                                        </svg></div>
                                    <h5 class="fw-bold card-title">Whois Query</h5>
                                    <p class="text-muted card-text mb-4">Expand your research by obtaining detailed information about a domain. (registration date, contact information, etc.)</p><a href="whois.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="proxy.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-columns-gap" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M6 1v3H1V1h5zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12v3h-5v-3h5zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8v7H1V8h5zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6v7h-5V1h5zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Proxy Extractor</h5>
                                    <p class="text-muted card-text mb-4">Automatically separate proxy values from the entered content in the form of proxy:port without losing time.</p><a href="proxy.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="preview.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-code">
                                            <path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8l-3.147-3.146z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Code Previewer</h5>
                                    <p class="text-muted card-text mb-4">Preview and edit HTML / CSS and JavaScript codes with the live web code editor.</p><a href="preview.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="discord.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-discord" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.19 12.19 0 0 0-3.658 0 8.258 8.258 0 0 0-.412-.833.051.051 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032c.001.014.01.028.021.037a13.276 13.276 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011 8.875 8.875 0 0 1-1.248-.595.05.05 0 0 1-.02-.066.051.051 0 0 1 .015-.019c.084-.063.168-.129.248-.195a.05.05 0 0 1 .051-.007c2.619 1.196 5.454 1.196 8.041 0a.052.052 0 0 1 .053.007c.08.066.164.132.248.195a.051.051 0 0 1-.004.085 8.254 8.254 0 0 1-1.249.594.05.05 0 0 0-.03.03.052.052 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019 13.235 13.235 0 0 0 4.001-2.02.049.049 0 0 0 .021-.037c.334-3.451-.559-6.449-2.366-9.106a.034.034 0 0 0-.02-.019Zm-8.198 7.307c-.789 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.45.73 1.438 1.613 0 .888-.637 1.612-1.438 1.612Zm5.316 0c-.788 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.451.73 1.438 1.613 0 .888-.631 1.612-1.438 1.612Z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Discord Profile Information</h5>
                                    <p class="text-muted card-text mb-4">With one click, quickly view the detailed information of the specified profile. (avatar, badges, discriminator, etc.)</p><a href="discord.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="currency.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-currency-dollar">
                                            <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"></path>
                                        </svg></div>
                                    <h5 class="fw-bold card-title">Currency</h5>
                                    <p class="text-muted card-text mb-4">Be informed by examining the changes in currency with detail in a quick, automatic and easy way against TL.</p><a href="currency.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="currenyCalculator.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-currency-exchange">
                                            <path d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z"></path>
                                        </svg></div>
                                    <h5 class="fw-bold card-title">Currency Calculator</h5>
                                    <p class="text-muted card-text mb-4">Quickly convert from Turkish lira to the specified currency with one click and instant data.</p><a href="currencyCalculator.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="githubUser.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-person-badge-fill" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-.245z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Github Profile Information</h5>
                                    <p class="text-muted card-text mb-4">With a single click view the detailed information of the specified profile and access the profile picture.</p><a href="githubUser.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="githubProject.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-github" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Github Repository Lister</h5>
                                    <p class="text-muted card-text mb-4">With one click, quickly view and list the projects of the specified profile in detail.</p><a href="githubProject.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="wordCount.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-text-paragraph">
                                            <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm4-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z"></path>
                                        </svg></div>
                                    <h5 class="fw-bold card-title">Word Count Calculator</h5>
                                    <p class="text-muted card-text mb-4">Calculate how many words are in the entered text quickly, easily and automatically.</p><a href="wordCount.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="editor.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-journal-richtext" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M7.5 3.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zm-.861 1.542 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047L11 4.75V7a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 7v-.5s1.54-1.274 1.639-1.208zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"></path>
                                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                                            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Live Text Editor</h5>
                                    <p class="text-muted card-text mb-4">Create quality online content with instant, advanced and live preview text editor.</p><a href="editor.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="estimatedReading.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-clock-history" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"></path>
                                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"></path>
                                            <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Estimated Reading Time</h5>
                                    <p class="text-muted card-text mb-4">Calculate quickly average estimated reading time for specified content by one click.</p><a href="estimatedReading.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="weather.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-clouds" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 7.5a2.5 2.5 0 0 1-1.456 2.272 3.513 3.513 0 0 0-.65-.824 1.5 1.5 0 0 0-.789-2.896.5.5 0 0 1-.627-.421 3 3 0 0 0-5.22-1.625 5.587 5.587 0 0 0-1.276.088 4.002 4.002 0 0 1 7.392.91A2.5 2.5 0 0 1 16 7.5z"></path>
                                            <path d="M7 5a4.5 4.5 0 0 1 4.473 4h.027a2.5 2.5 0 0 1 0 5H3a3 3 0 0 1-.247-5.99A4.502 4.502 0 0 1 7 5zm3.5 4.5a3.5 3.5 0 0 0-6.89-.873.5.5 0 0 1-.51.375A2 2 0 1 0 3 13h8.5a1.5 1.5 0 1 0-.376-2.953.5.5 0 0 1-.624-.492V9.5z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Weather Forecast</h5>
                                    <p class="text-muted card-text mb-4">Access detailed (sunrise, sunset, etc.) information about the current weather conditions of the specified city.</p><a href="weather.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="ipLookup.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-hdd-network" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M4.5 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zM3 4.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8.5v3a1.5 1.5 0 0 1 1.5 1.5h5.5a.5.5 0 0 1 0 1H10A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5H.5a.5.5 0 0 1 0-1H6A1.5 1.5 0 0 1 7.5 10V7H2a2 2 0 0 1-2-2V4zm1 0v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm6 7.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Detailed IP Information</h5>
                                    <p class="text-muted card-text mb-4">Access detailed information about your IP address (provider, location, etc.) with a single click.</p><a href="ipLookup.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="qrCode.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-qr-code" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M5 1H1v4h4V1ZM1 11v4h4v-4H1ZM15 1h-4v4h4V1ZM5 0h1v6H0V0h5Zm0 10h1v6H0v-6h5Zm6-10h-1v6h6V0h-5ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Zm-2 4.5V12h1v3h4v1H7v-.5Zm9-1.5v2h-3v-1h2v-1h1ZM2 2h2v2H2V2Zm10 0h2v2h-2V2ZM4 12H2v2h2v-2Z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">QR Code Generator</h5>
                                    <p class="text-muted card-text mb-4">Create a QR code of the specified content in the specified dimensions and use it quickly by one click.</p><a href="qrCode.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="imageCompressor.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-image" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Image Compressor</h5>
                                    <p class="text-muted card-text mb-4">Convert selected image to reduced size with one click without losing quality.</p><a href="imageCompressor.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="siteResource.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-file-earmark-code" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"></path>
                                            <path d="M8.646 6.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 9 8.646 7.354a.5.5 0 0 1 0-.708zm-1.292 0a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .708l2 2a.5.5 0 0 0 .708-.708L5.707 9l1.647-1.646a.5.5 0 0 0 0-.708z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Website Resource Code</h5>
                                    <p class="text-muted card-text mb-4">Quickly find and view the source code (HTML, CSS and JS) of the specified URL by one click.</p><a href="siteResource.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="draw.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-card-list">
                                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"></path>
                                            <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Draw Genarator</h5>
                                    <p class="text-muted card-text mb-4">Choose a winner easily, quickly and automatically with advanced options from the specified participants.</p><a href="draw.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="password.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-unlock">
                                            <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Password Generator</h5>
                                    <p class="text-muted card-text mb-4">Secure your accounts by easily and automatically generating mixed and secure passwords.</p><a href="password.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="bodyIndex.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-ui-checks" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Index Calculator</h5>
                                    <p class="text-muted card-text mb-4">Get quick result for your body index with a single click specifying height and weight.</p><a href="bodyIndex.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="metaTag.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-tags">
                                            <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"></path>
                                            <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Meta Tag Generator</h5>
                                    <p class="text-muted card-text mb-4">Automatically generate meta tag codes that allow search engines to correctly classify your site.</p><a href="metaTag.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="coloredText.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-paint-bucket">
                                            <path d="M6.192 2.78c-.458-.677-.927-1.248-1.35-1.643a2.972 2.972 0 0 0-.71-.515c-.217-.104-.56-.205-.882-.02-.367.213-.427.63-.43.896-.003.304.064.664.173 1.044.196.687.556 1.528 1.035 2.402L.752 8.22c-.277.277-.269.656-.218.918.055.283.187.593.36.903.348.627.92 1.361 1.626 2.068.707.707 1.441 1.278 2.068 1.626.31.173.62.305.903.36.262.05.64.059.918-.218l5.615-5.615c.118.257.092.512.05.939-.03.292-.068.665-.073 1.176v.123h.003a1 1 0 0 0 1.993 0H14v-.057a1.01 1.01 0 0 0-.004-.117c-.055-1.25-.7-2.738-1.86-3.494a4.322 4.322 0 0 0-.211-.434c-.349-.626-.92-1.36-1.627-2.067-.707-.707-1.441-1.279-2.068-1.627-.31-.172-.62-.304-.903-.36-.262-.05-.64-.058-.918.219l-.217.216zM4.16 1.867c.381.356.844.922 1.311 1.632l-.704.705c-.382-.727-.66-1.402-.813-1.938a3.283 3.283 0 0 1-.131-.673c.091.061.204.15.337.274zm.394 3.965c.54.852 1.107 1.567 1.607 2.033a.5.5 0 1 0 .682-.732c-.453-.422-1.017-1.136-1.564-2.027l1.088-1.088c.054.12.115.243.183.365.349.627.92 1.361 1.627 2.068.706.707 1.44 1.278 2.068 1.626.122.068.244.13.365.183l-4.861 4.862a.571.571 0 0 1-.068-.01c-.137-.027-.342-.104-.608-.252-.524-.292-1.186-.8-1.846-1.46-.66-.66-1.168-1.32-1.46-1.846-.147-.265-.225-.47-.251-.607a.573.573 0 0 1-.01-.068l3.048-3.047zm2.87-1.935a2.44 2.44 0 0 1-.241-.561c.135.033.324.11.562.241.524.292 1.186.8 1.846 1.46.45.45.83.901 1.118 1.31a3.497 3.497 0 0 0-1.066.091 11.27 11.27 0 0 1-.76-.694c-.66-.66-1.167-1.322-1.458-1.847z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Colored Text Generator</h5>
                                    <p class="text-muted card-text mb-4">Quickly and automatically get your colored text code with text effects in HTML - CSS or BBCode format.</p><a href="coloredText.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="colorPicker.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-droplet-half">
                                            <path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0c.109.363.234.708.371 1.038.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8zm.413 1.021A31.25 31.25 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10c0 0 2.5 1.5 5 .5s5-.5 5-.5c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"></path>
                                            <path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Color Picker</h5>
                                    <p class="text-muted card-text mb-4">Get the code (HEX, RGB and HSL) by selecting the color you want from the advanced color palette.</p><a href="colorPicker.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="md5.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-shield-check">
                                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"></path>
                                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"></path>
                                        </svg></div>
                                    <h5 class="fw-bold card-title">MD5 Encryptor</h5>
                                    <p class="text-muted card-text mb-4">Use the popular and undecryptable MD5 encryption type to secure data.</p><a href="md5.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="calculator.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-calculator" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"></path>
                                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Calculator</h5>
                                    <p class="text-muted card-text mb-4">Calculate your math stuffs with modern and easy to use theme designed calculator.</p><a href="calculator.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" id="englishNumbers.php">
                            <div class="card shadow-sm">
                                <div class="card-body px-4 py-5 px-md-5">
                                    <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-sort-numeric-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.438 1.668V7H11.39V2.684h-.051l-1.211.859v-.969l1.262-.906h1.046z"></path>
                                            <path fill-rule="evenodd" d="M11.36 14.098c-1.137 0-1.708-.657-1.762-1.278h1.004c.058.223.343.45.773.45.824 0 1.164-.829 1.133-1.856h-.059c-.148.39-.57.742-1.261.742-.91 0-1.72-.613-1.72-1.758 0-1.148.848-1.835 1.973-1.835 1.09 0 2.063.636 2.063 2.687 0 1.867-.723 2.848-2.145 2.848zm.062-2.735c.504 0 .933-.336.933-.972 0-.633-.398-1.008-.94-1.008-.52 0-.927.375-.927 1 0 .64.418.98.934.98z"></path>
                                            <path d="M4.5 13.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707V13.5z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="fw-bold card-title">Number to Text Converter</h5>
                                    <p class="text-muted card-text mb-4">Automatically and quickly convert the specified numeric value to English text, regardless of size.</p><a href="englishNumbers.php" class="btn btn-dark shadow">More</a>
                                </div>
                            </div>
                        </div>
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
        <?php require("pages/footer.php"); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="assets/js/home.js"></script>
        <?php if($settings["typeWriter"] == "on"){ ?>
            <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
            <script>
                var app = document.getElementById("text");
                var typewriter = new Typewriter(app, {
                    loop: true
                });
                typewriter.typeString("<?php echo($settings["homeSlogan"]); ?>").pauseFor(2500).start();
            </script>
        <?php }
        $queryForClosedTools = $connect->prepare("SELECT * FROM closedtools");
        $queryForClosedTools->execute();
        if($queryForClosedTools->rowCount() > 0){ ?>
            <script>
                let closedTools = <?php echo(json_encode($queryForClosedTools->fetchAll(PDO::FETCH_ASSOC))); ?>;
                closedTools.forEach((el) => {
                    try{
                        document.getElementById(el.name + ".php").style.display = "none";
                    }catch(e){}
                });
            </script>
        <?php } ?>

        <script src="assets/js/all.js"></script>
        <script src="assets/js/bold-and-bright.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        </body>
        </html>
<?php }else{
        if(file_exists("main/{$par[0]}.php")){
            require("main/{$par[0]}.php");
        }else{
            $connect = null;
            header("Location: ./");
        }
    }
$connect = null; ?>