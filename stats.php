<?php
require("core/functions.php");
require("core/dbConnect.php");
$getStats = $connect->prepare("SELECT * FROM stats");
$getStats->execute();
$getBrowsersAndDevices = $connect->prepare("SELECT * FROM browsers");
$getBrowsersAndDevices->execute(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Statistics</title>
    <?php require("pages/header.php"); ?>
    <link rel="stylesheet" href="assets/css/stats.css">
</head>
<body class="bg-primary-gradient">
<?php require("pages/navbar.php"); ?>
<a id="topButton" href="#">
    <svg class="bi bi-chevron-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="white" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"></path>
    </svg>
</a>
<section class="pt-5 mt-5 mb-4">
    <div class="container mb-0 pt-5 p-lg-5">
        <?php if(($getStats->rowCount()) > 0 and ($getBrowsersAndDevices->rowCount() > 0)){ ?>
        <div class="row mb-5">
            <div>
                <h3 class="fw-bold">Most Frequently Used Tools</h3>
            </div>
        </div>
        <?php $stats = $getStats->fetchAll(PDO::FETCH_ASSOC);
        uasort($stats[0], function($a, $b){
            return $b - $a;
        });
        $popularTools = array_slice($stats[0], 0, 10); ?>
        <div class="chart">
            <div class="chart-container">
                <canvas id="popularTools"></canvas>
            </div>
        </div>
        <div class="row mb-5">
            <div>
                <h3 class="fw-bold">Most Frequently Used Browsers</h3>
            </div>
        </div>
        <div class="chart">
            <div class="chart-container">
                <canvas id="popularBrowsers"></canvas>
            </div>
        </div>

        <div class="row mb-5">
            <div>
                <h3 class="fw-bold">Most Frequently Used Devices</h3>
            </div>
        </div>
        <div class="chart">
            <div class="chart-container" style="margin-bottom: 0;">
                <canvas id="popularDevices"></canvas>
            </div>
        </div>
    </div>
    <?php }else{ ?>
        <div class="alert alert-danger" role="alert">
            There are currently no statistics available.
        </div>
    <?php } ?>
</section>
<?php require("pages/footer.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/bold-and-bright.js"></script>
<script>
    <?php
    if(($getStats->rowCount()) > 0 and ($getBrowsersAndDevices->rowCount() > 0)){
    $popularToolsKeys = array_keys($popularTools);
    $popularToolsKeys = array_map(function($el) use ($pageNames){
        return @$pageNames[$el] ?? "Unknown Tool";
    }, $popularToolsKeys);
    $popularToolsData = array_values($popularTools);

    echo "let getPopularTools = " . json_encode($popularToolsKeys) . ";\n";
    echo "let getPopularToolsData = " . json_encode($popularToolsData) . ";\n";

    $browsersAndDevices = $getBrowsersAndDevices->fetchAll(PDO::FETCH_ASSOC)[0];

    $getBrowsers = json_decode($browsersAndDevices["browsers"], true);
    uasort($getBrowsers, function($a, $b){
        return $b - $a;
    });
    $getBrowsers = array_slice($getBrowsers, 0, 10);
    $getBrowsers = array_filter($getBrowsers, function($key, $val){
        return !strpos(strtolower($val), "bot") and !strpos(strtolower($val), "unknown");
    }, ARRAY_FILTER_USE_BOTH);

    $getDevices = json_decode($browsersAndDevices["devices"], true);
    uasort($getDevices, function($a, $b){
        return $b - $a;
    });
    $getDevices = array_slice($getDevices, 0, 10);

    echo "let getPopularBrowsers = " . json_encode(array_keys($getBrowsers)) . ";\n";
    echo "let getPopularBrowsersData = " . json_encode(array_values($getBrowsers)) . ";\n";

    echo "let getPopularDevices = " . json_encode(array_keys($getDevices)) . ";\n";
    echo "let getPopularDevicesData = " . json_encode(array_values($getDevices)) . ";\n"; ?>
</script>
    <script src="assets/js/stats.js"></script>
    <script src="assets/js/all.js"></script>
<?php
   } ?>
</body>
</html>