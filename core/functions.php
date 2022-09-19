<?php
    $googleApiKey = ""; // Google page speed API key.
    $token = ""; //Discord bot token.
    $githubToken = ""; //Github API key.
    $weatherApiKey = ""; // Weather API key from https://openweathermap.org/api.
    $siteLink = ""; // Your website URL without http/s.
    $mailHost = ""; // Mail host for contact forms.
    $mailUsername = ""; // Mail username for contact forms.
    $mailPassword = ""; // Mail password for contact forms.

    if((basename($_SERVER["PHP_SELF"]) == basename(__FILE__)) or (basename($_SERVER["PHP_SELF"]) == substr(basename(__FILE__), 0, (strlen(basename(__FILE__)) - 4)))){
        header("Location: ./");
        die();
    }
    require_once("dbConnect.php");
    function getIP(){
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }else{
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        return $ip;
    }
    $getBlockedIPS = $connect->prepare("SELECT * FROM blockedips WHERE ip = ?");
    $getBlockedIPS->execute(array(
        getIP(),
    ));
    if($getBlockedIPS->rowCount() > 0){
        echo("Your access to the system is blocked.");
        $connect = null;
        die();
    }
    function filter($param){
        $a = trim($param);
        $b = strip_tags($a);
        return htmlspecialchars($b, ENT_QUOTES);
    }
    function getFormattedTime($time){
        //date_default_timezone_set("Europe/Istanbul");
        return date("d/m/Y", $time) . ", " . date("H:i", $time);
    }
    function getFormattedTimeForVisit($time){
        //date_default_timezone_set("Europe/Istanbul");
        return date("d/m/Y", $time);
    }
    function randomName(){
        return md5(uniqid(mt_rand()));
    }
    function mb_ucfirst($string, $encoding){
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
    function descFilter($val, $len){
        $val = trim($val);
        $val = strip_tags($val);        
        $val = str_replace(['"', "'"], "", $val);
        $val = htmlspecialchars_decode($val);
        $val = str_replace ( '&ccedil;', 'ç', $val );
        $val = str_replace ( '&yacute;','ı',$val );
        $val = str_replace ( '&Ccedil;', 'Ç', $val );
        $val = str_replace ( '&Ouml;', 'Ö', $val );
        $val = str_replace ( '&Yacute;', 'Ü', $val );
        $val = str_replace ( '&ETH;','Ğ',$val );
        $val = str_replace ( '&THORN;','Ş', $val );
        $val = str_replace ( '&Yacute;','İ', $val );
        $val = str_replace ( '&ouml;','ö', $val );
        $val = str_replace ( '&thorn;','ş', $val );
        $val = str_replace ( '&eth;','ğ', $val );
        $val = str_replace ( '&uuml;','ü', $val );
        $val = str_replace ( '&yacute;','ı', $val );
        $val = str_replace ( '&amp;','&', $val );
        $val = mb_substr($val, 0, $len, "UTF-8") . "...";
        $patternForHTMLChars = "/(&(amp|nbsp);)/u";
        return trim(preg_replace($patternForHTMLChars, " ", $val));
    } 
    function getFormattedStr($str){
        $pattern = "/\s/";
        $control = preg_match($pattern, $str);
        if($control > 0){
            $formattedStr = "";
            $explodedContent = explode(" ", $str);
            foreach($explodedContent as $item){
                $replaced = preg_replace("/hakki/", "hakkı", mb_strtolower($item, "utf-8"));
                $formattedStr = $formattedStr . mb_ucfirst(mb_strtolower($replaced, "utf-8"), "utf-8") . " ";
            }
            return $formattedStr;
        }
          return mb_ucfirst(mb_strtolower($str, "utf-8"), "utf-8");
    }
    function estimatedReadingTime($content = "", $wpm = 300){
        $clean_content = filter($content);
        $word_count = str_word_count($clean_content);
        $ert = round($word_count / $wpm, 2);
        $explodedContent = array_filter(@explode(".", $ert));
        if((!is_array($explodedContent)) or (@count($explodedContent) < 1)){
            return "1 second";
        }elseif($explodedContent[1] > 59){
            return ceil($ert) . " minute";
        }elseif(substr($explodedContent[1], 0, 1) == 0){
            return @$explodedContent[0] == 0 ? substr($explodedContent[1], 1, 1) . " seconds" : $explodedContent[0] . " minutes " . substr($explodedContent[1], 1, 1) . " seconds";
        }elseif(substr($explodedContent[1], 0, 1) > 0){
            return @$explodedContent[0] == 0 ? $explodedContent[1] . " seconds" : $explodedContent[0] . " minutes " . $explodedContent[1] . " seconds";
        }else{
            return @$explodedContent[0] == 0 ? substr($explodedContent[1], 1, 1) . " seconds" : $explodedContent[0] . " minutes " . substr($explodedContent[1], 1, 1) . " seconds";
        }
    }
    function wordCount($content){
        $clean_content = filter($content);
        $pattern = "/\s+/us";
        preg_match_all($pattern, $clean_content,$matches);
        return count($matches[0]) + 1;
    }
    function javascriptFilter($par){
        $pattern = "/\<(\s*)script\>.*?<(\s*)\/(\s*)script\>/";
        $first = trim(htmlspecialchars_decode($par));
        return preg_replace($pattern, "", $first);
    }
    function randomPass($maxLength, $chars){
        $pass = "";
        $chars = str_split($chars);
        $counter = 0;
        while($counter < $maxLength){
            $pass .= $chars[$counter];
            $counter++;
        }
        return $pass;
    }
    function SEF($param){
        $trChars =	array("ç", "Ç", "ğ", "Ğ", "ı", "İ", "ö", "Ö", "ş", "Ş", "ü", "Ü");
        $enChars = array("c", "c", "g", "g", "i", "i", "o", "o", "s", "s", "u", "u");
        $param	=  trim($param);
        $param	= str_replace($trChars, $enChars, $param);
        $param	= mb_strtolower($param, "UTF-8");
        $param	= preg_replace("/[^a-z0-9]/", "-", $param);
        $param	= preg_replace("/-+/", "-", $param);
        return trim($param, "-");
    }
    function compress($source){
        $info = getimagesize($source);
        if(($info["mime"] == "image/jpeg") or ($info["mime"] == "image/jpg")){
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, "compressedImages/compressed.jpeg",75);
            $fileName = "compressed.jpeg";
        }elseif($info["mime"] == "image/png"){
            $image = imagecreatefrompng($source);
            imagepng($image, "compressedImages/compressed.png",5);
            $fileName = "compressed.png";
        }elseif($info["mime"] == "image/webp"){
            $image = imagecreatefromwebp($source);
            imagewebp($image, "compressedImages/compressed.webp",75);
            $fileName = "compressed.webp";
        }else{
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, "compressedImages/compressed.jpeg",75);
            $fileName = "compressed.jpeg";
        }
        imagedestroy($image);
        return $fileName;
    }
    $pageNames = array(
        "estimatedReading" => "Estimated Reading",
        "whois" => "Whois Query",
        "githubProject" => "Github Project Lister",
        "metaTag" => "Meta Tag Generator",
        "weather" => "Weather Forecast",
        "indexCalculator" => "Index Calculator",
        "preview" => "Code Previewer",
        "githubUser" => "Github Profile Information",
        "password" => "Password Generator",
        "editor" => "Live Text Editor",
        "qrCode" => "QR Code Generator",
        "discord" => "Discord Profile Information",
        "currency" => "Currency",
        "coloredText" => "Colored Text Generator",
        "md5" => "MD5 Encryptor",
        "currencyCalculator" => "Currency Calculator",
        "colorPicker" => "Color Picker",
        "screenshot" => "Website Screenshot",
        "draw" => "Draw Generator",
        "wordCount" => "Word Count Calculator",
        "ipLookup" => "Detailed IP Information",
        "englishNumbers" => "Number to Text Converter",
        "calculator" => "Calculator",
        "proxy" => "Proxy Extractor",
        "imageCompressor" => "Image Compressor",
        "siteResource" => "Website Resource Code"
    );
    $getSettings = $connect->prepare("SELECT * FROM settings");
    $getSettings->execute();
    $settings = $getSettings->fetch(PDO::FETCH_ASSOC);
    if(!empty($_COOKIE["id"])){
        $pattern = '/.+\&[a-zA-Z0-9].+/';
        $cookieControl = preg_match($pattern, $_COOKIE["id"]);
        if($cookieControl != 1){
            setcookie("id", null, 0);
            if(!empty($_COOKIE["id"])){
                unset($_COOKIE["id"]);
            }
            $connect = null;
            header("Location: admin/login.php");
            die();
        }
        $explodedCookie = explode("&", $_COOKIE["id"]);
        $cookieUsername = filter($explodedCookie[0]);
        $cookiePassword = filter($explodedCookie[1]);
        if(($cookieUsername != $settings["username"]) or ($cookiePassword != $settings["password"])){
            $cookieEditorQuery = $connect->prepare("SELECT * FROM editors WHERE username = ? AND password = ?");
            $cookieEditorQuery->execute(array(
                $cookieUsername,
                $cookiePassword
            ));
            if($cookieEditorQuery->rowCount() < 1){
                setcookie("id", null, 0);
                if(!empty($_COOKIE["id"])){
                    unset($_COOKIE["id"]);
                }
                $connect = null;
                header("Location: admin/login.php");
                die();
            }
        }
    }

    $getTime = getFormattedTimeForVisit(time());
    $queryVisit = $connect->prepare("SELECT * FROM visits WHERE time = ?");
    $queryVisit->execute(array(
        $getTime,
    ));
    if($queryVisit->rowCount() < 1){
        $dailyVisitCount = "1";
        $addVisit = $connect->prepare("INSERT INTO visits (time, visit) VALUES (?, ?)");
        $addVisit->execute(array(
           $getTime,
           "1",
        ));
    }else{
        $dailyVisitCount = $queryVisit->fetch(PDO::FETCH_ASSOC)["visit"] + 1;
        $addVisit = $connect->prepare("UPDATE visits SET visit = visit + 1 WHERE time = ? LIMIT 1");
        $addVisit->execute(array(
            $getTime,
        ));
    }
    require("browser.php");
    $getBrowserClass = new Browser();
    $getBrowser = (($getBrowserClass->getBrowser() == "") or ($getBrowserClass->getBrowser() == "unknown")) ? "Unknown Browser" : $getBrowserClass->getBrowser();
    $getPlatform = (($getBrowserClass->getPlatform() == "") or ($getBrowserClass->getPlatform() == "unknown")) ? "Unknown Platform" : $getBrowserClass->getPlatform();
    
    $getCurrentDataForStats = $connect->prepare("SELECT * FROM browsers");
    $getCurrentDataForStats->execute();
    if($getCurrentDataForStats->rowCount() > 0){
        $currentDataForStats = $getCurrentDataForStats->fetchAll(PDO::FETCH_ASSOC);
        if($currentDataForStats[0]["browsers"] == ""){
            $getBrowsers = array($getBrowser => 1);
        }else{
            $getBrowsers = json_decode($currentDataForStats[0]["browsers"], true);
            if(empty($getBrowsers[$getBrowser])){
                $getBrowsers[$getBrowser] = 1;
            }else{
                $getBrowsers[$getBrowser] = $getBrowsers[$getBrowser] + 1;
            }
        }
        if($currentDataForStats[0]["devices"] == ""){
            $getDevices = array($getPlatform => 1);
        }else{
            $getDevices = json_decode($currentDataForStats[0]["devices"], true);
            if(empty($getDevices[$getPlatform])){
                $getDevices[$getPlatform] = 1;
            }else{
                $getDevices[$getPlatform] = $getDevices[$getPlatform] + 1;
            }
        }
        $updateBrowsers = $connect->prepare("UPDATE browsers SET browsers = ?, devices = ?");
        $updateBrowsers->execute(array(
            json_encode($getBrowsers),
            json_encode($getDevices)
        ));
    }
    function url(){
        if(isset($_SERVER["HTTPS"])){
            $protocol = ($_SERVER["HTTPS"] && $_SERVER["HTTPS"] != "off") ? "https" : "http";
        }
        else{
            $protocol = "http";
        }
        return $protocol . "://" . $_SERVER["HTTP_HOST"];
    }
    $websiteAddress = url();
    $websiteBlogAddress = url() . "/blog";
    $getReqURL = $_SERVER["REQUEST_URI"];
    $getLastReqItem = array_filter(explode("/", $getReqURL));
    $explodedItems = $getLastReqItem;
    $getLastReqItem = end($getLastReqItem);

    $currentPageForClosePattern = "/(?<fileName>.+)\.php/u";
    if(preg_match($currentPageForClosePattern, $getLastReqItem, $matches)){
        $getCurrentPageForClose = @$matches["fileName"];
        $queryForClose = $connect->prepare("SELECT * FROM closedtools WHERE name = ?");
        $queryForClose->execute(array(
            $getCurrentPageForClose
        ));
        if($queryForClose->rowCount() > 0){
            $connect = null;
            header("Location: ./");
            die();
        }
    }

    if((in_array("blog", $explodedItems)) and ($getLastReqItem != "blog")){
        if((!preg_match("/\?page=[0-9]+/", $getLastReqItem)) and (!preg_match("/\?search=[a-zA-Z0-9\-]/", $getLastReqItem))){
            $explodedReqURL = explode("/", $getReqURL);
            $countReqURL = count($explodedReqURL);
            $lastReqItem = $explodedReqURL[$countReqURL - 1];
            $explodedLastItem = explode("?", $lastReqItem)[0];
            if(!preg_match("/(index\.php|rss\.xml|sitemap\.xml|robots\.txt)/", $getReqURL)){
                if(!preg_match("/(begen|sil)\/.+/", $getReqURL)){
                    if(count(array_filter($explodedReqURL)) != 2){
                        if($countReqURL > 4){
                            $connect = null;
                            header("Location: {$websiteBlogAddress}");
                            die();
                        }
                    }else{
                        if($countReqURL > 5){
                            $connect = null;
                            header("Location: {$websiteBlogAddress}");
                            die();
                        }
                    }
                }else{
                    if($countReqURL > 5){
                        $connect = null;
                        header("Location: {$websiteBlogAddress}");
                        die();
                    }
                }
                $getBlog = $connect->prepare("SELECT * FROM blog WHERE sef = ?");
                $getBlog->execute(array(
                    filter($explodedLastItem),
                ));
                if($getBlog->rowCount() < 1){
                    $connect = null;
                    header("Location: {$websiteBlogAddress}");
                    die();
                }
                $getPost = $getBlog->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
?>
