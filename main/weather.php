<?php
    $addStat = $connect->prepare("UPDATE stats SET weather = weather + 1 LIMIT 1");
    $addStat->execute();
    $cities = array("Aberdeen", "Abilene", "Akron", "Albany", "Albuquerque", "Alexandria", "Allentown", "Amarillo", "Anaheim", "Anchorage", "Ann Arbor", "Antioch", "Apple Valley", "Appleton", "Arlington", "Arvada", "Asheville", "Athens", "Atlanta", "Atlantic City", "Augusta", "Aurora", "Austin", "Bakersfield", "Baltimore", "Barnstable", "Baton Rouge", "Beaumont", "Bel Air", "Bellevue", "Berkeley", "Bethlehem", "Billings", "Birmingham", "Bloomington", "Boise", "Boise City", "Bonita Springs", "Boston", "Boulder", "Bradenton", "Bremerton", "Bridgeport", "Brighton", "Brownsville", "Bryan", "Buffalo", "Burbank", "Burlington", "Cambridge", "Canton", "Cape Coral", "Carrollton", "Cary", "Cathedral City", "Cedar Rapids", "Champaign", "Chandler", "Charleston", "Charlotte", "Chattanooga", "Chesapeake", "Chicago", "Chula Vista", "Cincinnati", "Clarke County", "Clarksville", "Clearwater", "Cleveland", "College Station", "Colorado Springs", "Columbia", "Columbus", "Concord", "Coral Springs", "Corona", "Corpus Christi", "Costa Mesa", "Dallas", "Daly City", "Danbury", "Davenport", "Davidson County", "Dayton", "Daytona Beach", "Deltona", "Denton", "Denver", "Des Moines", "Detroit", "Downey", "Duluth", "Durham", "El Monte", "El Paso", "Elizabeth", "Elk Grove", "Elkhart", "Erie", "Escondido", "Eugene", "Evansville", "Fairfield", "Fargo", "Fayetteville", "Fitchburg", "Flint", "Fontana", "Fort Collins", "Fort Lauderdale", "Fort Smith", "Fort Walton Beach", "Fort Wayne", "Fort Worth", "Frederick", "Fremont", "Fresno", "Fullerton", "Gainesville", "Garden Grove", "Garland", "Gastonia", "Gilbert", "Glendale", "Grand Prairie", "Grand Rapids", "Grayslake", "Green Bay", "GreenBay", "Greensboro", "Greenville", "Gulfport-Biloxi", "Hagerstown", "Hampton", "Harlingen", "Harrisburg", "Hartford", "Havre de Grace", "Hayward", "Hemet", "Henderson", "Hesperia", "Hialeah", "Hickory", "High Point", "Hollywood", "Honolulu", "Houma", "Houston", "Howell", "Huntington", "Huntington Beach", "Huntsville", "Independence", "Indianapolis", "Inglewood", "Irvine", "Irving", "Jackson", "Jacksonville", "Jefferson", "Jersey City", "Johnson City", "Joliet", "Kailua", "Kalamazoo", "Kaneohe", "Kansas City", "Kennewick", "Kenosha", "Killeen", "Kissimmee", "Knoxville", "Lacey", "Lafayette", "Lake Charles", "Lakeland", "Lakewood", "Lancaster", "Lansing", "Laredo", "Las Cruces", "Las Vegas", "Layton", "Leominster", "Lewisville", "Lexington", "Lincoln", "Little Rock", "Long Beach", "Lorain", "Los Angeles", "Louisville", "Lowell", "Lubbock", "Macon", "Madison", "Manchester", "Marina", "Marysville", "McAllen", "McHenry", "Medford", "Melbourne", "Memphis", "Merced", "Mesa", "Mesquite", "Miami", "Milwaukee", "Minneapolis", "Miramar", "Mission Viejo", "Mobile", "Modesto", "Monroe", "Monterey", "Montgomery", "Moreno Valley", "Murfreesboro", "Murrieta", "Muskegon", "Myrtle Beach", "Naperville", "Naples", "Nashua", "Nashville", "New Bedford", "New Haven", "New London", "New Orleans", "New York", "New York City", "Newark", "Newburgh", "Newport News", "Norfolk", "Normal", "Norman", "North Charleston", "North Las Vegas", "North Port", "Norwalk", "Norwich", "Oakland", "Ocala", "Oceanside", "Odessa", "Ogden", "Oklahoma City", "Olathe", "Olympia", "Omaha", "Ontario", "Orange", "Orem", "Orlando", "Overland Park", "Oxnard", "Palm Bay", "Palm Springs", "Palmdale", "Panama City", "Pasadena", "Paterson", "Pembroke Pines", "Pensacola", "Peoria", "Philadelphia", "Phoenix", "Pittsburgh", "Plano", "Pomona", "Pompano Beach", "Port Arthur", "Port Orange", "Port Saint Lucie", "Port St. Lucie", "Portland", "Portsmouth", "Poughkeepsie", "Providence", "Provo", "Pueblo", "Punta Gorda", "Racine", "Raleigh", "Rancho Cucamonga", "Reading", "Redding", "Reno", "Richland", "Richmond", "Richmond County", "Riverside", "Roanoke", "Rochester", "Rockford", "Roseville", "Round Lake Beach", "Sacramento", "Saginaw", "Saint Louis", "Saint Paul", "Saint Petersburg", "Salem", "Salinas", "Salt Lake City", "San Antonio", "San Bernardino", "San Buenaventura", "San Diego", "San Francisco", "San Jose", "Santa Ana", "Santa Barbara", "Santa Clara", "Santa Clarita", "Santa Cruz", "Santa Maria", "Santa Rosa", "Sarasota", "Savannah", "Scottsdale", "Scranton", "Seaside", "Seattle", "Sebastian", "Shreveport", "Simi Valley", "Sioux City", "Sioux Falls", "South Bend", "South Lyon", "Spartanburg", "Spokane", "Springdale", "Springfield", "St. Louis", "St. Paul", "St. Petersburg", "Stamford", "Sterling Heights", "Stockton", "Sunnyvale", "Syracuse", "Tacoma", "Tallahassee", "Tampa", "Temecula", "Tempe", "Thornton", "Thousand Oaks", "Toledo", "Topeka", "Torrance", "Trenton", "Tucson", "Tulsa", "Tuscaloosa", "Tyler", "Utica", "Vallejo", "Vancouver", "Vero Beach", "Victorville", "Virginia Beach", "Visalia", "Waco", "Warren", "Washington", "Waterbury", "Waterloo", "West Covina", "West Valley City", "Westminster", "Wichita", "Wilmington", "Winston", "Winter Haven", "Worcester", "Yakima", "Yonkers", "York", "Youngstown");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo($settings["title"]); ?> - Weather Forecast</title>
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
                        <div class="bs-icon-lg d-flex justify-content-center align-items-center mb-3 bs-icon" style="top: 1rem;right: 1rem;position: absolute;"><svg class="bi bi-clouds" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 7.5a2.5 2.5 0 0 1-1.456 2.272 3.513 3.513 0 0 0-.65-.824 1.5 1.5 0 0 0-.789-2.896.5.5 0 0 1-.627-.421 3 3 0 0 0-5.22-1.625 5.587 5.587 0 0 0-1.276.088 4.002 4.002 0 0 1 7.392.91A2.5 2.5 0 0 1 16 7.5z"></path>
                                <path d="M7 5a4.5 4.5 0 0 1 4.473 4h.027a2.5 2.5 0 0 1 0 5H3a3 3 0 0 1-.247-5.99A4.502 4.502 0 0 1 7 5zm3.5 4.5a3.5 3.5 0 0 0-6.89-.873.5.5 0 0 1-.51.375A2 2 0 1 0 3 13h8.5a1.5 1.5 0 1 0-.376-2.953.5.5 0 0 1-.624-.492V9.5z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold card-title">Weather Forecast</h5>
                        <p class="text-muted card-text">Access detailed (sunrise, sunset, etc.) information about the current weather conditions of the specified city.</p>
                        <?php if(!empty($_POST["city"])){
                                    $city = filter($_POST["city"]);
                                    $url = "https://api.openweathermap.org/data/2.5/weather?q={$city},usa&units=metric&lang=en&appid={$weatherApiKey}";
                                    $ch = curl_init();
                                    curl_setopt_array($ch, array(
                                        CURLOPT_URL => $url,
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_FOLLOWLOCATION => true
                                    ));
                                    $chEnd = curl_exec($ch);
                                    $err = curl_error($ch);
                                    curl_close($ch);
                                    if(!$err){
                                        $getWeatherData = json_decode($chEnd, TRUE);
                                        if($getWeatherData["cod"] == "404"){ ?>
                                            <div class="alert alert-warning" role="alert">
                                                Please specify a true city.
                                            </div>
                                        <?php }else{
                                            $getTemp = @round($getWeatherData["main"]["temp"]) ?? "0";
                                            $getFahrenheit = ($getTemp * 1.8) ?? "0";
                                            $getFahrenheit = round($getFahrenheit) + 32;
                                            $getWeatherDataFirst = reset($getWeatherData["weather"]);
                                            $getIconData = $getWeatherDataFirst["icon"];
                                            $getWeatherDesc = mb_ucfirst($getWeatherDataFirst["description"], "utf-8");
                                            $getIcon = "http://openweathermap.org/img/wn/{$getIconData}@2x.png";
                                            $getSunrise = @getFormattedTime($getWeatherData["sys"]["sunrise"]);
                                            $getSunset = @getFormattedTime($getWeatherData["sys"]["sunset"]); ?>
                                            <div class="container mb-0">
                                                <div class="py-5 p-lg-5">
                                                    <div class="row row-cols-1 row-cols-md-2 mx-auto d-flex justify-content-center" style="max-width: 900px;">
                                                            <div class="col-11 mb-4">
                                                                <div class="card shadow-sm border-3">
                                                                    <div class="card-body px-4 py-5 px-md-5">
                                                                        <h5 class="fw-bold card-title">
                                                                            <?php echo($city); ?>
                                                                        </h5>
                                                                        <div class="bs-icon-lg d-flex bs-icon" style="top: 1rem;right: 1rem; position: absolute;">
                                                                            <img id="imageDiv" class="img-fluid" src="<?php echo($getIcon); ?>" alt="">
                                                                        </div>
                                                                        <p class="text-muted card-text">
                                                                                <?php echo($getTemp . " °C / " . $getFahrenheit . " °F"); ?> - <?php echo($getWeatherDesc); ?><br>
                                                                                <span style="font-weight: bold;">Perceived temperature:</span> <?php echo(round(@$getWeatherData["main"]["feels_like"] ?? "0") . " °C"); ?><br>
                                                                                <span style="font-weight: bold;">Cloud rate:</span> <?php echo("%" . (@$getWeatherData["clouds"]["all"] ?? "0")); ?><br>
                                                                                <span style="font-weight: bold;">Wind speed:</span> <?php echo((@$getWeatherData["wind"]["speed"] ?? "0") . " m/s" ); ?><br>
                                                                                <span style="font-weight: bold;">Wind direction:</span> <?php echo((@$getWeatherData["wind"]["deg"] ?? "0") . "°" ); ?><br>
                                                                                <span style="font-weight: bold;">Sunrise:</span> <?php echo($getSunrise ?? "Hesaplanmamış."); ?><br>
                                                                                <span style="font-weight: bold;">Sunset:</span> <?php echo($getSunset ?? "Hesaplanmamış."); ?><br>
                                                                                <span style="font-weight: bold;">Latitude:</span> <?php echo((@$getWeatherData["coord"]["lat"] ?? "0") . "°"); ?><br>
                                                                                <span style="font-weight: bold;">Longitude:</span> <?php echo((@$getWeatherData["coord"]["lon"] ?? "0") . "°"); ?><br>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <style> @media screen and (max-width: 768px){ #imageDiv{ display: none; } } </style>
                                        <?php }
                                        }else{ ?>
                                        <div class="alert alert-danger" role="alert">
                                            An unexpected error occurred while loading the relevant data. Please try again later.
                                        </div>
                                    <?php }?>
                        <?php } ?>
                        <form method="post">
                            <select class="form-select" name="city" aria-label="City">
                                <option selected disabled>Please choose a city.</option>
                                <?php foreach($cities as $item){
                                    echo("<option value='{$item}'>{$item}</option>");
                                } ?>
                            </select>
                            <button style="margin-top: 20px;" class="btn btn-dark shadow" type="submit">Search</button>
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
