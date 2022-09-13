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
<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
	<channel>
		<title><?php echo($settings["title"]); ?></title>
		<description><?php echo($settings["description"]); ?></description>
		<link><?php echo($siteUrl); ?></link>
		<language>tr</language>
		<?php
		$posts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
		foreach($posts as $post){ ?>
			<item>
				<title><?php echo($post["title"]); ?></title>
				<image>
					<url><?php echo($siteUrl . "/blog/assets/imgs/" . $post["image"]); ?></url>
				</image>
				<link><?php echo($siteUrl. "/blog/" . $post["sef"]); ?></link>
				<pubDate><?php echo date(DATE_W3C, $post["date"]); ?></pubDate>
				<description><?php echo html_entity_decode(descFilter($post["content"], 100)); ?></description>
				<language>tr</language>
				<guid isPermaLink="true"><?php echo($siteUrl. "/blog/" . $post["sef"]); ?></guid>
			</item>
		<?php
		} ?>
	</channel>
</rss>
<?php $connect = null; ?>