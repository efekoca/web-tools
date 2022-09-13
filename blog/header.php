<?php
if((basename($_SERVER['PHP_SELF']) == basename(__FILE__)) or (basename($_SERVER['PHP_SELF']) == substr(basename(__FILE__), 0, (strlen(basename(__FILE__)) - 4)))){
    header("Location: ./");
    die();
}
$getUrl = url();
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta property="og:image" content="<?php echo($getUrl); ?>/assets/img/<?php echo($settings["ogImage"]); ?>">
<meta property="og:description" content="<?php echo($settings["description"]); ?>">
<meta name="description" content="<?php echo($settings["description"]); ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo($getUrl); ?>">
<meta property="og:site_name" content="<?php echo($settings["title"]); ?>">
<meta property="og:title" content="<?php echo($settings["title"]); ?>">
<meta name="keywords" content="<?php echo($settings["keywords"]); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo($getUrl); ?>">
<meta name="twitter:title" content="<?php echo($settings["title"]); ?>">
<meta name="twitter:description" content="<?php echo($settings["description"]); ?>">
<meta name="twitter:image" content="<?php echo($getUrl); ?>/assets/img/<?php echo($settings["ogImage"]); ?>">
<link rel="icon" href="<?php echo($getUrl); ?>/assets/img/<?php echo($settings["favicon"]); ?>">
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<link rel="stylesheet" href="../assets/css/style.css">
<?php if($settings["googleCodes"] != ""){ echo($settings["googleCodes"]); }  ?>