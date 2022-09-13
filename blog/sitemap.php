<?php header('Content-type: text/xml');
require("../core/functions.php");
require("../core/dbConnect.php");
$twoDaysBefore = strtotime("-2 day");
$getPosts = $connect->prepare("SELECT * FROM blog WHERE date >= ? ORDER BY id DESC");
$getPosts->execute(array($twoDaysBefore));
if($getPosts->rowCount() < 1){
    $connect = null;
    header("Location: ./");
    die();
}
$siteUrl = url(); ?>
<?php echo('<?xml version="1.0" encoding="UTF-8"?>'); ?>
<urlset
  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    <?php $posts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
    foreach($posts as $post){
        $keywords = "";
        $explodedContent = count(array_filter(explode(" ", $post["title"]))) == 0 ? array($post["title"]) : array_filter(explode(" ", $post["title"]));
        foreach($explodedContent as $item){
            if(strlen($item) > 2){
                $keywords .= $item . ", ";
            }
        }
        $keywords = substr($keywords, 0, (strlen($keywords) - 2)); ?>
        <url>
        <loc><?php echo($siteUrl . "/blog/" . $post["sef"]); ?></loc>
        <news:news>
            <news:publication>
                <news:name><?php echo($settings["title"]); ?></news:name>
                <news:language>tr</news:language>
            </news:publication>
            <news:publication_date><?php echo date(DATE_W3C, $post["date"]) ?></news:publication_date>
            <news:title><?php echo($post["title"]); ?></news:title>
            <news:keywords><?php echo($keywords . ", " . $post["title"]); ?></news:keywords>
        </news:news>
    </url>
    <?php } ?>
</urlset>
<?php $connect = null; ?>