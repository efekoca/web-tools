<?php header("Content-type: text/xml");
require("core/functions.php");
require("core/dbConnect.php");
$siteUrl = url(); 
$blockedPages = array("dbConnect.php", "cookie.php", "browser.php", "sitemap.php", "functions.php", "secure.php");
$getPosts = $connect->prepare("SELECT * FROM blog ORDER BY id DESC");
$getPosts->execute();
$files = glob("*.php");
if($getPosts->rowCount() > 0){
    $allPages = $files;
    $blogPosts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
    array_push($allPages, "blog/");
    foreach($blogPosts as $post){
        array_push($allPages, "blog/" . $post["sef"]);
    }
}else{
    $allPages = $files;
}

$allPages = array_filter($allPages, function($el){
    global $blockedPages;
    return !in_array($el, $blockedPages);
});

echo('<?xml version="1.0" encoding="UTF-8"?>'); ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
      <loc><?php echo($siteUrl); ?></loc>
      <lastmod><?php echo(date(DATE_W3C, time())); ?></lastmod>
      <priority>1.00</priority>
    </url>
<?php
foreach($allPages as $filename){ ?>
    <url>
      <loc><?php echo($siteUrl . "/" . $filename); ?></loc>
      <lastmod><?php echo(date(DATE_W3C, time())); ?></lastmod>
      <priority>0.80</priority>
    </url>
<?php } 
echo("</urlset>");
$connect = null; ?>
