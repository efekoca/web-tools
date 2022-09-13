<?php
$addStat = $connect->prepare("UPDATE stats SET whois = whois + 1 LIMIT 1");
$addStat->execute();
$servers = array(
    "biz" => "whois.neulevel.biz",
    "xyz" => "whois.internic.net",
    "com" => "whois.internic.net",
    "us" => "whois.nic.us",
    "coop" => "whois.nic.coop",
    "info" => "whois.nic.info",
    "name" => "whois.nic.name",
    "net" => "whois.internic.net",
    "gov" => "whois.nic.gov",
    "edu" => "whois.internic.net",
    "mil" => "rs.internic.net",
    "int" => "whois.iana.org",
    "ac" => "whois.nic.ac",
    "ae" => "whois.uaenic.ae",
    "at" => "whois.ripe.net",
    "au" => "whois.aunic.net",
    "be" => "whois.dns.be",
    "bg" => "whois.ripe.net",
    "br" => "whois.registro.br",
    "bz" => "whois.belizenic.bz",
    "ca" => "whois.cira.ca",
    "cc" => "whois.nic.cc",
    "ch" => "whois.nic.ch",
    "cl" => "whois.nic.cl",
    "cn" => "whois.cnnic.net.cn",
    "cz" => "whois.nic.cz",
    "de" => "whois.nic.de",
    "fr" => "whois.nic.fr",
    "hu" => "whois.nic.hu",
    "ie" => "whois.domainregistry.ie",
    "il" => "whois.isoc.org.il",
    "in" => "whois.ncst.ernet.in",
    "ir" => "whois.nic.ir",
    "mc" => "whois.ripe.net",
    "to" => "whois.tonic.to",
    "tv" => "whois.nic.tv",
    "ru" => "whois.ripn.net",
    "org" => "whois.pir.org",
    "aero" => "whois.information.aero",
    "nl" => "whois.domain-registry.nl",
    "com.tr" => "whois.nic.tr",
    "gen.tr" => "whois.nic.tr",
    "web.tr" => "whois.nic.tr",
    "k12.tr" => "whois.nic.tr",
    "org.tr" => "whois.nic.tr"
);
$serversForSelect = array_keys($servers);
?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <title><?php echo($settings["title"]); ?> - Whois Query</title>
        <?php require("pages/header.php"); ?>
    </head>
    <body class="bg-primary-gradient">
    <?php require("pages/navbar.php"); ?>
    <a id="topButton" href="#">
        <svg class="bi bi-chevron-up" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="white" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"></path>
        </svg>
    </a>
    <section class="pt-5 mt-5">
        <div class="container mb-0">
            <div class="pt-5 p-lg-5 d-flex justify-content-center align-items-center">
                <div class="col-11">
                    <div class="card shadow-sm">
                        <div class="card-body px-4 py-5 px-md-5">
                            <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-window-stack">
                                    <path fill-rule="evenodd" d="M12 1a2 2 0 0 1 2 2 2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2 2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h10ZM2 12V5a2 2 0 0 1 2-2h9a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1Zm1-4v5a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V8H3Zm12-1H3V5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2ZM4.5 6a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1ZM6 6a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Zm2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
                                </svg>
                            </div>
                            <h5 class="fw-bold card-title">Whois Query</h5>
                            <p class="text-muted card-text">Expand your research by obtaining detailed information about a domain. (registration date, contact information, etc.)</p>
                            <?php if(!empty($_POST["domain"])){
                                $patternForDomain = "/^(?<domain>[a-zA-Z0-9\-\_ğüşıöç]{2,256})$/u";
                                $filteredUrl = filter($_POST["domain"]);
                                if(preg_match($patternForDomain, $filteredUrl, $matches)){
                                    $domainName = $matches["domain"];
                                    $whoisData = array();
                                    function queryDomain($domain, $domainExt){
                                        global $whoisData;
                                        global $servers;
                                        if(empty($servers[$domainExt])){
                                            $whoisData[$domainExt]["err"] = "Unknown extension.";
                                            return;
                                        }
                                        $connectServer = $servers[$domainExt];
                                        $output = "";
                                        try{
                                            if($conn = @fsockopen($connectServer, 43)){
                                                @fputs($conn, $domain . '.' . $domainExt . "\r\n");
                                                while(!feof($conn)){
                                                    $output .= fgets($conn,128);
                                                }
                                                fclose($conn);
                                            }else{
                                                $whoisData[$domainExt]["err"] = "An unexpected error occurred while connecting to the server.";
                                            }
                                        }catch(exception $e){
                                            $whoisData[$domainExt]["err"] = "An unexpected error occurred while connecting to the server.";
                                        }
                                        $whoisData[$domainExt]["whois"] = $output;
                                        if(stristr($output,"No match") || stristr($output,"No entries") || stristr($output, "NOT FOUND")){
                                            $whoisData[$domainExt]["status"] = 0;
                                        }
                                        else{
                                            $whoisData[$domainExt]["status"] = 1;
                                        }
                                    }
                                    function checkDomain(){
                                        $extensions = array_map("filter", $_POST["extension"]);
                                        global $domainName;
                                        global $domainName;
                                        global $whoisData;
                                        foreach($extensions as $extension){
                                            $extension = strtolower(trim($extension));
                                            queryDomain($domainName, $extension);
                                        }
                                        echo '<div class="alert alert-dark" style="line-break: anywhere; word-break: break-all;" role="alert">
                                        <strong class="card-title fw-bold">Result of' . $domainName . ':</strong>            
                                        <table>';
                                        foreach($whoisData as $key => $value){
                                            if(!empty($value["err"])){
                                                $response = "- <span class='fw-bold'>" . $domainName . '.' . $key . "</span>: " . $value["err"];
                                            }elseif($value["status"]){
                                                $patternCheck = "/(?<par>.+)(notice?.+)/uis";
                                                $patternCheckSec = "/(?<par>.+)(terms of?.+)/uis";
                                                if(preg_match($patternCheck, $whoisData[$key]["whois"], $matchesForFilter)){
                                                    $whoisData[$key]["whois"] = $matchesForFilter["par"];
                                                }elseif(preg_match($patternCheckSec, $whoisData[$key]["whois"], $matchesForFilter)){
                                                    $whoisData[$key]["whois"] = $matchesForFilter["par"];
                                                }
                                                $response = '- <a href="http://www.'.$domainName . '.' . $key . '" target="_blank" style="color: black; font-weight: bold;">Details of ' . $domainName . '.' . $key."</a>:<br><pre style='white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: pre-wrap; white-space: -o-pre-wrap; word-break: break-all;'>" . $whoisData[$key]["whois"] . "</pre>";
                                            }else{
                                                $response = "- <span class='fw-bold'>" . $domainName . '.' . $key . "</span><span>: Available</span>";
                                            }
                                            echo '<tr><td>' . $response . '</td></tr>';
                                        }
                                        echo "</table></div>";
                                    }
                                    checkDomain();
                                }else{ ?>
                                    <div class="alert alert-danger" role="alert">
                                        Please select a domain extension by specifying a correct word. (An example: google)
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <form id="domainForm" style="margin-top: -30px !important;" method="post">
                                <label for="domain"></label>
                                <input class="form-control mb-3" id="domain" name="domain" placeholder="Please specify a domain name." required>
                                <table class="extensions w-100">
                                    <tr>
                                        <td><label><input type="checkbox"  value="com" name="extension[]" checked="checked" /> com </label></td>
                                        <td><label><input type="checkbox" value="net" name="extension[]" /> net</label></td>
                                        <td><label> <input type="checkbox" value="org" name="extension[]" /> org</label></td>
                                        <td><label><input type="checkbox" value="info" name="extension[]" /> info</label></td>
                                        <td><label><input type="checkbox" value="biz" name="extension[]" /> biz</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" value="com.tr" name="extension[]" /> com.tr  </label></td>
                                        <td><label><input type="checkbox" value="gen.tr" name="extension[]" /> gen.tr</label></td>
                                        <td><label><input type="checkbox" value="web.tr" name="extension[]" /> web.tr</label></td>
                                        <td><label><input type="checkbox" value="k12.tr" name="extension[]" /> k12.tr</label></td>
                                        <td><label><input type="checkbox" value="org.tr" name="extension[]" /> org.tr</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" value="tv" name="extension[]" /> tv</label></td>
                                        <td><label><input type="checkbox" value="de" name="extension[]" /> de</label></td>
                                        <td><label><input type="checkbox" value="cc" name="extension[]" /> cc</label></td>
                                        <td><label><input type="checkbox" value="ru" name="extension[]" /> ru</label></td>
                                        <td><label><input type="checkbox" value="fr" name="extension[]" /> fr</label></td>
                                    </tr>
                                </table>
                                <button type="submit" class="btn btn-dark mt-4 fw-bold" style="border-radius: 0; margin-top: 10px;">Query</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require("pages/footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/all.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assets/js/bold-and-bright.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </body>
    </html>
<?php $connect = null; ?>